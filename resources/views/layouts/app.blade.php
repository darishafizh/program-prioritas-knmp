<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Default head --}}
    @include('layouts.head')

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    {{-- Stack tambahan CSS (jika ada dari halaman lain) --}}
    @stack('styles')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Overlay */
        .alert-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.45);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            opacity: 0;
            transition: opacity .4s ease;
        }

        .alert-overlay.show {
            opacity: 1;
        }

        /* Card utama */
        .alert-card {
            width: 320px;
            background: #ffffff;
            border-radius: 18px;
            padding: 25px 20px 22px;
            text-align: center;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.18);
            transform: translateY(20px) scale(0.95);
            animation: alertPop .35s ease forwards;
        }

        @keyframes alertPop {
            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        /* Icon */
        .alert-icon-wrapper {
            margin-bottom: 10px;
        }

        .alert-icon-circle {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            font-size: 38px;
            font-weight: bold;
            color: white;
        }

        /* Success */
        .alert-card.success .alert-icon-circle {
            background: linear-gradient(135deg, #38d39f, #1ebd7e);
            box-shadow: 0 8px 20px rgba(56, 211, 159, 0.40);
        }

        /* Error */
        .alert-card.error .alert-icon-circle {
            background: linear-gradient(135deg, #ff4a4a, #d63030);
            box-shadow: 0 8px 20px rgba(255, 74, 74, 0.40);
        }

        .alert-title {
            margin-top: 8px;
            font-size: 22px;
            font-weight: bold;
        }

        .alert-card.success .alert-title {
            color: #1ebd7e;
        }

        .alert-card.error .alert-title {
            color: #d63030;
        }

        .alert-subtitle {
            font-size: 14px;
            color: #555;
            margin-bottom: 18px;
        }

        /* Progress bar bawah icon */
        .alert-progress {
            width: 100%;
            height: 5px;
            background: #e5e5e5;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 18px;
        }

        .alert-progress-bar {
            height: 100%;
            width: 0%;
            animation: loadBar 2.5s linear forwards;
        }

        .alert-card.success .alert-progress-bar {
            background: #1ebd7e;
        }

        .alert-card.error .alert-progress-bar {
            background: #d63030;
        }

        @keyframes loadBar {
            to {
                width: 100%;
            }
        }

        /* Button bawah */
        .alert-btn {
            width: 100%;
            padding: 10px 0;
            border-radius: 10px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .alert-card.success .alert-btn {
            color: #1ebd7e;
            background: #e7fff5;
        }

        .alert-card.error .alert-btn {
            color: #d63030;
            background: #ffeaea;
        }
    </style>



</head>

<body
    class="loading"
    data-layout-color="light"
    data-layout="topnav"
    data-leftbar-theme="dark"
    data-layout-mode="fluid"
    data-rightbar-onstart="true">

    <!-- Begin page -->
    <div class="wrapper">

        <!-- Content Wrapper -->
        <div class="content-page">
            <div class="content">

                {{-- Header --}}
                @include('layouts.header')

                {{-- Navigation --}}
                @include('layouts.navigation')

                {{-- Main Content --}}
                <div class="container-fluid">
                    @yield('content')
                </div>

            </div>

            {{-- Footer --}}
            @include('layouts.footer')

        </div>
        <!-- End content-page -->

    </div>
    <!-- END wrapper -->

    {{-- Settings Sidebar --}}
    @include('layouts.settings')

    <div class="rightbar-overlay"></div>

    {{-- Default JS footer --}}
    @include('layouts.foot')

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    {{-- Stack tambahan JS dari halaman lain --}}
    @stack('scripts')

</body>


</html>