{{-- resources/views/view_booking.blade.php --}}
@extends('layouts.member_app')

@section('title', 'QuickClean - ' . __('page.myBookings'))

@push('styles')
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: #f5f6f8; font-family: 'Segoe UI', sans-serif; color: #1a1a1a; }

    .topbar {
        background: #fff;
        border-bottom: 1px solid #e8eaed;
        position: sticky;
        top: 0;
        z-index: 100;
    }
    .topbar-row {
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .topbar .back-btn { background: none; border: none; cursor: pointer; font-size: 22px; color: #333; }
    .topbar h1 { font-size: 18px; font-weight: 700; }

    /* Tab Bar */
    .tab-bar {
        display: flex;
        border-top: 1px solid #f0f0f0;
    }
    .tab-btn {
        flex: 1;
        padding: 13px 0;
        background: none;
        border: none;
        border-bottom: 2.5px solid transparent;
        font-size: 15px;
        font-weight: 600;
        color: #999;
        cursor: pointer;
        font-family: inherit;
        transition: color 0.2s, border-color 0.2s;
    }
    .tab-btn.active {
        color: #1a1a1a;
        border-bottom-color: #1a1a1a;
    }

    /* Tab Panels */
    .tab-panel { display: none; padding: 16px; }
    .tab-panel.active { display: block; }

    /* Booking Card */
    .booking-card {
        background: #fff;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }
    .service-name { font-size: 17px; font-weight: 700; }
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.4px;
    }
    .badge-pending   { background: #fff8e1; color: #b45309; }
    .badge-confirmed { background: #dcfce7; color: #166534; }
    .badge-completed { background: #e8eaed; color: #555; }
    .badge-cancelled { background: #fee2e2; color: #b91c1c; }

    .card-divider { border: none; border-top: 1px solid #f0f0f0; margin: 0 0 14px; }

    .card-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        color: #555;
        flex-wrap: wrap;
    }
    .meta-icon { font-size: 16px; }
    .meta-sep { color: #ccc; margin: 0 6px; }

    .card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 14px;
    }
    .total-price { font-size: 16px; font-weight: 700; }
    .cancel-btn {
        background: none;
        border: none;
        color: #ef4444;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        padding: 6px 12px;
        border-radius: 8px;
        transition: background 0.15s;
    }
    .cancel-btn:hover { background: #fee2e2; }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
        font-size: 15px;
    }

    /* Cancel Confirm Dialog */
    .dialog-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.45);
        z-index: 500;
        align-items: center;
        justify-content: center;
    }
    .dialog-overlay.show { display: flex; }
    .dialog-box {
        background: #fff;
        border-radius: 16px;
        padding: 24px 20px 16px;
        width: 88%; max-width: 340px;
        animation: popIn 0.2s ease;
    }
    .dialog-box h2 { font-size: 17px; font-weight: 700; margin-bottom: 10px; }
    .dialog-box p  { font-size: 14px; color: #555; line-height: 1.5; }
    .dialog-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 20px;
    }
    .dialog-actions button {
        padding: 8px 20px;
        border: none; border-radius: 8px;
        font-size: 14px; font-weight: 600;
        cursor: pointer; font-family: inherit;
    }
    .btn-no     { background: #f0f0f0; color: #333; }
    .btn-yes    { background: #fee2e2; color: #b91c1c; }
    .btn-no:hover  { background: #e0e0e0; }
    .btn-yes:hover { background: #fecaca; }

    /* Toast */
    .toast {
        position: fixed;
        bottom: 24px; left: 50%;
        transform: translateX(-50%);
        padding: 12px 24px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        z-index: 600;
        display: none;
        white-space: nowrap;
    }
    .toast.success { background: #1a1a1a; color: #fff; display: block; }
    .toast.error   { background: #b91c1c; color: #fff; display: block; }

    @keyframes popIn { from { transform: scale(0.88); opacity: 0; } to { transform: scale(1); opacity: 1; } }
</style>
@endpush

@section('content')

<header class="topbar">
    <div class="topbar-row">
        <button class="back-btn" onclick="history.back()">&#8592;</button>
        <h1>{{ __('page.myBookings') }}</h1>
    </div>
    <div class="tab-bar">
        <button class="tab-btn active" onclick="switchTab('upcoming', this)">{{ __('page.upcoming') }}</button>
        <button class="tab-btn"        onclick="switchTab('history', this)">{{ __('page.history') }}</button>
    </div>
</header>

{{-- Flash Messages --}}
@if (session('success'))
    <div class="toast success" id="flash-toast">{{ session('success') }}</div>
@elseif (session('error'))
    <div class="toast error" id="flash-toast">{{ session('error') }}</div>
@endif

{{-- Upcoming Tab --}}
<div class="tab-panel active" id="tab-upcoming">
    @forelse ($upcoming as $booking)
        @include('partials.booking_card', ['booking' => $booking])
    @empty
        <div class="empty-state">{{ __('page.noBookingsFound') }}</div>
    @endforelse
</div>

{{-- History Tab --}}
<div class="tab-panel" id="tab-history">
    @forelse ($history as $booking)
        @include('partials.booking_card', ['booking' => $booking])
    @empty
        <div class="empty-state">{{ __('page.noBookingsFound') }}</div>
    @endforelse
</div>

{{-- Cancel Confirm Dialog --}}
<div class="dialog-overlay" id="cancel-dialog">
    <div class="dialog-box">
        <h2>{{ __('page.cancelBooking') }}</h2>
        <p>{{ __('page.confirmCancelBooking') }}</p>
        <div class="dialog-actions">
            <button class="btn-no" onclick="document.getElementById('cancel-dialog').classList.remove('show')">No</button>
            <form id="cancel-form" method="POST" style="display:inline">
                @csrf
                @method('PUT')
                <button type="submit" class="btn-yes">{{ __('page.cancel') }}</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Tab switching
    function switchTab(tab, btn) {
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.getElementById('tab-' + tab).classList.add('active');
        btn.classList.add('active');
    }

    // Open cancel dialog and set form action
    function confirmCancel(bookingId) {
        const form = document.getElementById('cancel-form');
        form.action = '/bookings/' + bookingId + '/cancel';
        document.getElementById('cancel-dialog').classList.add('show');
    }

    // Auto-hide flash toast after 3s
    const toast = document.getElementById('flash-toast');
    if (toast) setTimeout(() => toast.style.display = 'none', 3000);
</script>
@endpush