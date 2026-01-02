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
                            <select name="knmp_id" id="knmpSelect" class="form-select form-select-lg">
                                <option value="">-- Cari dan Pilih KNMP --</option>
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

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

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
        
        /* Select2 Custom Styling */
        .select2-container--bootstrap-5 .select2-selection {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.5rem 0.75rem;
            min-height: 48px;
            font-weight: 500;
        }
        
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            padding-left: 0;
            line-height: 28px;
        }
        
        .select2-container--bootstrap-5.select2-container--focus .select2-selection,
        .select2-container--bootstrap-5.select2-container--open .select2-selection {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        
        .select2-container--bootstrap-5 .select2-dropdown {
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        
        .select2-container--bootstrap-5 .select2-results__option--highlighted {
            background-color: #3b82f6;
        }
        
        .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            padding: 0.5rem 0.75rem;
        }
        
        .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
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

@push('scripts')
<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for searchable dropdown
    $('#knmpSelect').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Cari dan Pilih KNMP --',
        allowClear: true,
        width: '100%'
    });
    
    // Submit form when selection changes
    $('#knmpSelect').on('change', function() {
        if (this.value) {
            document.getElementById('knmpForm').submit();
        }
    });
    
    // Initialize Map
    @if($selectedKnmp)
        var mapElement = document.getElementById('knmpMap');
        if (mapElement) {
            @php
                $lat = $stats['latitude'] ?? -2.5;
                $lng = $stats['longitude'] ?? 118;
                $hasCoords = $stats['latitude'] && $stats['longitude'];
            @endphp
            
            var lat = {{ $lat }};
            var lng = {{ $lng }};
            var hasCoords = {{ $hasCoords ? 'true' : 'false' }};
            
            var map = L.map('knmpMap').setView([lat, lng], hasCoords ? 12 : 5);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            var customIcon = L.divIcon({
                className: 'custom-marker',
                html: '<div style="background: linear-gradient(135deg, #ef4444, #dc2626); width: 30px; height: 30px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 3px solid #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.3);"></div>',
                iconSize: [30, 30],
                iconAnchor: [15, 30],
                popupAnchor: [0, -30]
            });
            
            var marker = L.marker([lat, lng], {icon: customIcon}).addTo(map);
            
            @if($hasCoords)
                marker.bindPopup("<b>{{ $selectedKnmp->nama }}</b><br>{{ $selectedKnmp->village->name ?? '' }}, {{ $selectedKnmp->district->name ?? '' }}").openPopup();
            @else
                marker.bindPopup("<b>{{ $selectedKnmp->nama }}</b><br><span style='color:#999'>Koordinat belum tersedia</span>");
                // Show all of Indonesia if no coords
                map.setView([-2.5, 118], 5);
            @endif
            
            // Fix map display issue
            setTimeout(function() {
                map.invalidateSize();
            }, 100);
        }
    @endif
});
</script>
@endpush