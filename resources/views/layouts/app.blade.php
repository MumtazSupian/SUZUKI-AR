<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AR Service - @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-wrapper">
        {{-- ===== Sidebar ===== --}}
        <aside class="sidebar" id="sidebar">
            {{-- Brand --}}
            <div class="sidebar-brand">
                <div class="brand-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M8 12l2 2 4-4"></path>
                    </svg>
                </div>
                <div>
                    <span class="brand-name">AR SERVICE</span>
                    <span class="brand-subtitle">Piutang Konsumen</span>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="sidebar-nav">
                {{-- Dashboard --}}
                <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" id="nav-dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span>Dashboard</span>
                </a>

                {{-- BP --}}
                <a href="{{ url('/bp') }}" class="nav-link {{ request()->is('bp*') ? 'active' : '' }}" id="nav-bp">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <span>BP</span>
                </a>

                {{-- GR (Expandable) --}}
                <div class="nav-group {{ request()->is('gr/*') ? 'open' : '' }}" id="grMenu">
                    <button class="nav-link nav-toggle" onclick="toggleSubmenu('grMenu')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg>
                        <span>GR</span>
                        <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="18 15 12 9 6 15"></polyline>
                        </svg>
                    </button>
                    <div class="nav-submenu">
                        <a href="{{ url('/gr/cinere') }}" class="nav-sublink {{ request()->is('gr/cinere*') ? 'active' : '' }}">
                            <span class="bullet"></span>CINERE
                        </a>
                        <a href="{{ url('/gr/jatiasih') }}" class="nav-sublink {{ request()->is('gr/jatiasih*') ? 'active' : '' }}">
                            <span class="bullet"></span>JATIASIH
                        </a>
                        <a href="{{ url('/gr/cianjur') }}" class="nav-sublink {{ request()->is('gr/cianjur*') ? 'active' : '' }}">
                            <span class="bullet"></span>CIANJUR
                        </a>
                        <a href="{{ url('/gr/ciawi') }}" class="nav-sublink {{ request()->is('gr/ciawi*') ? 'active' : '' }}">
                            <span class="bullet"></span>CIAWI
                        </a>
                    </div>
                </div>
            </nav>
        </aside>

        {{-- ===== Main Content ===== --}}
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    {{-- Settings Button --}}
    <button class="settings-btn" id="settingsBtn" title="Pengaturan">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="3"></circle>
            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
        </svg>
    </button>

    {{-- Sidebar Toggle Script --}}
    <script>
        function toggleSubmenu(id) {
            const group = document.getElementById(id);
            group.classList.toggle('open');
        }
    </script>

    @yield('scripts')
</body>
</html>
