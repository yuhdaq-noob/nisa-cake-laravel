@php
    $defaultLinks = [
        ['label' => 'Kasir', 'href' => url('/kasir'), 'key' => 'kasir', 'icon' => 'bi bi-cart-check'],
        ['label' => 'Gudang', 'href' => url('/gudang'), 'key' => 'gudang', 'icon' => 'bi bi-box-seam'],
        ['label' => 'Laporan', 'href' => url('/laporan'), 'key' => 'laporan', 'icon' => 'bi bi-bar-chart-line'],
    ];

    $navLinks = $links ?? ($navbarLinks ?? $defaultLinks);
    $activeKey = $active ?? null;
@endphp

<!-- Mobile Top Bar -->
<div class="fixed top-0 inset-x-0 z-40 bg-white/90 backdrop-blur border-b border-slate-200 lg:hidden">
    <div class="flex items-center justify-between h-14 px-4">
        <div class="flex items-center gap-2">
            <div class="h-10 w-10 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center font-semibold">NC</div>
            <div class="leading-tight">
                <p class="text-sm font-semibold text-slate-900">Nisa Cake</p>
                <p class="text-xs text-slate-500">Dashboard</p>
            </div>
        </div>
        <button class="p-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-100" data-drawer-toggle>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
</div>

<!-- Sidebar / Drawer -->
<aside class="fixed inset-y-0 left-0 z-50 w-72 bg-white shadow-xl border-r border-slate-200 transition-transform duration-200 -translate-x-full lg:translate-x-0" data-drawer>
    <div class="flex items-center justify-between px-6 h-16 border-b border-slate-200">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center font-semibold">NC</div>
            <div class="leading-tight">
                <p class="text-base font-bold text-slate-900">Nisa Cake</p>
                <p class="text-xs text-slate-500">Operasional</p>
            </div>
        </div>
        <button class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 lg:hidden" data-drawer-close aria-label="Tutup menu">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="h-[calc(100%-4rem)] flex flex-col overflow-y-auto px-6 py-5">
        <div class="text-center mb-6">
            <img src="/images/owner.jpg" alt="Foto Profil" class="mx-auto h-16 w-16 rounded-full object-cover shadow-card">
            <p class="mt-3 text-sm font-semibold text-slate-900">Ibu Nisa</p>
            <p class="text-xs text-slate-500">Owner & Admin</p>
        </div>

        <nav class="flex-1 space-y-1">
            @foreach($navLinks as $link)
                @php
                    $hrefPath = parse_url($link['href'], PHP_URL_PATH) ?: '/';
                    $isActive = false;
                    if($activeKey) {
                        $isActive = ($activeKey === ($link['key'] ?? $link['href']));
                    } else {
                        $trim = trim($hrefPath, '/');
                        $isActive = $hrefPath === '/' ? request()->is('/') : (request()->is($trim) || request()->is($trim.'/*'));
                    }

                    $activeClass = $isActive
                        ? 'bg-amber-50 text-amber-900 shadow-sm border border-amber-100'
                        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border border-transparent';
                @endphp
                <a href="{{ $link['href'] }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-semibold transition {{ $activeClass }}">
                    <span class="text-lg">{!! isset($link['icon']) ? '<i class="'.$link['icon'].'"></i>' : '<i class="bi bi-circle"></i>' !!}</span>
                    <span>{{ $link['label'] }}</span>
                </a>
            @endforeach
        </nav>

        @if($showLogout ?? true)
            <div class="pt-6 border-t border-slate-200 mt-6">
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 text-white py-2.5 font-semibold shadow-card hover:bg-slate-800 transition">
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        @endif
    </div>
</aside>

<div class="hidden fixed inset-0 bg-slate-900/40 z-40 lg:hidden" data-drawer-backdrop></div>