@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <h4 class="page-title"><i class="mdi mdi-chart-box-outline me-2"></i>Informasi Umum</h4>
                    <small class="text-muted">Ringkasan Statistik Kampung Nelayan Merah Putih</small>
                </div>
                <div class="page-title-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Informasi Umum</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- KNMP Selector with Search - Only for Admin -->
    @if(Auth::user()->isAdmin())
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm selector-card">
                <div class="card-body py-3">
                    <form method="GET" action="{{ route('laporan.index') }}" id="knmpForm" class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="selector-icon">
                            <i class="mdi mdi-home-city"></i>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label mb-1 fw-semibold text-dark">Pilih Kampung Nelayan</label>
                            <select name="knmp_id" id="knmpSelect" class="form-select">
                                <option value="">-- Pilih KNMP --</option>
                                @foreach ($knmpList as $item)
                                    <option value="{{ $item->id }}" {{ $selectedKnmpId == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }} — {{ $item->regency->name ?? '' }}, {{ $item->province->name ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($selectedKnmp)
    <!-- KNMP Title -->
    <div class="mb-3">
        <h5 class="fw-bold text-dark mb-0">
            <i class="mdi mdi-map-marker-check text-primary me-2"></i>
            {{ $selectedKnmp->nama }}, Kec. {{ $selectedKnmp->district->name ?? '-' }}, Kab. {{ $selectedKnmp->regency->name ?? '-' }}, Prov. {{ $selectedKnmp->province->name ?? '-' }}
        </h5>
    </div>

    <!-- ROW 1: KPI Cards (4 cards) -->
    <div class="d-flex gap-3 mb-4 kpi-row">
        <div class="flex-fill">
            <div class="card border-0 shadow-sm h-100 kpi-card-white">
                <div class="card-body d-flex align-items-center gap-2">
                    <div class="kpi-icon kpi-icon-blue">
                        <i class="mdi mdi-account-group"></i>
                    </div>
                    <div class="kpi-text">
                        <p class="kpi-label mb-0">Jumlah Penduduk Desa</p>
                        <h4 class="kpi-value mb-0">{{ number_format($stats['jmlKepalaKeluarga'], 0, ',', '.') }}</h4>
                        <small class="kpi-unit">KK</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-fill">
            <div class="card border-0 shadow-sm h-100 kpi-card-white">
                <div class="card-body d-flex align-items-center gap-2">
                    <div class="kpi-icon kpi-icon-green">
                        <i class="mdi mdi-fish"></i>
                    </div>
                    <div class="kpi-text">
                        <p class="kpi-label mb-0">Jumlah Nelayan</p>
                        <h4 class="kpi-value mb-0">{{ number_format($stats['totalNelayan'], 0, ',', '.') }}</h4>
                        <small class="kpi-unit">Orang</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-fill">
            <div class="card border-0 shadow-sm h-100 kpi-card-white">
                <div class="card-body d-flex align-items-center gap-2">
                    <div class="kpi-icon kpi-icon-orange">
                        <i class="mdi mdi-ferry"></i>
                    </div>
                    <div class="kpi-text">
                        <p class="kpi-label mb-0">Jumlah Kapal</p>
                        <h4 class="kpi-value mb-0">{{ number_format($stats['jumlahKapal'], 0, ',', '.') }}</h4>
                        <small class="kpi-unit">Unit</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-fill">
            <div class="card border-0 shadow-sm h-100 kpi-card-white">
                <div class="card-body d-flex align-items-center gap-2">
                    <div class="kpi-icon kpi-icon-purple">
                        <i class="mdi mdi-account-hard-hat"></i>
                    </div>
                    <div class="kpi-text">
                        <p class="kpi-label mb-0">Tenaga Kerja</p>
                        <h4 class="kpi-value mb-0">{{ number_format($stats['serapanTenagaKerja'], 0, ',', '.') }}</h4>
                        <small class="kpi-unit">Orang</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 2: Pendapatan Nelayan + Koperasi -->
    <div class="d-flex gap-3 mb-4 kpi-row">
        <!-- Pendapatan - same flex-fill as Row 1 -->
        <div class="flex-fill">
            <div class="card border-0 shadow-sm h-100 kpi-card-white">
                <div class="card-body d-flex align-items-center gap-2">
                    <div class="kpi-icon kpi-icon-pink">
                        <i class="mdi mdi-cash-multiple"></i>
                    </div>
                    <div class="kpi-text">
                        <p class="kpi-label mb-0">Avg Pendapatan Nelayan</p>
                        <h4 class="kpi-value mb-0">Rp {{ number_format($stats['pendapatanNelayan'], 0, ',', '.') }}</h4>
                        <small class="kpi-unit">Per Bulan</small>
                    </div>
                </div>
            </div>
        </div>
        <!-- Koperasi - takes 3 cards width -->
        <div class="flex-fill" style="flex: 3;">
            @if($stats['koperasiDesaMerahPutih'])
            <div class="card border-0 shadow-sm h-100 kpi-card-white">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="kpi-icon kpi-icon-teal">
                        <i class="mdi mdi-handshake"></i>
                    </div>
                    <div class="kpi-text flex-grow-1">
                        <p class="kpi-label mb-0">Koperasi Desa Merah Putih</p>
                        <div class="d-flex flex-wrap gap-2 mt-1">
                            <span class="badge bg-light text-dark"><i class="mdi mdi-office-building-outline me-1"></i>{{ $stats['koperasiDesaMerahPutih']['nama'] }}</span>
                            <span class="badge bg-light text-dark"><i class="mdi mdi-account-tie me-1"></i>Ketua: {{ $stats['koperasiDesaMerahPutih']['ketua'] }}</span>
                            <span class="badge bg-light text-dark"><i class="mdi mdi-account-group me-1"></i>{{ $stats['koperasiDesaMerahPutih']['anggotaLaki'] + $stats['koperasiDesaMerahPutih']['anggotaPerempuan'] }} Anggota</span>
                            <span class="badge bg-light text-dark"><i class="mdi mdi-file-document-outline me-1"></i>SK: {{ $stats['koperasiDesaMerahPutih']['sk'] ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="card border-0 shadow-sm h-100 kpi-card-white">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <span class="text-muted"><i class="mdi mdi-information-outline me-2"></i>Data Koperasi belum tersedia</span>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- ROW 3: Komoditas Cards -->
    <div class="row mb-4">
        
        <!-- Produksi Keseluruhan -->
        <div class="col-12 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="d-flex align-items-center">
                                <div class="kpi-icon kpi-icon-blue me-3">
                                    <i class="mdi mdi-weight-kilogram"></i>
                                </div>
                                <div>
                                    <p class="kpi-label mb-0">Volume Produksi per Tahun</p>
                                    <h4 class="kpi-value mb-0">{{ number_format($stats['volumeKomoditas1'], 2, ',', '.') }} <small class="text-muted">Ton</small></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="kpi-icon kpi-icon-green me-3">
                                    <i class="mdi mdi-cash-multiple"></i>
                                </div>
                                <div>
                                    <p class="kpi-label mb-0">Nilai Produksi per Tahun</p>
                                    <h4 class="kpi-value mb-0">Rp {{ number_format($stats['nilaiKomoditas1'], 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Komoditas 1 -->
        @if($stats['komoditas1'] && $stats['komoditas1'] != '-')
        <div class="col-lg-6 mb-3">
            <div class="card border-0 shadow-sm komoditas-card h-100">
                <div class="card-header komoditas-header">
                    <div class="d-flex align-items-center">
                        <div class="komoditas-icon">
                            <i class="mdi mdi-fishbowl"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0 text-white">{{ $stats['komoditas1'] }}</h5>
                            <small class="text-white-50">Komoditas Utama 1</small>
                        </div>
                    </div>
                </div>
                <div class="card-body d-flex align-items-center">
                    <div class="komoditas-stat w-100">
                        <i class="mdi mdi-tag-outline text-warning"></i>
                        <div>
                            <span class="komoditas-stat-label">Harga Rata-rata</span>
                            <h5 class="komoditas-stat-value">Rp {{ number_format($stats['hargaKomoditas1'], 0, ',', '.') }} <small>/Kg</small></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Komoditas 2 -->
        @if($stats['komoditas2'] && $stats['komoditas2'] != '-')
        <div class="col-lg-6 mb-3">
            <div class="card border-0 shadow-sm komoditas-card h-100">
                <div class="card-header komoditas-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <div class="d-flex align-items-center">
                        <div class="komoditas-icon">
                            <i class="mdi mdi-fishbowl-outline"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0 text-white">{{ $stats['komoditas2'] }}</h5>
                            <small class="text-white-50">Komoditas Utama 2</small>
                        </div>
                    </div>
                </div>
                <div class="card-body d-flex align-items-center">
                    <div class="komoditas-stat w-100">
                        <i class="mdi mdi-tag-outline text-warning"></i>
                        <div>
                            <span class="komoditas-stat-label">Harga Rata-rata</span>
                            <h5 class="komoditas-stat-value">Rp {{ number_format($stats['hargaKomoditas2'], 0, ',', '.') }} <small>/Kg</small></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        @if((!$stats['komoditas1'] || $stats['komoditas1'] == '-') && (!$stats['komoditas2'] || $stats['komoditas2'] == '-'))
        <div class="col-12">
            <div class="alert alert-light text-center py-4">
                <i class="mdi mdi-information-outline me-2" style="font-size: 1.5rem;"></i>
                <p class="mb-0">Data komoditas belum tersedia untuk KNMP ini</p>
            </div>
        </div>
        @endif
    </div>

    <!-- ROW 4: Map + Pie Chart Distribusi Anggaran -->
    <div class="row mb-4">
        <!-- Map -->
        <div class="col-lg-6 mb-3 mb-lg-0">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-2">
                    <h6 class="mb-0">
                        <i class="mdi mdi-map-marker-radius me-2 text-danger"></i>Lokasi KNMP
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div id="knmpMap" style="height: 280px; width: 100%; background: #e5e7eb;"></div>
                    <div class="px-3 py-2 bg-light" style="border-radius: 0 0 8px 8px;">
                        <p class="mb-0 small text-muted">
                            <i class="mdi mdi-map-marker me-1"></i>
                            {{ $selectedKnmp->village->name ?? '' }}, {{ $selectedKnmp->district->name ?? '' }}, {{ $selectedKnmp->regency->name ?? '' }}
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Map Script -->
            <script>
            (function() {
                function initMap() {
                    if (typeof L === 'undefined') { setTimeout(initMap, 100); return; }
                    var mapEl = document.getElementById('knmpMap');
                    if (!mapEl || mapEl._leaflet_id) return;
                    var lat = {{ $selectedKnmp->latitude && is_numeric($selectedKnmp->latitude) ? $selectedKnmp->latitude : -2.5 }};
                    var lng = {{ $selectedKnmp->longitude && is_numeric($selectedKnmp->longitude) ? $selectedKnmp->longitude : 118 }};
                    var zoom = {{ ($selectedKnmp->latitude && $selectedKnmp->longitude) ? 13 : 5 }};
                    var knmpName = {!! json_encode($selectedKnmp->nama) !!};
                    try {
                        var map = L.map('knmpMap').setView([lat, lng], zoom);
                        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OSM' }).addTo(map);
                        L.marker([lat, lng]).addTo(map).bindPopup('<b>' + knmpName + '</b>').openPopup();
                        setTimeout(function() { map.invalidateSize(); }, 300);
                    } catch(e) { console.error('Map error:', e); }
                }
                if (document.readyState === 'complete') initMap();
                else window.addEventListener('load', initMap);
            })();
            </script>
        </div>

        <!-- Pie Chart -->
        <div class="col-lg-6">
            @php
                // Get budget data from progres_knmp table
                $anggaranKonstruksi = $stats['progres']->anggaran_konstruksi ?? 0;
                $anggaranSarpras = $stats['progres']->anggaran_sarpras ?? 0;
                $totalBudget = $anggaranKonstruksi + $anggaranSarpras;
            @endphp
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-2">
                    <h6 class="mb-0">
                        <i class="mdi mdi-chart-pie me-2 text-primary"></i>Distribusi Anggaran per Komponen
                    </h6>
                </div>
                <div class="card-body">
                    <div style="height: 250px; position: relative;">
                        <canvas id="budgetPieChart" 
                            data-budget-konstruksi="{{ $anggaranKonstruksi }}"
                            data-budget-sarpras="{{ $anggaranSarpras }}">
                        </canvas>
                    </div>
                    <div class="d-flex justify-content-center flex-wrap gap-4 pt-2">
                        <small><span class="legend-dot" style="background:#3b82f6;"></span> Konstruksi</small>
                        <small><span class="legend-dot" style="background:#10b981;"></span> Sarana Prasarana</small>
                    </div>
                    @if($totalBudget > 0)
                    <div class="text-center mt-2">
                        <small class="text-muted">Total Anggaran: Rp {{ number_format($totalBudget, 0, ',', '.') }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Components - 4 Categories with Sub-items -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="section-title mb-3">
                <i class="mdi mdi-chart-timeline-variant me-2"></i>Progres Komponen Pembangunan KNMP
            </h5>
        </div>
        
        <div class="col-12">
                    @php
                        // Define 4 categories with their sub-items
                        $progressCategories = [
                            [
                                'code' => 'A',
                                'name' => 'Konstruksi',
                                'icon' => 'mdi-office-building',
                                'color' => '#3b82f6',
                                'gradient' => 'linear-gradient(135deg, #3b82f6, #1d4ed8)',
                                'items' => [
                                    'Tambatan Perahu / Dermaga',
                                    'Shelter pendaratan ikan',
                                    'Bengkel/ Docking kapal nelayan',
                                    'Kantor pengelola',
                                    'Sentra kuliner produk perikanan',
                                    'Balai Pertemuan Nelayan',
                                    'Shelter perbaikan jaring',
                                    'Shelter Cool Box',
                                    'Bangunan Tapak Cold Storage',
                                    'Miniplan pengolahan ikan',
                                    'Kios perbekalan',
                                    'Tempat pembuangan sampah dan IPAL',
                                    'Musholla',
                                    'Sarana toilet umum',
                                    'Jalan di kawasan lahan pembangunan',
                                    'Penerangan umum',
                                    'Pagar, gapura, dan/atau landmark',
                                    'Parkir',
                                    'Talud / Revetment Sungai dan Laut',
                                ]
                            ],
                            [
                                'code' => 'B',
                                'name' => 'Bantuan Kapal, Mesin dan API',
                                'icon' => 'mdi-ferry',
                                'color' => '#10b981',
                                'gradient' => 'linear-gradient(135deg, #10b981, #059669)',
                                'items' => [
                                    'Kapal penangkap ikan',
                                    'Mesin kapal perikanan',
                                    'Alat Penangkap Ikan',
                                ]
                            ],
                            [
                                'code' => 'C',
                                'name' => 'Bantuan Sarana Rantai Dingin',
                                'icon' => 'mdi-snowflake',
                                'color' => '#06b6d4',
                                'gradient' => 'linear-gradient(135deg, #06b6d4, #0891b2)',
                                'items' => [
                                    'Cold Storage',
                                    'Pabrik Es Balok',
                                    'Pabrik Es Slurry',
                                    'Kendaraan Berpendingin',
                                    'Cool Box',
                                ]
                            ],
                            [
                                'code' => 'D',
                                'name' => 'SPBU Nelayan',
                                'icon' => 'mdi-gas-station',
                                'color' => '#f59e0b',
                                'gradient' => 'linear-gradient(135deg, #f59e0b, #d97706)',
                                'items' => [
                                    'SPBU Nelayan / SPBN',
                                ]
                            ],
                        ];
                        
                        // Find matching progress from database
                        function findProgress($itemName, $progresDetails) {
                            foreach ($progresDetails as $detail) {
                                $searchTerms = explode(' ', strtolower($itemName));
                                $komponen = strtolower($detail->komponen);
                                $matchCount = 0;
                                foreach ($searchTerms as $term) {
                                    if (strlen($term) > 2 && str_contains($komponen, $term)) {
                                        $matchCount++;
                                    }
                                }
                                if ($matchCount >= 2 || str_contains($komponen, strtolower($itemName)) || str_contains(strtolower($itemName), $komponen)) {
                                    return $detail;
                                }
                            }
                            return null;
                        }
                    @endphp
                    
                    <div class="row">
                        @foreach($progressCategories as $category)
                        @php
                            $completedCount = 0;
                            $totalProgress = 0;
                            foreach ($category['items'] as $item) {
                                $progress = findProgress($item, $stats['progresDetails']);
                                if ($progress && $progress->persen > 0) {
                                    $completedCount++;
                                    $totalProgress += $progress->persen;
                                }
                            }
                            $avgProgress = count($category['items']) > 0 ? round($totalProgress / count($category['items'])) : 0;
                        @endphp
                        <div class="col-lg-6 mb-4">
                            <div class="progress-category-card">
                                <div class="progress-category-header" style="background: {{ $category['gradient'] }};">
                                    <div class="d-flex align-items-center">
                                        <div class="progress-category-icon">
                                            <i class="mdi {{ $category['icon'] }}"></i>
                                        </div>
                                        <div class="ms-3">
                                            <span class="progress-category-code">{{ $category['code'] }}.</span>
                                            <h5 class="progress-category-title mb-0">{{ $category['name'] }}</h5>
                                            <small class="text-white-50">{{ $completedCount }}/{{ count($category['items']) }} item dengan progres</small>
                                        </div>
                                    </div>
                                    <div class="progress-category-percent">
                                        <span class="percent-value">{{ $avgProgress }}%</span>
                                        <span class="percent-label">Rata-rata</span>
                                    </div>
                                </div>
                                <div class="progress-category-body">
                                    <div class="progress progress-lg mb-3">
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: {{ $avgProgress }}%; background: {{ $category['gradient'] }};">
                                        </div>
                                    </div>
                                    <div class="progress-items-list">
                                        @foreach($category['items'] as $idx => $item)
                                        @php
                                            $itemProgress = findProgress($item, $stats['progresDetails']);
                                            $itemPersen = $itemProgress ? ($itemProgress->persen ?? 0) : 0;
                                            $statusClass = $itemPersen >= 100 ? 'complete' : ($itemPersen > 0 ? 'in-progress' : 'pending');
                                        @endphp
                                        <div class="progress-item {{ $statusClass }}">
                                            <div class="progress-item-info">
                                                <span class="progress-item-check">
                                                    @if($itemPersen >= 100)
                                                        <i class="mdi mdi-check-circle"></i>
                                                    @elseif($itemPersen > 0)
                                                        <i class="mdi mdi-progress-clock"></i>
                                                    @else
                                                        <i class="mdi mdi-circle-outline"></i>
                                                    @endif
                                                </span>
                                                <span class="progress-item-name">{{ $item }}</span>
                                            </div>
                                            <div class="progress-item-value">
                                                <span class="badge {{ $itemPersen >= 100 ? 'bg-success' : ($itemPersen > 0 ? 'bg-warning' : 'bg-secondary') }}">
                                                    {{ $itemPersen }}%
                                                </span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="mdi mdi-information-outline text-muted" style="font-size: 4rem;"></i>
                    <h5 class="text-muted mt-3">Pilih KNMP</h5>
                    <p class="text-muted">Silakan pilih KNMP untuk melihat statistik</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <style>
        .selector-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        
        .selector-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.75rem;
        }
        
        /* Custom Searchable Dropdown */
        .custom-searchable-dropdown {
            position: relative;
            width: 100%;
        }
        
        .dropdown-toggle-btn {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background: #fff;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            min-height: 48px;
            width: 100%;
        }
        
        .dropdown-toggle-btn:hover {
            border-color: #3b82f6;
        }
        
        .dropdown-toggle-btn.open {
            border-color: #3b82f6;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .dropdown-toggle-btn .selected-text {
            font-size: 14px;
            color: #374151;
            font-weight: 500;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex: 1;
        }
        
        .dropdown-toggle-btn i {
            color: #64748b;
            font-size: 20px;
            transition: transform 0.2s ease;
            margin-left: 8px;
        }
        
        .dropdown-toggle-btn.open i {
            transform: rotate(180deg);
            color: #3b82f6;
        }
        
        .dropdown-menu-custom {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 2px solid #3b82f6;
            border-top: none;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            display: none;
            z-index: 9999;
        }
        
        .dropdown-menu-custom.show {
            display: block;
        }
        
        .dropdown-search {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f8fafc;
        }
        
        .dropdown-search i {
            color: #3b82f6;
            font-size: 20px;
        }
        
        .dropdown-search input {
            flex: 1;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 14px;
            color: #374151;
            background: #fff;
            outline: none;
        }
        
        .dropdown-search input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        }
        
        .dropdown-search input::placeholder {
            color: #9ca3af;
        }
        
        .dropdown-options {
            max-height: 250px;
            overflow-y: auto;
        }
        
        .dropdown-option {
            padding: 10px 14px;
            cursor: pointer;
            transition: background 0.15s;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .dropdown-option:last-child {
            border-bottom: none;
        }
        
        .dropdown-option:hover {
            background: #eff6ff;
        }
        
        .dropdown-option.selected {
            background: #3b82f6;
        }
        
        .dropdown-option.selected .option-name,
        .dropdown-option.selected .option-location {
            color: #fff !important;
        }
        
        .dropdown-option .option-name {
            font-weight: 600;
            font-size: 14px;
            color: #1f2937;
            display: block;
        }
        
        .dropdown-option .option-location {
            font-size: 12px;
            color: #6b7280;
            display: block;
            margin-top: 2px;
        }
        
        .dropdown-no-results {
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        
        .dropdown-no-results i {
            margin-right: 6px;
        }
        
        /* ========== WHITE KPI CARD STYLES ========== */
        .kpi-card-white {
            border-radius: 12px;
            transition: all 0.2s ease;
        }
        
        .kpi-card-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
        }
        
        .kpi-card-white .card-body {
            padding: 1rem;
        }
        
        .kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .kpi-icon i {
            font-size: 1.4rem;
            color: #fff;
        }
        
        .kpi-icon-blue { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .kpi-icon-green { background: linear-gradient(135deg, #10b981, #059669); }
        .kpi-icon-orange { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .kpi-icon-purple { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
        .kpi-icon-pink { background: linear-gradient(135deg, #ec4899, #db2777); }
        .kpi-icon-teal { background: linear-gradient(135deg, #14b8a6, #0d9488); }
        
        .kpi-text {
            flex: 1;
            min-width: 0;
        }
        
        .kpi-label {
            font-size: 0.75rem;
            font-weight: 500;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .kpi-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.2;
        }
        
        .kpi-unit {
            font-size: 0.7rem;
            font-weight: 500;
            color: #9ca3af;
        }
        
        /* Responsive for KPI Cards */
        @media (max-width: 991.98px) {
            .kpi-icon {
                width: 42px;
                height: 42px;
            }
            .kpi-icon i {
                font-size: 1.2rem;
            }
            .kpi-value {
                font-size: 1.1rem;
            }
        }
        
        @media (max-width: 575.98px) {
            .kpi-card-white .card-body {
                padding: 0.75rem;
            }
            .kpi-icon {
                width: 38px;
                height: 38px;
            }
            .kpi-icon i {
                font-size: 1rem;
            }
            .kpi-label {
                font-size: 0.65rem;
            }
            .kpi-value {
                font-size: 1rem;
            }
            .kpi-unit {
                font-size: 0.6rem;
            }
        }
        
        /* Section Title */
        .section-title {
            font-size: 1rem;
            font-weight: 600;
            color: #374151;
            display: flex;
            align-items: center;
        }
        
        /* Komoditas Card */
        .komoditas-card {
            border-radius: 16px;
            overflow: hidden;
        }
        
        .komoditas-header {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            padding: 1.25rem;
            border: none;
        }
        
        .komoditas-icon {
            width: 48px;
            height: 48px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.5rem;
        }
        
        .komoditas-stat {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.75rem;
            background: #f8fafc;
            border-radius: 10px;
        }
        
        .komoditas-stat > i {
            font-size: 1.25rem;
            margin-top: 2px;
        }
        
        .komoditas-stat-label {
            font-size: 0.75rem;
            color: #64748b;
            display: block;
        }
        
        .komoditas-stat-value {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }
        
        .komoditas-stat-value small {
            font-size: 0.75rem;
            font-weight: 400;
            color: #94a3b8;
        }
        
        /* Koperasi */
        .koperasi-badge {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ec4899, #db2777);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.25rem;
        }
        
        .koperasi-item {
            background: #f8fafc;
            padding: 0.75rem 1rem;
            border-radius: 10px;
        }
        
        .koperasi-label {
            display: block;
            font-size: 0.7rem;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }
        
        .koperasi-value {
            font-weight: 600;
            color: #1e293b;
        }
        
        /* Progress Category Card */
        .progress-category-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .progress-category-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }
        
        .progress-category-header {
            padding: 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .progress-category-icon {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.5rem;
        }
        
        .progress-category-code {
            font-size: 0.85rem;
            font-weight: 600;
            color: rgba(255,255,255,0.8);
        }
        
        .progress-category-title {
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
        }
        
        .progress-category-percent {
            text-align: right;
        }
        
        .progress-category-percent .percent-value {
            display: block;
            font-size: 1.75rem;
            font-weight: 700;
            color: #fff;
            line-height: 1;
        }
        
        .progress-category-percent .percent-label {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.7);
        }
        
        .progress-category-body {
            padding: 1.25rem;
            max-height: 350px;
            overflow-y: auto;
        }
        
        .progress-lg {
            height: 10px;
            border-radius: 5px;
            background: #e2e8f0;
        }
        
        .progress-lg .progress-bar {
            border-radius: 5px;
        }
        
        .progress-items-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .progress-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.6rem 0.75rem;
            background: #f8fafc;
            border-radius: 8px;
            transition: all 0.2s;
        }
        
        .progress-item:hover {
            background: #f1f5f9;
        }
        
        .progress-item-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex: 1;
        }
        
        .progress-item-check {
            font-size: 1rem;
        }
        
        .progress-item.complete .progress-item-check { color: #10b981; }
        .progress-item.in-progress .progress-item-check { color: #f59e0b; }
        .progress-item.pending .progress-item-check { color: #94a3b8; }
        
        .progress-item-name {
            font-size: 0.8rem;
            color: #374151;
        }
        
        .progress-item.complete .progress-item-name {
            color: #10b981;
        }
        
        .progress-item-value .badge {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
        }

        #knmpMap {
            background: #e5e7eb;
            border-radius: 0;
            min-height: 300px;
            z-index: 1;
        }
        
        /* Fix Leaflet map tiles */
        .leaflet-container {
            background: #e5e7eb;
            z-index: 1;
        }
        
        .leaflet-tile-pane {
            z-index: 2;
        }
        
        .leaflet-control-container {
            z-index: 100;
        }
    </style>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    
    <style>
        /* Select2 Custom Styling */
        .select2-container--bootstrap-5 .select2-selection {
            border: 2px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 4px 8px !important;
            min-height: 38px !important;
            font-size: 13px;
        }
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            padding-left: 0 !important;
            line-height: 24px !important;
            color: #374151 !important;
            font-size: 13px !important;
        }
        .select2-container--bootstrap-5.select2-container--focus .select2-selection,
        .select2-container--bootstrap-5.select2-container--open .select2-selection {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        }
        .select2-container--bootstrap-5 .select2-dropdown {
            border: 2px solid #3b82f6 !important;
            border-radius: 0 0 10px 10px !important;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15) !important;
        }
        .select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected] {
            background-color: #3b82f6 !important;
        }
        .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
            border: 1px solid #e2e8f0 !important;
            border-radius: 6px !important;
            padding: 8px 12px !important;
        }
        .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1) !important;
            outline: none !important;
        }
        
        /* Pendapatan Card */
        .pendapatan-card {
            border-left: 4px solid #ec4899;
        }
        
        /* Chart Legend */
        .legend-dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 4px;
        }
    </style>
@endsection

@push('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    if ($('#knmpSelect').length) {
        $('#knmpSelect').select2({
            theme: 'bootstrap-5',
            placeholder: '🔍 Ketik untuk mencari KNMP...',
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() { return "KNMP tidak ditemukan"; },
                searching: function() { return "Mencari..."; }
            }
        });
        
        // Submit form on change
        $('#knmpSelect').on('change', function() {
            if (this.value) {
                document.getElementById('knmpForm').submit();
            }
        });
    }
    
    // Initialize Pie Chart for Budget Distribution
    var ctx = document.getElementById('budgetPieChart');
    if (ctx) {
        // Read budget data from data attributes
        var budgetKonstruksi = parseFloat(ctx.dataset.budgetKonstruksi) || 0;
        var budgetSarpras = parseFloat(ctx.dataset.budgetSarpras) || 0;
        var total = budgetKonstruksi + budgetSarpras;
        
        // If no data, show placeholder
        var chartData = total > 0 ? [budgetKonstruksi, budgetSarpras] : [50, 50];
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Konstruksi', 'Sarana Prasarana'],
                datasets: [{
                    data: chartData,
                    backgroundColor: ['#3b82f6', '#10b981'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if (total > 0) {
                                    var value = context.parsed;
                                    var persen = ((value / total) * 100).toFixed(1);
                                    return context.label + ': Rp ' + value.toLocaleString('id-ID') + ' (' + persen + '%)';
                                }
                                return context.label + ': 50%';
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush