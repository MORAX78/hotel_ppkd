<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PPKD Hotel') — Sistem Reservasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Lora:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
<button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<div class="app-shell">

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="sidebar">

        <a href="{{ route('reservations.index') }}" class="sidebar-brand">
            <div class="sidebar-brand-logo">
                <img src="{{ asset('images/ppkd-logo.jpg') }}" alt="Logo PPKD"
                     style="width:32px;height:32px;object-fit:contain;border-radius:50%;"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='inline';">
                <i class="fas fa-hotel" style="display:none;"></i>
            </div>
            <span class="sidebar-brand-name">PPKD Hotel</span>
            <span class="sidebar-brand-sub">Jakarta Pusat</span>
        </a>

        <nav class="sidebar-nav">
            <div class="sidebar-section-label">Menu Utama</div>

            <a href="{{ route('reservations.index') }}"
               class="nav-link {{ request()->routeIs('reservations.index') ? 'active' : '' }}">
                <span class="nav-link-icon"><i class="fas fa-th-list"></i></span>
                Daftar Reservasi
            </a>

            <a href="{{ route('reservations.create') }}"
               class="nav-link {{ request()->routeIs('reservations.create') ? 'active' : '' }}">
                <span class="nav-link-icon"><i class="fas fa-calendar-plus"></i></span>
                Reservasi Baru
            </a>
        </nav>

        <div class="nav-cta">
            <a href="{{ route('reservations.create') }}" class="btn btn-gold">
                <i class="fas fa-plus"></i> Reservasi Baru
            </a>
        </div>

        {{-- User info + Logout --}}
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                    <div class="sidebar-user-role">Resepsionis</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- MAIN WRAPPER --}}
    <div class="main-wrapper">

        @hasSection('hero')
        <section class="page-hero">
            <div class="page-hero-inner">
                @yield('hero')
            </div>
        </section>
        @endif

        <main class="main-content">

            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            @yield('content')

        </main>

        <footer class="site-footer">
            <div class="footer-inner">
                <span class="footer-copy">&copy; {{ date('Y') }} PPKD Hotel Jakarta Pusat. Hak cipta dilindungi.</span>
            </div>
        </footer>

    </div>

</div>

@stack('scripts')
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('active');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('active');
}
</script>
</body>
</html>
