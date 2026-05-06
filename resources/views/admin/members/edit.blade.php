@extends('layouts.admin_app')

@section('title', 'Edit Member')

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
<div style="max-width: 600px; margin: 0 auto;">
    <h2 style="margin-bottom: 20px;">Edit Member Profile</h2>

    <div class="admin-section">
        <form action="{{ route('admin.members.update', $member->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Full Name</label>
                <input type="text" name="name" value="{{ $member->name }}" required style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">Email Address</label>
                <input type="email" name="email" value="{{ $member->email }}" required style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" style="background: #2563eb; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer;">Update Member</button>
                <a href="{{ route('admin.members.index') }}" style="background: #f1f5f9; color: #1e293b; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection