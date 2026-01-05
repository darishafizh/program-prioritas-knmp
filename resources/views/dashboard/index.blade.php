@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <h4 class="page-title">Dashboard</h4>
                    <small class="text-muted">Data: {{ $periodLabel ?? 'Semua Waktu' }}</small>
                </div>
                <div class="page-title-right">
                    <form method="GET" action="{{ route('dashboard.index') }}" class="d-flex align-items-center gap-2">
                        <label class="mb-0 text-muted me-1">Filter:</label>
                        <select name="period" class="form-select form-select-sm" style="width: auto;"
                            onchange="this.form.submit()">
                            <option value="all" {{ ($period ?? 'all') == 'all' ? 'selected' : '' }}>Semua Waktu</option>
                            <option value="week" {{ ($period ?? '') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="month" {{ ($period ?? '') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="year" {{ ($period ?? '') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Greeting Banner - Modern Design -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="greeting-card position-relative overflow-hidden">
                <!-- Background Layer with Gradient -->
                <div class="greeting-bg"></div>
                
                <!-- Animated Wave Decoration -->
                <div class="greeting-wave">
                    <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
                        <path d="M0,64 C288,96 576,32 720,32 C864,32 1008,80 1152,80 C1296,80 1368,48 1440,48 L1440,120 L0,120 Z" 
                              fill="rgba(255,255,255,0.08)"></path>
                        <path d="M0,96 C288,64 360,96 540,96 C720,96 900,48 1080,48 C1260,48 1380,80 1440,96 L1440,120 L0,120 Z" 
                              fill="rgba(255,255,255,0.05)"></path>
                    </svg>
                </div>
                
                <!-- Decorative Circles -->
                <div class="greeting-circle circle-1"></div>
                <div class="greeting-circle circle-2"></div>
                <div class="greeting-circle circle-3"></div>
                
                <!-- Content -->
                <div class="greeting-content">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <!-- Left Section: Greeting & User Info -->
                        <div class="d-flex align-items-center">
                            <!-- Animated Icon Container -->
                            <div class="greeting-icon-wrapper me-4">
                                <div class="greeting-icon-bg">
                                    <i class="mdi {{ $greetingIcon ?? 'mdi-weather-sunny' }}"></i>
                                </div>
                                <div class="greeting-icon-pulse"></div>
                            </div>
                            
                            <!-- Text Content -->
                            <div>
                                <p class="greeting-label mb-1">
                                    <i class="mdi mdi-hand-wave me-1"></i>
                                    {{ $greeting ?? 'Selamat Datang' }}
                                </p>
                                <h3 class="greeting-name mb-2">{{ Auth::user()->name ?? 'Pengguna' }}</h3>
                                <p class="greeting-subtitle mb-0">
                                    <i class="mdi mdi-chart-timeline-variant-shimmer me-1"></i>
                                    Semoga harimu produktif! Berikut ringkasan data terkini.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Right Section: Date & Time -->
                        <div class="greeting-datetime text-end">
                            <div class="datetime-container">
                                <div class="datetime-date">
                                    <i class="mdi mdi-calendar-month me-1"></i>
                                    <span id="current-date"></span>
                                </div>
                                <div class="datetime-time">
                                    <i class="mdi mdi-clock-outline me-1"></i>
                                    <span id="current-time"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
    /* ===================================
       MODERN GREETING CARD STYLES
    =================================== */
    .greeting-card {
        border-radius: 20px;
        padding: 2rem 2.5rem;
        position: relative;
        min-height: 140px;
        box-shadow: 0 10px 40px rgba(6, 182, 212, 0.25),
                    0 0 0 1px rgba(255, 255, 255, 0.1) inset;
    }
    
    .greeting-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, #0891b2 0%, #0e7490 50%, #155e75 100%);
        border-radius: 20px;
        z-index: 0;
    }
    
    /* Alternative gradient based on time of day */
    @if(isset($greetingIcon) && str_contains($greetingIcon, 'night'))
    .greeting-bg {
        background: linear-gradient(135deg, #134e5e 0%, #1a3a5c 50%, #0f2027 100%) !important;
    }
    @elseif(isset($greetingIcon) && str_contains($greetingIcon, 'sunset'))
    .greeting-bg {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 50%, #c2410c 100%) !important;
    }
    @elseif(isset($greetingIcon) && str_contains($greetingIcon, 'sunny'))
    .greeting-bg {
        background: linear-gradient(135deg, #14b8a6 0%, #0d9488 50%, #0f766e 100%) !important;
    }
    @endif
    
    .greeting-wave {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 80px;
        z-index: 1;
        pointer-events: none;
    }
    
    .greeting-wave svg {
        width: 100%;
        height: 100%;
    }
    
    /* Decorative Circles */
    .greeting-circle {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        z-index: 1;
        pointer-events: none;
    }
    
    .circle-1 {
        width: 150px;
        height: 150px;
        top: -40px;
        right: 10%;
        animation: float-circle 8s ease-in-out infinite;
    }
    
    .circle-2 {
        width: 80px;
        height: 80px;
        bottom: 20px;
        right: 25%;
        animation: float-circle 6s ease-in-out infinite 1s;
    }
    
    .circle-3 {
        width: 50px;
        height: 50px;
        top: 30%;
        right: 5%;
        animation: float-circle 5s ease-in-out infinite 0.5s;
    }
    
    @keyframes float-circle {
        0%, 100% { transform: translateY(0) scale(1); opacity: 0.1; }
        50% { transform: translateY(-10px) scale(1.05); opacity: 0.15; }
    }
    
    .greeting-content {
        position: relative;
        z-index: 2;
    }
    
    /* Icon Wrapper */
    .greeting-icon-wrapper {
        position: relative;
        width: 80px;
        height: 80px;
        flex-shrink: 0;
    }
    
    .greeting-icon-bg {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .greeting-icon-bg i {
        font-size: 2.5rem;
        color: #fff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .greeting-icon-pulse {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.3);
        animation: pulse-ring 2s infinite;
        pointer-events: none;
    }
    
    @keyframes pulse-ring {
        0% { transform: scale(1); opacity: 0.3; }
        100% { transform: scale(1.3); opacity: 0; }
    }
    
    /* Text Styles */
    .greeting-label {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.85);
        font-weight: 500;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    
    .greeting-name {
        font-size: 1.75rem;
        font-weight: 700;
        color: #fff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin: 0;
    }
    
    .greeting-subtitle {
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.8);
    }
    
    /* DateTime Section */
    .greeting-datetime {
        flex-shrink: 0;
    }
    
    .datetime-container {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 1rem 1.5rem;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .datetime-date {
        font-size: 1rem;
        color: #fff;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .datetime-time {
        font-size: 1.5rem;
        color: #fff;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
    }
    
    /* Quick Stats */
    .greeting-stats {
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        padding-top: 1.25rem;
    }
    
    .quick-stat {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(10px);
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        transition: all 0.3s ease;
    }
    
    .quick-stat:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    
    .quick-stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .quick-stat-icon i {
        font-size: 1.25rem;
        color: #fff;
    }
    
    .quick-stat-content {
        display: flex;
        flex-direction: column;
    }
    
    .quick-stat-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #fff;
        line-height: 1.2;
    }
    
    .quick-stat-label {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.75);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .greeting-card {
            padding: 1.5rem;
        }
        
        .greeting-icon-wrapper {
            width: 60px;
            height: 60px;
        }
        
        .greeting-icon-bg {
            width: 60px;
            height: 60px;
            border-radius: 16px;
        }
        
        .greeting-icon-bg i {
            font-size: 1.75rem;
        }
        
        .greeting-name {
            font-size: 1.35rem;
        }
        
        .greeting-datetime {
            display: none;
        }
        
        .circle-1, .circle-2, .circle-3 {
            display: none;
        }
    }
    
    /* ===================================
       EXECUTIVE SUMMARY STYLES
    =================================== */
    .executive-summary-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .national-progress-section {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 1.25rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }
    
    .progress-percentage {
        font-size: 1.5rem;
        background: linear-gradient(135deg, #0891b2 0%, #0d9488 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .progress-lg .progress-bar {
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .progress-label {
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    }
    
    /* Quick Stat Cards */
    .quick-stat-card {
        padding: 1.25rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 1rem;
        color: #fff;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .quick-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .quick-stat-card .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .quick-stat-card .stat-icon i {
        font-size: 1.75rem;
    }
    
    .quick-stat-card .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }
    
    .quick-stat-card .stat-label {
        font-size: 0.85rem;
        opacity: 0.9;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    }
    
    /* Province Ranking Styles */
    .rank-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
    }
    
    .rank-1 { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: #fff; }
    .rank-2 { background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%); color: #fff; }
    .rank-3 { background: linear-gradient(135deg, #d97706 0%, #b45309 100%); color: #fff; }
    .rank-4, .rank-5 { background: #e2e8f0; color: #64748b; }
    .rank-attention { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: #fff; }
    
    .bg-soft-primary { background-color: rgba(59, 130, 246, 0.1); }
    .bg-soft-success { background-color: rgba(16, 185, 129, 0.1); }
    .bg-soft-danger { background-color: rgba(239, 68, 68, 0.1); }
    .bg-soft-secondary { background-color: rgba(100, 116, 139, 0.1); }
    
    .table-centered th, .table-centered td {
        vertical-align: middle;
    }
    
    /* Responsive for Quick Stats */
    @media (max-width: 768px) {
        .quick-stat-card {
            padding: 1rem;
        }
        
        .quick-stat-card .stat-icon {
            width: 48px;
            height: 48px;
        }
        
        .quick-stat-card .stat-icon i {
            font-size: 1.5rem;
        }
        
        .quick-stat-card .stat-value {
            font-size: 1.25rem;
        }
    }
    </style>
    
    <script>
    // Real-time Date & Time Update
    function updateDateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateStr = now.toLocaleDateString('id-ID', options);
        const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        
        document.getElementById('current-date').textContent = dateStr;
        document.getElementById('current-time').textContent = timeStr;
    }
    
    updateDateTime();
    setInterval(updateDateTime, 1000);
    </script>
    <!-- End Greeting Banner -->

    {{-- ===================================
        EXECUTIVE SUMMARY - NATIONAL OVERVIEW
    =================================== --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card executive-summary-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="header-title mb-1">
                                <i class="mdi mdi-chart-arc me-2 text-primary"></i>
                                Ringkasan Eksekutif Program KNMP Nasional
                            </h4>
                            <p class="text-muted mb-0">Monitoring perkembangan program KNMP di seluruh Indonesia</p>
                        </div>
                        <span class="badge bg-soft-primary text-primary px-3 py-2">
                            <i class="mdi mdi-update me-1"></i>
                            {{ $periodLabel ?? 'Semua Waktu' }}
                        </span>
                    </div>
                    
                    {{-- Progress Bar Nasional --}}
                    <div class="national-progress-section">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Progress Target Nasional</span>
                            <span class="progress-percentage fw-bold">{{ $progressNasional ?? 0 }}%</span>
                        </div>
                        <div class="progress progress-lg" style="height: 24px; border-radius: 12px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated 
                                @if(($progressNasional ?? 0) >= 80) bg-success 
                                @elseif(($progressNasional ?? 0) >= 50) bg-primary 
                                @elseif(($progressNasional ?? 0) >= 30) bg-warning 
                                @else bg-danger @endif" 
                                role="progressbar" 
                                style="width: {{ $progressNasional ?? 0 }}%">
                                <span class="progress-label">{{ $totalKnmpNasional ?? 0 }} / {{ $targetKnmp ?? 100 }} KNMP</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <small class="text-muted">
                                <i class="mdi mdi-map-marker-multiple me-1"></i>
                                {{ $totalProvinsiCovered ?? 0 }} Provinsi ter-cover
                            </small>
                            <small class="text-muted">
                                <i class="mdi mdi-target me-1"></i>
                                Target: {{ $targetKnmp ?? 100 }} Lokasi KNMP
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistic Cards - Baris 1 (Original KPI Cards) --}}
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="widget-icon">
                        <i class="mdi mdi-map-marker-radius"></i>
                    </div>
                    <h5>Total Lokasi KNMP</h5>
                    <h3>{{ number_format(count($desa_knmp ?? []), 0, ',', '.') }}</h3>
                    <p class="mb-0 text-muted" style="font-size: 0.8rem;">
                        <i class="mdi mdi-trending-up text-success me-1"></i>
                        Lokasi tersebar di seluruh Indonesia
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="widget-icon" style="background: linear-gradient(135deg, #10B981 0%, #34D399 100%); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                        <i class="mdi mdi-clipboard-text-search"></i>
                    </div>
                    <h5>Total Survey</h5>
                    <h3>{{ number_format($totalSurveyTerisi ?? 0, 0, ',', '.') }}</h3>
                    <p class="mb-0 text-muted" style="font-size: 0.8rem;">
                        <i class="mdi mdi-check-circle text-success me-1"></i>
                        Survey terisi lengkap
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="widget-icon" style="background: linear-gradient(135deg, #F59E0B 0%, #FBBF24 100%); box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);">
                        <i class="mdi mdi-database-check"></i>
                    </div>
                    <h5>Tingkat Kelengkapan Data</h5>
                    <h3>{{ number_format($tingkatKelengkapanData ?? 0, 2, ',', '.') }}%</h3>
                    <p class="mb-0 text-muted" style="font-size: 0.8rem;">
                        <i class="mdi mdi-information-outline text-info me-1"></i>
                        Dari total seluruh data
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistic Cards - Baris 2 --}}
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="widget-icon" style="background: linear-gradient(135deg, #8B5CF6 0%, #A78BFA 100%); box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
                        <i class="mdi mdi-bullseye-arrow"></i>
                    </div>
                    <h5>Rata-rata Capaian Indikator</h5>
                    <h3>{{ number_format($capaianIndikator ?? 0, 2, ',', '.') }}%</h3>
                    <p class="mb-0 text-muted" style="font-size: 0.8rem;">
                        <i class="mdi mdi-chart-line text-primary me-1"></i>
                        Target tercapai
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="widget-icon" style="background: linear-gradient(135deg, #EC4899 0%, #F472B6 100%); box-shadow: 0 4px 15px rgba(236, 72, 153, 0.3);">
                        <i class="mdi mdi-emoticon-happy"></i>
                    </div>
                    <h5>Rata-rata Indeks Kebahagiaan</h5>
                    <h3>{{ number_format($rataRataKebahagiaan ?? 0, 2, ',', '.') }}</h3>
                    <p class="mb-0 text-muted" style="font-size: 0.8rem;">
                        <i class="mdi mdi-thumb-up text-success me-1"></i>
                        Skala 1-10
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="widget-icon" style="background: linear-gradient(135deg, #06B6D4 0%, #22D3EE 100%); box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);">
                        <i class="mdi mdi-home-group-plus"></i>
                    </div>
                    <h5>Desa dengan Aset Bertambah</h5>
                    <h3>{{ number_format($desaAsetBertambah ?? 0, 0, ',', '.') }}</h3>
                    <p class="mb-0 text-muted" style="font-size: 0.8rem;">
                        <i class="mdi mdi-arrow-up-bold text-success me-1"></i>
                        Pertumbuhan positif
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    {{-- ===================================
        PROVINCE STATISTICS & RANKING
    =================================== --}}
    <div class="row mb-4">
        {{-- Top Performing Provinces --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="header-title mb-0">
                            <i class="mdi mdi-trophy text-warning me-2"></i>
                            Top 5 Provinsi Terbaik
                        </h4>
                        <span class="badge bg-soft-success text-success">
                            <i class="mdi mdi-trending-up me-1"></i>Tertinggi
                        </span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-centered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>Provinsi</th>
                                    <th style="width: 80px;">KNMP</th>
                                    <th style="width: 150px;">Capaian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProvinsi ?? [] as $index => $prov)
                                <tr>
                                    <td>
                                        <span class="rank-badge rank-{{ $index + 1 }}">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $prov->province_name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-primary text-primary">{{ $prov->total_knmp }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                <div class="progress-bar bg-success" style="width: {{ min($prov->avg_capaian, 100) }}%"></div>
                                            </div>
                                            <span class="fw-semibold text-success">{{ number_format($prov->avg_capaian, 1) }}%</span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="mdi mdi-database-off mdi-48px d-block mb-2"></i>
                                        Belum ada data provinsi
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Provinces Needing Attention --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="header-title mb-0">
                            <i class="mdi mdi-alert-circle text-danger me-2"></i>
                            Provinsi Perlu Perhatian
                        </h4>
                        <span class="badge bg-soft-danger text-danger">
                            <i class="mdi mdi-trending-down me-1"></i>Prioritas
                        </span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-centered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>Provinsi</th>
                                    <th style="width: 80px;">KNMP</th>
                                    <th style="width: 150px;">Capaian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bottomProvinsi ?? [] as $index => $prov)
                                <tr>
                                    <td>
                                        <span class="rank-badge rank-attention">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $prov->province_name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-secondary text-secondary">{{ $prov->total_knmp }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                <div class="progress-bar 
                                                    @if($prov->avg_capaian >= 50) bg-warning 
                                                    @else bg-danger @endif" 
                                                    style="width: {{ min($prov->avg_capaian, 100) }}%"></div>
                                            </div>
                                            <span class="fw-semibold 
                                                @if($prov->avg_capaian >= 50) text-warning 
                                                @else text-danger @endif">{{ number_format($prov->avg_capaian, 1) }}%</span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="mdi mdi-check-circle mdi-48px text-success d-block mb-2"></i>
                                        Semua provinsi berkinerja baik!
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Row Chart 1 --}}
    <div class="row mt-4">
        <div class="col-xl-6 col-lg-6">
            <div class="card card-h-100">
                <div class="card-body">
                    <ul class="nav float-end d-none d-lg-flex">
                        <li class="nav-item"><a class="nav-link text-muted" href="#">Today</a></li>
                        <li class="nav-item"><a class="nav-link text-muted" href="#">7d</a></li>
                        <li class="nav-item"><a class="nav-link active" href="#">15d</a></li>
                        <li class="nav-item"><a class="nav-link text-muted" href="#">1m</a></li>
                        <li class="nav-item"><a class="nav-link text-muted" href="#">1y</a></li>
                    </ul>
                    <h4 class="header-title mb-3">Capaian Indikator</h4>

                    <div id="sessions-overview" class="apex-charts mt-3" data-colors="#0acf97"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="header-title">Distribusi Kategori Aset</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" class="dropdown-item">Refresh Report</a>
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                            </div>
                        </div>
                    </div>

                    <div id="country-chart" class="apex-charts" data-colors="#727cf5"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Row Chart 2 --}}
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="header-title">Penyerapan Tenaga Kerja</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" class="dropdown-item">Weekly Report</a>
                                <a href="javascript:void(0);" class="dropdown-item">Monthly Report</a>
                            </div>
                        </div>
                    </div>

                    <div class="chartjs-chart" style="height: 355px;">
                        <canvas id="task-area-chart"></canvas>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="header-title">Tingkat Kesejahteraan</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" class="dropdown-item">Refresh Report</a>
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                            </div>
                        </div>
                    </div>

                    <div id="sessions-browser" class="apex-charts mt-3" data-colors="#727cf5"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- MAP SECTION --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Sebaran Lokasi KNMP</h4>
                    <div id="map-knmp" style="height: 450px; border-radius:10px;"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

    <script>
        /* ===================================
           FIX: Prevent duplicate map instance
        =================================== */
        if (window.mapInstance) {
            window.mapInstance.remove();
        }

        var map = L.map("map-knmp").setView([-2.5, 118], 5);
        window.mapInstance = map;

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19
        }).addTo(map);

        /* ===================================
           ICON MERAH (VALID CDN)
        =================================== */
        var redIcon = new L.Icon({
            iconUrl: "https://cdn.jsdelivr.net/gh/pointhi/leaflet-color-markers@master/img/marker-icon-red.png",
            shadowUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png",
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41],
        });

        /* ===================================
           LOAD DATA DARI CONTROLLER
        =================================== */
        var desaKNMP = @json($desa_knmp ?? []);

        var detailUrlPattern = "{{ route('survey.questionnaires-pdf', ['knmp' => ':id']) }}";

        desaKNMP.forEach(function (item) {
            if (item.latitude !== null && item.longitude !== null) {

                var detailUrl = detailUrlPattern.replace(':id', item.id);
                var popupContent = `
                                                        <div class="p-1">
                                                            <h6 class="mb-2 text-primary fw-bold" style="font-size: 14px;">${item.nama ?? "Lokasi KNMP " + item.id}</h6>

                                                            <div class="mb-2 small text-muted">
                                                                <div class="mb-1"><i class="mdi mdi-map-marker-radius me-1 text-danger"></i> 
                                                                    ${item.village ? item.village.name : '-'}, ${item.district ? item.district.name : '-'}
                                                                </div>
                                                                <div><i class="mdi mdi-city me-1 text-secondary"></i>
                                                                    ${item.regency ? item.regency.name : '-'}, ${item.province ? item.province.name : '-'}
                                                                </div>
                                                            </div>

                                                            <a href="${detailUrl}" class="btn btn-xs btn-primary w-100 rounded-pill">
                                                                <i class="mdi mdi-eye me-1"></i> Lihat Data Survey
                                                            </a>
                                                        </div>
                                                    `;

                L.marker([item.latitude, item.longitude], {
                    icon: redIcon
                })
                    .addTo(map)
                    .bindPopup(popupContent, {
                        minWidth: 200
                    });
            }
        });

        /* ===================================
           FIX MAP RENDER
        =================================== */
        setTimeout(() => map.invalidateSize(), 300);
    </script>



    <style>
        /* FIX: Leaflet icon tidak terkena CSS bootstrap/theme */
        .leaflet-marker-icon,
        .leaflet-marker-shadow {
            max-width: none !important;
            max-height: none !important;
            image-rendering: auto !important;
            display: block !important;
        }
    </style>

    {{-- ===================================
    CHART 1: Capaian Indikator (ApexCharts Bar)
    =================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data dari controller dengan fallback
            var capaianPerKnmpData = {!! json_encode($capaianPerKnmp ?? []) !!};
            var labelKnmpData = {!! json_encode($labelKnmp ?? []) !!};
            var distribusiAsetDataArr = {!! json_encode($distribusiAsetData ?? []) !!};
            var distribusiAsetLabelsArr = {!! json_encode($distribusiAsetLabels ?? []) !!};
            var penyerapanTenagaKerjaData = {!! json_encode($penyerapanTenagaKerja ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]) !!};
            var penyerapanLabelsData = {!! json_encode($penyerapanLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']) !!};
            var tingkatKesejahteraanDataArr = {!! json_encode($tingkatKesejahteraanData ?? [0, 0, 0, 0]) !!};
            var tingkatKesejahteraanLabelsArr = {!! json_encode($tingkatKesejahteraanLabels ?? ['Sangat Sejahtera', 'Sejahtera', 'Cukup Sejahtera', 'Kurang Sejahtera']) !!};

            // Fallback jika data kosong
            if (capaianPerKnmpData.length === 0) {
                capaianPerKnmpData = [44, 55, 57, 56, 61, 58, 63, 60, 66];
                labelKnmpData = ['KNMP 1', 'KNMP 2', 'KNMP 3', 'KNMP 4', 'KNMP 5', 'KNMP 6', 'KNMP 7', 'KNMP 8', 'KNMP 9'];
            }
            if (distribusiAsetDataArr.length === 0) {
                distribusiAsetDataArr = [44, 55, 41, 17, 15];
                distribusiAsetLabelsArr = ['Perahu', 'Alat Tangkap', 'Gedung', 'Kendaraan', 'Lainnya'];
            }

            // Chart 1: Capaian Indikator
            var capaianIndikatorOptions = {
                chart: {
                    height: 309,
                    type: 'bar',
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '45%',
                        borderRadius: 4
                    }
                },
                dataLabels: { enabled: false },
                stroke: { show: true, width: 2, colors: ['transparent'] },
                series: [{
                    name: 'Capaian',
                    data: capaianPerKnmpData
                }],
                xaxis: {
                    categories: labelKnmpData,
                    labels: {
                        style: { colors: '#6c757d' },
                        rotate: -45,
                        rotateAlways: true
                    }
                },
                yaxis: {
                    title: { text: 'Persentase (%)', style: { color: '#6c757d' } },
                    labels: { style: { colors: '#6c757d' } },
                    max: 100
                },
                fill: { opacity: 1 },
                tooltip: {
                    y: { formatter: function (val) { return val + "%"; } }
                },
                colors: ['#0acf97'],
                grid: { borderColor: '#f1f3fa' }
            };
            var capaianChart = new ApexCharts(document.querySelector("#sessions-overview"), capaianIndikatorOptions);
            capaianChart.render();

            // Chart 2: Distribusi Kategori Aset (Donut Chart)
            var distribusiAsetOptions = {
                chart: {
                    height: 350,
                    type: 'donut'
                },
                series: distribusiAsetDataArr,
                labels: distribusiAsetLabelsArr,
                colors: ['#727cf5', '#0acf97', '#fa5c7c', '#ffbc00', '#39afd1'],
                legend: {
                    show: true,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    labels: { colors: '#6c757d' }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: { width: 200 },
                        legend: { position: 'bottom' }
                    }
                }],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total Aset',
                                    color: '#6c757d'
                                }
                            }
                        }
                    }
                }
            };
            var distribusiChart = new ApexCharts(document.querySelector("#country-chart"), distribusiAsetOptions);
            distribusiChart.render();

            // Chart 3: Penyerapan Tenaga Kerja (Chart.js Line)
            var ctx = document.getElementById('task-area-chart').getContext('2d');

            var taskAreaChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: penyerapanLabelsData,
                    datasets: [{
                        label: 'Tenaga Kerja Terserap',
                        data: penyerapanTenagaKerjaData,
                        backgroundColor: 'rgba(114, 124, 245, 0.3)',
                        borderColor: '#727cf5',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#727cf5',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#727cf5'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: true, position: 'top' }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f3fa' },
                            ticks: { color: '#6c757d' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#6c757d' }
                        }
                    }
                }
            });

            // Chart 4: Tingkat Kesejahteraan (Donut Chart - Bulat)
            var tingkatKesejahteraanOptions = {
                chart: {
                    height: 350,
                    type: 'donut'
                },
                series: tingkatKesejahteraanDataArr,
                labels: tingkatKesejahteraanLabelsArr,
                colors: ['#0acf97', '#727cf5', '#ffbc00', '#fa5c7c'],
                legend: {
                    show: true,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    labels: { colors: '#6c757d' }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    color: '#6c757d',
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0) + '%';
                                    }
                                }
                            }
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: { width: 200 },
                        legend: { position: 'bottom' }
                    }
                }]
            };
            var kesejahteraanChart = new ApexCharts(document.querySelector("#sessions-browser"), tingkatKesejahteraanOptions);
            kesejahteraanChart.render();
        });
    </script>

@endpush