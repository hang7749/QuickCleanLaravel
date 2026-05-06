<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminProviderController extends Controller
{
    public function index()
    {
        $providers = DB::table('service_providers')->orderBy('name', 'asc')->get();
        return view('admin.providers.index', compact('providers'));
    }

    public function create()
    {
        // Fetch services so we can assign a provider to a category
        $services = DB::table('services')->get();
        return view('admin.providers.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'specialty' => 'required', // This matches the 'name' of the service
            'phone' => 'nullable',
            'image_url' => 'nullable|url'
        ]);

        DB::table('service_providers')->insert([
            'id' => (string) Str::uuid(),
            'name' => $request->name,
            'specialty' => $request->specialty,
            'phone' => $request->phone,
            'image_url' => $request->image_url,
            'is_available' => $request->has('is_available'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.providers.index')->with('success', 'Provider added successfully!');
    }

    public function edit($id)
    {
        $provider = DB::table('service_providers')->where('id', $id)->first();
        $services = DB::table('services')->get();
        return view('admin.providers.edit', compact('provider', 'services'));
    }

    public function update(Request $request, $id)
    {
        DB::table('service_providers')->where('id', $id)->update([
            'name' => $request->name,
            'specialty' => $request->specialty,
            'phone' => $request->phone,
            'image_url' => $request->image_url,
            'is_available' => $request->has('is_available'),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.providers.index')->with('success', 'Provider updated!');
    }

    public function destroy($id)
    {
        DB::table('service_providers')->where('id', $id)->delete();
        return redirect()->route('admin.providers.index')->with('success', 'Provider removed.');
    }
}