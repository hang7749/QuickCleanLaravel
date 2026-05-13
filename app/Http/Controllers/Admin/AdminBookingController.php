<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = DB::table('bookings')
            ->join('service_providers', 'bookings.provider_id', '=', 'service_providers.id')
            ->select('bookings.*', 'service_providers.name as provider_name')
            ->orderBy('bookings.created_at', 'desc')
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function edit(String $id)
    {
        $booking = DB::table('bookings')->where('id', $id)->first();
        $providers = DB::table('service_providers')->where('is_available', true)->get();
        
        return view('admin.bookings.edit', compact('booking', 'providers'));
    }

    public function update(Request $request, String $id)
    {
        try {
            DB::table('bookings')->where('id', $id)->update([
                'status' => $request->status,
                'provider_id' => $request->provider_id,
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('page.bookingUpdateFailed') . ': ' . $e->getMessage());
        }

        return redirect()->route('admin.bookings.index')->with('success', __('page.bookingUpdated'));
    }
}