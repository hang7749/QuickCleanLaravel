@extends('layouts.admin_app')

@section('title', 'Create Admin')

@push('styles')
<style>
    .admin-section { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #e2e8f0; }
    .btn-add { background: #2563eb; color: #fff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; }
    .admin-table { width: 100%; border-collapse: collapse; }
    .admin-table th { text-align: left; padding: 12px; background: #f8fafc; border-bottom: 2px solid #edf2f7; color: #64748b; font-size: 12px; }
    .admin-table td { padding: 15px 12px; border-bottom: 1px solid #edf2f7; }
</style>
@endpush


@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <h2 style="margin-bottom: 20px;">Create Admin Account</h2>
    
    <div class="admin-section">
        <form action="{{ route('admin.admins.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Full Name</label>
                <input type="text" name="name" required style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Email Address</label>
                <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Initial Password</label>
                <input type="password" name="password" required placeholder="Min 6 characters" 
                       style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" style="flex: 1; background: #0f172a; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer;">Create Admin</button>
                <a href="{{ route('admin.admins.index') }}" style="flex: 1; text-align: center; background: #f1f5f9; color: #1e293b; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: 600;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection