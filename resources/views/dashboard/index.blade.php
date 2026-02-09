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
            padding: 0.5rem 0.75rem;
        }
        .search-field-enhanced .input-group-text i {
            color: #6b7280;
            font-size: 1.1rem;
        }
        .search-field-enhanced .form-control {
            border: none;
            padding: 0.5rem 0.75rem;
        }
        .search-field-enhanced .form-control:focus {
            box-shadow: none;
        }
        .search-field-enhanced:focus-within {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        /* Fix modal centering - override app.css margin */
        #importProgresNasionalModal .modal-dialog {
            margin: auto !important;
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
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Setiap langkah kecil membawa kita lebih dekat ke tujuan besar.</p>
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
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm mb-0">
                <div class="card-body py-2 px-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-filter-outline text-muted me-2" style="font-size: 1.2rem;"></i>
                            <span class="text-muted me-2">Periode:</span>
                            <form method="GET" action="{{ route('dashboard.index') }}" class="d-inline">
                                <select name="period" class="form-select form-select-sm border-0 bg-light" 
                                    style="width: auto; font-weight: 500;" onchange="this.form.submit()">
                                    <option value="all" {{ ($period ?? 'all') == 'all' ? 'selected' : '' }}>Semua Waktu</option>
                                    <option value="week" {{ ($period ?? '') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                                    <option value="month" {{ ($period ?? '') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                                    <option value="year" {{ ($period ?? '') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                                </select>
                            </form>
                        </div>
                        <a href="{{ route('dashboard.export-pdf', ['period' => $period ?? 'all']) }}"
                            class="btn btn-sm btn-primary" target="_blank">
                            <i class="mdi mdi-file-pdf-box me-1"></i>Export PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistic Cards - Baris 1 --}}
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="widget-icon">
                        <i class="mdi mdi-home-city"></i>
                    </div>
                    <h5>Total KNMP</h5>
                    <h3>{{ number_format($totalKnmp ?? 0, 0, ',', '.') }}</h3>
                    <p class="mb-0 text-muted" style="font-size: 0.8rem;">
                        <i class="mdi mdi-map-marker-radius text-primary me-1"></i>
                        Lokasi KNMP aktif
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="widget-icon"
                        style="background: linear-gradient(135deg, #10B981 0%, #34D399 100%); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                        <i class="mdi mdi-domain"></i>
                    </div>
                    <h5>Ketersediaan Infrastruktur</h5>
                    <h3>{{ number_format($ketersediaanInfrastruktur ?? 0, 2, ',', '.') }}%</h3>
                    <p class="mb-0 text-muted" style="font-size: 0.8rem;">
                        <i class="mdi mdi-check-circle text-success me-1"></i>
                        Komponen infrastruktur tersedia
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="widget-icon"
                        style="background: linear-gradient(135deg, #8B5CF6 0%, #A78BFA 100%); box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
                        <i class="mdi mdi-cash-multiple"></i>
                    </div>
                    <h5>Pendapatan RT Nelayan</h5>
                    <h3>Rp {{ number_format($pendapatanRtNelayan ?? 0, 0, ',', '.') }}</h3>
                    <p class="mb-0 text-muted" style="font-size: 0.8rem;">
                        <i class="mdi mdi-trending-up text-success me-1"></i>
                        Rata-rata pendapatan/orang/bulan
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
                        style="background: linear-gradient(135deg, #F59E0B 0%, #FBBF24 100%); box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);">
                        <i class="mdi mdi-clipboard-check-outline"></i>
                    </div>
                    <h5>Indeks Kesesuaian Kebutuhan</h5>
                    <h3>{{ number_format($indeksKesesuaianKebutuhan ?? 0, 2, ',', '.') }}%</h3>
                    <p class="mb-0 text-muted" style="font-size: 0.8rem;">
                        <i class="mdi mdi-check-decagram text-warning me-1"></i>
                        Responden menyatakan sesuai
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
                    <h5>Indeks Kesejahteraan Nelayan</h5>
                    <h3>{{ number_format($indeksKesejahteraan ?? 0, 2, ',', '.') }}</h3>
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
                        style="background: linear-gradient(135deg, #14B8A6 0%, #2DD4BF 100%); box-shadow: 0 4px 15px rgba(20, 184, 166, 0.3);">
                        <i class="mdi mdi-account-group"></i>
                    </div>
                    <h5>Tingkat Kelembagaan Nelayan</h5>
                    <h3>{{ number_format($tingkatKelembagaan ?? 0, 2, ',', '.') }}%</h3>
                    <p class="mb-0 text-muted" style="font-size: 0.8rem;">
                        <i class="mdi mdi-account-multiple text-info me-1"></i>
                        Nelayan dalam kelompok/koperasi
                    </p>
                </div>
            </div>
        </div>
    </div>






    {{-- Progres KNMP Nasional --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h5 class="header-title mb-0">
                        <i class="mdi mdi-chart-bar me-2 text-info"></i>
                        Progres Pembangunan KNMP Nasional
                    </h5>
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <!-- Date Filter Dropdown -->
                        @if(count($availableProgressDates ?? []) > 0)
                            <div class="input-group input-group-sm me-2" style="width: 180px;">
                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                <select class="form-select" id="progresDateFilter" onchange="filterByDate(this.value)">
                                    @foreach($availableProgressDates as $date)
                                        <option value="{{ $date }}" {{ $selectedProgresDate == $date ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <!-- Search Input -->
                        <div class="input-group input-group-sm me-2 search-field-enhanced" style="width: 180px;">
                            <span class="input-group-text"><i class="mdi mdi-magnify"></i></span>
                            <input type="text" id="paramsSearch" class="form-control"
                                placeholder="Cari KNMP..." onkeyup="filterTable()">
                        </div>

                        <!-- Action Buttons -->
                        <div class="btn-group btn-group-sm">
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
                                        <th onclick="sortTable(1)" style="cursor: pointer;" class="sortable">
                                            Nama KNMP <i class="mdi mdi-sort ms-1 text-muted"></i>
                                        </th>
                                        <th style="width: 250px;">Status Progres</th>
                                        <th style="width: 140px; white-space: nowrap;" class="text-end sortable" onclick="sortTable(3)">
                                            Persentase <i class="mdi mdi-sort ms-1 text-muted"></i>
                                        </th>
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
                            <small class="text-muted">Data akan ditambahkan untuk tanggal yang dipilih. Data lama tidak akan dihapus.</small>
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
                <div class="card-body">
                    <h4 class="header-title mb-3">Sebaran Lokasi KNMP</h4>
                    <div id="map-knmp" style="height: 450px; border-radius:10px;"></div>
                </div>
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
            url.searchParams.set('progres_date', date);
            window.location.href = url.toString();
        }

        let sortDirections = [true, true, true, true]; 

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
            const headerIndexRef = n === 1 ? 1 : 3; // Mapped because HTML collection might differ
            const headersAll = table.querySelectorAll("th");
            // Find the header corresponding to column n
            let currentHeader = null;
            // Simple mapping: 
            // n=1 (Nama KNMP) is headersAll[1]
            // n=3 (Persentase) is headersAll[3]
             if(headersAll.length > n) currentHeader = headersAll[n];
            
            if(currentHeader) {
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
                    if (n === 3) {
                        xVal = parseFloat(xVal.replace('%', '').replace(',', '.'));
                        yVal = parseFloat(yVal.replace('%', '').replace(',', '.'));
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
                 if(numCell) numCell.innerHTML = i;
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
            detailUrlPattern: "{{ route('informasi_umum.index') }}?knmp_id=:id"
        };
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush