<header class="main-header">
    <div class="container-fluid px-4">
        <nav class="header-nav">
            <!-- Logo & Brand -->
            <a class="header-brand" href="{{ route('dashboard.index') }}">
                <img src="{{ asset('assets/images/knmp-logo.png') }}" alt="Logo KNMP" class="header-logo">
            </a>

            <!-- Mobile Toggle -->
            <button class="header-toggler" type="button" id="headerToggler">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Navigation Menu -->
            <div class="header-menu" id="headerMenu">
                <ul class="header-nav-list">
                    <!-- Dashboard - untuk semua user -->
                    <li class="header-nav-item">
                        <a class="header-nav-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}"
                            href="{{ route('dashboard.index') }}">
                            <i class="mdi mdi-view-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- Analytics - hanya untuk admin -->
                    <!-- @if(Auth::user()->isAdmin())
                        <li class="header-nav-item">
                            <a class="header-nav-link {{ request()->routeIs('analytics.*') ? 'active' : '' }}"
                                href="{{ route('analytics.index') }}">
                                <i class="mdi mdi-chart-timeline-variant"></i>
                                <span>Analytics</span>
                            </a>
                        </li>
                    @endif -->

                    <!-- Survey - untuk semua user -->
                    <li class="header-nav-item">
                        <a class="header-nav-link {{ request()->routeIs('survey.*') ? 'active' : '' }}"
                            href="{{ route('survey.index') }}">
                            <i class="mdi mdi-clipboard-text-outline"></i>
                            <span>Survey</span>
                        </a>
                    </li>

                    <!-- Informasi Umum - untuk semua user -->
                    <li class="header-nav-item">
                        <a class="header-nav-link {{ request()->routeIs('informasi_umum.*') ? 'active' : '' }}"
                            href="{{ route('informasi_umum.index') }}">
                            <i class="mdi mdi-information-outline"></i>
                            <span>Informasi Umum</span>
                        </a>
                    </li>

                    <!-- Manajemen User - hanya untuk admin -->
                    @if(Auth::user()->isAdmin())
                        <li class="header-nav-item">
                            <a class="header-nav-link {{ request()->routeIs('user_management.*') ? 'active' : '' }}"
                                href="{{ route('user_management.index') }}">
                                <i class="mdi mdi-account-cog"></i>
                                <span>Manajemen User</span>
                            </a>
                        </li>
                    @endif
                </ul>

                <!-- User Menu -->
                <div class="header-user header-dropdown">
                    <a class="header-user-btn" href="#" id="userDropdown">
                        <div class="header-user-avatar-text">
                            {{ strtoupper(substr(Auth::user()->username ?? Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="header-user-info">
                            <span
                                class="header-user-name">{{ Auth::user()->username ?? Auth::user()->name ?? 'User' }}</span>
                            <span class="header-user-role">
                                @if(Auth::user()->hasRole('admin'))
                                    Admin
                                @elseif(Auth::user()->hasRole('enumerator'))
                                    Enumerator
                                @else
                                    Member
                                @endif
                            </span>
                        </div>
                        <i class="mdi mdi-chevron-down"></i>
                    </a>
                    <ul class="header-dropdown-menu header-dropdown-end">
                        <li class="dropdown-user-header">
                            <strong>{{ Auth::user()->username ?? Auth::user()->name ?? 'User' }}</strong>
                            <small>
                                @if(Auth::user()->hasRole('admin'))
                                    <span class="badge bg-danger">Admin</span>
                                @elseif(Auth::user()->hasRole('enumerator'))
                                    <span class="badge bg-success">Enumerator</span>
                                @endif
                            </small>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <a href="{{ route('password.change') }}">
                                <i class="mdi mdi-key"></i> Ganti Password
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                                @csrf
                                <a href="javascript:void(0);"
                                    onclick="event.preventDefault(); document.getElementById('logoutForm').submit();"
                                    class="text-danger">
                                    <i class="mdi mdi-logout"></i> Logout
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>

<style>
    /* Main Header */
    .main-header {
        background: linear-gradient(135deg, #003D7A 0%, #0054A6 100%);
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.15);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .header-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 56px;
        gap: 1.5rem;
    }

    /* Brand / Logo */
    .header-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        flex-shrink: 0;
    }

    .header-logo {
        height: 34px;
        width: auto;
        background: #fff;
        border-radius: 6px;
        padding: 3px;
    }

    .header-brand-text {
        display: flex;
        flex-direction: column;
    }

    .header-brand-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #fff;
        line-height: 1.2;
    }

    .header-brand-subtitle {
        font-size: 0.65rem;
        color: rgba(255, 255, 255, 0.75);
        line-height: 1.2;
    }

    /* Navigation List */
    .header-menu {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1;
        justify-content: flex-end;
    }

    .header-nav-list {
        display: flex;
        align-items: center;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 0.25rem;
    }

    .header-nav-item {
        position: relative;
    }

    .header-nav-link {
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .header-nav-link:hover,
    .header-nav-link.active {
        color: #fff;
        background: rgba(255, 255, 255, 0.15);
    }

    .header-nav-link i {
        font-size: 1rem;
    }

    .header-nav-link .dropdown-arrow {
        font-size: 0.9rem;
        margin-left: 2px;
    }

    /* Dropdown */
    .header-dropdown {
        position: relative;
    }

    .header-dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 200px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        list-style: none;
        margin: 8px 0 0;
        padding: 8px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.2s ease;
        z-index: 1001;
    }

    .header-dropdown:hover .header-dropdown-menu,
    .header-dropdown.show .header-dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .header-dropdown-end {
        left: auto;
        right: 0;
    }

    .header-dropdown-menu li a {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        color: #333;
        text-decoration: none;
        font-size: 0.8rem;
        border-radius: 6px;
        transition: background 0.15s;
    }

    .header-dropdown-menu li a:hover {
        background: #f5f7fa;
    }

    .header-dropdown-menu li a.text-danger {
        color: #dc3545;
    }

    .dropdown-user-header {
        padding: 12px 14px;
        border-bottom: 1px solid #eee;
        margin-bottom: 4px;
    }

    .dropdown-user-header strong {
        display: block;
        font-size: 0.8rem;
        color: #333;
    }

    .dropdown-user-header small {
        color: #6c757d;
        font-size: 0.75rem;
    }

    .dropdown-divider {
        height: 1px;
        background: #eee;
        margin: 4px 0;
    }

    /* User Button */
    .header-user {
        margin-left: 1rem;
        padding-left: 1rem;
        border-left: 1px solid rgba(255, 255, 255, 0.2);
    }

    .header-user-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 10px;
        text-decoration: none;
        border-radius: 8px;
        transition: background 0.2s;
    }

    .header-user-btn:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .header-user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .header-user-avatar-text {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .header-user-info {
        display: flex;
        flex-direction: column;
        text-align: left;
    }

    .header-user-name {
        font-size: 0.78rem;
        font-weight: 600;
        color: #fff;
        line-height: 1.2;
    }

    .header-user-role {
        font-size: 0.65rem;
        color: rgba(255, 255, 255, 0.7);
    }

    .header-user-btn>i {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1rem;
    }

    /* Mobile Toggle */
    .header-toggler {
        display: none;
        flex-direction: column;
        gap: 5px;
        padding: 8px;
        background: transparent;
        border: none;
        cursor: pointer;
    }

    .header-toggler span {
        display: block;
        width: 22px;
        height: 2px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 2px;
        transition: all 0.3s;
    }

    /* Responsive */
    @media (max-width: 1199.98px) {
        .header-brand-subtitle {
            display: none;
        }
    }

    @media (max-width: 991.98px) {
        .header-toggler {
            display: flex;
        }

        .header-menu {
            position: fixed;
            top: 64px;
            left: 0;
            right: 0;
            bottom: 0;
            background: #003D7A;
            flex-direction: column;
            align-items: stretch;
            justify-content: flex-start;
            padding: 1rem;
            gap: 0;
            display: none;
            overflow-y: auto;
        }

        .header-menu.show {
            display: flex;
        }

        .header-nav-list {
            flex-direction: column;
            align-items: stretch;
            gap: 4px;
        }

        .header-nav-link {
            padding: 12px 16px;
        }

        .header-dropdown-menu {
            position: static;
            opacity: 1;
            visibility: visible;
            transform: none;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: none;
            margin: 4px 0 4px 16px;
            display: none;
        }

        .header-dropdown.show .header-dropdown-menu {
            display: block;
        }

        .header-dropdown-menu li a {
            color: rgba(255, 255, 255, 0.9);
        }

        .header-dropdown-menu li a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .header-user {
            margin: 1rem 0 0;
            padding: 1rem 0 0;
            border-left: none;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header-user .header-dropdown-menu {
            margin-left: 0;
        }
    }

    @media (max-width: 575.98px) {
        .header-brand-text {
            display: none;
        }

        .header-user-info {
            display: none;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mobile menu toggle
        var toggler = document.getElementById('headerToggler');
        var menu = document.getElementById('headerMenu');

        if (toggler && menu) {
            toggler.addEventListener('click', function () {
                menu.classList.toggle('show');
            });
        }

        // Dropdown toggle for mobile
        document.querySelectorAll('.header-dropdown > a').forEach(function (link) {
            link.addEventListener('click', function (e) {
                if (window.innerWidth < 992) {
                    e.preventDefault();
                    this.parentElement.classList.toggle('show');
                }
            });
        });
    });
</script>