<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #2563eb;
            --bg-light: #f8fafc;
            --sidebar-bg: #040319;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-light); color: #1e293b; overflow-x: hidden; }

        /* Sidebar - Default State */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: white;
            height: 100vh;
            position: fixed;
            left: 0; top: 0;
            z-index: 1000;
            transition: transform 0.3s ease;
            padding: 20px 0;
        }

        /* Sidebar Brand */
        .sidebar-brand {
            padding: 0 24px 30px;
            font-size: 20px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link {
            padding: 12px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 14px;
            transition: 0.2s;
        }
        .nav-link:hover, .nav-link.active { background: #1e293b; color: white; }
        .nav-link.active { border-left: 4px solid var(--primary-color); background: #1e293b; }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            transition: all 0.3s ease;
        }

        /* Topbar */
        .topbar {
            height: 64px;
            background: white;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: sticky;
            top: 0; z-index: 500;
        }

        /* Hamburger Menu Button */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--sidebar-bg);
        }

        /* Mobile Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        /* Alert Containers */
        .alert-success, .alert-error {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            position: relative;
            animation: slideDown 0.4s ease-out;
            border: 1px solid;
        }

        .alert-success {
            background-color: #f0fdf4;
            border-color: #bbf7d0;
            color: #166534;
        }

        .alert-error {
            background-color: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }

        .alert-icon {
            font-size: 20px;
            margin-right: 15px;
        }

        .alert-content p {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
        }

        .alert-close {
            margin-left: auto;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: currentColor;
            opacity: 0.5;
        }

        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* RESPONSIVE BREAKPOINT */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%); /* Hide sidebar */
            }
            .sidebar.active {
                transform: translateX(0); /* Slide in */
            }
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            .menu-toggle {
                display: block; /* Show hamburger on mobile */
            }
            .sidebar-overlay.active {
                display: block;
            }
        }

        .content-body { padding: 20px; }
        .btn-logout { background: #fee2e2; color: #ef4444; border: none; padding: 8px 12px; border-radius: 6px; font-weight: 600; cursor: pointer; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="overlay" onclick="toggleMenu()"></div>

    <aside class="sidebar" id="sidebar">
        <img src="{{ asset('quick_clean.png') }}" style="width: 250px;">
        <div class="sidebar-brand">
   
            Admin Panel
        </div>

        <nav>
            <a href="{{ route('admin.home') }}" class="nav-link {{ request()->routeIs('admin.home') ? 'active' : '' }}">🏠 Dashboard</a>
            <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">📅 Bookings</a>
            <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">🛠️ Services</a>
            <a href="{{ route('admin.providers.index') }}" class="nav-link {{ request()->routeIs('admin.providers.*') ? 'active' : '' }}">👤 Providers</a>
            <a href="{{ route('admin.members.index') }}" class="nav-link {{ request()->routeIs('admin.members.*') ? 'active' : '' }}">👥 Members</a>
            <hr style="border: 0; border-top: 1px solid #1e293b; margin: 15px 20px;">
            <a href="{{ route('admin.admins.index') }}" class="nav-link">🔐 Admins</a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <button class="menu-toggle" onclick="toggleMenu()">☰</button>

            <div></div> 

            <div style="display: flex; align-items: center; gap: 12px; margin-left: auto;">
                {{-- <span style="font-size: 14px; font-weight: 600; color: #64748b;">{{ auth()->user()->username }}</span> --}}
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </header>
        <div class="content-body">
            {{-- Success Alert --}}
            @if (session('success'))
                <div id="success-alert" class="alert-success">
                    <span class="alert-icon">✅</span>
                    <div class="alert-content">
                        <strong>Success!</strong>
                        <p>{{ session('success') }}</p>
                    </div>
                    <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            @endif

            {{-- Error Alert (Optional but recommended) --}}
            @if (session('error'))
                <div class="alert-error">
                    <span class="alert-icon">⚠️</span>
                    <div class="alert-content">
                        <strong>Error!</strong>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        function toggleMenu() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('overlay').classList.toggle('active');
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(() => {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = "0";
                    setTimeout(() => alert.remove(), 500);
                }, 4000); // 4 seconds
            }
        });
    </script>
    @stack('scripts')
</body>
</html>