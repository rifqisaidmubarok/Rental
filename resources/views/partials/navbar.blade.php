<header class="navbar">

    <div>

        <div class="page-title">
            @yield('page-title', 'Dashboard')
        </div>

        <div class="page-subtitle">
            Sistem Informasi Rental Kendaraan
        </div>

    </div>


    <div class="navbar-right">

        <div class="user-info">

            <div class="user-name">
                {{ auth()->user()->name }}
            </div>

            <div class="user-role">
                {{ auth()->user()->role }}
            </div>

        </div>

        <div class="user-avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>

    </div>

</header>