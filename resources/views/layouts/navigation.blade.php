<div class="topnav bg-info">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-dark topnav-menu">

            {{-- Toggler / Hamburger --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content" aria-controls="topnav-menu-content" aria-expanded="false" aria-label="Toggle navigation">
                {{-- Icon putih proporsional --}}
                <span class="navbar-toggler-icon-custom"></span>
            </button>

            {{-- Menu --}}
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard.index') }}" id="topnav-dashboards" role="button">
                            <i class="uil-dashboard me-1"></i>Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('survey.index') }}" id="topnav-survey" role="button">
                            <i class="uil-home me-1"></i>Survey KNMP
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-kuesioner" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-bag-alt me-1"></i>Kuesioner <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-kuesioner">
                            <a href="#" class="dropdown-item">Aspek & Sub-Aspek</a>
                            <a href="#" class="dropdown-item">Indikator Pertanyaan</a>
                            <a href="#" class="dropdown-item">Opsi Jawaban</a>
                            <a href="#" class="dropdown-item">Versi Kuesioner</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('laporan.index') }}" id="topnav-laporan" role="button">
                            <i class="uil-chart me-1"></i>Laporan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user_management.index') }}" id="topnav-users" role="button">
                            <i class="uil-users-alt me-1"></i>User Management
                        </a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>

<style>
    /* Hamburger custom sesuai tinggi navbar */
    .navbar-toggler-icon-custom {
        display: inline-block;
        width: 10px;
        /* Lebar ikon */
        height: 10px;
        /* Tinggi area ikon */
        position: relative;
    }

    .navbar-toggler-icon-custom::before,
    .navbar-toggler-icon-custom::after,
    .navbar-toggler-icon-custom div {
        content: "";
        display: block;
        height: 2px;
        /* Ketebalan garis: cukup tipis agar 3 garis terlihat */
        background-color: #fff;
        /* Putih agar kontras dengan bg-info */
        border-radius: 1px;
        position: absolute;
        width: 100%;
        transition: all 0.3s ease;
    }

    /* Posisi garis */
    .navbar-toggler-icon-custom::before {
        top: 0;
        /* Garis atas */
    }

    .navbar-toggler-icon-custom div {
        top: 50%;
        /* Garis tengah */
        transform: translateY(-50%);
    }

    .navbar-toggler-icon-custom::after {
        bottom: 0;
        /* Garis bawah */
    }
</style>

<!-- Button toggler -->
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content" aria-controls="topnav-menu-content" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon-custom">
        <div></div>
    </span>
</button>