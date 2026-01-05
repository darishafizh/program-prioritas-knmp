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

    <!-- KNMP Selector with Search -->
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
                            <div class="custom-searchable-dropdown">
                                <div class="dropdown-toggle-btn" id="knmpDropdownBtn">
                                    <span class="selected-text">
                                        @if($selectedKnmp)
                                            {{ $selectedKnmp->nama }} — {{ $selectedKnmp->regency->name ?? '' }}, {{ $selectedKnmp->province->name ?? '' }}
                                        @else
                                            -- Pilih KNMP --
                                        @endif
                                    </span>
                                    <i class="mdi mdi-chevron-down"></i>
                                </div>
                                <div class="dropdown-menu-custom" id="knmpDropdownMenu">
                                    <div class="dropdown-search">
                                        <i class="mdi mdi-magnify"></i>
                                        <input type="text" id="knmpSearch" placeholder="Ketik untuk mencari KNMP..." autocomplete="off">
                                    </div>
                                    <div class="dropdown-options" id="knmpOptions">
                                        @foreach ($knmpList as $item)
                                            <div class="dropdown-option {{ $selectedKnmpId == $item->id ? 'selected' : '' }}" 
                                                 data-value="{{ $item->id }}"
                                                 data-text="{{ $item->nama }} — {{ $item->regency->name ?? '' }}, {{ $item->province->name ?? '' }}">
                                                <span class="option-name">{{ $item->nama }}</span>
                                                <span class="option-location">{{ $item->regency->name ?? '' }}, {{ $item->province->name ?? '' }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="dropdown-no-results" style="display:none;">
                                        <i class="mdi mdi-alert-circle-outline"></i> KNMP tidak ditemukan
                                    </div>
                                </div>
                                <input type="hidden" name="knmp_id" id="knmpInput" value="{{ $selectedKnmpId }}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($selectedKnmp)
    <!-- Section 1: Main KPI Cards (4 cards) -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="kpi-card">
                <div class="kpi-card-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                    <i class="mdi mdi-account-group"></i>
                </div>
                <div class="kpi-card-body">
                    <h3 class="kpi-value">{{ number_format($stats['jmlKepalaKeluarga'], 0, ',', '.') }}</h3>
                    <p class="kpi-label">Jumlah Kepala Keluarga</p>
                    <span class="kpi-unit">KK</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="kpi-card">
                <div class="kpi-card-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="mdi mdi-fish"></i>
                </div>
                <div class="kpi-card-body">
                    <h3 class="kpi-value">{{ number_format($stats['totalNelayan'], 0, ',', '.') }}</h3>
                    <p class="kpi-label">Jumlah Nelayan</p>
                    <span class="kpi-unit">Orang</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="kpi-card">
                <div class="kpi-card-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <i class="mdi mdi-ferry"></i>
                </div>
                <div class="kpi-card-body">
                    <h3 class="kpi-value">{{ number_format($stats['jumlahKapal'], 0, ',', '.') }}</h3>
                    <p class="kpi-label">Jumlah Kapal</p>
                    <span class="kpi-unit">Unit</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="kpi-card">
                <div class="kpi-card-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                    <i class="mdi mdi-account-hard-hat"></i>
                </div>
                <div class="kpi-card-body">
                    <h3 class="kpi-value">{{ number_format($stats['serapanTenagaKerja'], 0, ',', '.') }}</h3>
                    <p class="kpi-label">Serapan Tenaga Kerja</p>
                    <span class="kpi-unit">Orang</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Komoditas Cards -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="section-title mb-3">
                <i class="mdi mdi-package-variant me-2"></i>Data Komoditas Utama
            </h5>
        </div>
        
        <!-- Komoditas 1 -->
        @if($stats['komoditas1'] && $stats['komoditas1'] != '-')
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm komoditas-card">
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
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="komoditas-stat">
                                <i class="mdi mdi-weight-kilogram text-primary"></i>
                                <div>
                                    <span class="komoditas-stat-label">Volume Produksi</span>
                                    <h5 class="komoditas-stat-value">{{ number_format($stats['volumeKomoditas1'], 2, ',', '.') }} <small>Ton/Tahun</small></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="komoditas-stat">
                                <i class="mdi mdi-cash-multiple text-success"></i>
                                <div>
                                    <span class="komoditas-stat-label">Nilai Produksi</span>
                                    <h5 class="komoditas-stat-value">Rp {{ number_format($stats['nilaiKomoditas1'], 0, ',', '.') }} <small>/Tahun</small></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="komoditas-stat">
                                <i class="mdi mdi-tag-outline text-warning"></i>
                                <div>
                                    <span class="komoditas-stat-label">Harga Rata-rata</span>
                                    <h5 class="komoditas-stat-value">Rp {{ number_format($stats['hargaKomoditas1'], 0, ',', '.') }} <small>/Kg</small></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Komoditas 2 -->
        @if($stats['komoditas2'] && $stats['komoditas2'] != '-')
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm komoditas-card">
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
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="komoditas-stat">
                                <i class="mdi mdi-weight-kilogram text-primary"></i>
                                <div>
                                    <span class="komoditas-stat-label">Volume Produksi</span>
                                    <h5 class="komoditas-stat-value">{{ number_format($stats['volumeKomoditas2'], 2, ',', '.') }} <small>Ton/Tahun</small></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="komoditas-stat">
                                <i class="mdi mdi-cash-multiple text-success"></i>
                                <div>
                                    <span class="komoditas-stat-label">Nilai Produksi</span>
                                    <h5 class="komoditas-stat-value">Rp {{ number_format($stats['nilaiKomoditas2'], 0, ',', '.') }} <small>/Tahun</small></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="komoditas-stat">
                                <i class="mdi mdi-tag-outline text-warning"></i>
                                <div>
                                    <span class="komoditas-stat-label">Harga Rata-rata</span>
                                    <h5 class="komoditas-stat-value">Rp {{ number_format($stats['hargaKomoditas2'], 0, ',', '.') }} <small>/Kg</small></h5>
                                </div>
                            </div>
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

    <!-- Section 3: Map & Koperasi -->
    <div class="row mb-4">
        <!-- Map -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-0">
                        <i class="mdi mdi-map-marker-radius me-2 text-danger"></i>
                        Lokasi KNMP
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div id="knmpMap" style="height: 300px;"></div>
                    <div class="p-3 bg-light" style="border-radius: 0 0 12px 12px;">
                        <p class="mb-1 small text-muted">
                            <i class="mdi mdi-map-marker me-1"></i>
                            {{ $selectedKnmp->village->name ?? 'N/A' }}, {{ $selectedKnmp->district->name ?? 'N/A' }}
                        </p>
                        <p class="mb-0 small text-muted">
                            {{ $selectedKnmp->regency->name ?? 'N/A' }}, {{ $selectedKnmp->province->name ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Koperasi -->
        @if($stats['koperasiDesaMerahPutih'])
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-0 d-flex align-items-center">
                        <span class="koperasi-badge me-2">
                            <i class="mdi mdi-handshake"></i>
                        </span>
                        Koperasi Desa Merah Putih
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="koperasi-item">
                                <span class="koperasi-label">Nama Koperasi</span>
                                <span class="koperasi-value">{{ $stats['koperasiDesaMerahPutih']['nama'] }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="koperasi-item">
                                <span class="koperasi-label">Ketua</span>
                                <span class="koperasi-value">{{ $stats['koperasiDesaMerahPutih']['ketua'] }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="koperasi-item">
                                <span class="koperasi-label">SK Kopdeskel</span>
                                <span class="koperasi-value">{{ $stats['koperasiDesaMerahPutih']['sk'] }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="koperasi-item">
                                <span class="koperasi-label">Jumlah Anggota</span>
                                <span class="koperasi-value">
                                    {{ $stats['koperasiDesaMerahPutih']['anggotaLaki'] + $stats['koperasiDesaMerahPutih']['anggotaPerempuan'] }} Orang
                                    <small class="text-muted">(L: {{ $stats['koperasiDesaMerahPutih']['anggotaLaki'] }}, P: {{ $stats['koperasiDesaMerahPutih']['anggotaPerempuan'] }})</small>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Progress Components - 4 Categories with Sub-items -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="mdi mdi-chart-timeline-variant me-2 text-primary"></i>
                        Progres Komponen Pembangunan KNMP
                    </h5>
                </div>
                <div class="card-body pt-0">
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
            padding: 0.75rem 1rem;
            background: #fff;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            min-height: 50px;
        }
        
        .dropdown-toggle-btn:hover {
            border-color: #3b82f6;
        }
        
        .dropdown-toggle-btn.open {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            border-radius: 12px 12px 0 0;
        }
        
        .dropdown-toggle-btn .selected-text {
            font-size: 0.95rem;
            color: #374151;
            font-weight: 500;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .dropdown-toggle-btn i {
            color: #64748b;
            font-size: 1.25rem;
            transition: transform 0.2s;
        }
        
        .dropdown-toggle-btn.open i {
            transform: rotate(180deg);
        }
        
        .dropdown-menu-custom {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 2px solid #3b82f6;
            border-top: none;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            display: none;
            z-index: 1000;
            max-height: 350px;
            overflow: hidden;
        }
        
        .dropdown-menu-custom.show {
            display: block;
        }
        
        .dropdown-search {
            padding: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f8fafc;
        }
        
        .dropdown-search i {
            color: #64748b;
            font-size: 1.25rem;
        }
        
        .dropdown-search input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            font-size: 0.9rem;
            color: #374151;
        }
        
        .dropdown-search input::placeholder {
            color: #94a3b8;
        }
        
        .dropdown-options {
            max-height: 280px;
            overflow-y: auto;
        }
        
        .dropdown-option {
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: all 0.15s;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            flex-direction: column;
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
            color: #fff;
        }
        
        .dropdown-option .option-name {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.9rem;
        }
        
        .dropdown-option .option-location {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 2px;
        }
        
        .dropdown-no-results {
            padding: 1.5rem;
            text-align: center;
            color: #64748b;
            font-size: 0.9rem;
        }
        
        .dropdown-no-results i {
            margin-right: 0.5rem;
        }
        
        /* KPI Card Styles */
        .kpi-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            height: 100%;
            transition: all 0.3s ease;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .kpi-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .kpi-card-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        
        .kpi-card-body {
            flex: 1;
        }
        
        .kpi-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            line-height: 1.2;
        }
        
        .kpi-label {
            font-size: 0.85rem;
            color: #64748b;
            margin: 0.25rem 0 0;
        }
        
        .kpi-unit {
            font-size: 0.75rem;
            color: #94a3b8;
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 0.5rem;
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
            background: #f1f5f9;
            border-radius: 0;
        }
    </style>
@endsection

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
@endpush

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script loaded');
    
    // Custom Searchable Dropdown
    var dropdownBtn = document.getElementById('knmpDropdownBtn');
    var dropdownMenu = document.getElementById('knmpDropdownMenu');
    var searchInput = document.getElementById('knmpSearch');
    var optionsContainer = document.getElementById('knmpOptions');
    var noResults = document.querySelector('.dropdown-no-results');
    var hiddenInput = document.getElementById('knmpInput');
    var form = document.getElementById('knmpForm');
    
    console.log('Dropdown elements:', dropdownBtn, dropdownMenu);
    
    if (dropdownBtn && dropdownMenu) {
        console.log('Dropdown elements found, attaching event listeners');
        
        // Toggle dropdown
        dropdownBtn.onclick = function(e) {
            console.log('Dropdown button clicked');
            e.preventDefault();
            e.stopPropagation();
            
            if (dropdownMenu.classList.contains('show')) {
                dropdownMenu.classList.remove('show');
                dropdownBtn.classList.remove('open');
            } else {
                dropdownMenu.classList.add('show');
                dropdownBtn.classList.add('open');
                if (searchInput) {
                    searchInput.focus();
                    searchInput.value = '';
                }
                filterOptions('');
            }
        };
        
        // Close on click outside
        document.addEventListener('click', function(e) {
            if (dropdownMenu && !dropdownMenu.contains(e.target) && !dropdownBtn.contains(e.target)) {
                dropdownMenu.classList.remove('show');
                dropdownBtn.classList.remove('open');
            }
        });
        
        // Search functionality
        if (searchInput) {
            searchInput.oninput = function() {
                filterOptions(this.value.toLowerCase());
            };
            
            searchInput.onclick = function(e) {
                e.stopPropagation();
            };
        }
        
        function filterOptions(searchTerm) {
            if (!optionsContainer) return;
            var options = optionsContainer.querySelectorAll('.dropdown-option');
            var visibleCount = 0;
            
            options.forEach(function(option) {
                var text = option.getAttribute('data-text');
                if (text && text.toLowerCase().includes(searchTerm)) {
                    option.style.display = 'flex';
                    visibleCount++;
                } else {
                    option.style.display = 'none';
                }
            });
            
            if (noResults) {
                noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }
        
        // Select option
        if (optionsContainer) {
            optionsContainer.onclick = function(e) {
                var option = e.target.closest('.dropdown-option');
                if (option) {
                    var value = option.getAttribute('data-value');
                    var text = option.getAttribute('data-text');
                    
                    // Update selected
                    optionsContainer.querySelectorAll('.dropdown-option').forEach(function(o) {
                        o.classList.remove('selected');
                    });
                    option.classList.add('selected');
                    
                    // Update display
                    var selectedText = dropdownBtn.querySelector('.selected-text');
                    if (selectedText) {
                        selectedText.textContent = text;
                    }
                    if (hiddenInput) {
                        hiddenInput.value = value;
                    }
                    
                    // Close dropdown
                    dropdownMenu.classList.remove('show');
                    dropdownBtn.classList.remove('open');
                    
                    // Submit form
                    if (form) {
                        form.submit();
                    }
                }
            };
        }
    }
    
    // Initialize Map
    @if(isset($selectedKnmp) && $selectedKnmp)
    setTimeout(function() {
        var mapElement = document.getElementById('knmpMap');
        if (mapElement && typeof L !== 'undefined') {
            @php
                $lat = $stats['latitude'] ?? null;
                $lng = $stats['longitude'] ?? null;
                $hasCoords = !empty($lat) && !empty($lng);
                $defaultLat = -2.5;
                $defaultLng = 118;
            @endphp
            
            @if($hasCoords)
                var lat = {{ $lat }};
                var lng = {{ $lng }};
                var zoom = 12;
            @else
                var lat = {{ $defaultLat }};
                var lng = {{ $defaultLng }};
                var zoom = 5;
            @endif
            
            var map = L.map('knmpMap', {
                scrollWheelZoom: false
            }).setView([lat, lng], zoom);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap',
                maxZoom: 19
            }).addTo(map);
            
            var customIcon = L.icon({
                iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
            
            var marker = L.marker([lat, lng], {icon: customIcon}).addTo(map);
            
            @if($hasCoords)
                marker.bindPopup("<div style='text-align:center'><b>{{ addslashes($selectedKnmp->nama) }}</b><br><span style='color:#666'>{{ addslashes($selectedKnmp->village->name ?? '') }}, {{ addslashes($selectedKnmp->district->name ?? '') }}</span></div>").openPopup();
            @else
                marker.bindPopup("<div style='text-align:center'><b>{{ addslashes($selectedKnmp->nama) }}</b><br><span style='color:#999'>Koordinat belum tersedia</span></div>");
            @endif
            
            setTimeout(function() {
                map.invalidateSize();
            }, 200);
        }
    }, 100);
    @endif
});
</script>
@endpush