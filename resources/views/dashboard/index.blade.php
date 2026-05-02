@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <style>
        .sortable {
            position: relative;
            cursor: pointer;
            user-select: none;
            transition: all 0.2s;
        }

        .sortable:hover {
            background-color: #f3f4f6;
            color: #3b82f6;
        }

        .sortable i {
            font-size: 1.1em;
            vertical-align: middle;
            transition: transform 0.2s;
        }

        .sort-active {
            background-color: #eff6ff !important;
            color: #1d4ed8 !important;
        }

        /* Enhanced Search Field */
        .search-field-enhanced {
            border: 1px solid #d1d5db !important;
            border-radius: 8px !important;
            overflow: hidden;
            background: #fff;
        }

        .search-field-enhanced .input-group-text {
            background: #f8f9fa;
            border: none;
            border-right: 1px solid #e5e7eb;
            padding: 0.25rem 0.6rem;
        }

        .search-field-enhanced .input-group-text i {
            color: #6b7280;
            font-size: 1rem;
        }

        .search-field-enhanced .form-control,
        .search-field-enhanced .form-select {
            border: none;
            padding: 0.25rem 0.6rem;
            font-size: 0.875rem;
        }

        .search-field-enhanced .form-control:focus,
        .search-field-enhanced .form-select:focus {
            box-shadow: none;
        }

        .search-field-enhanced:focus-within {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        /* Menyembunyikan ikon kalender native browser sepenuhnya */
        .search-field-enhanced input[type="date"]::-webkit-calendar-picker-indicator {
            display: none !important;
            -webkit-appearance: none !important;
        }

        /* Menyembunyikan ikon kalender native untuk Firefox */
        .search-field-enhanced input[type="date"] {
            -moz-appearance: textfield;
        }

        /* Fix modal centering - override app.css margin */
        #importProgresNasionalModal .modal-dialog,
        #exportPdfModal .modal-dialog {
            margin: auto !important;
        }

        /* Flatpickr Modern & Compact Styling */
        .flatpickr-calendar {
            font-family: 'Poppins', sans-serif !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            padding-bottom: 8px !important;
        }

        .flatpickr-calendar.arrowTop:before,
        .flatpickr-calendar.arrowTop:after,
        .flatpickr-calendar.arrowBottom:before,
        .flatpickr-calendar.arrowBottom:after {
            display: none !important; /* Menghilangkan segitiga panah popup */
        }

        .flatpickr-current-month {
            font-size: 0.95rem !important;
            padding-top: 2px !important;
        }

        span.flatpickr-weekday {
            font-size: 0.72rem !important;
            font-weight: 600 !important;
            color: #64748b !important;
        }

        .flatpickr-day {
            font-size: 0.82rem !important;
            height: 34px !important;
            line-height: 34px !important;
            border-radius: 8px !important;
        }

        .flatpickr-day.selected {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3) !important;
        }
    </style>
@endpush

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="me-3" style="font-size: 2rem; color: #f59e0b;">
                        <i class="mdi {{ $greetingIcon ?? 'mdi-weather-sunny' }}"></i>
                    </div>
                    <div>
                        <h4 class="page-title mb-1">{{ $greeting }}, {{ Auth::user()->name ?? 'Pengguna' }}!</h4>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Setiap langkah kecil membawa kita lebih dekat
                            ke tujuan besar.</p>
                    </div>
                </div>
                <div class="text-end">
                    <span class="text-muted" style="font-size: 0.9rem;">
                        <i class="mdi mdi-calendar-today me-1"></i>
                        <span id="current-date-display"></span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Filter Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card mb-0 shadow-sm">
                <div class="card-body py-2 px-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-filter-outline text-muted me-2" style="font-size: 1rem;"></i>
                                <span class="text-muted me-2" style="font-size: 0.78rem;">Periode:</span>
                                <form method="GET" action="{{ route('dashboard.index') }}" class="d-inline" id="filterForm">
                                    <input type="hidden" name="tahap" value="{{ $tahap ?? 'all' }}">
                                    <input type="hidden" name="progres_date" value="{{ $selectedProgresDate ?? '' }}">
                                    <select name="period" class="form-select form-select-sm border-0 bg-light"
                                        style="width: auto; font-weight: 500; font-size: 0.78rem;" onchange="this.form.submit()">
                                        <option value="all" {{ ($period ?? 'all') == 'all' ? 'selected' : '' }}>Semua Waktu</option>
                                        <option value="week" {{ ($period ?? '') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                                        <option value="month" {{ ($period ?? '') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                                        <option value="year" {{ ($period ?? '') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                                    </select>
                                </form>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="text-muted me-2" style="font-size: 0.78rem;">Tahap:</span>
                                <form method="GET" action="{{ route('dashboard.index') }}" class="d-inline" id="tahapFilterForm">
                                    <input type="hidden" name="period" value="{{ $period ?? 'all' }}">
                                    <input type="hidden" name="progres_date" value="{{ $selectedProgresDate ?? '' }}">
                                    <select name="tahap" class="form-select form-select-sm border-0 bg-light"
                                        style="width: auto; font-weight: 500; font-size: 0.78rem;" onchange="this.form.submit()">
                                        <option value="all" {{ ($tahap ?? 'all') == 'all' ? 'selected' : '' }}>Semua Tahap</option>
                                        @foreach($availableTahap as $t)
                                            <option value="{{ $t }}" {{ ($tahap ?? '') == (string)$t ? 'selected' : '' }}>Tahap {{ $t }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-danger d-flex align-items-center gap-1 shadow-sm"
                                data-bs-toggle="modal" data-bs-target="#exportPdfModal"
                                style="font-size: 0.78rem; font-weight: 500; border-radius: 4px;">
                                <i class="mdi mdi-file-pdf-box"></i> Ekspor PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($tahap !== 'all')
    <div class="row mb-3">
        <div class="col-12">
            <h5 class="fw-bold text-dark mb-0" style="font-size: 1rem;">
                <i class="mdi mdi-flag-variant text-primary me-1"></i>
                Kampung Nelayan Merah Putih Tahap {{ $tahap == 1 ? 'I' : ($tahap == 2 ? 'II' : ($tahap == 3 ? 'III' : $tahap)) }}
            </h5>
            <p class="text-muted mb-0" style="font-size: 0.75rem;">Menampilkan data untuk {{ $totalKnmp }} lokasi KNMP pada tahap ini.</p>
        </div>
    </div>
    @endif

    {{-- ANALISIS PROGRES --}}
    <div class="row mb-4">
        
        <!-- Sebaran Progres -->
        <div class="col-xl-4 col-md-12 mb-xl-0 mb-3">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header bg-white border-bottom pb-2 pt-3 px-4" style="min-height: 48px;">
                    <h5 class="header-title mb-0">
                        <i class="mdi mdi-chart-bar me-2 text-info"></i>
                        Sebaran Persentase Progres
                    </h5>
                </div>
                <div class="card-body px-4 pb-4 pt-2 d-flex align-items-center justify-content-center" style="height: 300px;">
                    <div id="sebaranProgresChart" class="w-100"></div>
                </div>
            </div>
        </div>

        <!-- Top 10 Performa -->
        <div class="col-xl-4 col-md-6 mb-md-0 mb-3">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header bg-white border-bottom pb-2 pt-3 px-4" style="min-height: 48px;">
                    <h5 class="header-title mb-0">
                        <i class="mdi mdi-chart-bar me-2 text-info"></i>
                        10 KNMP Progres Tertinggi
                    </h5>
                </div>
                <div class="card-body p-0" style="height: 300px;">
                    <div class="table-responsive" style="height: 300px; overflow-y: auto;">
                        <table class="table table-sm table-centered table-hover mb-0">
                            <thead class="table-light fade-sticky-header">
                                <tr>
                                    <th class="ps-4" style="font-size: 0.75rem; text-transform: uppercase;">KNMP</th>
                                    <th class="text-end pe-4" style="font-size: 0.75rem; text-transform: uppercase;">Progres</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($top10Knmp ?? [] as $item)
                                    <tr>
                                        <td class="ps-4 align-middle" style="font-size: 0.8rem;" title="{{ $item->knmp->nama ?? 'KNMP #'.$item->knmp_id }}">
                                            <div class="d-flex align-items-center">
                                                @if($item->is_stagnan)
                                                    <i class="mdi mdi-alert text-danger me-1" title="Stagnan selama 5 hari!"></i>
                                                @endif
                                                <span class="fw-medium text-truncate d-inline-block {{ $item->is_stagnan ? 'text-danger' : 'text-dark' }}" style="max-width: 140px;">
                                                    {{ $item->knmp->nama ?? 'KNMP #'.$item->knmp_id }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-end fw-bold pe-4 align-middle {{ $item->is_stagnan ? 'text-danger' : 'text-success' }}" style="font-size: 0.8rem;">
                                            {{ round($item->progres, 2) }}%
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-center text-muted py-4 align-middle" style="font-size: 0.8rem;">Tidak ada data</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom 10 Performa -->
        <div class="col-xl-4 col-md-6 mb-md-0 mb-3">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header bg-white border-bottom pb-2 pt-3 px-4" style="min-height: 48px;">
                    <h5 class="header-title mb-0">
                        <i class="mdi mdi-chart-bar me-2 text-info"></i>
                        10 KNMP Progres Terendah
                    </h5>
                </div>
                <div class="card-body p-0" style="height: 300px;">
                    <div class="table-responsive" style="height: 300px; overflow-y: auto;">
                        <table class="table table-sm table-centered table-hover mb-0">
                            <thead class="table-light fade-sticky-header">
                                <tr>
                                    <th class="ps-4" style="font-size: 0.75rem; text-transform: uppercase;">KNMP</th>
                                    <th class="text-end pe-4" style="font-size: 0.75rem; text-transform: uppercase;">Progres</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bottom10Knmp ?? [] as $item)
                                    <tr class="{{ $item->is_stagnan ? 'bg-danger bg-opacity-10' : '' }}">
                                        <td class="ps-4 align-middle" style="font-size: 0.8rem;" title="{{ $item->knmp->nama ?? 'KNMP #'.$item->knmp_id }}">
                                            <div class="d-flex align-items-center">
                                                @if($item->is_stagnan)
                                                    <i class="mdi mdi-alert text-danger me-1" title="Stagnan selama 5 hari!"></i>
                                                @endif
                                                <span class="fw-medium text-truncate d-inline-block {{ $item->is_stagnan ? 'text-danger' : 'text-dark' }}" style="max-width: 140px;">
                                                    {{ $item->knmp->nama ?? 'KNMP #'.$item->knmp_id }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-end fw-bold pe-4 align-middle {{ $item->is_stagnan ? 'text-danger' : 'text-warning' }}" style="font-size: 0.8rem;">
                                            {{ round($item->progres, 2) }}%
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-center text-muted py-4 align-middle" style="font-size: 0.8rem;">Tidak ada data</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Progres KNMP Nasional --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h5 class="header-title mb-0">
                        <i class="mdi mdi-chart-bar me-2 text-info"></i>
                        Progres Pembangunan KNMP Nasional
                    </h5>
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <!-- Delta Period Filter -->
                        <div class="input-group input-group-sm me-2 search-field-enhanced flex-nowrap" style="width: 240px;">
                            <span class="input-group-text"><i class="mdi mdi-swap-vertical text-info"></i> Delta</span>
                            <select class="form-select" id="deltaPeriodFilter" onchange="filterByDate(document.getElementById('progresDateFilter')?.value)" style="cursor: pointer; font-weight: 500; color: #4b5563;">
                                <option value="latest" {{ ($deltaPeriod ?? 'latest') == 'latest' ? 'selected' : '' }}>Terakhir Diupdate</option>
                                <option value="weekly" {{ ($deltaPeriod ?? 'latest') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                            </select>
                        </div>
                        
                        <!-- Date Filter Calendar -->
                        <div class="input-group input-group-sm me-2 search-field-enhanced flex-nowrap" style="width: 200px;" title="Pilih Tanggal Progres">
                            <span class="input-group-text"><i class="mdi mdi-calendar-month text-primary"></i></span>
                            <input type="text" class="form-control flatpickr-dashboard" id="progresDateFilter" 
                                value="{{ $selectedProgresDate ?? date('Y-m-d') }}" 
                                style="cursor: pointer; font-weight: 500; color: #4b5563; min-width: 130px; background: transparent;">
                        </div>

                        <!-- Search Input -->
                        <div class="input-group input-group-sm search-field-enhanced" style="width: 220px;">
                            <span class="input-group-text"><i class="mdi mdi-magnify"></i></span>
                            <input type="text" id="paramsSearch" class="form-control" placeholder="Cari KNMP..."
                                onkeyup="filterTable()">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-light p-3 rounded me-3">
                                <h2 class="mb-0 text-primary" id="kpi-progresNasionalAvg">
                                    {{ number_format($progresNasionalAvg, 2) }}%</h2>
                                <small class="text-muted">Rata-rata Nasional</small>
                            </div>
                            <div>
                                <p class="mb-1 text-muted">Statistik Import Data:</p>
                                <div class="d-flex gap-3">
                                    <span class="badge bg-soft-info text-info p-2" id="kpi-progresCount">
                                        <i class="mdi mdi-map-marker me-1"></i> {{ count($progresNasional) }} Lokasi
                                    </span>
                                    <span class="badge bg-soft-success text-success p-2" id="kpi-progresSelesai">
                                        <i class="mdi mdi-check-circle me-1"></i>
                                        {{ $progresNasional->where('progres', 100)->count() }} Selesai (100%)
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Sparkline Chart -->
                            <div class="ms-4 px-2 pt-1" style="width: 150px; height: 60px; overflow: hidden;">
                                <div id="trendNasionalChart"></div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#importProgresNasionalModal">
                                <i class="mdi mdi-upload me-1"></i> Import/Update
                            </button>
                            <a href="{{ route('forms.download_template', ['section' => 'progres-knmp-nasional']) }}"
                                class="btn btn-outline-secondary">
                                <i class="mdi mdi-download me-1"></i> Template
                            </a>
                        </div>
                    </div>

                    @if(count($progresNasional) > 0)
                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-centered table-nowrap mb-0">
                                <thead class="table-light fade-sticky-header">
                                    <tr>
                                        <th style="width: 30px;">#</th>
                                        <th onclick="sortTable(1)" style="cursor: pointer;" class="sortable">
                                            Nama KNMP <i class="mdi mdi-sort ms-1 text-muted"></i>
                                        </th>
                                        <th style="width: 400px;">Penyedia Jasa Konstruksi</th>
                                        <th style="width: 200px; cursor: pointer;" class="sortable" onclick="sortTable(3)">
                                            Progres <i class="mdi mdi-sort ms-1 text-muted"></i>
                                        </th>
                                        <th style="width: 140px; white-space: nowrap;" class="text-end sortable"
                                            onclick="sortTable(4)">
                                            Delta <i class="mdi mdi-sort ms-1 text-muted"></i>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="progres-nasional-tbody">
                                    @foreach($progresNasional as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="fw-semibold">
                                                {{ $item->knmp ? $item->knmp->nama : 'KNMP #' . $item->knmp_id }}
                                            </td>
                                            <td>
                                                <span class="text-muted fst-italic">{{ $item->nama_jasa_konstruksi ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="fw-bold {{ $item->progres >= 100 ? 'text-success' : 'text-dark' }}" style="font-size: 0.85rem;">
                                                        {{ number_format($item->progres, 2) }}%
                                                    </span>
                                                </div>
                                                <div class="progress" style="height: 6px; background-color: #f1f3fa; border-radius: 3px;">
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
                                                        style="width: {{ $item->progres }}%; border-radius: 3px;" aria-valuenow="{{ $item->progres }}"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td class="text-end fw-bold">
                                                @if($item->delta > 0)
                                                    <span class="text-success"><i class="mdi mdi-arrow-up"></i> +{{ number_format($item->delta, 2) }}%</span>
                                                @elseif($item->delta < 0)
                                                    <span class="text-danger"><i class="mdi mdi-arrow-down"></i> {{ number_format($item->delta, 2) }}%</span>
                                                @else
                                                    <span class="text-muted"><i class="mdi mdi-minus"></i> 0.00%</span>
                                                @endif
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

    <!-- Modal Export PDF -->
    <div class="modal fade" id="exportPdfModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <form action="{{ route('dashboard.export-pdf') }}" method="GET" target="_blank">
                    <div class="modal-header bg-light border-bottom-0 pb-0 pt-3 px-4">
                        <h5 class="modal-title fw-bold" style="color: #1e293b;">
                            <i class="mdi mdi-file-pdf-box text-danger me-1"></i> Ekspor Laporan PDF
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4 pt-3 pb-4">
                        <p class="text-muted" style="font-size: 0.85rem; margin-bottom: 20px;">
                            Pilih tahap dan tanggal progres untuk menentukan data yang akan ditampilkan pada laporan PDF.
                        </p>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.85rem;">Pilih Tahap</label>
                            <select name="tahap" class="form-select" style="border-radius: 8px;">
                                <option value="all" {{ ($tahap ?? 'all') == 'all' ? 'selected' : '' }}>Semua Tahap</option>
                                @foreach($availableTahap as $t)
                                    <option value="{{ $t }}" {{ ($tahap ?? '') == (string)$t ? 'selected' : '' }}>Tahap {{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-2">
                            <label class="form-label fw-semibold" style="font-size: 0.85rem;">Tanggal Progres <span class="text-danger">*</span></label>
                            <input type="date" name="progres_date" class="form-control" style="border-radius: 8px;"
                                value="{{ $selectedProgresDate ?? date('Y-m-d') }}" required>
                            <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">
                                Data progres fisik dan dokumentasi akan diambil berdasarkan tanggal yang dipilih.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 bg-light px-4 py-3">
                        <button type="button" class="btn btn-light" style="border-radius: 6px; font-weight: 500;" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger d-flex align-items-center gap-1" style="border-radius: 6px; font-weight: 500;" onclick="setTimeout(() => { $('#exportPdfModal').modal('hide'); }, 500)">
                            <i class="mdi mdi-download"></i> Download PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <div class="modal fade" id="importProgresNasionalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('analytics.import_progres_nasional') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Import Progres Nasional</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Data <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                            <small class="text-muted">Pilih tanggal untuk data progres yang akan diimport.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File Excel (.xlsx)</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx, .xls, .csv" required>
                            <small class="text-muted d-block mt-1">Format: knmp_id, progres</small>
                            <small class="text-muted">Data akan ditambahkan untuk tanggal yang dipilih. Data lama tidak akan
                                dihapus.</small>
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

    {{-- MAP SECTION --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="header-title mb-0">
                        <i class="mdi mdi-map-marker-multiple me-2 text-danger"></i>Sebaran Lokasi KNMP
                    </h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 0.7rem;">{{ $totalKnmp }} Lokasi</span>
                </div>
                <div class="card-body p-0">
                    <div style="position: relative;">
                        <div id="map-knmp" style="height: 500px;"></div>
                        <!-- Fixed info card overlay -->
                        <div id="map-info-card" style="
                            position: absolute; top: 12px; right: 12px; z-index: 999;
                            width: 280px; background: #fff; border-radius: 10px;
                            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
                            display: none; overflow: hidden; font-family: 'Poppins', sans-serif;
                        ">
                            <div id="map-info-header" style="
                                background: linear-gradient(135deg, #003D7A, #0054A6);
                                color: #fff; padding: 12px 14px;
                            ">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 id="map-info-name" class="mb-0" style="font-size: 0.78rem; font-weight: 700; color: #fff;"></h6>
                                        <small id="map-info-location" style="font-size: 0.65rem; opacity: 0.85;"></small>
                                    </div>
                                    <button onclick="document.getElementById('map-info-card').style.display='none'" style="
                                        background: rgba(255,255,255,0.15); border: none; color: #fff;
                                        width: 22px; height: 22px; border-radius: 50%; cursor: pointer;
                                        display: flex; align-items: center; justify-content: center; font-size: 0.75rem; flex-shrink: 0;
                                    ">&times;</button>
                                </div>
                            </div>
                            <div style="padding: 12px 14px;">
                                <div id="map-info-progres" style="margin-bottom: 10px;"></div>
                                <div id="map-info-stats" style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-bottom: 10px;"></div>
                                <div id="map-info-komoditas" style="margin-bottom: 10px;"></div>
                                <a id="map-info-link" href="#" class="btn btn-sm btn-primary w-100" style="font-size: 0.7rem; border-radius: 6px; padding: 6px;">
                                    <i class="mdi mdi-information-outline me-1"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Real-time update indicator --}}
    <div id="realtime-indicator" style="position: fixed; bottom: 20px; right: 20px; z-index: 1050; display: none;">
        <div class="card border-0 shadow-lg mb-0" style="border-radius: 12px; overflow: hidden;">
            <div class="card-body py-2 px-3 d-flex align-items-center gap-2">
                <div class="spinner-grow spinner-grow-sm text-success" role="status" id="realtime-spinner">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <i class="mdi mdi-check-circle text-success" id="realtime-check"
                    style="display: none; font-size: 1.1rem;"></i>
                <small class="text-muted" id="realtime-text">Memperbarui data...</small>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{-- Filtering and Sorting Scripts for KNMP Progress Table --}}
    <script>
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("paramsSearch");
            filter = input.value.toUpperCase();
            var tbody = document.querySelector(".table-responsive table tbody");
            if (!tbody) return; // Guard clause
            tr = tbody.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
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

        function filterByDate(date) {
            const url = new URL(window.location.href);
            if (date) url.searchParams.set('progres_date', date);
            
            const deltaPeriod = document.getElementById('deltaPeriodFilter')?.value || 'latest';
            url.searchParams.set('delta_period', deltaPeriod);

            // Preserve existing filters
            if (!url.searchParams.has('period')) url.searchParams.set('period', '{{ $period ?? "all" }}');
            if (!url.searchParams.has('tahap')) url.searchParams.set('tahap', '{{ $tahap ?? "all" }}');
            window.location.href = url.toString();
        }

        let sortDirections = [true, true, true, true, true];

        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.querySelector(".table-responsive table");
            if (!table) return; // Guard clause
            switching = true;
            dir = sortDirections[n] ? "asc" : "desc";

            // 1. Reset all headers styling
            const headers = table.querySelectorAll("th.sortable");
            headers.forEach((th) => {
                th.classList.remove('sort-active');
                const icon = th.querySelector("i");
                if (icon) {
                    icon.className = "mdi mdi-sort ms-1 opacity-25"; // default faint icon
                }
            });

            // 2. Highlight active header
            const headersAll = table.querySelectorAll("th");
            // Find the header corresponding to column n
            let currentHeader = null;
            if (headersAll.length > n) currentHeader = headersAll[n];

            if (currentHeader) {
                currentHeader.classList.add('sort-active');
                const currentIcon = currentHeader.querySelector("i");
                if (currentIcon) {
                    currentIcon.className = dir === "asc"
                        ? "mdi mdi-sort-ascending ms-1 fw-bold"
                        : "mdi mdi-sort-descending ms-1 fw-bold";
                }
            }

            while (switching) {
                switching = false;
                rows = table.rows;
                // Loop starts at 1 to skip header
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("td")[n];
                    y = rows[i + 1].getElementsByTagName("td")[n];

                    if (!x || !y) continue;

                    let xVal = x.textContent || x.innerText;
                    let yVal = y.textContent || y.innerText;
                    if (n === 3 || n === 4) {
                        xVal = parseFloat(xVal.replace('%', '').replace('+', '').replace(',', '.'));
                        yVal = parseFloat(yVal.replace('%', '').replace('+', '').replace(',', '.'));
                    } else {
                        xVal = xVal.toLowerCase();
                        yVal = yVal.toLowerCase();
                    }
                    if (dir == "asc") {
                        if (xVal > yVal) { shouldSwitch = true; break; }
                    } else if (dir == "desc") {
                        if (xVal < yVal) { shouldSwitch = true; break; }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
            sortDirections[n] = (dir === "asc");
            // Renumber rows
            rows = table.rows;
            for (i = 1; i < rows.length; i++) {
                let numCell = rows[i].getElementsByTagName("td")[0];
                if (numCell) numCell.innerHTML = i;
            }
        }
    </script>
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
            trendDates: @json($trendDates ?? []),
            trendAverages: @json($trendAverages ?? []),
            detailUrlPattern: "{{ route('informasi_umum.index') }}?knmp_id=:id"
        };
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof flatpickr !== 'undefined') {
                flatpickr('.flatpickr-dashboard', {
                    dateFormat: 'Y-m-d',
                    altInput: true,
                    altFormat: 'd M Y',
                    allowInput: false,
                    onChange: function(selectedDates, dateStr, instance) {
                        filterByDate(dateStr);
                    }
                });
            }

            // Render Sebaran Progres Pie Chart
            if (document.getElementById('sebaranProgresChart') && typeof ApexCharts !== 'undefined') {
                var sebaranData = @json(array_values($sebaranProgres ?? []));
                var sebaranLabels = @json(array_keys($sebaranProgres ?? []));
                
                // Cek apakah ada data sama sekali
                var hasData = sebaranData.some(function(val) { return val > 0; });
                
                if (hasData) {
                    var sebaranOptions = {
                        chart: {
                            type: 'pie',
                            height: 250,
                            toolbar: { show: false }
                        },
                        series: sebaranData,
                        labels: sebaranLabels,
                        colors: ['#fa5c7c', '#ffbc00', '#39afd1', '#727cf5', '#0acf97'], // danger, warning, info, primary, success
                        legend: {
                            position: 'bottom',
                            horizontalAlign: 'center',
                            fontSize: '12px',
                            markers: { radius: 12 }
                        },
                        dataLabels: {
                            enabled: true,
                            dropShadow: { enabled: false }
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return val + " Lokasi";
                                }
                            }
                        },
                        stroke: { width: 1, colors: ['#fff'] }
                    };

                    var sebaranChart = new ApexCharts(document.querySelector("#sebaranProgresChart"), sebaranOptions);
                    sebaranChart.render();
                } else {
                    document.getElementById('sebaranProgresChart').innerHTML = '<div class="d-flex h-100 justify-content-center align-items-center text-muted"><p class="mb-0">Tidak ada data</p></div>';
                }
            }
        });
    </script>
@endpush