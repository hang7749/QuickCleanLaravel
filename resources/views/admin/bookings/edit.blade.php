@extends('layouts.admin_app')

@section('title', __('page.editBooking') . ' | QuickClean')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <h2 style="margin-bottom: 20px;">{{ __('page.editBooking') }}</h2>

    <div class="admin-section">
        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">{{ __('page.status') }}</label>
                <select name="status" class="admin-input" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>{{ __('page.pending') }}</option>
                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>{{ __('page.confirmed') }}</option>
                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>{{ __('page.completed') }}</option>
                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>{{ __('page.cancelled') }}</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">{{ __('page.provider') }}</label>
                
                {{-- FIXED: Changed name to provider_ids[] and added 'multiple' --}}
                <select name="provider_ids[]" class="admin-input" multiple style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; min-height: 120px;">
                    @foreach($providers as $provider)
                        {{-- FIXED: Checking if this provider's ID exists in our active assignment array --}}
                        <option value="{{ $provider->id }}" {{ in_array($provider->id, $currentProviderIds ?? []) ? 'selected' : '' }}>
                            {{ $provider->name }} ({{ $provider->specialty }})
                        </option>
                    @endforeach
                </select>
                <small style="color: #64748b; display: block; margin-top: 6px;">
                    Hold <strong>Ctrl</strong> (Windows) or <strong>Command</strong> (Mac) to select multiple specialists.
                </small>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" style="background: #1e293b; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    {{ __('page.save') }}
                </button>
                <a href="{{ route('admin.bookings.index') }}" style="background: #f1f5f9; color: #1e293b; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;">{{ __('page.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection