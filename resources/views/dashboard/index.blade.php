@extends('layouts.app')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <form class="d-flex"></form>
            </div>
            <h4 class="page-title">Dashboard</h4>
        </div>
    </div>
</div>
<!-- end page title -->

{{-- Statistic Cards - Baris 1 --}}
<div class="row">
    <div class="col-lg-4">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end"><i class="mdi mdi-map-marker-radius widget-icon"></i></div>
                <h5 class="text-muted fw-normal mt-0">Total Lokasi KNMP</h5>
                <h3 class="mt-3 mb-3">65</h3>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end"><i class="mdi mdi-clipboard-text-search widget-icon"></i></div>
                <h5 class="text-muted fw-normal mt-0">Total Survey</h5>
                <h3 class="mt-3 mb-3">{{ number_format($totalSurveyTerisi, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end"><i class="mdi mdi-database-check widget-icon"></i></div>
                <h5 class="text-muted fw-normal mt-0">Tingkat Kelengkapan Data</h5>
                <h3 class="mt-3 mb-3">{{ number_format($tingkatKelengkapanData, 2, ',', '.') }}%</h3>
            </div>
        </div>
    </div>
</div>

{{-- Statistic Cards - Baris 2 --}}
<div class="row mt-3">
    <div class="col-lg-4">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end"><i class="mdi mdi-bullseye-arrow widget-icon"></i></div>
                <h5 class="text-muted fw-normal mt-0">Rata-rata Capaian Indikator</h5>
                <h3 class="mt-3 mb-3">{{ number_format($capaianIndikator, 2, ',', '.') }}%</h3>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end"><i class="mdi mdi-emoticon-happy widget-icon"></i></div>
                <h5 class="text-muted fw-normal mt-0">Rata-rata Indeks Kebahagiaan</h5>
                <h3 class="mt-3 mb-3">{{ number_format($rataRataKebahagiaan, 2, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="float-end"><i class="mdi mdi-home-group-plus widget-icon"></i></div>
                <h5 class="text-muted fw-normal mt-0">Desa dengan Aset Bertambah</h5>
                <h3 class="mt-3 mb-3">{{ number_format($desaAsetBertambah, 0, ',', '.') }}</h3>
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

    desaKNMP.forEach(function(item) {
        if (item.latitude !== null && item.longitude !== null) {

            L.marker([item.latitude, item.longitude], {
                    icon: redIcon
                })
                .addTo(map)
                .bindPopup(
                    "<b>" + (item.nama ?? "Lokasi KNMP " + item.id) + "</b><br>" +
                    "Lat: " + item.latitude + "<br>" +
                    "Lng: " + item.longitude
                );
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

@endpush