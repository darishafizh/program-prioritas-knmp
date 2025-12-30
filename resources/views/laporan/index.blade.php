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

    <!-- KNMP Selector -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm selector-card">
                <div class="card-body py-3">
                    <form method="GET" action="{{ route('laporan.index') }}" class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="selector-icon">
                            <i class="mdi mdi-home-city"></i>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label mb-1 fw-semibold text-dark">Pilih Kampung Nelayan</label>
                            <select name="knmp_id" class="form-select form-select-lg knmp-dropdown" onchange="this.form.submit()">
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
    <!-- Main Stats Grid -->
    <div class="row">
        <!-- Left Column - Stats Cards -->
        <div class="col-lg-8">
            <!-- Row 1: Key Metrics -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stat-card-modern">
                        <div class="stat-card-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                            <i class="mdi mdi-account-group"></i>
                        </div>
                        <div class="stat-card-content">
                            <p class="stat-label">Kepala Keluarga</p>
                            <h3 class="stat-value">{{ number_format($stats['jmlKepalaKeluarga'], 0, ',', '.') }}</h3>
                            <span class="stat-unit">KK</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-modern">
                        <div class="stat-card-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                            <i class="mdi mdi-fish"></i>
                        </div>
                        <div class="stat-card-content">
                            <p class="stat-label">Total Nelayan</p>
                            <h3 class="stat-value">{{ number_format($stats['totalNelayan'], 0, ',', '.') }}</h3>
                            <span class="stat-unit">Orang</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-modern">
                        <div class="stat-card-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                            <i class="mdi mdi-ferry"></i>
                        </div>
                        <div class="stat-card-content">
                            <p class="stat-label">Jumlah Kapal</p>
                            <h3 class="stat-value">{{ number_format($stats['jumlahKapal'], 0, ',', '.') }}</h3>
                            <span class="stat-unit">Unit</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 2: Production & Income -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="stat-card-modern stat-card-wide">
                        <div class="stat-card-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                            <i class="mdi mdi-currency-usd"></i>
                        </div>
                        <div class="stat-card-content">
                            <p class="stat-label">Pendapatan per Tahun</p>
                            <h3 class="stat-value">Rp {{ number_format($stats['pendapatanPerTahun'], 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card-modern stat-card-wide">
                        <div class="stat-card-icon" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                            <i class="mdi mdi-weight-kilogram"></i>
                        </div>
                        <div class="stat-card-content">
                            <p class="stat-label">Volume Produksi per Tahun</p>
                            <h3 class="stat-value">{{ number_format($stats['volumeProduksiPerTahun'], 2, ',', '.') }} <small>Ton</small></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 3: Additional Stats -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stat-card-compact">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 text-muted small">Serapan Tenaga Kerja</p>
                                <h4 class="mb-0 fw-bold">{{ number_format($stats['serapanTenagaKerja'], 0, ',', '.') }}</h4>
                            </div>
                            <div class="stat-mini-icon bg-primary-subtle">
                                <i class="mdi mdi-account-hard-hat text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-compact">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 text-muted small">Pendapatan Nelayan</p>
                                <h4 class="mb-0 fw-bold">Rp {{ number_format($stats['pendapatanNelayan'], 0, ',', '.') }}</h4>
                            </div>
                            <div class="stat-mini-icon bg-success-subtle">
                                <i class="mdi mdi-cash-multiple text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-compact">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 text-muted small">Komoditas Utama</p>
                                <h4 class="mb-0 fw-bold" style="font-size: 1rem;">{{ $stats['komoditasUtama'] }}</h4>
                            </div>
                            <div class="stat-mini-icon bg-warning-subtle">
                                <i class="mdi mdi-fishbowl-outline text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Koperasi Card -->
            @if($stats['koperasiDesaMerahPutih'])
            <div class="card border-0 shadow-sm mb-4">
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
            @endif
        </div>

        <!-- Right Column - Map -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-0">
                        <i class="mdi mdi-map-marker-radius me-2 text-danger"></i>
                        Lokasi KNMP
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div id="knmpMap" style="height: 400px; border-radius: 0 0 12px 12px;"></div>
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
    </div>

    <!-- Progress Components -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="mdi mdi-chart-timeline-variant me-2 text-primary"></i>
                        Progres Komponen Pembangunan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $komponenIcons = [
                                'Konstruksi' => ['icon' => 'mdi-office-building', 'color' => '#3b82f6'],
                                'Bantuan Kapal' => ['icon' => 'mdi-ferry', 'color' => '#10b981'],
                                'API' => ['icon' => 'mdi-hook', 'color' => '#f59e0b'],
                                'Sarana Tangkap' => ['icon' => 'mdi-hook', 'color' => '#f59e0b'],
                                'Sarana Rantai Dingin' => ['icon' => 'mdi-snowflake', 'color' => '#06b6d4'],
                                'Cold Storage' => ['icon' => 'mdi-fridge', 'color' => '#06b6d4'],
                                'SPBU Nelayan' => ['icon' => 'mdi-gas-station', 'color' => '#ef4444'],
                                'Sarana Pendukung' => ['icon' => 'mdi-tools', 'color' => '#8b5cf6'],
                            ];
                        @endphp
                        
                        @forelse($stats['progresDetails'] as $detail)
                            @php
                                $iconData = collect($komponenIcons)->first(function($v, $k) use ($detail) {
                                    return str_contains(strtolower($detail->komponen), strtolower($k));
                                }) ?? ['icon' => 'mdi-checkbox-marked-circle-outline', 'color' => '#6b7280'];
                            @endphp
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="progress-card">
                                    <div class="progress-card-header">
                                        <div class="progress-icon" style="background: {{ $iconData['color'] }}20; color: {{ $iconData['color'] }};">
                                            <i class="mdi {{ $iconData['icon'] }}"></i>
                                        </div>
                                        <span class="progress-percentage" style="color: {{ $iconData['color'] }};">{{ $detail->persen ?? 0 }}%</span>
                                    </div>
                                    <h6 class="progress-title">{{ $detail->komponen }}</h6>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: {{ $detail->persen ?? 0 }}%; background: {{ $iconData['color'] }};" 
                                             aria-valuenow="{{ $detail->persen ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    @if($detail->keterangan)
                                        <small class="text-muted mt-2 d-block">{{ Str::limit($detail->keterangan, 50) }}</small>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-4 text-muted">
                                    <i class="mdi mdi-information-outline" style="font-size: 2rem;"></i>
                                    <p class="mb-0 mt-2">Belum ada data progres komponen</p>
                                </div>
                            </div>
                        @endforelse
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
        
        .knmp-dropdown {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .knmp-dropdown:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        
        .stat-card-modern {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            height: 100%;
            transition: all 0.3s ease;
        }
        
        .stat-card-modern:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .stat-card-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .stat-card-content .stat-label {
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-card-content .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            line-height: 1.2;
        }
        
        .stat-card-content .stat-unit {
            font-size: 0.75rem;
            color: #94a3b8;
        }
        
        .stat-card-wide .stat-value {
            font-size: 1.5rem;
        }
        
        .stat-card-compact {
            background: #fff;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            height: 100%;
        }
        
        .stat-mini-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        
        .bg-primary-subtle { background: rgba(59, 130, 246, 0.1); }
        .bg-success-subtle { background: rgba(16, 185, 129, 0.1); }
        .bg-warning-subtle { background: rgba(245, 158, 11, 0.1); }
        
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
        
        .progress-card {
            background: #fff;
            border-radius: 14px;
            padding: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            height: 100%;
        }
        
        .progress-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }
        
        .progress-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        
        .progress-percentage {
            font-size: 1.25rem;
            font-weight: 700;
        }
        
        .progress-title {
            font-size: 0.85rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.75rem;
        }
        
        .progress-sm {
            height: 6px;
            border-radius: 3px;
            background: #e2e8f0;
        }
        
        .progress-sm .progress-bar {
            border-radius: 3px;
        }
        
        #knmpMap {
            background: #f1f5f9;
        }
    </style>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($selectedKnmp && $stats['latitude'] && $stats['longitude'])
            var lat = {{ $stats['latitude'] ?? -2.5 }};
            var lng = {{ $stats['longitude'] ?? 118 }};
            
            var map = L.map('knmpMap').setView([lat, lng], 10);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);
            
            var marker = L.marker([lat, lng]).addTo(map);
            marker.bindPopup("<b>{{ $selectedKnmp->nama }}</b><br>{{ $selectedKnmp->village->name ?? '' }}").openPopup();
        @else
            // Default Indonesia view
            var map = L.map('knmpMap').setView([-2.5, 118], 4);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);
            
            // Add marker at approximate location
            @if($selectedKnmp)
                var marker = L.marker([-2.5, 118]).addTo(map);
                marker.bindPopup("<b>{{ $selectedKnmp->nama }}</b><br>Koordinat belum tersedia");
            @endif
        @endif
    });
</script>
@endpush