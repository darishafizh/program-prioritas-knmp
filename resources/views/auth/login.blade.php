<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from coderthemes.com/hyper/saas/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 29 Jul 2022 10:21:16 GMT -->

<head>
    <meta charset="utf-8" />
    <title>Log In | Monev KNMP - KKP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">`

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

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

        body.loading {
            margin: 0 !important;
            padding: 0 !important;
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

        .login-card .form-control::placeholder {
            color: #adb5bd;
        }

        .login-card .input-group-text {
            background: #f8f9fc;
            border: 1.5px solid #e0e5ec;
            border-left: none;
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

        .login-card .btn-primary:active {
            transform: translateY(0);
        }

        .login-card .form-check-input:checked {
            background-color: #0066cc;
            border-color: #0066cc;
        }

        .login-card a {
            color: #0066cc;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .login-card a:hover {
            color: #004d99;
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

            .login-left-panel .logo-container img {
                width: 100px;
                margin-bottom: 20px;
            }

            .login-left-panel .ministry-name {
                font-size: 1.4rem;
            }

            .login-left-panel .ministry-subtitle {
                font-size: 0.95rem;
                margin-top: 12px;
            }

            .login-left-panel .footer-text {
                display: none;
            }

            .login-right-panel {
                width: 100%;
                height: auto;
                padding: 30px 20px 50px;
            }

            .login-card .card-body {
                padding: 35px 25px;
            }
        }
    </style>

    <div class="login-wrapper">
        <!-- Left Panel - Logo -->
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

        <!-- Right Panel - Login Form -->
        <div class="login-right-panel">
            <div class="card login-card">
                <div class="card-body">
                    <h4 class="login-title text-center">Selamat Datang</h4>
                    <p class="login-subtitle text-center">Masukan email dan password Anda untuk mengakses sistem.</p>

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="border-radius: 12px;">
                            <i class="mdi mdi-block-helper me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="border-radius: 12px;">
                            <i class="mdi mdi-check-all me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger" style="border-radius: 12px;">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.perform') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Email</label>
                            <input class="form-control" type="email" id="emailaddress" name="email"
                                value="{{ old('email') }}" required autofocus placeholder="Masukan email anda">
                        </div>

                        <div class="mb-3">
                            <a href="{{ route('password.request') }}" class="text-muted float-end"><small>Lupa
                                    password?</small></a>
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password" required
                                    placeholder="Masukan password anda" style="border-radius: 12px 0 0 12px;">
                                <div class="input-group-text" data-password="false"
                                    style="border-radius: 0 12px 12px 0;">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                <label class="form-check-label" for="checkbox-signin">Ingat saya</label>
                            </div>
                        </div>

                        <div class="mb-0">
                            <button class="btn btn-primary" type="submit">
                                <i class="mdi mdi-login me-1"></i> Masuk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- bundle -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

</body>

<!-- Mirrored from coderthemes.com/hyper/saas/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 29 Jul 2022 10:21:16 GMT -->

</html>