<div class="booking-card">
    <div class="card-top">
        <span class="service-name">{{ $booking->service_type }}</span>
        <span class="status-badge badge-{{ $booking->status }}">
            {{ strtoupper($booking->status) }}
        </span>
    </div>

    <hr class="card-divider">

    <div class="card-meta">
        <span class="meta-icon">👤</span>
        <span>{{ $booking->provider_names }}</span>
        <span class="meta-sep">|</span>
        <span class="meta-icon">📅</span>
        <span>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</span>
        <span class="meta-sep">|</span>
        <span class="meta-icon">⏰</span>
        <span>{{ $booking->booking_time }}</span>
        <span class="meta-sep">|</span>
        <span class="meta-icon">{{ __('page.createdAt') }}:</span>
        <span>{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}</span>
    </div>

    <div class="card-footer">
        <span class="total-price">RM {{ number_format($booking->total_price, 2) }}</span>
        
        @if(in_array($booking->status, ['pending', 'confirmed']))
            <button class="cancel-btn" onclick="confirmCancel('{{ $booking->id }}')">
                {{ __('page.cancel') }}
            </button>
        @endif
    </div>
</div>