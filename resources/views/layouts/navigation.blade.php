<div class="leftside-menu">

    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-light">
        <span class="logo-lg">
            <p class="h3 mt-3">ImuNaku</p>
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/Logo - ImuNaku.png') }}" alt="" height="16">
        </span>
    </a>

    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-dark">
        <span class="logo-lg">
            <img src="assets/images/logo-dark.png" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="assets/images/logo_sm_dark.png" alt="" height="16">
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        @php
            $role = Auth::user()->role ?? null;
        @endphp

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title side-nav-item">Analisis</li>

            @if ($role == 1 || $role == 2)
                <li class="side-nav-item">
                    <a href="{{ route('dashboard.index') }}" class="side-nav-link">
                        <i class="uil-home-alt"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
            @endif

            <li class="side-nav-title side-nav-item">Master</li>

            @if ($role == 1)
                <li class="side-nav-item">
                    <a href="{{ route('user.index') }}" class="side-nav-link">
                        <i class="uil-user"></i>
                        <span> User </span>
                    </a>
                </li>
            @endif

            @if ($role == 2)
                <li class="side-nav-item">
                    <a href="{{ route('posyandu.index') }}" class="side-nav-link">
                        <i class="uil-heart-medical"></i>
                        <span> Posyandu </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="{{ route('vaksin.index') }}" class="side-nav-link">
                        <i class="uil-medkit"></i>
                        <span> Vaksin </span>
                    </a>
                </li>
            @endif

            @if ($role == 1)
                <li class="side-nav-item">
                    <a href="{{ route('master_jadwal_imunisasi.index') }}" class="side-nav-link">
                        <i class="uil-medkit"></i>
                        <span> Jadwal Imunisasi </span>
                    </a>
                </li>
            @endif

            @if ($role == 2)
                <li class="side-nav-item">
                    <a href="{{ route('balita.index') }}" class="side-nav-link">
                        <i class="uil-kid"></i>
                        <span> Balita </span>
                    </a>
                </li>

                <li class="side-nav-title side-nav-item">Imunisasi</li>

                <li class="side-nav-item">
                    <a href="{{ route('jadwal_imunisasi.index') }}" class="side-nav-link">
                        <i class="uil-schedule"></i>
                        <span> Jadwal Posyandu </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="{{ route('notifikasi.index') }}" class="side-nav-link">
                        <i class="dripicons-bell"></i>
                        <span> Notifikasi </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="{{ route('imunisasi.index') }}" class="side-nav-link">
                        <i class="uil-syringe"></i>
                        <span> Imunisasi </span>
                    </a>
                </li>
            @endif

            <li class="side-nav-title side-nav-item">Laporan</li>

            <li class="side-nav-item">
                <a href="{{ route('laporan.index') }}" class="side-nav-link">
                    <i class="uil-file-info-alt"></i>
                    <span> Laporan </span>
                </a>
            </li>

        </ul>
        <!-- End Sidebar -->


        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
