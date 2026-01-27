@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
@endpush

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <h4 class="page-title">Dashboard</h4>
                    <small class="text-muted">Data: {{ $periodLabel ?? 'Semua Waktu' }}</small>
                </div>
                <div class="page-title-right d-flex align-items-center gap-2">
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
                    <a href="{{ route('dashboard.export-pdf', ['period' => $period ?? 'all']) }}"
                        class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="mdi mdi-file-pdf-box me-1"></i>Export PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Greeting Banner - Clean Modern Design -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="greeting-card-clean">
                <div class="d-flex align-items-center justify-content-between greeting-wrapper">
                    <!-- Left: Icon + Text -->
                    <div class="d-flex align-items-center">
                        <div class="greeting-icon-clean me-3">
                            <i class="mdi {{ $greetingIcon ?? 'mdi-weather-sunny' }}"></i>
                        </div>
                        <div>
                            <h4 class="greeting-title-clean mb-0">{{ $greeting }}, <span
                                    class="greeting-name-clean">{{ Auth::user()->name ?? 'Pengguna' }}</span></h4>
                            <p class="greeting-motivation-clean mb-0">Setiap langkah kecil membawa kita lebih dekat ke
                                tujuan besar. <span class="greeting-tagline">#2026KKPGrowStronger</span></p>
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
                    <div class="widget-icon"
                        style="background: linear-gradient(135deg, #10B981 0%, #34D399 100%); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
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
                    <div class="widget-icon"
                        style="background: linear-gradient(135deg, #F59E0B 0%, #FBBF24 100%); box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);">
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
                    <div class="widget-icon"
                        style="background: linear-gradient(135deg, #8B5CF6 0%, #A78BFA 100%); box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
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
                    <div class="widget-icon"
                        style="background: linear-gradient(135deg, #EC4899 0%, #F472B6 100%); box-shadow: 0 4px 15px rgba(236, 72, 153, 0.3);">
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
                    <div class="widget-icon"
                        style="background: linear-gradient(135deg, #06B6D4 0%, #22D3EE 100%); box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);">
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
                                        <td>iip
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                    <div class="progress-bar bg-success"
                                                        style="width: {{ min($prov->avg_capaian, 100) }}%"></div>
                                                </div>
                                                <span
                                                    class="fw-semibold text-success">{{ number_format($prov->avg_capaian, 1) }}%</span>
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
                                                <span
                                                    class="fw-semibold 
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
    {{-- Pass data to JavaScript --}}
    <script>
        window.dashboardData = {
            capaianPerKnmp: {!! json_encode($capaianPerKnmp ?? []) !!},
            labelKnmp: {!! json_encode($labelKnmp ?? []) !!},
            distribusiAsetData: {!! json_encode($distribusiAsetData ?? []) !!},
            distribusiAsetLabels: {!! json_encode($distribusiAsetLabels ?? []) !!},
            penyerapanTenagaKerja: {!! json_encode($penyerapanTenagaKerja ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]) !!},
            penyerapanLabels: {!! json_encode($penyerapanLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']) !!},
            tingkatKesejahteraanData: {!! json_encode($tingkatKesejahteraanData ?? [0, 0, 0, 0]) !!},
            tingkatKesejahteraanLabels: {!! json_encode($tingkatKesejahteraanLabels ?? ['Sangat Sejahtera', 'Sejahtera', 'Cukup Sejahtera', 'Kurang Sejahtera']) !!},
            desaKnmp: @json($desa_knmp ?? []),
            detailUrlPattern: "{{ route('survey.questionnaires-pdf', ['knmp' => ':id']) }}"
        };
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush