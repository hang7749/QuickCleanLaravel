<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminMemberController extends Controller
{
    public function index()
    {
        // Fetch users who are NOT admins
        $members = DB::table('users')
            ->where('role', '!=', 'admin') 
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.members.index', compact('members'));
    }

    public function edit(String $id)
    {
        $member = DB::table('users')->where('id', $id)->first();
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, String $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        DB::table('users')->where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.members.index')->with('success', 'Member profile updated.');
    }

    public function destroy(String $id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('admin.members.index')->with('success', 'Member account deleted.');
    }
}