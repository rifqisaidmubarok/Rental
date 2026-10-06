<aside class="sidebar">

    <div class="logo">

        <div class="logo-icon">
            🚗
        </div>

        <div>
            <div class="logo-text">
                Rental Kendaraan
            </div>

            <div class="logo-subtitle">
                Sistem Informasi
            </div>
        </div>

    </div>


    {{-- =====================================================
         MENU ADMIN
    ====================================================== --}}

    @if(auth()->user()->role === 'admin')

        <div class="menu-title">
            Menu Utama
        </div>

        <ul class="menu">

            {{-- Dashboard --}}
            <li>
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                >
                    <span class="menu-icon">📊</span>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- Pengguna --}}
            <li>
    <a href="{{ route('users.index') }}"
       class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
        <span class="menu-icon">👥</span>
        <span>Pengguna</span>
    </a>
</li>

            {{-- Kategori Kendaraan --}}
            <li>
                <a
                    href="{{ route('admin.categories.index') }}"
                    class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                >
                    <span class="menu-icon">🏷️</span>
                    <span>Kategori Kendaraan</span>
                </a>
            </li>

            {{-- Kendaraan --}}
            <li>
                <a
                    href="{{ route('vehicles.index') }}"
                    class="{{ request()->routeIs('vehicles.*') ? 'active' : '' }}"
                >
                    <span class="menu-icon">🚗</span>
                    <span>Kendaraan</span>
                </a>
            </li>

            {{-- Customer --}}
            <li>
                <a
                    href="{{ route('customers.index') }}"
                    class="{{ request()->routeIs('customers.*') ? 'active' : '' }}"
                >
                    <span class="menu-icon">🧑</span>
                    <span>Customer</span>
                </a>
            </li>

        </ul>


        {{-- =========================
             TRANSAKSI ADMIN
        ========================== --}}

        <div class="menu-title">
            Transaksi
        </div>

        <ul class="menu">

            {{-- Rental --}}
            <li>
                <a
                    href="{{ route('rentals.index') }}"
                    class="{{ request()->routeIs('rentals.*') ? 'active' : '' }}"
                >
                    <span class="menu-icon">📋</span>
                    <span>Rental</span>
                </a>
            </li>

            {{-- Laporan Rental --}}
            <li>
                <a
                    href="{{ route('reports.rentals') }}"
                    class="{{ request()->routeIs('reports.rentals') ? 'active' : '' }}"
                >
                    <span class="menu-icon">📈</span>
                    <span>Laporan Rental</span>
                </a>
            </li>

            {{-- Laporan Pembayaran --}}
            <li>
                <a
                    href="{{ route('reports.payments') }}"
                    class="{{ request()->routeIs('reports.payments') ? 'active' : '' }}"
                >
                    <span class="menu-icon">💰</span>
                    <span>Laporan Pembayaran</span>
                </a>
            </li>

        </ul>


        {{-- =========================
             LOG ADMIN
        ========================== --}}

        <div class="menu-title">
            Log Sistem
        </div>

        <ul class="menu">

            {{-- Login Log --}}
            <li>
                 <a     href="{{ route('login-logs.index') }}"
                        class="{{ request()->routeIs('login-logs.*') ? 'active' : '' }}">
                        <span class="menu-icon">🔐</span>
                        <span>Login Log</span>
                </a>
            </li>

            {{-- Activity Log --}}
            <li>
                <a
                    href="{{ route('activity-logs.index') }}"
                    class="{{ request()->routeIs('activity-logs.*') ? 'active' : '' }}"
                >
                    <span class="menu-icon">📝</span>
                    <span>Activity Log</span>
                </a>
            </li>

        </ul>

    @endif



    {{-- =====================================================
         MENU PETUGAS
    ====================================================== --}}

    @if(auth()->user()->role === 'petugas')

        <div class="menu-title">
            Menu Utama
        </div>

        <ul class="menu">

            {{-- Dashboard --}}
            <li>
                <a
                    href="{{ route('petugas.dashboard') }}"
                    class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}"
                >
                    <span class="menu-icon">📊</span>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- Kendaraan --}}
            <li>
                <a
                    href="{{ route('vehicles.index') }}"
                    class="{{ request()->routeIs('vehicles.*') ? 'active' : '' }}"
                >
                    <span class="menu-icon">🚗</span>
                    <span>Kendaraan</span>
                </a>
            </li>

            {{-- Customer --}}
            <li>
                <a
                    href="{{ route('customers.index') }}"
                    class="{{ request()->routeIs('customers.*') ? 'active' : '' }}"
                >
                    <span class="menu-icon">🧑</span>
                    <span>Customer</span>
                </a>
            </li>

        </ul>


        {{-- =========================
             TRANSAKSI PETUGAS
        ========================== --}}

        <div class="menu-title">
            Transaksi
        </div>

        <ul class="menu">

            {{-- Rental --}}
            <li>
                <a
                    href="{{ route('rentals.index') }}"
                    class="{{ request()->routeIs('rentals.*') ? 'active' : '' }}"
                >
                    <span class="menu-icon">📋</span>
                    <span>Rental</span>
                </a>
            </li>

           

        </ul>


        {{-- =========================
             LAPORAN PETUGAS
        ========================== --}}

        <div class="menu-title">
            Laporan
        </div>

        <ul class="menu">

            {{-- Laporan Rental --}}
            <li>
                <a
                    href="{{ route('reports.rentals') }}"
                    class="{{ request()->routeIs('reports.rentals') ? 'active' : '' }}"
                >
                    <span class="menu-icon">📈</span>
                    <span>Laporan Rental</span>
                </a>
            </li>

            {{-- Laporan Pembayaran --}}
            <li>
                <a
                    href="{{ route('reports.payments') }}"
                    class="{{ request()->routeIs('reports.payments') ? 'active' : '' }}"
                >
                    <span class="menu-icon">💰</span>
                    <span>Laporan Pembayaran</span>
                </a>
            </li>

            {{-- Activity Log --}}
            <li>
                <a
                    href="{{ route('activity-logs.index') }}"
                    class="{{ request()->routeIs('activity-logs.*') ? 'active' : '' }}"
                >
                    <span class="menu-icon">📝</span>
                    <span>Activity Log</span>
                </a>
            </li>

        </ul>

    @endif



    {{-- =====================================================
         LOGOUT
    ====================================================== --}}

    <div class="logout-section">

        <form
            action="{{ route('logout') }}"
            method="POST"
        >

            @csrf

            <button
                type="submit"
                class="logout-btn"
            >
                <span class="menu-icon">🚪</span>
                <span>Logout</span>
            </button>

        </form>

    </div>

</aside>