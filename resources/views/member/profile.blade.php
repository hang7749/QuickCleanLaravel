{{-- resources/views/profile.blade.php --}}
@extends('layouts.member_app')

@section('title', 'Profile Details')

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
    .topbar .back-btn { background: none; border: none; cursor: pointer; font-size: 22px; color: #333; }
    .topbar h1 { font-size: 18px; font-weight: 700; }

    .page-body {
        max-width: 480px;
        margin: 0 auto;
        padding: 30px 20px 60px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Avatar */
    .avatar-wrap {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
    }
    .avatar-circle {
        width: 100px; height: 100px;
        border-radius: 50%;
        background: #e0e0e0;
        display: flex; align-items: center; justify-content: center;
        font-size: 52px;
        color: #555;
    }

    /* Form Fields */
    .field-group { display: flex; flex-direction: column; gap: 6px; }
    .field-group label { font-size: 13px; color: #777; font-weight: 500; }
    .input-wrap {
        display: flex;
        align-items: center;
        border: 1.5px solid #d1d5db;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
        transition: border-color 0.2s;
    }
    .input-wrap:focus-within { border-color: #1a73e8; }
    .input-wrap.disabled { background: #f5f6f8; }
    .input-wrap .icon {
        padding: 0 12px;
        font-size: 18px;
        color: #888;
        flex-shrink: 0;
    }
    .input-wrap input {
        border: none; outline: none;
        font-size: 15px; font-family: inherit;
        padding: 13px 12px 13px 0;
        width: 100%;
        background: transparent;
        color: #1a1a1a;
    }
    .input-wrap input:disabled { color: #888; cursor: not-allowed; }

    /* Toast */
    .toast {
        display: none;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 14px;
        text-align: center;
    }
    .toast.success { display: block; background: #dcfce7; color: #166534; border: 1px solid #86efac; }
    .toast.error   { display: block; background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

    /* Save Button */
    .save-btn {
        width: 100%; height: 54px;
        background: #1a1a1a; color: #fff;
        border: none; border-radius: 12px;
        font-size: 16px; font-weight: 600;
        cursor: pointer; font-family: inherit;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: background 0.2s;
    }
    .save-btn:hover:not(:disabled) { background: #333; }
    .save-btn:disabled { background: #888; cursor: not-allowed; }
    .save-btn .spinner {
        width: 20px; height: 20px;
        border: 3px solid rgba(255,255,255,0.4);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        display: none;
    }
    .save-btn.loading .btn-text { display: none; }
    .save-btn.loading .spinner  { display: block; }

    /* Divider */
    .divider { border: none; border-top: 1px solid #e8eaed; margin: 4px 0; }

    /* List Tiles */
    .list-tile {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 14px 4px;
        cursor: pointer;
        border-radius: 10px;
        text-decoration: none;
        color: inherit;
        transition: background 0.15s;
    }
    .list-tile:hover { background: #f5f6f8; }
    .list-tile .tile-icon { font-size: 22px; flex-shrink: 0; width: 28px; text-align: center; }
    .list-tile .tile-text h3 { font-size: 15px; font-weight: 600; }
    .list-tile .tile-text p  { font-size: 12px; color: #888; margin-top: 2px; }
    .list-tile .tile-arrow   { margin-left: auto; color: #bbb; font-size: 14px; }

    /* Bottom Sheet (Change Password) */
    .sheet-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.45);
        z-index: 400;
        align-items: flex-end;
        justify-content: center;
    }
    .sheet-overlay.show { display: flex; }
    .sheet-box {
        background: #fff;
        border-radius: 24px 24px 0 0;
        padding: 24px 20px 36px;
        width: 100%; max-width: 480px;
        animation: slideUp 0.25s ease;
    }
    .sheet-box h2 { font-size: 18px; font-weight: 700; text-align: center; margin-bottom: 20px; }
    .sheet-close { float: right; background: none; border: none; font-size: 20px; cursor: pointer; color: #888; margin-top: -4px; }
    .sheet-btn {
        width: 100%; height: 50px;
        background: #1a73e8; color: #fff;
        border: none; border-radius: 12px;
        font-size: 15px; font-weight: 600;
        cursor: pointer; font-family: inherit;
        margin-top: 16px;
        transition: background 0.2s;
    }
    .sheet-btn:hover { background: #1558b0; }

    /* Logout Dialog */
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
    .btn-cancel  { background: #f0f0f0; color: #333; }
    .btn-logout  { background: #fee2e2; color: #b91c1c; }
    .btn-cancel:hover { background: #e0e0e0; }
    .btn-logout:hover { background: #fecaca; }

    @keyframes spin    { to { transform: rotate(360deg); } }
    @keyframes slideUp { from { transform: translateY(100%); } to { transform: translateY(0); } }
    @keyframes popIn   { from { transform: scale(0.88); opacity: 0; } to { transform: scale(1); opacity: 1; } }
</style>
@endpush

@section('content')

<header class="topbar">
    <button class="back-btn" onclick="history.back()">&#8592;</button>
    <h1>Profile Details</h1>
</header>

<main class="page-body">

    {{-- Avatar --}}
    <div class="avatar-wrap">
        <div class="avatar-circle">👤</div>
    </div>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="toast success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="toast error">{{ session('error') }}</div>
    @endif

    {{-- Profile Update Form --}}
    <form method="POST" action="{{ route('profile.update') }}" id="profile-form">
        @csrf
        @method('PUT')

        {{-- Email (read only) --}}
        <div class="field-group" style="margin-bottom: 18px;">
            <label>Email Address</label>
            <div class="input-wrap disabled">
                <span class="icon">✉️</span>
                <input type="email" value="{{ $user['email'] }}" disabled>
            </div>
        </div>

        {{-- Full Name --}}
        <div class="field-group" style="margin-bottom: 24px;">
            <label>Full Name</label>
            <div class="input-wrap">
                <span class="icon">👤</span>
                <input type="text" name="name" id="name-input"
                       value="{{ old('name', $user['name']) }}"
                       placeholder="Enter your full name" required>
            </div>
            @error('name')
                <span style="font-size:12px; color:#b91c1c;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Save Button --}}
        <button type="button" class="save-btn" id="save-btn" onclick="saveProfile()">
            <span class="btn-text">Save Changes</span>
            <span class="spinner"></span>
        </button>
    </form>

    <hr class="divider" style="margin: 12px 0;">

    {{-- Change Password --}}
    <div class="list-tile" onclick="document.getElementById('password-sheet').classList.add('show')">
        <span class="tile-icon" style="color:#1a73e8;">🔒</span>
        <div class="tile-text">
            <h3>Change Password</h3>
            <p>Update your account security</p>
        </div>
        <span class="tile-arrow">›</span>
    </div>

    {{-- Logout --}}
    <div class="list-tile" onclick="document.getElementById('logout-dialog').classList.add('show')">
        <span class="tile-icon" style="color:#ef4444;">🚪</span>
        <div class="tile-text">
            <h3>Logout</h3>
            <p>Sign out of your account</p>
        </div>
        <span class="tile-arrow">›</span>
    </div>

</main>

{{-- Change Password Bottom Sheet --}}
<div class="sheet-overlay" id="password-sheet" onclick="closeSheet(event)">
    <div class="sheet-box">
        <button class="sheet-close" onclick="document.getElementById('password-sheet').classList.remove('show')">✕</button>
        <h2>Change Password</h2>

        <form method="POST" action="{{ route('profile.password') }}" id="password-form">
            @csrf
            @method('PUT')
            <div class="field-group">
                <label>New Password</label>
                <div class="input-wrap">
                    <span class="icon">🔑</span>
                    <input type="password" name="password" id="password-input"
                           placeholder="Min. 6 characters" minlength="6" required>
                </div>
            </div>
            <button type="submit" class="sheet-btn">Update Password</button>
        </form>
    </div>
</div>

{{-- Logout Confirmation Dialog --}}
<div class="dialog-overlay" id="logout-dialog">
    <div class="dialog-box">
        <h2>Logout</h2>
        <p>Are you sure you want to leave?</p>
        <div class="dialog-actions">
            <button class="btn-cancel" onclick="document.getElementById('logout-dialog').classList.remove('show')">Cancel</button>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function saveProfile() {
        const btn = document.getElementById('save-btn');
        btn.classList.add('loading');
        btn.disabled = true;
        document.getElementById('profile-form').submit();
    }

    // Close bottom sheet when tapping the backdrop
    function closeSheet(e) {
        if (e.target === document.getElementById('password-sheet')) {
            document.getElementById('password-sheet').classList.remove('show');
        }
    }
</script>
@endpush