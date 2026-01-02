<div class="topnav modern-topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg topnav-menu modern-nav">

            {{-- Toggler / Hamburger --}}
            <button class="navbar-toggler modern-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#topnav-menu-content" aria-controls="topnav-menu-content" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="toggler-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>

            {{-- Menu --}}
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav modern-nav-list">

                    <li class="nav-item">
                        <a class="nav-link modern-nav-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}"
                            href="{{ route('dashboard.index') }}" id="topnav-dashboards" role="button">
                            <i class="uil-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link modern-nav-link {{ request()->routeIs('survey.*') ? 'active' : '' }}"
                            href="{{ route('survey.index') }}" id="topnav-survey" role="button">
                            <i class="uil-home"></i>
                            <span>Survey KNMP</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link modern-nav-link dropdown-toggle arrow-none" href="#" id="topnav-kuesioner"
                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-bag-alt"></i>
                            <span>Kuesioner</span>
                            <i class="mdi mdi-chevron-down dropdown-arrow"></i>
                        </a>
                        <div class="dropdown-menu modern-dropdown-menu" aria-labelledby="topnav-kuesioner">
                            <a href="#" class="dropdown-item modern-dropdown-item">
                                <i class="mdi mdi-format-list-bulleted-type"></i>
                                Aspek & Sub-Aspek
                            </a>
                            <a href="#" class="dropdown-item modern-dropdown-item">
                                <i class="mdi mdi-help-circle-outline"></i>
                                Indikator Pertanyaan
                            </a>
                            <a href="#" class="dropdown-item modern-dropdown-item">
                                <i class="mdi mdi-checkbox-marked-circle-outline"></i>
                                Opsi Jawaban
                            </a>
                            <a href="#" class="dropdown-item modern-dropdown-item">
                                <i class="mdi mdi-file-document-edit-outline"></i>
                                Versi Kuesioner
                            </a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link modern-nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
                            href="{{ route('laporan.index') }}" id="topnav-laporan" role="button">
                            <i class="uil-chart"></i>
                            <span>Laporan</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link modern-nav-link {{ request()->routeIs('user_management.*') ? 'active' : '' }}"
                            href="{{ route('user_management.index') }}" id="topnav-users" role="button">
                            <i class="uil-users-alt"></i>
                            <span>User Management</span>
                        </a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>