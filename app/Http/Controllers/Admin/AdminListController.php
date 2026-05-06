<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminListController extends Controller
{
    public function index()
    {
        $admins = DB::table('users')
            ->where('role', 'admin')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        DB::table('users')->insert([
            'id' => (string) Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Securely hash password
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'New admin account created.');
    }

}