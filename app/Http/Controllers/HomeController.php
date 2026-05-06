<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Get the currently logged in user (from Laravel session)
        $user = Auth::user();

        // 2. Fetch Services from your Supabase 'services' table
        $services = DB::table('services')->get()->map(function($item) {
            return (array) $item;
        });

        // 3. Fetch Top Rated Providers from your Supabase 'service_providers' table
        $providers = DB::table('service_providers')
            ->orderBy('rating', 'desc')
            ->take(5)
            ->get()
            ->map(function($item) {
                return (array) $item;
            });

        return view('member.home', compact('user', 'services', 'providers'));
    }
}