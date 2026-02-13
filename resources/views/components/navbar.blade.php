@php
    $defaultLinks = [
        ['label' => 'Kasir', 'href' => url('/kasir'), 'key' => 'kasir', 'icon' => 'bi bi-cash-stack'],
        ['label' => 'Gudang', 'href' => url('/gudang'), 'key' => 'gudang', 'icon' => 'bi bi-boxes'],
        ['label' => 'Laporan', 'href' => url('/laporan'), 'key' => 'laporan', 'icon' => 'bi bi-graph-up-arrow'],
    ];

    $navLinks = $links ?? ($navbarLinks ?? $defaultLinks);
    $activeKey = $active ?? null;
@endphp

<!-- Mobile Top Bar -->
<div class="fixed top-0 inset-x-0 z-40 bg-white/95 backdrop-blur border-b border-slate-200 lg:hidden">
    <div class="flex items-center justify-between h-16 px-5">
        <div class="flex items-center gap-3">
            <div class="h-12 w-12 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center font-semibold tracking-tight shadow-inner">NC</div>
            <div class="leading-tight">
                <p class="text-base font-semibold text-slate-900">Nisa Cake</p>
                <p class="text-xs font-medium text-slate-500/80">Management</p>
            </div>
        </div>
        <button class="p-2.5 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-100 transition" data-drawer-toggle aria-label="Buka menu">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
</div>

<!-- Sidebar / Drawer -->
<aside
    class="fixed inset-y-0 left-0 z-50 w-[272px] bg-gradient-to-b from-white via-white to-gray-50 border-r border-gray-200 shadow-[0_10px_40px_rgba(15,23,42,0.08)] transition-all duration-300 ease-in-out -translate-x-full lg:translate-x-0"
    data-drawer
    data-sidebar
    data-collapsed="false"
>
    <div class="flex flex-col h-full">
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-200">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-2xl overflow-hidden shadow-sm ring-1 ring-amber-100 bg-white flex items-center justify-center">
                    <img src="/images/logo.png" alt="Logo" class="h-full w-full object-cover">
                </div>
                <div class="sidebar-textual leading-tight">
                    <p class="text-lg font-semibold text-slate-900 tracking-tight">Nisa Cake</p>
                    <p class="text-[0.78rem] font-medium text-slate-500/80">Management</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" class="hidden lg:flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-100 transition" data-sidebar-collapse aria-expanded="false">
                    <span class="collapse-icon collapse-icon--expand">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16m-6-6 6 6-6 6" />
                        </svg>
                    </span>
                    <span class="collapse-icon collapse-icon--collapse">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4m6 6-6-6 6-6" />
                        </svg>
                    </span>
                </button>
                <button class="p-2.5 rounded-xl text-slate-500 hover:bg-slate-100 transition lg:hidden" data-drawer-close aria-label="Tutup menu">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-y-auto px-5 py-6 gap-8">
            <div class="profile-card rounded-2xl bg-white/90 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 px-5 py-4">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <img src="/images/owner.jpg" alt="Foto Profil" class="h-16 w-16 rounded-2xl object-cover ring-2 ring-white ring-offset-2 ring-offset-gray-100">
                        <span class="absolute bottom-1 right-1 h-3 w-3 rounded-full bg-emerald-400 ring-2 ring-white"></span>
                    </div>
                    <div class="sidebar-textual">
                        <p class="text-[0.97rem] font-semibold text-slate-900">Ibu Nisa</p>
                        <p class="text-xs font-medium text-slate-500">Owner & Admin</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 space-y-1" aria-label="Navigasi utama">
                <p class="sidebar-textual text-[0.65rem] uppercase tracking-[0.2em] text-slate-400 px-1">Menu utama</p>
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
                        $baseIcon = isset($link['icon']) ? '<i class="'.$link['icon'].'"></i>' : '<i class="bi bi-circle"></i>';
                        $activeClass = $isActive
                            ? 'bg-gradient-to-r from-amber-50 via-orange-50 to-amber-100/80 text-amber-900 border-amber-700 shadow-sm font-semibold scale-[1.01]'
                            : 'text-slate-600 hover:bg-gray-100/60 hover:text-slate-900 hover:border-amber-200 hover:scale-[1.02] hover:shadow-sm';
                    @endphp
                    <a
                        href="{{ $link['href'] }}"
                        title="{{ $link['label'] }}"
                        aria-current="{{ $isActive ? 'page' : 'false' }}"
                        data-tooltip="{{ $link['label'] }}"
                        class="nav-link group relative flex items-center gap-3 rounded-xl px-4 py-3 text-[0.95rem] font-medium border-l-[3px] border-transparent transition-all duration-200 ease-[cubic-bezier(0.4,0,0.2,1)] {{ $activeClass }}"
                    >
                        <span class="text-xl text-amber-700">{!! $baseIcon !!}</span>
                        <span class="nav-label text-gray-700">{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        @if($showLogout ?? true)
            <div class="mt-auto px-5 pb-6">
                <div class="border-t border-gray-200 pt-5 bg-gradient-to-t from-white via-white/80 to-transparent rounded-b-2xl">
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" title="Logout" class="logout-btn w-full inline-flex items-center justify-center gap-3 rounded-xl bg-red-50 text-red-700 py-3 font-semibold border border-red-100 hover:bg-red-100 transition-all duration-200">
                            <i class="bi bi-box-arrow-right text-lg"></i>
                            <span class="logout-label">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</aside>

<div class="hidden fixed inset-0 bg-slate-900/40 z-40 lg:hidden" data-drawer-backdrop></div>

@once
    <style>
        [data-sidebar] {
            font-family: "Plus Jakarta Sans", "Inter", "Segoe UI", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        }

        [data-sidebar][data-collapsed="true"] {
            width: 5.25rem;
        }

        [data-sidebar] .sidebar-textual,
        [data-sidebar] .nav-label,
        [data-sidebar] .logout-label,
        [data-sidebar] .profile-card {
            transition: opacity 200ms ease, transform 200ms ease;
        }

        [data-sidebar][data-collapsed="true"] .sidebar-textual,
        [data-sidebar][data-collapsed="true"] .nav-label,
        [data-sidebar][data-collapsed="true"] .logout-label {
            opacity: 0;
            transform: translateX(-8px);
            pointer-events: none;
            width: 0;
        }

        [data-sidebar][data-collapsed="true"] .profile-card {
            opacity: 0;
            transform: translateY(-12px);
            pointer-events: none;
            height: 0;
            margin: 0;
            padding: 0;
            border: 0;
        }

        [data-sidebar][data-collapsed="true"] .nav-link {
            justify-content: center;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
            border-left-width: 0;
        }

        [data-sidebar][data-collapsed="true"] .nav-link span {
            text-align: center;
        }

        [data-sidebar][data-collapsed="true"] .logout-btn {
            justify-content: center;
        }

        [data-sidebar][data-collapsed="true"] .nav-link::after {
            content: attr(data-tooltip);
            position: absolute;
            left: calc(100% + 0.75rem);
            top: 50%;
            transform: translateY(-50%) scale(0.96);
            background: #111827;
            color: #f9fafb;
            padding: 0.35rem 0.6rem;
            border-radius: 0.75rem;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.15);
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 150ms ease, transform 150ms ease;
            font-size: 0.75rem;
            font-weight: 600;
        }

        [data-sidebar][data-collapsed="true"] .nav-link:hover::after {
            opacity: 1;
            transform: translateY(-50%) scale(1);
        }

        [data-sidebar] .collapse-icon--collapse {
            display: none;
        }

        [data-sidebar][data-collapsed="true"] .collapse-icon--expand {
            display: none;
        }

        [data-sidebar][data-collapsed="true"] .collapse-icon--collapse {
            display: inline-flex;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.querySelector("[data-sidebar]");
            const toggles = document.querySelectorAll("[data-sidebar-collapse]");

            if (!sidebar || !toggles.length) {
                return;
            }

            toggles.forEach(function (button) {
                button.addEventListener("click", function () {
                    const isCollapsed = sidebar.getAttribute("data-collapsed") === "true";
                    sidebar.setAttribute("data-collapsed", isCollapsed ? "false" : "true");
                    button.setAttribute("aria-expanded", isCollapsed ? "false" : "true");
                });
            });
        });
    </script>
@endonce