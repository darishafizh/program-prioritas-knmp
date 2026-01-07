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

    <!-- Greeting Banner - Clean Modern Design -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="greeting-card-clean">
                <div class="d-flex align-items-center justify-content-between">
                    <!-- Left: Icon + Text -->
                    <div class="d-flex align-items-center">
                        <div class="greeting-icon-clean me-3">
                            <i class="mdi mdi-weather-sunny"></i>
                        </div>
                        <div>
                            <h4 class="greeting-title-clean mb-0">Selamat Pagi, <span class="greeting-name-clean">{{ Auth::user()->name ?? 'Pengguna' }}</span></h4>
                            <p class="greeting-motivation-clean mb-0">Setiap langkah kecil membawa kita lebih dekat ke tujuan besar. <span class="greeting-tagline">#2026KKPGrowStronger</span></p>
                        </div>
                    </div>
                    
                    <!-- Right: Date -->
                    <div class="greeting-date-clean">
                        <i class="mdi mdi-calendar-today me-1"></i>
                        <span id="current-date-display"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    (function() {
        const now = new Date();
        const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
        document.getElementById('current-date-display').textContent = now.toLocaleDateString('id-ID', options);
    })();
    </script>
    
    <style>
    /* ===================================
       CLEAN GREETING CARD STYLES
    =================================== */
    .greeting-card-clean {
        background: #ffffff;
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
    }
    
    .greeting-icon-clean {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .greeting-icon-clean i {
        font-size: 1.4rem;
        color: #fff;
    }
    
    .greeting-title-clean {
        font-size: 1.1rem;
        font-weight: 500;
        color: #374151;
        line-height: 1.4;
    }
    
    .greeting-name-clean {
        font-weight: 600;
        color: #1f2937;
    }
    
    .greeting-motivation-clean {
        font-size: 0.85rem;
        color: #9ca3af;
        margin-top: 0.125rem;
    }
    
    .greeting-tagline {
        color: #0891b2;
        font-weight: 600;
    }
    
    .greeting-date-clean {
        font-size: 0.85rem;
        color: #6b7280;
        display: flex;
        align-items: center;
        background: #f9fafb;
        padding: 0.5rem 0.875rem;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }
    
    .greeting-date-clean i {
        color: #9ca3af;
        font-size: 1rem;
    }
    
    @media (max-width: 576px) {
        .greeting-card-clean {
            padding: 1rem 1.25rem;
        }
        
        .greeting-icon-clean {
            width: 40px;
            height: 40px;
        }
        
        .greeting-icon-clean i {
            font-size: 1.2rem;
        }
        
        .greeting-name-clean {
            font-size: 1rem;
        }
        
        .greeting-date-clean {
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
    <!-- End Greeting Banner -->

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