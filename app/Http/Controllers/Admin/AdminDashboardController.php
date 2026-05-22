<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
  public function index()
    {
        // 1. Calculate Stats (This remains unchanged and safe, as total_price is stored on parent)
        $stats = [
            'total_revenue'   => DB::table('bookings')->where('status', 'confirmed')->sum('total_price'),
            'total_bookings'  => DB::table('bookings')->count(),
            'active_members'  => DB::table('users')->count(),
            'total_providers' => DB::table('service_providers')->count(),
        ];

        // 2. Recent Bookings (Last 5) - FIXED to traverse the junction table
        $recentBookings = DB::table('bookings')
            ->leftJoin('booking_assignments', 'bookings.id', '=', 'booking_assignments.booking_id')
            ->leftJoin('service_providers', 'booking_assignments.provider_id', '=', 'service_providers.id')
            ->select(
                'bookings.*', 
                DB::raw("string_agg(service_providers.name, ', ') as provider_names")
            )
            ->groupBy('bookings.id')
            ->orderBy('bookings.created_at', 'desc')
            ->limit(5)
            ->get();

        // 3. Status Breakdown for a Chart
        $statusCounts = DB::table('bookings')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return view('admin.home', compact('stats', 'recentBookings', 'statusCounts'));
    }
}