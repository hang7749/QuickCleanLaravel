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

    /* Input Field Style Triggers */
    .date-trigger, .time-trigger {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fffefe;
        border-radius: 10px;
        padding: 14px 16px;
        cursor: pointer;
        font-size: 15px;
        border: none;
        width: 100%;
        color: #1a1a1a;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .date-trigger:hover, .time-trigger:hover { background: #eceef2; }
    
    #date-input, #time-input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
        pointer-events: none;
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
    .specialist-card input[type="checkbox"] { display: none; }
    
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
        font-size: 18px;
        font-weight: 700;
        color: #1a73e8;
        transition: all 0.2s ease;
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
    {{-- Validation Error Feedback Block --}}
    @if ($errors->any())
        <div style="background: #fee2e2; border: 1px solid #fca5a5; border-radius: 12px; padding: 14px;">
            <ul style="color: #b91c1c; font-size: 13px; list-style-type: none; padding-left: 0;">
                @foreach ($errors->all() as $error)
                    <li style="margin-bottom: 4px;">⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CRITICAL FIX: Wrap your structural inputs AND selector cards inside the single active <form> element block --}}
    <form id="booking-form" action="{{ route('booking.proceed') }}" method="POST" style="display: flex; flex-direction: column; gap: 28px;">
        @csrf
        
        <!-- Hidden Parameter Handlers -->
        <input type="hidden" name="service_id" value="{{ $serviceId }}">
        <input type="hidden" name="service_type" value="{{ $serviceName }}">
        <input type="hidden" name="booking_date" id="hidden-date">
        <input type="hidden" name="booking_time" id="hidden-time">
        <input type="hidden" name="total_price" id="hidden-total">

        {{-- Select Date --}}
        <div>
            <p class="section-label">{{ __('page.selectDate') }}</p>
            <input type="date" id="date-input"
                   min="{{ now()->addDay()->toDateString() }}"
                   max="{{ now()->addDays(30)->toDateString() }}"
                   value="{{ now()->addDay()->toDateString() }}">
            <button type="button" class="date-trigger" id="date-trigger" onclick="document.getElementById('date-input').showPicker()">
                <span id="date-display">{{ now()->addDay()->format('d/m/Y') }}</span>
                <span>📅</span>
            </button>
        </div>

        {{-- Select Time --}}
        <div>
            <p class="section-label">{{ __('page.selectTime') }}</p>
            <input type="time" id="time-input" value="10:00">
            <button type="button" class="time-trigger" id="time-trigger" onclick="document.getElementById('time-input').showPicker()">
                <span id="time-display">10:00 AM</span>
                <span>🕒</span>
            </button>
        </div>

        {{-- Select Specialist --}}
        <div>
            <p class="section-label">{{ __('page.selectSpecialist') }}</p>
            @if ($providers->isEmpty())
                <p class="no-specialist">{{ __('page.noSpecialist') }}</p>
            @else
                <div class="specialists-scroll">
                    @foreach ($providers as $provider)
                        <label class="specialist-card" id="card-{{ $provider->id }}">
                            <input type="checkbox" name="provider_ids[]" value="{{ $provider->id }}" id="check-{{ $provider->id }}" onchange="toggleProvider('{{ $provider->id }}')">
                            <img src="{{ $provider->image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($provider->name) }}" alt="{{ $provider->name }}">
                            <span class="sp-name">{{ $provider->name }}</span>
                            <span class="sp-rating">★ {{ number_format($provider->rating, 1) }}</span>
                        </label>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Price --}}
        <div>
            <p class="section-label">{{ __('page.price') }}</p>
            <span class="price-badge" id="display-price">RM {{ number_format($service['price'], 2) }}</span>
        </div>

        {{-- Toast Alert --}}
        <div class="toast" id="toast">{{ __('page.selectSpecialist') }}</div>

        {{-- Confirm Button inside form block --}}
        <button type="button" class="confirm-btn" onclick="proceedToPayment()">
            {{ __('page.confirmBooking') }}
        </button>
    </form>
</main>

@endsection

@push('scripts')
<script>
    // Base configuration parameters
    const basePrice = parseFloat("{{ $service['price'] }}");
    let selectedProviders = [];

    // Elements cache
    const dateInput = document.getElementById('date-input');
    const dateDisplay = document.getElementById('date-display');
    const timeInput = document.getElementById('time-input');
    const timeDisplay = document.getElementById('time-trigger').querySelector('span');
    
    const hiddenDate = document.getElementById('hidden-date');
    const hiddenTime = document.getElementById('hidden-time');
    const hiddenTotal = document.getElementById('hidden-total');

    // Initialize hidden fields default value state tracking
    window.addEventListener('DOMContentLoaded', () => {
        hiddenDate.value = dateInput.value;
        
        // Formulating initial 10:00 AM string formatting logic natively 
        hiddenTime.value = "10:00 AM";
        hiddenTotal.value = basePrice.toFixed(2);
    });

    // Date picker synchronization 
    dateInput.addEventListener('change', function () {
        if (!this.value) return;
        const [y, m, d] = this.value.split('-');
        dateDisplay.textContent = `${d}/${m}/${y}`;
        hiddenDate.value = this.value;
    });

    // Time Picker Logic with 12-hour formatting translation adjustments
    timeInput.addEventListener('change', function () {
        let timeString = this.value; 
        if (!timeString) return;
        
        let [hours, minutes] = timeString.split(':');
        let ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; 
        
        let formattedTime = `${hours}:${minutes} ${ampm}`;
        timeDisplay.textContent = formattedTime;
        hiddenTime.value = formattedTime;
    });

    // Multiple Checkbox Toggling Engine Logic
    function toggleProvider(id) {
        const card = document.getElementById('card-' + id);
        const checkbox = document.getElementById('check-' + id);
        const index = selectedProviders.indexOf(id);

        if (checkbox.checked) {
            if (index === -1) {
                selectedProviders.push(id);
            }
            card.classList.add('selected');
        } else {
            if (index > -1) {
                selectedProviders.splice(index, 1);
            }
            card.classList.remove('selected');
        }

        document.getElementById('toast').classList.remove('show');
        calculateTotalPrice();
    }

    function calculateTotalPrice() {
        // Multiplier defaults down safely to base pricing if none chosen visually
        const multiplier = selectedProviders.length === 0 ? 1 : selectedProviders.length;
        const currentTotal = basePrice * multiplier;

        document.getElementById('display-price').textContent = `RM ${currentTotal.toFixed(2)}`;
        hiddenTotal.value = currentTotal.toFixed(2);
    }

    // Submit Validation Check Block
    function proceedToPayment() {
        if (selectedProviders.length === 0) {
            const toast = document.getElementById('toast');
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
            return;
        }
        document.getElementById('booking-form').submit();
    }
</script>
@endpush