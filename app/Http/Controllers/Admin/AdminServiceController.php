<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = DB::table('services')->orderBy('name', 'asc')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image_url' => 'nullable|url', // Ensures it's a valid link
            'description' => 'nullable|string'
        ]);

        $imageUrl = $request->image_url ?? 'https://via.placeholder.com/150';

        DB::table('services')->insert([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image_url' => $imageUrl,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Service added!');
    }

    public function update(Request $request, String $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image_url' => 'nullable|url'
        ]);

        DB::table('services')->where('id', $id)->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image_url' => $request->image_url, // Added this
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Service updated!');
    }

    public function edit(String $id)
    {
        $service = DB::table('services')->where('id', $id)->first();
        return view('admin.services.edit', compact('service'));
    }

    public function destroy(String $id)
    {
        try {
            DB::table('services')->where('id', $id)->delete();
            return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.services.index')->with('error', 'Cannot delete service. It might be linked to active bookings.');
        }
    }

}