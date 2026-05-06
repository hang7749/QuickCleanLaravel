@extends('layouts.admin_app')

@section('title', 'Add Provider')

@section('content')
<div style="max-width: 700px; margin: 0 auto;">
    <h2 style="margin-bottom: 20px;">Add Service Provider</h2>
    <div class="admin-section" style="background: #fff; padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0;">
        <form action="{{ route('admin.providers.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Full Name</label>
                <input type="text" name="name" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Specialty (Service Type)</label>
                <select name="specialty" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                    @foreach($services as $s)
                        <option value="{{ $s->name }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Phone Number</label>
                <input type="text" name="phone" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Photo URL</label>
                <input type="text" name="image_url" placeholder="https://..." style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_available" checked>
                    <span style="font-weight: 600;">Active / Available for Work</span>
                </label>
            </div>
            
            <div style="display: flex; gap: 10px;">
                 <button type="submit" style="flex: 1; background: #2563eb; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer;">Save Provider</button>
                <a href="{{ route('admin.providers.index') }}" style="flex: 1; text-align: center; background: #f1f5f9; color: #475569; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: 600;">Cancel</a>
            </div>
            
           
        </form>
    </div>
</div>
@endsection