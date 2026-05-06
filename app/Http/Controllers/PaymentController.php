<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Show the payment page.
     * Booking data comes from session (set by BookingController::store).
     */
    public function index()
    {
        $bookingData = session('booking_data');

        // Fallback dummy data if session is empty (for direct testing)
        if (!$bookingData) {
            $bookingData = [
                'service_type' => 'Floor Cleaning',
                'booking_date' => now()->addDay()->toDateString(),
                'booking_time' => '10:00 AM',
                'total_price'  => 80.00,
                'provider_id'  => '1',
            ];
        }

        return view('member.payment', compact('bookingData'));
    }

    /**
     * Process the payment and store the booking.
     * Replaces: supabase.from('bookings').insert(...)
     */
    public function process(Request $request)
    {
        $data = $request->validate([
            'service_type' => 'required|string',
            'booking_date' => 'required|date',
            'booking_time' => 'required|string',
            'total_price'  => 'required|numeric',
            'provider_id'  => 'required|string',
        ]);

        // Simulate a 2-second payment delay (already handled in JS).
        // Replace this block with your real DB insert, e.g.:
        //
        // \DB::table('bookings')->insert([
        //     'user_id'      => auth()->id(),
        //     'service_type' => $data['service_type'],
        //     'booking_date' => $data['booking_date'],
        //     'booking_time' => $data['booking_time'],
        //     'total_price'  => $data['total_price'],
        //     'provider_id'  => $data['provider_id'],
        //     'status'       => 'pending',
        //     'created_at'   => now(),
        //     'updated_at'   => now(),
        // ]);

        // Dummy: just log the booking data
        logger()->info('New booking (dummy)', array_merge($data, [
            'user_id' => 1, // replace with auth()->id()
            'status'  => 'pending',
        ]));

        // Clear booking session and flash success
        session()->forget('booking_data');
        session()->flash('booking_success', true);

        return redirect()->route('payment');
    }
}