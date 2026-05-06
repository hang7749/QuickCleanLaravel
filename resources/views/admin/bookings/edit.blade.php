@extends('layouts.admin_app')

@section('title', 'Edit Booking')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <h2 style="margin-bottom: 20px;">Update Booking #{{ Str::limit($booking->id, 6) }}</h2>

    <div class="admin-section">
        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">Service Status</label>
                <select name="status" class="admin-input" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">Assigned Provider</label>
                <select name="provider_id" class="admin-input" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}" {{ $booking->provider_id == $provider->id ? 'selected' : '' }}>
                            {{ $provider->name }} ({{ $provider->specialty }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" style="background: #1e293b; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    Save Changes
                </button>
                <a href="{{ route('admin.bookings.index') }}" style="background: #f1f5f9; color: #1e293b; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection