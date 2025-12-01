<div class="topnav bg-info">
    <div class="container-fluid">
        <nav class="navbar navbar-dark navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard.index') }}" id="topnav-dashboards" role="button">
                            <i class="uil-dashboard me-1"></i>Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('survey.index') }}" id="topnav-dashboards" role="button">
                            <i class="uil-home me-1"></i>Survey KNMP
                        </a>
                    </li>

                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-bag-alt me-1"></i>Kuesioner <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-apps">
                            <a href="apps-calendar.html" class="dropdown-item">Aspek & Sub-Aspek</a>
                            <a href="apps-chat.html" class="dropdown-item">Indikator Pertanyaan</a>
                            <a href="apps-chat.html" class="dropdown-item">Opsi Jawaban</a>
                            <a href="apps-chat.html" class="dropdown-item">Versi Kuesioner</a>
                        </div>
                    </li> --}}

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('laporan.index') }}" id="topnav-dashboards" role="button">
                            <i class="uil-chart me-1"></i>Laporan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user_management.index') }}" id="topnav-dashboards"
                            role="button">
                            <i class="uil-users-alt me-1"></i>User Management
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
