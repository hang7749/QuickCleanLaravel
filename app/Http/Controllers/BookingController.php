<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

        // 2. Fetch specialists linked via matching specialty names
        $providers = DB::table('service_providers')
            ->join('services', 'service_providers.specialty', '=', 'services.name')
            ->where('services.id', $id)
            ->where('service_providers.is_available', true) 
            // FIX: Explicitly alias key columns to protect against naming collisions
            ->select(
                'service_providers.id',
                'service_providers.name',
                'service_providers.image_url',
                'service_providers.rating',
                'service_providers.specialty'
            )
            ->get();

        return view('member.booking', [
            'service'     => (array)$service, // Casts perfectly to match your $service['price'] syntax
            'serviceId'   => $id,
            'serviceName' => $service->name,
            'providers'   => $providers       // Collection of objects, safe for $provider->id iteration
        ]);
    }

    public function proceed(Request $request)
    {
        // 1. Updated validation rules to support arrays
        $validated = $request->validate([
            'service_id'     => 'required|uuid',
            'service_type'   => 'required|string',
            'provider_ids'   => 'required|array|min:1',       // Must be an array with at least 1 item
            'provider_ids.*' => 'required|uuid',               // Every item inside must be a valid UUID
            'booking_date'   => 'required|date|after:today',
            'booking_time'   => 'required|string',
            'total_price'    => 'required|numeric'
        ]);

        // 2. Flash clean validated data structure directly to the user session
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
        // 1. Validate incoming checkout payloads from payment form
        $validated = $request->validate([
            'service_type'   => 'required|string',
            'booking_date'   => 'required|date',
            'booking_time'   => 'required|string',
            'total_price'    => 'required|numeric|min:0.01',
            'provider_ids'   => 'required|array|min:1',
            'provider_ids.*' => 'required|uuid',
        ]);

        try {
            // 2. Transaction safety block wrapping both table insertions
            DB::transaction(function () use ($validated) {
                
                $bookingId = Str::uuid();

                // Insert the SINGLE primary booking record row (No provider_id here anymore!)
                DB::table('bookings')->insert([
                    'id'           => $bookingId,
                    'user_id'      => Auth::id(),
                    'service_type' => $validated['service_type'],
                    'booking_date' => $validated['booking_date'],
                    'booking_time' => $validated['booking_time'],
                    'total_price'  => $validated['total_price'], // Storing full price on the parent record
                    'status'       => 'confirmed', // Or 'pending' depending on your business logic
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);

                // 3. Prepare mass assignment data rows for your junction table
                $assignments = [];
                foreach ($validated['provider_ids'] as $providerId) {
                    $assignments[] = [
                        'id'          => Str::uuid(), // Only keep this if your junction table requires a UUID primary key
                        'booking_id'  => $bookingId,
                        'provider_id' => $providerId,
                        'assigned_at' => now(),
                    ];
                }

                // Insert all specialists linked to this single booking atomically
                DB::table('booking_assignments')->insert($assignments);
            });

            // 4. Clear the pending session context
            session()->forget('pending_booking');

            // 5. Redirect back with a success flag to show your modal
            return redirect()->route('home')->with('booking_success', true);

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', __('page.bookingSaveError') . ' ' . $e->getMessage());
        }
    }
}