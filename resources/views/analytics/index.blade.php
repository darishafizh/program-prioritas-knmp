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

        .comparison-chart-container {
            height: 400px;
        }

        .total-stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border-radius: 12px;
            padding: 1.5rem;
        }

        .total-stats-card .stat-item {
            text-align: center;
            padding: 1rem;
        }

        .total-stats-card .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
        }

        .total-stats-card .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
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

    <!-- Total Stats (All Time) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="total-stats-card">
                <div class="row">
                    <div class="col-md-4 stat-item border-end">
                        <div class="stat-value">{{ number_format($totalSurveyAllTime) }}</div>
                        <div class="stat-label">Total Survey Terisi (Semua Waktu)</div>
                    </div>
                    <div class="col-md-4 stat-item border-end">
                        <div class="stat-value">{{ number_format($totalKnmpAllTime) }}</div>
                        <div class="stat-label">Total KNMP Terdaftar</div>
                    </div>
                    <div class="col-md-4 stat-item">
                        <div class="stat-value">{{ number_format($totalTenagaKerjaAllTime) }}</div>
                        <div class="stat-label">Total Tenaga Kerja Terserap</div>
                    </div>
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
                    <span class="stat-label">KNMP Aktif</span>
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

        <!-- Rata-rata Kebahagiaan -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="comparison-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="stat-label">Indeks Kebahagiaan</span>
                    <span
                        class="growth-badge {{ $growthKebahagiaan > 0 ? 'growth-positive' : ($growthKebahagiaan < 0 ? 'growth-negative' : 'growth-neutral') }}">
                        <i
                            class="mdi {{ $growthKebahagiaan > 0 ? 'mdi-trending-up' : ($growthKebahagiaan < 0 ? 'mdi-trending-down' : 'mdi-minus') }}"></i>
                        {{ $growthKebahagiaan > 0 ? '+' : '' }}{{ $growthKebahagiaan }}%
                    </span>
                </div>
                <div class="stat-value text-info">{{ number_format($currentKebahagiaan, 1) }}</div>
                <small class="text-muted">
                    vs {{ number_format($previousKebahagiaan, 1) }} {{ $periodLabel }} lalu
                </small>
            </div>
        </div>
    </div>

    <!-- Visual Comparison Bar Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3">
                        <i class="mdi mdi-chart-bar me-2 text-primary"></i>
                        Perbandingan {{ $periodLabel }} Ini vs {{ $periodLabel }} Lalu
                    </h5>
                    <p class="text-muted mb-3">
                        Periode saat ini: {{ $currentStart->format('d M Y') }} - {{ $currentEnd->format('d M Y') }}
                        <br>
                        Periode sebelumnya: {{ $previousStart->format('d M Y') }} - {{ $previousEnd->format('d M Y') }}
                    </p>
                    <div class="comparison-chart-container">
                        <canvas id="comparisonBarChart"></canvas>
                    </div>
                </div>
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

    <!-- Progres KNMP Nasional -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="header-title mb-0">
                        <i class="mdi mdi-chart-bar me-2 text-info"></i>
                        Progres Pembangunan KNMP Nasional
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <!-- Search Input -->
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <span class="input-group-text bg-light border-end-0"><i class="mdi mdi-magnify"></i></span>
                            <input type="text" id="paramsSearch" class="form-control border-start-0 ps-0"
                                placeholder="Cari KNMP..." onkeyup="filterTable()">
                        </div>

                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#importProgresNasionalModal">
                            <i class="mdi mdi-upload me-1"></i> Import/Update Data
                        </button>
                        <a href="{{ route('forms.download_template', ['section' => 'progres-knmp-nasional']) }}"
                            class="btn btn-sm btn-outline-secondary">
                            <i class="mdi mdi-download me-1"></i> Template
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-light p-3 rounded me-3">
                            <h2 class="mb-0 text-primary">{{ number_format($progresNasionalAvg, 2) }}%</h2>
                            <small class="text-muted">Rata-rata Nasional</small>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1 text-muted">Statistik Import Data:</p>
                            <div class="d-flex gap-3">
                                <span class="badge bg-soft-info text-info p-2">
                                    <i class="mdi mdi-map-marker me-1"></i> {{ count($progresNasional) }} Lokasi
                                </span>
                                <span class="badge bg-soft-success text-success p-2">
                                    <i class="mdi mdi-check-circle me-1"></i>
                                    {{ $progresNasional->where('progres', 100)->count() }} Selesai (100%)
                                </span>
                            </div>
                        </div>
                    </div>

                    @if(count($progresNasional) > 0)
                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-centered table-nowrap mb-0">
                                <thead class="table-light fade-sticky-header">
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Nama KNMP</th>
                                        <th style="width: 250px;">Status Progres</th>
                                        <th style="width: 100px;" class="text-end">Persentase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($progresNasional as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="fw-semibold">
                                                {{ $item->knmp ? $item->knmp->nama : 'KNMP #' . $item->knmp_id }}
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 8px;">
                                                    @php
                                                        $colorClass = 'bg-danger';
                                                        if ($item->progres >= 100)
                                                            $colorClass = 'bg-success';
                                                        elseif ($item->progres >= 75)
                                                            $colorClass = 'bg-primary';
                                                        elseif ($item->progres >= 50)
                                                            $colorClass = 'bg-warning';
                                                    @endphp
                                                    <div class="progress-bar {{ $colorClass }}" role="progressbar"
                                                        style="width: {{ $item->progres }}%" aria-valuenow="{{ $item->progres }}"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td class="text-end fw-bold">
                                                <span class="{{ $item->progres >= 100 ? 'text-success' : '' }}">
                                                    {{ number_format($item->progres, 2) }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="mdi mdi-database-off fs-1"></i>
                            <p class="mt-2">Belum ada data progres nasional.</p>
                            <button type="button" class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal"
                                data-bs-target="#importProgresNasionalModal">
                                Import Data Sekarang
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <div class="modal fade" id="importProgresNasionalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('analytics.import_progres_nasional') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Import Progres Nasional</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">File Excel (.xlsx)</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx, .xls, .csv" required>
                            <small class="text-muted d-block mt-1">Format: knmp_id, progres</small>
                            <small class="text-muted">Data akan di-update (replace) berdasarkan knmp_id.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
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

        <!-- Kebahagiaan Trend -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="header-title mb-3">
                        <i class="mdi mdi-emoticon-happy me-2 text-success"></i>
                        Trend Indeks Kebahagiaan (12 Bulan Terakhir)
                    </h5>
                    <div class="trend-chart-container">
                        <canvas id="kebahagiaanTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Capaian Trend -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="header-title mb-3">
                        <i class="mdi mdi-chart-areaspline me-2 text-info"></i>
                        Trend Rata-rata Capaian (12 Bulan Terakhir)
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
        function filterTable() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("paramsSearch");
            filter = input.value.toUpperCase();
            // Get the table body (assuming there's only one table with this class or use ID if possible)
            var tbody = document.querySelector(".table-responsive table tbody");
            tr = tbody.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                // Column 1 is Nama KNMP (index 1 because index 0 is Number)
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // ... existing code ...
            const trendLabels = @json($trendLabels);
            const surveyData = @json($trendData['surveys'] ?? []);
            const tenagaKerjaData = @json($trendData['tenaga_kerja'] ?? []);
            const capaianData = @json($trendData['capaian'] ?? []);

            const kebahagiaanData = @json($trendData['kebahagiaan'] ?? []);

            // Progres Nasional Data
            const progresNasional = @json($progresNasional ?? []);
            const progresNasionalLabels = progresNasional.map(item => item.knmp ? item.knmp.nama : 'KNMP #' + item.knmp_id);
            const progresNasionalValues = progresNasional.map(item => item.progres);
            const progresNasionalColors = progresNasionalValues.map(val => {
                if (val >= 100) return '#10b981'; // Green
                if (val >= 75) return '#3b82f6'; // Blue
                if (val >= 50) return '#f59e0b'; // Orange
                return '#ef4444'; // Red
            });

            // Comparison bar chart data

            // Comparison bar chart data
            const comparisonLabels = @json($comparisonLabels);
            const comparisonCurrent = @json($comparisonCurrent);
            const comparisonPrevious = @json($comparisonPrevious);
            const periodLabel = @json($periodLabel);

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f3fa'
                        },
                        ticks: {
                            color: '#6c757d'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6c757d'
                        }
                    }
                }
            };

            // Comparison Bar Chart
            new Chart(document.getElementById('comparisonBarChart'), {
                type: 'bar',
                data: {
                    labels: comparisonLabels,
                    datasets: [{
                        label: periodLabel + ' Ini',
                        data: comparisonCurrent,
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: '#3b82f6',
                        borderWidth: 1,
                        borderRadius: 6
                    },
                    {
                        label: periodLabel + ' Lalu',
                        data: comparisonPrevious,
                        backgroundColor: 'rgba(156, 163, 175, 0.6)',
                        borderColor: '#9ca3af',
                        borderWidth: 1,
                        borderRadius: 6
                    }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.parsed.y.toLocaleString('id-ID');
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f3fa'
                            },
                            ticks: {
                                color: '#6c757d',
                                callback: function (value) {
                                    return value.toLocaleString('id-ID');
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6c757d'
                            }
                        }
                    }
                }
            });



            // Progres Nasional Chart removed in favor of table view

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

            // Kebahagiaan Trend Chart
            new Chart(document.getElementById('kebahagiaanTrendChart'), {
                type: 'line',
                data: {
                    labels: trendLabels,
                    datasets: [{
                        label: 'Indeks Kebahagiaan',
                        data: kebahagiaanData,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#10b981'
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        ...chartOptions.scales,
                        y: {
                            ...chartOptions.scales.y,
                            max: 10
                        }
                    }
                }
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