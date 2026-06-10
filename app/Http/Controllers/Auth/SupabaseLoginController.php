<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class SupabaseLoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 1. Call Supabase Auth API
        $response = Http::withHeaders([
            'apikey' => env('SUPABASE_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('SUPABASE_URL') . '/auth/v1/token?grant_type=password', [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ]);

        if ($response->failed()) {
            return back()->withErrors(['email' => __('page.loginFailed')]);
        }

        $supabaseUser = $response->json()['user'];

        // 2. Sync with local Laravel Users table
        // This ensures Auth::user() works throughout your app
        $user = User::updateOrCreate(
            ['email' => $supabaseUser['email']],
            ['name' => $supabaseUser['user_metadata']['full_name'] ?? 'Supabase User']
        );

        // 3. Log into Laravel Session
        Auth::login($user);

        return redirect()->intended('/home');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Sync with local Laravel users table
            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name'      => $googleUser->name,
                    'username'  => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'password'  => bcrypt(\Illuminate\Support\Str::random(16)),
                ]
            );

            // Log into Laravel session
            Auth::login($user);

            return redirect('/home');

        } catch (\Exception $e) {
            return redirect('/')->withErrors(['email' => 'Google sign-in failed: ' . $e->getMessage()]);
        }
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            // Sync with local Laravel users table
            $user = User::updateOrCreate(
                ['email' => $facebookUser->email],
                [
                    'name'        => $facebookUser->name,
                    'username'    => str_replace(' ', '', $facebookUser->name), // Removes spaces for a cleaner username
                    'facebook_id' => $facebookUser->id, // Optional: if you track social IDs
                    'password'    => bcrypt(\Illuminate\Support\Str::random(16)),
                ]
            );

            // Log into Laravel session
            Auth::login($user);

            return redirect('/home');

        } catch (\Exception $e) {
            return redirect('/')->withErrors(['email' => 'Facebook sign-in failed.']);
        }
    }

    public function register(Request $request)
    {
        // 1. Add username to validation
        $data = $request->validate([
            'username' => 'required|string|max:50|unique:users,username', 
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        // 2. Call Supabase Auth Signup API
        $response = Http::withHeaders([
            'apikey' => env('SUPABASE_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('SUPABASE_URL') . '/auth/v1/signup', [
            'email'    => $data['email'],
            'password' => $data['password'],
            'options'  => [
                'data' => [
                    'full_name' => $data['username'],
                    'username'  => $data['username'], //
                ]
            ]
        ]);

        if ($response->failed()) {
            $error = $response->json()['msg'] ?? __('page.registrationFailed');
            return back()->withErrors(['email' => $error]);
        }

        if ($response->successful()) {
            // We wait a tiny bit for the Supabase trigger to sync to our 'public.users' table
            sleep(1); 

            $user = User::where('email', $data['email'])->first();
            
            if ($user) {
                Auth::login($user);
                return redirect('/home')->with('success', __('page.welcomeBack', ['name' => $user->username]));
            }
        }

        return redirect('/')->with('success', __('page.registrationSuccess'));
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 1. Verify with Supabase
        $response = Http::withHeaders([
            'apikey' => env('SUPABASE_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('SUPABASE_URL') . '/auth/v1/token?grant_type=password', [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ]);

        if ($response->failed()) {
            return back()->withErrors(['email' => __('page.loginFailed')]);
        }

        // 2. Check Role in local database
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || $user->role !== 'admin') {
            return back()->withErrors(['email' => __('page.loginFailed')]);
        }

        // 3. Log in to Laravel session
        Auth::login($user);

        return redirect('/admin/dashboard');
    }
}