@php
    $defaultLinks = [
        ['label' => 'kasir', 'href' => url('/kasir'), 'key' => 'kasir', 'icon' => 'bi bi-cart-check'],
        ['label' => 'Gudang', 'href' => url('/gudang'), 'key' => 'gudang', 'icon' => 'bi bi-box-seam'],
        ['label' => 'Laporan', 'href' => url('/laporan'), 'key' => 'laporan', 'icon' => 'bi bi-bar-chart-line'],
    ];

    $navLinks = $links ?? ($navbarLinks ?? $defaultLinks);
    $activeKey = $active ?? null;
@endphp

<style>
    /* UX Mobile: Sidebar Sizing & Backdrop */
    @media (max-width: 991.98px) {
        #sidebarMenu {
            width: 75% !important;
            max-width: 280px !important;
            background-color: #ffffff !important; /* Pastikan background putih bersih */
        }
    }
</style>

<!-- 1. Mobile Header (Hanya muncul di Layar Kecil < LG) -->
<nav class="navbar navbar-dark bg-dark d-lg-none sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">Nisa Cake</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<!-- 2. Sidebar (Muncul di Desktop >= LG, jadi Offcanvas di Mobile) -->
<div class="offcanvas-lg offcanvas-start sidebar-panel" tabindex="-1" id="sidebarMenu" style="min-width: 260px;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Nisa Cake</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column p-3 h-100">
        <!-- Profil Owner -->
        <div class="text-center mb-4 pt-2">
            <img src="/images/owner.jpg"
                class="rounded-circle mx-auto mb-2 shadow-sm"
                alt="Foto Profil"
                style="width: 80px; height: 80px; object-fit: cover;">
            <h6 class="user-name mb-0">Ibu Nisa</h6>
            <small class="user-role">Owner & Admin</small>
        </div>

        <hr class="opacity-25">

        <!-- Menu Navigasi -->
        <ul class="nav nav-pills flex-column mb-auto">
            @foreach($navLinks as $link)
                @php
                    $hrefPath = parse_url($link['href'], PHP_URL_PATH) ?: '/';
                    $isActive = false;
                    if($activeKey) {
                        $isActive = ($activeKey === ($link['key'] ?? $link['href']));
                    } else {
                        $trim = trim($hrefPath, '/');
                        if($hrefPath === '/') {
                            $isActive = request()->is('/');
                        } else {
                            $isActive = request()->is($trim) || request()->is($trim.'/*');
                        }
                    }
                @endphp
                <li class="nav-item">
                    <a href="{{ $link['href'] }}" class="nav-link {{ $isActive ? 'active' : '' }}">
                        <span class="me-2"><i class="{{ $link['icon'] ?? 'bi bi-circle' }}"></i></span> {{ $link['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <hr class="opacity-25">

        <!-- Logout -->
        @if($showLogout ?? true)
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2">
                     <span>Logout</span>
                </button>
            </form>
        @endif
    </div>
</div>