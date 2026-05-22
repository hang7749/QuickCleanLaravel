<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminBookingController extends Controller
{
    public function index()
    {
        // 1. Fetch all bookings with their concatenated provider names
        $bookings = DB::table('bookings')
            ->leftJoin('booking_assignments', 'bookings.id', '=', 'booking_assignments.booking_id')
            ->leftJoin('service_providers', 'booking_assignments.provider_id', '=', 'service_providers.id')
            ->select(
                'bookings.*',
                DB::raw("string_agg(service_providers.name, ', ') as provider_names")
            )
            ->groupBy('bookings.id')
            ->orderBy('bookings.created_at', 'desc')
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function edit(String $id)
    {
        // 1. Fetch the core single parent booking row
        $booking = DB::table('bookings')->where('id', $id)->first();
        
        if (!$booking) {
            return redirect()->route('admin.bookings.index')->with('error', 'Booking not found.');
        }

        // 2. Fetch all currently assigned provider UUIDs for this specific booking
        $currentProviderIds = DB::table('booking_assignments')
            ->where('booking_id', $id)
            ->pluck('provider_id')
            ->toArray();

        // 3. Fetch available specialists for the edit assignment select fields
        $providers = DB::table('service_providers')
            ->where('is_available', true)
            ->where('specialty', $booking->service_type) // Match the current booking's service type
            ->get();
    
        return view('admin.bookings.edit', compact('booking', 'providers', 'currentProviderIds'));
    }

    public function update(Request $request, String $id)
    {
        // Validate inputs: status is required, provider_ids must be an array of valid IDs
        $request->validate([
            'status'         => 'required|string',
            'provider_ids'   => 'required|array|min:1',
            'provider_ids.*' => 'required|uuid',
        ]);

        try {
            // Wrap changes in an atomic transaction to avoid structural mismatch states
            DB::transaction(function () use ($request, $id) {
                
                // 1. Update the parent booking data properties
                DB::table('bookings')->where('id', $id)->update([
                    'status'     => $request->status,
                    'updated_at' => now(),
                ]);

                // 2. Delete old provider links inside the junction table
                DB::table('booking_assignments')->where('booking_id', $id)->delete();

                // 3. Insert the newly updated specialists mapping payload
                $assignments = [];
                foreach ($request->provider_ids as $providerId) {
                    $assignments[] = [
                        'id'          => Str::uuid(), // Keep this if your junction table expects a UUID primary key
                        'booking_id'  => $id,
                        'provider_id' => $providerId,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ];
                }
                
                DB::table('booking_assignments')->insert($assignments);
            });

        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('page.bookingUpdateFailed') . ': ' . $e->getMessage());
        }

        return redirect()->route('admin.bookings.index')->with('success', __('page.bookingUpdated'));
    }
}