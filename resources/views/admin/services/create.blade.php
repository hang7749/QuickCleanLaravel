@extends('layouts.admin_app')

@section('title', 'Add New Service')

@section('content')
<div style="max-width: 700px; margin: 0 auto;">
    <h2 style="margin-bottom: 20px;">Add New Service</h2>
    
    <div style="background: #fff; padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0;">
        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Service Name</label>
                <input type="text" name="name" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Price (RM)</label>
                <input type="number" step="0.01" name="price" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Image URL</label>
                <input type="text" name="image_url" placeholder="https://example.com/image.png" 
                       style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-family: monospace; font-size: 13px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Description</label>
                <textarea name="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;"></textarea>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" style="background: #0f172a; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600; cursor: pointer;">Save Service</button>
                <a href="{{ route('admin.services.index') }}" style="padding: 12px 25px; text-decoration: none; color: #64748b; font-weight: 600;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection