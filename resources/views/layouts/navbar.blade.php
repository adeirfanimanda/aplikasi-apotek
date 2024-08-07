{{-- Navbar Top --}}
<nav class="navbar navbar-top fixed-top bg-primary text-white">
    <div class="container">
        {{-- Navbar Brand --}}
        <a class="d-inline navbar-brand text-white" href="/">
            <img src="{{ asset('images/logo-dashboard.png') }}" alt="Logo" width="32"
                class="align-text-bottom me-2">
            <span class="fs-4 text-uppercase">Apotek Rahmayani</span>
        </a>

        {{-- Logout Button --}}
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-light d-flex align-items-center">
                <i class="bi bi-box-arrow-left me-2"></i>Keluar
            </button>
        </form>
    </div>
</nav>

{{-- Navbar Menu --}}
<nav class="navbar navbar-menu fixed-top navbar-expand-lg bg-light shadow-lg-sm">
    <div class="container">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                @if (Auth::user()->roles === 'admin')
                    <li class="nav-item">
                        <x-navbar-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            <i class="ti ti-home align-text-top me-1"></i>Dashboard
                        </x-navbar-link>
                    </li>
                    <li class="nav-item">
                        <x-navbar-link href="{{ route('admin.pengguna.index') }}" :active="request()->routeIs('admin.pengguna.*')">
                            <i class="ti ti-users align-text-top me-1"></i>Data Pengguna
                        </x-navbar-link>
                    </li>
                    <li class="nav-item">
                        <x-navbar-link href="{{ route('categories.index') }}" :active="request()->routeIs('categories.*')">
                            <i class="ti ti-category align-text-top me-1"></i>Data Bentuk Kesediaan
                        </x-navbar-link>
                    </li>
                    <li class="nav-item">
                        <x-navbar-link href="{{ route('products.index') }}" :active="request()->routeIs('products.*')">
                            <i class="ti ti-copy align-text-top me-1"></i>Data Obat
                        </x-navbar-link>
                    </li>
                @endif
                @if (Auth::user()->roles === 'kasir')
                    <li class="nav-item">
                        <x-navbar-link href="{{ route('kasir.products.index') }}" :active="request()->routeIs('kasir.products.index')">
                            <i class="ti ti-copy align-text-top me-1"></i>Data Obat
                        </x-navbar-link>
                    </li>
                @endif
                <li class="nav-item">
                    <x-navbar-link href="{{ route('transactions.index') }}" :active="request()->routeIs('transactions.*')">
                        <i class="ti ti-folders align-text-top me-1"></i>Data Transaksi
                    </x-navbar-link>
                </li>
                <li class="nav-item">
                    <x-navbar-link href="{{ route('report.index') }}" :active="request()->routeIs('report.*')">
                        <i class="ti ti-file-text align-text-top me-1"></i>Laporan
                    </x-navbar-link>
                </li>
            </ul>
        </div>
    </div>
</nav>
