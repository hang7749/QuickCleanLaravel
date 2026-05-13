{{-- resources/views/booking.blade.php --}}
@extends('layouts.member_app')

@section('title', 'QuickClean - ' . __('page.book') . ' ' . $serviceName)

@push('styles')
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

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
        font-size: 22px; color: #333; line-height: 1;
    }
    .topbar h1 { font-size: 18px; font-weight: 700; }

    .page-body {
        margin: 0 auto;
        padding: 24px 20px 40px;
        display: flex;
        flex-direction: column;
        gap: 28px;
    }

    .section-label {
        font-size: 17px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    /* Date Picker */
    .date-trigger {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f5f6f8;
        border-radius: 10px;
        padding: 14px 16px;
        cursor: pointer;
        font-size: 15px;
        border: none;
        width: 100%;
        color: #1a1a1a;
    }
    .date-trigger:hover { background: #eceef2; }
    #date-input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
        pointer-events: none;
    }

    /* Time Slots */
    .time-slots {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .time-chip {
        padding: 8px 16px;
        border-radius: 20px;
        border: 1.5px solid #e0e0e0;
        background: #f5f6f8;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.15s;
        font-family: inherit;
        color: #1a1a1a;
    }
    .time-chip:hover { border-color: #aaa; }
    .time-chip.selected {
        background: #1a1a1a;
        color: #fff;
        border-color: #1a1a1a;
    }

    /* Specialist Cards */
    .specialists-scroll {
        display: flex;
        gap: 14px;
        overflow-x: auto;
        padding-bottom: 6px;
        scrollbar-width: none;
    }
    .specialists-scroll::-webkit-scrollbar { display: none; }

    .specialist-card {
        width: 120px;
        flex-shrink: 0;
        border: 2px solid #e0e0e0;
        border-radius: 15px;
        padding: 14px 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        background: #fff;
        transition: border-color 0.15s, background 0.15s;
    }
    .specialist-card:hover { border-color: #aaa; }
    .specialist-card.selected {
        border-color: #1a73e8;
        background: rgba(26,115,232,0.06);
    }
    .specialist-card input[type="radio"] { display: none; }
    .specialist-card img {
        width: 56px; height: 56px;
        border-radius: 50%;
        object-fit: cover;
    }
    .specialist-card .sp-name {
        font-size: 12px;
        font-weight: 700;
        text-align: center;
        line-height: 1.3;
    }
    .specialist-card .sp-rating {
        font-size: 11px;
        color: #f59e0b;
    }
    .no-specialist {
        font-size: 14px;
        color: #888;
        padding: 20px 0;
    }

    /* Price Badge */
    .price-badge {
        display: inline-block;
        background: #f5f6f8;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 16px;
        font-weight: 700;
    }

    /* Toast / Alert */
    .toast {
        display: none;
        background: #ff9800;
        color: #fff;
        padding: 12px 18px;
        border-radius: 10px;
        font-size: 14px;
        margin-top: -10px;
    }
    .toast.show { display: block; }

    /* Confirm Button */
    .confirm-btn {
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
        transition: background 0.2s;
    }
    .confirm-btn:hover { background: #333; }
    .confirm-btn:active { transform: scale(0.99); }
</style>
@endpush
    
@section('content')

{{-- App Bar --}}
<header class="topbar">
    <a href="{{ url('/home') }}" class="back-btn" style="text-decoration: none; display: inline-block;">&#8592;</a>
    <h1>{{ __('page.book') }} {{ $serviceName }}</h1>
</header>

<main class="page-body">
    {{-- Select Date --}}
    <div>
        <p class="section-label">{{ __('page.selectDate') }}</p>
        <input type="date" id="date-input"
               min="{{ now()->addDay()->toDateString() }}"
               max="{{ now()->addDays(30)->toDateString() }}"
               value="{{ now()->addDay()->toDateString() }}">
        <button class="date-trigger" id="date-trigger" onclick="document.getElementById('date-input').showPicker()">
            <span id="date-display">{{ now()->addDay()->format('d/m/Y') }}</span>
            <span>📅</span>
        </button>
    </div>

    {{-- Select Time --}}
    <div>
        <p class="section-label">{{ __('page.selectTime') }}</p>
        <div class="time-slots">
            @php
                $timeSlots = ['10:00 AM','11:00 AM','12:00 PM','1:00 PM','2:00 PM','3:00 PM','4:00 PM','5:00 PM'];
            @endphp
            @foreach ($timeSlots as $slot)
                <button class="time-chip {{ $loop->first ? 'selected' : '' }}"
                        onclick="selectTime(this, '{{ $slot }}')">
                    {{ $slot }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Select Specialist --}}
    <div>
        <p class="section-label">{{ __('page.selectSpecialist') }}</p>
        @if ($providers->isEmpty())
            <p class="no-specialist">{{ __('page.noSpecialist') }}</p>
        @else
            <div class="specialists-scroll">
                @foreach ($providers as $provider)
                    <label class="specialist-card" id="card-{{ $provider->id }}"
                           onclick="selectProvider('{{ $provider->id }}')">
                        <input type="radio" name="provider_id" value="{{ $provider->id }}">
                        <img src="{{ $provider->image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($provider->name) }}"
                             alt="{{ $provider->name }}">
                        <span class="sp-name">{{ $provider->name }}</span>
                        {{-- Change from $provider['rating'] to $provider->rating --}}
                        <span class="sp-rating">★ {{ number_format($provider->rating, 1) }}</span>
                    </label>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Price --}}
    <div>
        <p class="section-label">{{ __('page.price') }}</p>
        <span class="price-badge">RM {{ number_format($service['price'], 2) }}</span>
    </div>

    {{-- Toast Alert --}}
    <div class="toast" id="toast">{{ __('page.selectSpecialist') }}</div>

    {{-- Confirm Button --}}
    <button type="button" class="confirm-btn" onclick="proceedToPayment()">
        {{ __('page.confirmBooking') }}
    </button>

</main>

{{-- Hidden form to POST to payment --}}
<form id="booking-form" method="POST" action="{{ route('booking.proceed') }}" style="display:none">
    @csrf
    <input type="hidden" name="service_type"  value="{{ $serviceName }}">
    <input type="hidden" name="service_id"    value="{{ $serviceId }}">
    
    {{-- FIX: Use Object syntax -> instead of array [] --}}
    <input type="hidden" name="total_price"   value="{{ $service['price'] }}">
    
    <input type="hidden" name="booking_date"  id="form-date"     value="{{ now()->addDay()->toDateString() }}">
    <input type="hidden" name="booking_time"  id="form-time"     value="10:00 AM">
    <input type="hidden" name="provider_id"   id="form-provider" value="">
</form>

@endsection

@push('scripts')
<script>
    let selectedTime     = "10:00 AM";
    let selectedProvider = null;

    // Date picker
    const dateInput   = document.getElementById('date-input');
    const dateDisplay = document.getElementById('date-display');
    dateInput.addEventListener('change', function () {
        const [y, m, d] = this.value.split('-');
        dateDisplay.textContent = `${d}/${m}/${y}`;
        document.getElementById('form-date').value = this.value;
    });

    // Time chip selection
    function selectTime(el, time) {
        document.querySelectorAll('.time-chip').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
        selectedTime = time;
        document.getElementById('form-time').value = time;
    }

    // Specialist card selection
    function selectProvider(id) {
        document.querySelectorAll('.specialist-card').forEach(c => c.classList.remove('selected'));
        document.getElementById('card-' + id).classList.add('selected');
        selectedProvider = id;
        document.getElementById('form-provider').value = id;
        document.getElementById('toast').classList.remove('show');
    }

    // Confirm booking
    function proceedToPayment() {
        if (!selectedProvider) {
            const toast = document.getElementById('toast');
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
            return;
        }
        document.getElementById('booking-form').submit();
    }
</script>
@endpush