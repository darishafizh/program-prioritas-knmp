@extends('layouts.app')

@push('styles')
    <style>
        .comparison-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .comparison-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .comparison-card .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .comparison-card .growth-badge {
            font-size: 0.875rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
        }

        .growth-positive {
            background: rgba(16, 185, 129, 0.15);
            color: #059669;
        }

        .growth-negative {
            background: rgba(239, 68, 68, 0.15);
            color: #dc2626;
        }

        .growth-neutral {
            background: rgba(107, 114, 128, 0.15);
            color: #6b7280;
        }

        .period-selector .nav-link {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            margin-right: 0.5rem;
        }

        .period-selector .nav-link.active {
            background: #0891b2;
            color: #fff;
        }

        .trend-chart-container {
            height: 350px;
        }
    </style>
@endpush

@section('content')
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <h4 class="page-title">
                        <i class="mdi mdi-chart-timeline-variant me-2"></i>
                        Analytics & Trend Analysis
                    </h4>
                    <small class="text-muted">Perbandingan data dan analisis tren</small>
                </div>
                <div class="page-title-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Analytics</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Period Selector -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted me-3">Bandingkan berdasarkan:</span>
                        <ul class="nav period-selector mb-0">
                            <li class="nav-item">
                                <a class="nav-link {{ $period == 'month' ? 'active' : '' }}"
                                    href="{{ route('analytics.index', ['compare' => 'month']) }}">
                                    <i class="mdi mdi-calendar-month me-1"></i>Bulanan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $period == 'quarter' ? 'active' : '' }}"
                                    href="{{ route('analytics.index', ['compare' => 'quarter']) }}">
                                    <i class="mdi mdi-calendar-range me-1"></i>Kuartal
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $period == 'year' ? 'active' : '' }}"
                                    href="{{ route('analytics.index', ['compare' => 'year']) }}">
                                    <i class="mdi mdi-calendar me-1"></i>Tahunan
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparison Cards -->
    <div class="row mb-4">
        <!-- Survey Terisi -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="comparison-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="stat-label">Survey Terisi</span>
                    <span
                        class="growth-badge {{ $growthSurveys > 0 ? 'growth-positive' : ($growthSurveys < 0 ? 'growth-negative' : 'growth-neutral') }}">
                        <i
                            class="mdi {{ $growthSurveys > 0 ? 'mdi-trending-up' : ($growthSurveys < 0 ? 'mdi-trending-down' : 'mdi-minus') }}"></i>
                        {{ $growthSurveys > 0 ? '+' : '' }}{{ $growthSurveys }}%
                    </span>
                </div>
                <div class="stat-value text-primary">{{ number_format($currentSurveys) }}</div>
                <small class="text-muted">
                    vs {{ number_format($previousSurveys) }} {{ $periodLabel }} lalu
                </small>
            </div>
        </div>

        <!-- KNMP Progress -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="comparison-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="stat-label">KNMP Terupdate</span>
                    <span
                        class="growth-badge {{ $growthKnmpProgress > 0 ? 'growth-positive' : ($growthKnmpProgress < 0 ? 'growth-negative' : 'growth-neutral') }}">
                        <i
                            class="mdi {{ $growthKnmpProgress > 0 ? 'mdi-trending-up' : ($growthKnmpProgress < 0 ? 'mdi-trending-down' : 'mdi-minus') }}"></i>
                        {{ $growthKnmpProgress > 0 ? '+' : '' }}{{ $growthKnmpProgress }}%
                    </span>
                </div>
                <div class="stat-value text-success">{{ number_format($currentKnmpProgress) }}</div>
                <small class="text-muted">
                    vs {{ number_format($previousKnmpProgress) }} {{ $periodLabel }} lalu
                </small>
            </div>
        </div>

        <!-- Tenaga Kerja -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="comparison-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="stat-label">Tenaga Kerja Terserap</span>
                    <span
                        class="growth-badge {{ $growthTenagaKerja > 0 ? 'growth-positive' : ($growthTenagaKerja < 0 ? 'growth-negative' : 'growth-neutral') }}">
                        <i
                            class="mdi {{ $growthTenagaKerja > 0 ? 'mdi-trending-up' : ($growthTenagaKerja < 0 ? 'mdi-trending-down' : 'mdi-minus') }}"></i>
                        {{ $growthTenagaKerja > 0 ? '+' : '' }}{{ $growthTenagaKerja }}%
                    </span>
                </div>
                <div class="stat-value text-warning">{{ number_format($currentTenagaKerja) }}</div>
                <small class="text-muted">
                    vs {{ number_format($previousTenagaKerja) }} {{ $periodLabel }} lalu
                </small>
            </div>
        </div>

        <!-- Rata-rata Capaian -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="comparison-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="stat-label">Rata-rata Capaian</span>
                    <span
                        class="growth-badge {{ $growthCapaian > 0 ? 'growth-positive' : ($growthCapaian < 0 ? 'growth-negative' : 'growth-neutral') }}">
                        <i
                            class="mdi {{ $growthCapaian > 0 ? 'mdi-trending-up' : ($growthCapaian < 0 ? 'mdi-trending-down' : 'mdi-minus') }}"></i>
                        {{ $growthCapaian > 0 ? '+' : '' }}{{ $growthCapaian }}%
                    </span>
                </div>
                <div class="stat-value text-info">{{ number_format($currentAvgCapaian, 1) }}%</div>
                <small class="text-muted">
                    vs {{ number_format($previousAvgCapaian, 1) }}% {{ $periodLabel }} lalu
                </small>
            </div>
        </div>
    </div>

    <!-- Year over Year Summary -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-1">
                                <i class="mdi mdi-calendar-check me-2 text-primary"></i>
                                Perbandingan Year-over-Year (YoY)
                            </h5>
                            <p class="text-muted mb-0">Total survey tahun ini vs tahun lalu</p>
                        </div>
                        <div class="text-end">
                            <div class="d-flex align-items-center gap-4">
                                <div>
                                    <small class="text-muted d-block">Tahun Ini</small>
                                    <span class="fs-4 fw-bold text-primary">{{ number_format($yoySurveysCurrent) }}</span>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Tahun Lalu</small>
                                    <span
                                        class="fs-4 fw-bold text-secondary">{{ number_format($yoySurveysPrevious) }}</span>
                                </div>
                                <div class="ps-3 border-start">
                                    <small class="text-muted d-block">Pertumbuhan</small>
                                    <span class="fs-4 fw-bold {{ $yoyGrowth >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $yoyGrowth >= 0 ? '+' : '' }}{{ $yoyGrowth }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trend Charts -->
    <div class="row">
        <!-- Survey Trend -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="header-title mb-3">
                        <i class="mdi mdi-chart-line me-2 text-primary"></i>
                        Trend Survey (12 Bulan Terakhir)
                    </h5>
                    <div class="trend-chart-container">
                        <canvas id="surveyTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tenaga Kerja Trend -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="header-title mb-3">
                        <i class="mdi mdi-account-group me-2 text-warning"></i>
                        Trend Tenaga Kerja (12 Bulan Terakhir)
                    </h5>
                    <div class="trend-chart-container">
                        <canvas id="tenagaKerjaTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Capaian Trend -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3">
                        <i class="mdi mdi-chart-areaspline me-2 text-info"></i>
                        Trend Rata-rata Capaian Indikator (12 Bulan Terakhir)
                    </h5>
                    <div class="trend-chart-container">
                        <canvas id="capaianTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const trendLabels = @json($trendLabels);
            const surveyData = @json($trendData['surveys'] ?? []);
            const tenagaKerjaData = @json($trendData['tenaga_kerja'] ?? []);
            const capaianData = @json($trendData['capaian'] ?? []);

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
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
            };

            // Survey Trend Chart
            new Chart(document.getElementById('surveyTrendChart'), {
                type: 'line',
                data: {
                    labels: trendLabels,
                    datasets: [{
                        label: 'Survey Terisi',
                        data: surveyData,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#3b82f6'
                    }]
                },
                options: chartOptions
            });

            // Tenaga Kerja Trend Chart
            new Chart(document.getElementById('tenagaKerjaTrendChart'), {
                type: 'bar',
                data: {
                    labels: trendLabels,
                    datasets: [{
                        label: 'Tenaga Kerja',
                        data: tenagaKerjaData,
                        backgroundColor: 'rgba(245, 158, 11, 0.7)',
                        borderColor: '#f59e0b',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: chartOptions
            });

            // Capaian Trend Chart
            new Chart(document.getElementById('capaianTrendChart'), {
                type: 'line',
                data: {
                    labels: trendLabels,
                    datasets: [{
                        label: 'Rata-rata Capaian (%)',
                        data: capaianData,
                        borderColor: '#06b6d4',
                        backgroundColor: 'rgba(6, 182, 212, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#06b6d4'
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        ...chartOptions.scales,
                        y: {
                            ...chartOptions.scales.y,
                            max: 100
                        }
                    }
                }
            });
        });
    </script>
@endpush