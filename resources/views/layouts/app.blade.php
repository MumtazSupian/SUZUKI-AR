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

    <style>
        .app-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
            background-color: #0b1329;
        }

        .sidebar {
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 100;
            box-sizing: border-box;
        }

        .sidebar-brand {
            padding: 16px 12px;
            gap: 8px;
        }
        .brand-name {
            font-size: 13px !important;
        }
        .brand-subtitle {
            font-size: 10px !important;
        }
        .sidebar-nav .nav-link {
            padding: 10px 12px;
            font-size: 13px;
        }

        .main-content {
            flex: 1;
            margin-left: 200px;
            width: calc(100% - 200px);
            min-width: 0;
            box-sizing: border-box;
            padding: 24px;
            position: relative;
        }

        @media (max-width: 991px) {
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="app-wrapper">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon" style="width: 28px; height: 28px; flex-shrink: 0;">
                    <img src="{{ asset('assets/suzuki-icon.jpeg') }}" alt="Suzuki Logo"
                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                </div>
                <div style="min-width: 0;">
                    <span class="brand-name" style="display: block; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">AR SERVICE</span>
                    <span class="brand-subtitle" style="display: block; color: #8a99ad; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Piutang Konsumen</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" id="nav-dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ url('/bp') }}" class="nav-link {{ request()->is('bp*') ? 'active' : '' }}" id="nav-bp">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <span>BP</span>
                </a>

                <div class="nav-group {{ request()->is('gr/*') ? 'open' : '' }}" id="grMenu">
                    <button class="nav-link nav-toggle" onclick="toggleSubmenu('grMenu')" style="width: 100.2%; text-align: left;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px; height:18px;">
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg>
                        <span>GR</span>
                        <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left: auto;">
                            <polyline points="18 15 12 9 6 15"></polyline>
                        </svg>
                    </button>
                    <div class="nav-submenu">
                        <a href="{{ url('/gr/cinere') }}" class="nav-sublink {{ request()->is('gr/cinere*') ? 'active' : '' }}"><span class="bullet"></span>CINERE</a>
                        <a href="{{ url('/gr/jatiasih') }}" class="nav-sublink {{ request()->is('gr/jatiasih*') ? 'active' : '' }}"><span class="bullet"></span>JATIASIH</a>
                        <a href="{{ url('/gr/cianjur') }}" class="nav-sublink {{ request()->is('gr/cianjur*') ? 'active' : '' }}"><span class="bullet"></span>CIANJUR</a>
                        <a href="{{ url('/gr/ciawi') }}" class="nav-sublink {{ request()->is('gr/ciawi*') ? 'active' : '' }}"><span class="bullet"></span>CIAWI</a>
                    </div>
                </div>
            </nav>
        </aside>

        <main class="main-content">
            <button class="sidebar-toggle" id="sidebarToggle" type="button" onclick="toggleSidebar()" aria-label="Toggle sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
            @yield('content')
        </main>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <button class="settings-btn" id="settingsBtn" title="Pengaturan">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="3"></circle>
            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
        </svg>
    </button>

    <script>
        function toggleSubmenu(id) {
            const group = document.getElementById(id);
            group.classList.toggle('open');
        }

        function openModal() {
            const modal = document.getElementById('createModal');
            if (modal) modal.style.display = 'flex';
        }

        function closeModal() {
            const modal = document.getElementById('createModal');
            if (modal) {
                modal.style.display = 'none';
                const form = document.getElementById('createForm');
                if (form) form.reset();
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const open = sidebar.classList.toggle('open');
            overlay.classList.toggle('open', open);
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('createModal');
            if (modal) {
                @if ($errors->any()) openModal(); @endif
                modal.addEventListener('click', function(event) {
                    if (event.target === modal) closeModal();
                });
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
