<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Monev KNMP - KKP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
</head>

<body class="loading" data-layout-config='{"darkMode":false}'
    style="margin: 0 !important; padding: 0 !important; overflow: hidden !important;">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
            height: 100% !important;
            width: 100% !important;
        }

        .login-wrapper {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            height: 100vh;
            width: 100vw;
            display: flex;
            overflow: hidden;
        }

        .login-left-panel {
            background: linear-gradient(135deg, #003d7a 0%, #00529b 50%, #0066cc 100%);
            height: 100vh;
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .login-left-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .login-left-panel::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -30%;
            width: 80%;
            height: 80%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        .login-left-panel .logo-container {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .login-left-panel .logo-container img {
            width: 180px;
            height: auto;
            margin-bottom: 40px;
            filter: drop-shadow(0 15px 35px rgba(0, 0, 0, 0.3));
        }

        .login-left-panel .ministry-name {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            text-shadow: 0 2px 15px rgba(0, 0, 0, 0.2);
            line-height: 1.4;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .login-left-panel .ministry-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-top: 20px;
            text-align: center;
            font-weight: 400;
            letter-spacing: 0.3px;
        }

        .login-left-panel .footer-text {
            position: absolute;
            bottom: 30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 0.85rem;
            opacity: 0.7;
        }

        .login-right-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            width: 50%;
            padding: 40px;
            background-color: #f5f7fa;
            position: relative;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            background: #ffffff;
        }

        .login-card .card-body {
            padding: 50px 40px;
        }

        .login-card .login-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 8px;
        }

        .login-card .login-subtitle {
            color: #6c757d;
            margin-bottom: 35px;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .login-card .form-label {
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .login-card .form-control {
            border-radius: 12px;
            padding: 14px 18px;
            border: 1.5px solid #e0e5ec;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            background: #f8f9fc;
        }

        .login-card .form-control:focus {
            border-color: #0066cc;
            box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.1);
            background: #ffffff;
        }

        .login-card .btn-primary {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            background: linear-gradient(135deg, #0066cc 0%, #004d99 100%);
            border: none;
            transition: all 0.3s ease;
            letter-spacing: 0.3px;
        }

        .login-card .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 102, 204, 0.35);
            background: linear-gradient(135deg, #0077e6 0%, #0066cc 100%);
        }

        @media (max-width: 991.98px) {
            .login-wrapper {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
                overflow-y: auto;
            }

            .login-left-panel {
                width: 100%;
                height: auto;
                min-height: 280px;
                padding: 40px 30px;
            }

            .login-right-panel {
                width: 100%;
                height: auto;
                padding: 30px 20px 50px;
            }
        }
    </style>

    <div class="login-wrapper">
        <div class="login-left-panel">
            <div class="logo-container">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo KKP">
                <h1 class="ministry-name">Kementerian Kelautan<br>dan Perikanan</h1>
                <p class="ministry-subtitle">Sistem Monitoring dan Evaluasi KNMP</p>
            </div>
            <div class="footer-text">
                ©
                <script>document.write(new Date().getFullYear())</script> Monev KNMP - Kementerian Kelautan dan
                Perikanan
            </div>
        </div>

        <div class="login-right-panel">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
</body>

</html>