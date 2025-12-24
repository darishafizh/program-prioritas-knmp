<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    @stack('styles')

    <style>
        /* Overlay */
        .alert-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            opacity: 0;
            pointer-events: none;
            transition: opacity .25s ease;
        }

        .alert-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        /* Card */
        .alert-card {
            width: 360px;
            background: #fff;
            border-radius: 22px;
            padding: 28px 26px 30px;
            text-align: center;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.20);
            transform: scale(.85) translateY(25px);
            animation: popUp .32s ease forwards;
        }

        @keyframes popUp {
            to {
                transform: scale(1) translateY(0);
            }
        }

        .alert-icon-circle {
            width: 95px;
            height: 95px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            font-size: 45px;
            color: #fff;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .alert-card.success .alert-icon-circle {
            background: radial-gradient(circle at top, #4be7aa, #18b374);
            box-shadow: 0 8px 25px rgba(24, 179, 116, 0.45);
        }

        .alert-card.error .alert-icon-circle {
            background: radial-gradient(circle at top, #ff5b5b, #d62828);
            box-shadow: 0 8px 25px rgba(255, 60, 60, 0.45);
        }

        .alert-title {
            font-size: 25px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .alert-card.success .alert-title {
            color: #18b374;
        }

        .alert-card.error .alert-title {
            color: #d62828;
        }

        .alert-subtitle {
            color: #555;
            font-size: 15px;
            margin-bottom: 22px;
        }

        .alert-progress {
            width: 100%;
            height: 6px;
            background: #eee;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 22px;
        }

        .alert-progress-bar {
            height: 100%;
            width: 0%;
            animation: loadBar 2.5s linear forwards;
        }

        .alert-card.success .alert-progress-bar {
            background: #18b374;
        }

        .alert-card.error .alert-progress-bar {
            background: #d62828;
        }

        @keyframes loadBar {
            to {
                width: 100%;
            }
        }

        .alert-btn {
            width: 100%;
            padding: 14px 0;
            border-radius: 12px;
            border: none;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .alert-card.success .alert-btn {
            background: #e6fff3;
            color: #18b374;
        }

        .alert-card.success .alert-btn:hover {
            background: #d1ffe9;
        }

        .alert-card.error .alert-btn {
            background: #ffe6e6;
            color: #d62828;
        }

        .alert-card.error .alert-btn:hover {
            background: #ffd1d1;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28255,255,255,1%29)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/ %3E%3C/svg%3E");
        }
    </style>

</head>

<body class="loading" data-layout-color="light" data-layout="topnav" data-leftbar-theme="dark" data-layout-mode="fluid"
    data-rightbar-onstart="true">

    {{-- 🔔 GLOBAL ALERT --}}
    @if(session('success') || session('error'))
    <div id="customAlert" class="alert-overlay">
        <div class="alert-card {{ session('success') ? 'success' : 'error' }}">
            <div class="alert-icon-circle">
                @if(session('success'))
                <span class="alert-icon">✓</span>
                @else
                <span class="alert-icon">✕</span>
                @endif
            </div>
            <h3 class="alert-title">{{ session('success') ? 'Success!' : 'Failed!' }}</h3>
            <p class="alert-subtitle">{{ session('success') ? session('success') : session('error') }}</p>
            <div class="alert-progress">
                <div class="alert-progress-bar"></div>
            </div>
            <button class="alert-btn" id="alertCloseBtn">{{ session('success') ? 'DONE' : 'TRY AGAIN' }}</button>
        </div>
    </div>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const overlay = document.getElementById("customAlert");
            if (!overlay) return;

            const closeBtn = document.getElementById("alertCloseBtn");
            setTimeout(() => overlay.classList.add("show"), 20);

            function closeAlert() {
                overlay.classList.remove("show");
                setTimeout(() => overlay.remove(), 250);
            }

            if (closeBtn) closeBtn.addEventListener("click", closeAlert);
            setTimeout(closeAlert, 2500);
        });
    </script>

    <div class="wrapper">
        <div class="content-page">
            <div class="content">
                @include('layouts.header')
                @include('layouts.navigation')

                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>

    @include('layouts.settings')
    <div class="rightbar-overlay"></div>
    @include('layouts.foot')

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    {{-- ⚡ FIXED: Jangan inisialisasi tooltip/popover/offcanvas manual --}}
    {{-- Semua sudah di-handle oleh app.min.js / vendor.min.js --}}
    {{-- Ini mencegah "Option 'container' provided type 'null'" --}}

    @stack('scripts')
</body>

</html>