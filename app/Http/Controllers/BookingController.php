<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Fetch Upcoming Bookings (Pending or Confirmed)
        $upcoming = DB::table('bookings')
            ->join('service_providers', 'bookings.provider_id', '=', 'service_providers.id')
            ->where('bookings.user_id', $userId)
            ->whereIn('bookings.status', ['pending', 'confirmed'])
            ->select('bookings.*', 'service_providers.name as provider_name')
            ->orderBy('bookings.booking_date', 'asc')
            ->get();

        // 2. Fetch History (Completed or Cancelled)
        $history = DB::table('bookings')
            ->join('service_providers', 'bookings.provider_id', '=', 'service_providers.id')
            ->where('bookings.user_id', $userId)
            ->whereIn('bookings.status', ['completed', 'cancelled'])
            ->select('bookings.*', 'service_providers.name as provider_name')
            ->orderBy('bookings.booking_date', 'desc')
            ->get();

        return view('member.view_booking', compact('upcoming', 'history'));
    }

    /**
     * Cancel a booking
     */
    public function cancel(string $id)
    {
        try {
            $updated = DB::table('bookings')
                ->where('id', $id)
                ->where('user_id', Auth::id()) // Security: ensure user owns the booking
                ->update([
                    'status' => 'cancelled',
                    'updated_at' => now()
                ]);

            if ($updated) {
                return back()->with('success', __('page.bookingCancelled'));
            }

            return back()->with('error', __('page.bookingCancelError'));
            
        } catch (\Exception $e) {
            return back()->with('error', __('page.bookingCancelError') . ' ' . $e->getMessage());
        }
    }
    

    public function show(string $id)
    {
        // 1. Fetch the specific service
        $service = DB::table('services')->where('id', $id)->first();

        if (!$service) {
            abort(404, 'Service not found');
        }

        // 2. Fetch specialists specifically linked to this service UUID
        $providers = DB::table('service_providers')
            ->join('services', 'service_providers.specialty', '=', 'services.name')
            ->where('services.id', $id)
            ->where('service_providers.is_available', true) // Only show active staff
            ->select('service_providers.*')
            ->get();


        return view('member.booking', [
            'service' => (array)$service,
            'serviceId' => $id,
            'serviceName' => $service->name,
            'providers' => $providers
        ]);
    }

    public function proceed(Request $request)
    {
        $validated = $request->validate([
            'service_id'   => 'required|uuid',
            'service_type' => 'required|string',
            'provider_id'  => 'required|uuid',
            'booking_date' => 'required|date|after:today',
            'booking_time' => 'required',
            'total_price'  => 'required|numeric'
        ]);

        session(['pending_booking' => $validated]);

        return redirect()->route('payment.show');
    }

    /**
     * Show the Payment Summary Page
     */
    public function showPayment()
    {
        // Get the data we saved in the session during the previous step
        $bookingData = session('pending_booking');

        // If someone tries to access /payment without booking first, send them home
        if (!$bookingData) {
            return redirect()->route('home');
        }

        return view('member.payment', compact('bookingData'));
    }

    /**
     * Process the final payment and save to Database
     */
    public function processPayment(Request $request)
    {
        $bookingData = $request->all();


        // 1. Insert the record into your 'bookings' table
        // Ensure you have created this table in Supabase!
        try {
            DB::table('bookings')->insert([
                'id'           => \Illuminate\Support\Str::uuid(),
                'user_id'      => Auth::id(), // The logged-in member
                'service_type' => $bookingData['service_type'],
                'provider_id'  => $bookingData['provider_id'],
                'booking_date' => $bookingData['booking_date'],
                'booking_time' => $bookingData['booking_time'],
                'total_price'  => $bookingData['total_price'],
                'status'       => 'confirmed',
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            // 2. Clear the pending session
            session()->forget('pending_booking');

            // 3. Redirect back with a success flag to show your modal
            return redirect()->route('home')->with('booking_success', true);

        } catch (\Exception $e) {
            dd('hey', $e->getMessage());
            return back()->with('error', __('page.bookingSaveError') . ' ' . $e->getMessage());
        }
    }

}