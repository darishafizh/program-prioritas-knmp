<div class="navbar-custom topnav-navbar">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <!-- LOGO -->
        <a href="{{ route('dashboard.index') }}" class="topnav-logo">
            <span class="topnav-logo-lg d-flex align-items-center">
                <img src="{{ asset('assets/images/logo.png') }}" alt="" height="48">

                <span class="ms-2 fw-bold font-size-16 text-secondary d-none d-sm-block">
                    KEMENTERIAN KELAUTAN DAN PERIKANAN
                </span>
                <span class="ms-2 fw-bold font-size-12 text-secondary d-block d-sm-none">
                    KKP
                </span>
            </span>
            {{-- Hiding the small logo logic as we want the text likely --}}
            {{-- <span class="topnav-logo-sm d-none">
                <img src="{{ asset('assets/images/logo.png') }}" alt="" height="32">
            </span> --}}
        </a>

        <ul class="list-unstyled topbar-menu mb-0">
            <li class="notification-list">
                <a class="nav-link end-bar-toggle" href="javascript: void(0);">
                    <i class="dripicons-gear noti-icon"></i>
                </a>
            </li>

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown"
                    id="topbar-userdrop" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-image"
                            class="rounded-circle">
                    </span>
                    <span>
                        <span class="account-user-name">Dominic Keller</span>
                        <span class="account-position">Founder</span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown"
                    aria-labelledby="topbar-userdrop">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <a href="{{ route('password.change') }}" class="dropdown-item notify-item">
                        <i class="mdi mdi-account-key me-1"></i>
                        <span>Ganti Password</span>
                    </a>

                    <!-- item-->
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="dropdown-item notify-item"
                            style="border: none; background: none; width: 100%; text-align: left;">
                            <i class="mdi mdi-logout me-1"></i>
                            <span>Logout</span>
                        </button>
                    </form>

                </div>
            </li>
        </ul>
    </div>
</div>