{{-- resources/views/payment.blade.php --}}
@extends('layouts.member_app')

@section('title', 'Payment')

@push('styles')
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: #f4f6fa; font-family: 'Segoe UI', sans-serif; color: #1a1a1a; }

    .topbar {
        background: #fff;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid #e8eaed;
        position: sticky;
        top: 0;
        z-index: 100;
    }
    .topbar .back-btn {
        background: none; border: none; cursor: pointer;
        font-size: 22px; color: #333;
    }
    .topbar h1 { font-size: 18px; font-weight: 700; }

    .page-body {
        max-width: 480px;
        margin: 0 auto;
        padding: 24px 20px;
        min-height: calc(100vh - 57px);
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Booking Summary Card */
    .summary-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.07);
        overflow: hidden;
    }
    .summary-card .card-header {
        background: #1a1a1a;
        color: #fff;
        padding: 16px 20px;
        font-size: 15px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    .summary-card .card-body { padding: 0 20px; }
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
    }
    .summary-row:last-child { border-bottom: none; }
    .summary-row .label { color: #777; }
    .summary-row .value { font-weight: 600; color: #1a1a1a; }
    .summary-row.total .label { font-size: 16px; font-weight: 700; color: #1a1a1a; }
    .summary-row.total .value { font-size: 20px; font-weight: 700; color: #1a73e8; }

    /* Status badge */
    .status-badge {
        display: inline-block;
        background: #fff8e1;
        color: #b45309;
        border-radius: 20px;
        padding: 3px 12px;
        font-size: 12px;
        font-weight: 600;
    }

    /* Spacer */
    .spacer { flex: 1; }

    /* Pay Button */
    .pay-btn {
        width: 100%;
        height: 58px;
        background: #1a1a1a;
        color: #fff;
        border: none;
        border-radius: 15px;
        font-size: 17px;
        font-weight: 700;
        cursor: pointer;
        font-family: inherit;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: background 0.2s;
    }
    .pay-btn:hover:not(:disabled) { background: #333; }
    .pay-btn:disabled { background: #888; cursor: not-allowed; }
    .pay-btn .spinner {
        width: 22px; height: 22px;
        border: 3px solid rgba(255,255,255,0.4);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        display: none;
    }
    .pay-btn.processing .btn-text { display: none; }
    .pay-btn.processing .spinner { display: block; }

    /* Error Toast */
    .toast-error {
        display: none;
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fca5a5;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 14px;
        text-align: center;
    }
    .toast-error.show { display: block; }

    /* Success Modal Overlay */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 500;
        align-items: center;
        justify-content: center;
    }
    .modal-overlay.show { display: flex; }
    .modal-box {
        background: #fff;
        border-radius: 20px;
        padding: 36px 28px 24px;
        text-align: center;
        max-width: 320px;
        width: 90%;
        animation: popIn 0.25s ease;
    }
    .modal-box .check-icon {
        font-size: 64px;
        line-height: 1;
        margin-bottom: 16px;
    }
    .modal-box h2 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .modal-box p {
        font-size: 14px;
        color: #666;
        line-height: 1.6;
        margin-bottom: 24px;
    }
    .modal-box .home-btn {
        display: block;
        background: #1a1a1a;
        color: #fff;
        border-radius: 12px;
        padding: 13px;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s;
    }
    .modal-box .home-btn:hover { background: #333; }

    @keyframes spin { to { transform: rotate(360deg); } }
    @keyframes popIn {
        from { transform: scale(0.85); opacity: 0; }
        to   { transform: scale(1);    opacity: 1; }
    }
</style>
@endpush

@section('content')

<header class="topbar">
    <button class="back-btn" onclick="history.back()">&#8592;</button>
    <h1>Payment</h1>
</header>

<main class="page-body">

    {{-- Booking Summary Card --}}
    <div class="summary-card">
        <div class="card-header">Booking Summary</div>
        <div class="card-body">
            <div class="summary-row">
                <span class="label">Service</span>
                <span class="value">{{ $bookingData['service_type'] }}</span>
            </div>
            <div class="summary-row">
                <span class="label">Date</span>
                <span class="value">{{ \Carbon\Carbon::parse($bookingData['booking_date'])->format('d M Y') }}</span>
            </div>
            <div class="summary-row">
                <span class="label">Time</span>
                <span class="value">{{ $bookingData['booking_time'] }}</span>
            </div>
            <div class="summary-row">
                <span class="label">Status</span>
                <span class="value"><span class="status-badge">Pending</span></span>
            </div>
            <div class="summary-row total">
                <span class="label">Total Amount</span>
                <span class="value">RM {{ number_format($bookingData['total_price'], 2) }}</span>
            </div>
        </div>
    </div>

    <div class="spacer"></div>

    {{-- Error Toast --}}
    <div class="toast-error" id="error-toast"></div>

    {{-- Pay Now Button --}}
    <form id="payment-form" method="POST" action="{{ route('payment.process') }}">
        @csrf
        <input type="hidden" name="service_type"  value="{{ $bookingData['service_type'] }}">
        <input type="hidden" name="booking_date"  value="{{ $bookingData['booking_date'] }}">
        <input type="hidden" name="booking_time"  value="{{ $bookingData['booking_time'] }}">
        <input type="hidden" name="total_price"   value="{{ $bookingData['total_price'] }}">
        <input type="hidden" name="provider_id"   value="{{ $bookingData['provider_id'] }}">

        <button type="button" class="pay-btn" id="pay-btn" onclick="processPayment()">
            <span class="btn-text">Pay Now &amp; Confirm</span>
            <span class="spinner"></span>
        </button>
    </form>

</main>

{{-- Success Modal (replaces Flutter AlertDialog) --}}
@if (session('booking_success'))
<div class="modal-overlay show" id="success-modal">
    <div class="modal-box">
        <div class="check-icon">✅</div>
        <h2>Payment Successful!</h2>
        <p>Your booking is now confirmed.<br>We'll see you on the scheduled date.</p>
        <a href="{{ route('home') }}" class="home-btn">Back to Home</a>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
    function processPayment() {
        const btn = document.getElementById('pay-btn');
        btn.classList.add('processing');
        btn.disabled = true;

        // This MUST match the <form id="payment-form">
        const form = document.getElementById('payment-form');
        
        if(form) {
            // We add a slight delay to show the "Processing" spinner
            setTimeout(() => {
                form.submit();
            }, 1500); 
        } else {
            console.error("Form not found!");
        }
    }
</script>
@endpush