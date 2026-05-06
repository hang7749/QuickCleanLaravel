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
        // 1. Calculate Stats
        $stats = [
            'total_revenue' => DB::table('bookings')->where('status', 'confirmed')->sum('total_price'),
            'total_bookings' => DB::table('bookings')->count(),
            'active_members' => DB::table('users')->count(),
            'total_providers' => DB::table('service_providers')->count(),
        ];

        // 2. Recent Bookings (Last 5)
        $recentBookings = DB::table('bookings')
            ->join('service_providers', 'bookings.provider_id', '=', 'service_providers.id')
            ->select('bookings.*', 'service_providers.name as provider_name')
            ->orderBy('bookings.created_at', 'desc')
            ->limit(5)
            ->get();

        // 3. Status Breakdown for a Chart (optional)
        $statusCounts = DB::table('bookings')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return view('admin.home', compact('stats', 'recentBookings', 'statusCounts'));
    }
}