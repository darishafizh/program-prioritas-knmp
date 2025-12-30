<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-dark topnav-menu">

            {{-- Toggler / Hamburger --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content"
                aria-controls="topnav-menu-content" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon-custom">
                    <div></div>
                </span>
            </button>

            {{-- Menu --}}
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}" href="{{ route('dashboard.index') }}" id="topnav-dashboards" role="button">
                            <i class="mdi mdi-view-dashboard me-1"></i>Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('survey.*') ? 'active' : '' }}" href="{{ route('survey.index') }}" id="topnav-survey" role="button">
                            <i class="mdi mdi-home-group me-1"></i>Survey KNMP
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-kuesioner" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-clipboard-text me-1"></i>Kuesioner <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-kuesioner">
                            <a href="#" class="dropdown-item">Aspek & Sub-Aspek</a>
                            <a href="#" class="dropdown-item">Indikator Pertanyaan</a>
                            <a href="#" class="dropdown-item">Opsi Jawaban</a>
                            <a href="#" class="dropdown-item">Versi Kuesioner</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" href="{{ route('laporan.index') }}" id="topnav-laporan" role="button">
                            <i class="mdi mdi-chart-bar me-1"></i>Laporan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user_management.*') ? 'active' : '' }}" href="{{ route('user_management.index') }}" id="topnav-users" role="button">
                            <i class="mdi mdi-account-group me-1"></i>User Management
                        </a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>