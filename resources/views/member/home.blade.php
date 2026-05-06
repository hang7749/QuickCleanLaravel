@extends('layouts.member_app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@section('title', 'QuickClean - Home')

@push('styles')
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: #f4f6fa; font-family: 'Segoe UI', sans-serif; color: #1a1a1a; }

    .topbar {
        background: #fff;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #e8eaed;
        position: sticky;
        top: 0;
        z-index: 100;
    }
    .topbar h1 { font-size: 20px; font-weight: 700; color: #000000; }
    .topbar .notif-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 22px;
        color: #555;
        position: relative;
    }
    .notif-badge {
        position: absolute;
        top: -4px; right: -4px;
        background: #e53935;
        color: #fff;
        font-size: 10px;
        border-radius: 50%;
        width: 16px; height: 16px;
        display: flex; align-items: center; justify-content: center;
    }

    .page-body {
        /* max-width: 480px; */
        margin: 0 auto;
        padding: 20px 16px 100px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Profile Card */
    .profile-card {
        background: #fff;
        border-radius: 20px;
        padding: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.07);
        animation: fadeInUp 0.4s ease;
    }
    .profile-card .top-row {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .profile-card .avatar {
        width: 70px; height: 70px;
        border-radius: 15px;
        object-fit: cover;
        flex-shrink: 0;
    }
    .profile-card .info h2 { font-size: 18px; font-weight: 700; }
    .profile-card .info p { font-size: 15px; color: #666; margin-top: 4px; }
    .profile-card .view-profile-btn {
        display: block;
        margin-top: 14px;
        background: #1a73e8;
        color: #fff;
        text-align: center;
        border-radius: 12px;
        padding: 10px;
        font-size: 15px;
        font-weight: 500;
        text-decoration: none;
        transition: background 0.2s;
    }
    .profile-card .view-profile-btn:hover { background: #1558b0; }

    /* My Bookings Banner */
    .bookings-banner {
        background: #fff;
        border-radius: 20px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none;
        color: inherit;
        transition: box-shadow 0.2s;
    }
    .bookings-banner:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.1); }
    .bookings-banner h3 { font-size: 16px; font-weight: 700; }
    .bookings-banner p { font-size: 12px; color: #888; margin-top: 4px; }
    .bookings-banner .arrow { color: #999; font-size: 14px; }

    /* Section Title */
    .section-title {
        font-size: 18px;
        font-weight: 700;
        padding: 0 4px;
    }

    /* Services Grid */
    .services-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }
    .service-card {
        background: rgba(255,245,245,245);
        border-radius: 16px;
        padding: 14px 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: #1a1a1a;
        transition: transform 0.15s, box-shadow 0.15s;
        animation: fadeInUp 0.4s ease both;
        cursor: pointer;
    }
    .service-card:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,0.1); }
    .service-card img { width: 45px; height: 45px; object-fit: contain; }
    .service-card span { font-size: 13px; font-weight: 500; text-align: center; line-height: 1.3; }

    /* Top Rated */
    .providers-scroll {
        display: flex;
        gap: 14px;
        overflow-x: auto;
        padding-bottom: 6px;
   
    }

    .provider-card {
        background: #fff;
        border: 1.5px solid #e8eaed;
        border-radius: 16px;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        gap: 14px;
        flex-shrink: 0;
        min-width: 210px;
        animation: fadeInUp 0.5s ease both;
    }

    
    .provider-card img {
        width: 52px; height: 52px;
        border-radius: 14px;
        object-fit: cover;
        flex-shrink: 0;
    }
    .provider-card .meta h4 { font-size: 14px; font-weight: 700; white-space: nowrap; }
    .provider-card .meta p { font-size: 13px; color: #666; margin-top: 3px; }
    .provider-card .rating {
        margin-left: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        flex-shrink: 0;
    }
    .provider-card .rating span { font-size: 14px; font-weight: 700; }
    .provider-card .rating .star { color: #f59e0b; font-size: 18px; }

    /* Bottom Nav */
    .bottom-nav {
        position: fixed;
        bottom: 0; left: 0; right: 0;
        background: #fff;
        border-top: 1px solid #e8eaed;
        display: flex;
        justify-content: space-around;
        padding: 10px 0 14px;
        z-index: 200;
    }
    .nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 3px;
        text-decoration: none;
        color: #555;
        font-size: 11px;
        font-weight: 500;
        transition: color 0.2s;
    }
    .nav-item .icon { font-size: 22px; }
    .nav-item { color: #1a73e8; }
    .nav-item.phone { color: #1a73e8; }
    .nav-item.whatsapp { color: #22c55e; }
    .nav-item.email { color: #ef4444; }
    .nav-item.messenger { color: #0084ff; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')

{{-- Top App Bar --}}
<header class="topbar">
    <h1>QuickClean</h1>
</header>

<main class="page-body">
    {{-- Profile Card --}}
    <div class="profile-card">
        <div class="top-row">
            <img class="avatar"
                 src="https://images.pexels.com/photos/355164/pexels-photo-355164.jpeg?crop=faces&fit=crop&h=200&w=200&auto=compress&cs=tinysrgb"
                 alt="User avatar">
            <div class="info">
                <h2>Hello, {{ $user['name'] ?? 'Guest' }}</h2>
                <p>{{ $user['email'] ?? '-' }}</p>
            </div>
        </div>
        <a href="{{ route('profile') }}" class="view-profile-btn">View Profile</a>
    </div>

    {{-- My Bookings Banner --}}
    <a href="{{ route('booking.index') }}" class="bookings-banner">
        <div>
            <h3>My Bookings</h3>
            <p>Check your service schedule</p>
        </div>
        <span class="arrow">›</span>
    </a>

    {{-- Services Section --}}
    <p class="section-title">Bookings</p>
    <div class="services-grid">
        @foreach ($services as $index => $service)
            <a href="{{ route('booking.show', ['id' => $service['id']]) }}"
               class="service-card"
               style="animation-delay: {{ $index * 100 }}ms">
                <img src="{{ $service['image_url'] }}" alt="{{ $service['name'] }}">
                <span>{{ $service['name'] }}</span>
            </a>
        @endforeach
    </div>

    {{-- Top Rated Section --}}
    <p class="section-title">Top Rated</p>
    <div class="providers-scroll">
        @foreach ($providers as $index => $provider)
            <div class="provider-card" style="animation-delay: {{ $index * 150 }}ms">
                <img src="{{ $provider['image_url'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($provider['name']) }}"
                     alt="{{ $provider['name'] }}">
                <div class="meta">
                    <h4>{{ $provider['name'] }}</h4>
                    <p>{{ $provider['specialty'] }}</p>
                </div>
                <div class="rating">
                    <span>{{ number_format($provider['rating'], 1) }}</span>
                    <span class="star">★</span>
                </div>
            </div>
        @endforeach
    </div>

</main>

{{-- Bottom Nav / Contact Bar --}}
<nav class="bottom-nav">
    <a href="tel:+123456789" class="nav-item phone">
        <i class="fas fa-phone"></i>
        <span>Call</span>
    </a>

    <a href="https://wa.me/123456789" target="_blank" class="nav-item whatsapp">
        <i class="fab fa-whatsapp"></i>
        <span>WhatsApp</span>
    </a>

    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=info@clean.com&su=Service Inquiry&body=Hello"
       target="_blank"
       class="nav-item email">
        <i class="fas fa-envelope"></i>
        <span>Email</span>
    </a>

    <a href="https://m.me/YOUR_PAGE_ID" target="_blank" class="nav-item messenger">
        <i class="fab fa-facebook-messenger"></i>
        <span>Messenger</span>
    </a>
</nav>

{{-- Success Modal Popup --}}
@if (session('booking_success'))
    <div id="success-modal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 20px;">
        <div style="background: #fff; border-radius: 24px; padding: 32px; text-align: center; max-width: 320px; width: 100%; box-shadow: 0 10px 25px rgba(0,0,0,0.2); animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
            <div style="font-size: 60px; margin-bottom: 15px;">🎉</div>
            <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 8px; color: #1a1a1a;">All Set!</h2>
            <p style="color: #666; font-size: 15px; line-height: 1.5; margin-bottom: 24px;">Your booking was successful.</p>
            
            <button onclick="document.getElementById('success-modal').style.display='none'" 
                    style="width: 100%; background: #1a1a1a; color: #fff; border: none; padding: 14px; border-radius: 12px; font-weight: 700; cursor: pointer;">
                Awesome!
            </button>
        </div>
    </div>

    <style>
        @keyframes popIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    </style>
@endif

@endsection