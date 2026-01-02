<div class="navbar-custom topnav-navbar modern-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <!-- LOGO & BRAND -->
        <a href="{{ route('dashboard.index') }}" class="topnav-logo d-flex align-items-center text-decoration-none">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo KKP" height="48" class="header-logo">
            <span class="brand-title ms-3 d-none d-md-block">KEMENTERIAN KELAUTAN DAN PERIKANAN</span>
            <span class="brand-title-sm ms-2 d-block d-md-none">KKP</span>
        </a>

        <!-- RIGHT SIDE MENU -->
        <ul class="list-unstyled topbar-menu mb-0 d-flex align-items-center">
            <!-- Settings Button -->
            <li class="notification-list">
                <a class="nav-link end-bar-toggle header-icon-btn" href="javascript: void(0);" title="Pengaturan">
                    <i class="dripicons-gear"></i>
                </a>
            </li>

            <!-- User Dropdown -->
            <li class="dropdown notification-list ms-2">
                <a class="nav-link dropdown-toggle nav-user arrow-none me-0 user-dropdown-toggle"
                    data-bs-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="user-avatar-wrapper">
                        <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-image" class="user-avatar">
                        <span class="user-status-indicator"></span>
                    </div>
                    <div class="user-info d-none d-lg-block">
                        <span class="user-name">{{ Auth::user()->name ?? 'User' }}</span>
                        <span class="user-role">{{ Auth::user()->role ?? 'Administrator' }}</span>
                    </div>
                    <i class="mdi mdi-chevron-down user-dropdown-arrow d-none d-lg-inline-block"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown modern-dropdown"
                    aria-labelledby="topbar-userdrop">
                    <!-- Header -->
                    <div class="dropdown-header-custom">
                        <div class="dropdown-user-avatar">
                            <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-image">
                        </div>
                        <div class="dropdown-user-info">
                            <h6 class="dropdown-user-name">{{ Auth::user()->name ?? 'User' }}</h6>
                            <span class="dropdown-user-role">{{ Auth::user()->role ?? 'Administrator' }}</span>
                        </div>
                    </div>

                    <div class="dropdown-divider"></div>

                    <!-- Menu Items -->
                    <a href="{{ route('password.change') }}" class="dropdown-item notify-item modern-dropdown-item">
                        <i class="mdi mdi-account-key"></i>
                        <span>Ganti Password</span>
                    </a>

                    <!-- Logout -->
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="dropdown-item notify-item modern-dropdown-item logout-btn">
                            <i class="mdi mdi-logout"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>