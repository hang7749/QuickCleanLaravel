<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Show the profile page.
     * Replaces: supabase.from('users').select().eq('id', user.id).single()
     */
    public function index()
    {
       return view('member.profile', ['user' => Auth::user()]);
    }

    /**
     * Update the user's display username.
     * Replaces: supabase.from('users').update({username}).eq('id', userId)
     */
    public function updateUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
        ]);

        $user = User::find(Auth::id());
        $user->username = $request->username;
        $user->save();

        return back()->with('success', 'Profile username updated successfully!');
    }

    /**
     * Update the user's password.
     * Replaces: supabase.auth.updateUser(UserAttributes(password: ...))
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
        ]);
        

        // Use the SERVICE_ROLE_KEY to act as an administrator
        $response = Http::withHeaders([
            'apikey' => env('SUPABASE_SERVICE_ROLE_KEY'), 
            'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_ROLE_KEY'),
            'Content-Type' => 'application/json',
        ])->put(env('SUPABASE_URL') . '/auth/v1/admin/users/' . Auth::id(), [
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            return back()->with('success', __('page.passwordUpdated'));
        }

        // Log error for debugging
        Log::error('Supabase Password Update Failed: ' . $response->body());

        return back()->with('error', __('page.passwordUpdateFailed'));
    }

    /**
     * Log the user out.
     * Replaces: supabase.auth.signOut()
     */
    public function logout(Request $request)
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        $request->session()->flush();

        return redirect()->route('login'); // change to route('login') when auth is set up
    }
}