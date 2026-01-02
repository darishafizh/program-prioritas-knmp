@extends('layouts.app')

@section('content')

{{-- ===================================================== --}}
{{-- AUTO ERROR ALERT (VALIDATION FAILS) --}}
{{-- ===================================================== --}}
@if ($errors->any() && !session('error'))
@php(session()->flash('error', 'Lengkapi semua form!'))
@endif



{{-- ===================================================== --}}
{{-- ðŸ”” GLOBAL ALERT --}}
@if(session('success') || session('error'))
    <div id="customAlert" class="alert-overlay">
        <div class="alert-card {{ session('success') ? 'success' : 'error' }}">

            {{-- Icon --}}
            <div class="alert-icon-circle">
                @if(session('success'))
                    <span class="alert-icon">âœ“</span>
                @else
                    <span class="alert-icon">âœ•</span>
                @endif
            </div>

            {{-- Title --}}
            <h3 class="alert-title">
                {{ session('success') ? 'Success!' : 'Failed!' }}
            </h3>

            {{-- Message --}}
            <p class="alert-subtitle">
                {{ session('success') ? session('success') : session('error') }}
            </p>

            {{-- Progress Bar --}}
            <div class="alert-progress">
                <div class="alert-progress-bar"></div>
            </div>

            {{-- Button --}}
            <button class="alert-btn" id="alertCloseBtn">
                {{ session('success') ? 'DONE' : 'TRY AGAIN' }}
            </button>

        </div>
    </div>
@endif



<script>
    document.addEventListener("DOMContentLoaded", function () {

        const overlay = document.getElementById("customAlert");
        if (!overlay) return;

        const btn = document.getElementById("alertCloseBtn");

        // Show overlay
        setTimeout(() => overlay.classList.add("show"), 10);

        // Close if button exists
        if (btn) {
            btn.addEventListener("click", () => {
                overlay.classList.remove("show");
                setTimeout(() => overlay.remove(), 300);
            });
        }

        // Auto close
        setTimeout(() => {
            overlay.classList.remove("show");
            setTimeout(() => overlay.remove(), 250);
        }, 2600);
    });
</script>


<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}"><i
                                    class="mdi mdi-home-outline"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ url('/survey') }}">Survey</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kuesioner KNMP</li>
                    </ol>
                </nav>
            </div>
            <h4 class="page-title"><i class="mdi mdi-clipboard-text-outline me-2"></i>Kuesioner KNMP</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<!-- KNMP Info Card -->
<div class="row">
    <div class="col-12">
        <div class="card survey-header-card">
            <!-- Card Header with Gradient -->
            <div class="card-header survey-card-header border-0">
                <div class="d-flex align-items-center">
                    <div class="survey-header-icon">
                        <i class="mdi mdi-anchor"></i>
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-1 text-white fw-bold">{{ $knmp->nama ?? 'Nama KNMP Tidak Ditemukan' }}</h4>
                        <p class="mb-0 text-white-50 small"><i class="mdi mdi-map-marker me-1"></i>Kawasan Nelayan
                            Modern Perkotaan</p>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row g-4">
                    <!-- Location Info -->
                    <div class="col-lg-5 col-md-12">
                        <div class="location-info-card">
                            <div class="location-header mb-3">
                                <i class="mdi mdi-map-marker-radius text-primary me-2"></i>
                                <span class="fw-semibold text-dark">Informasi Lokasi</span>
                            </div>
                            <div class="location-grid">
                                <div class="location-item">
                                    <div class="location-label">
                                        <i class="mdi mdi-home-city-outline text-muted me-2"></i>
                                        <span class="text-muted">Desa</span>
                                    </div>
                                    <div class="location-value">
                                        <span
                                            class="badge bg-soft-primary text-primary rounded-pill px-3">{{ $knmp->village->name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="location-item">
                                    <div class="location-label">
                                        <i class="mdi mdi-map-outline text-muted me-2"></i>
                                        <span class="text-muted">Kecamatan</span>
                                    </div>
                                    <div class="location-value">
                                        <span
                                            class="badge bg-soft-info text-info rounded-pill px-3">{{ $knmp->district->name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="location-item">
                                    <div class="location-label">
                                        <i class="mdi mdi-city-variant-outline text-muted me-2"></i>
                                        <span class="text-muted">Kabupaten</span>
                                    </div>
                                    <div class="location-value">
                                        <span
                                            class="badge bg-soft-success text-success rounded-pill px-3">{{ $knmp->regency->name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="location-item">
                                    <div class="location-label">
                                        <i class="mdi mdi-map-marker-multiple-outline text-muted me-2"></i>
                                        <span class="text-muted">Provinsi</span>
                                    </div>
                                    <div class="location-value">
                                        <span
                                            class="badge bg-soft-warning text-warning rounded-pill px-3">{{ $knmp->province->name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Section -->
                    <div class="col-lg-7 col-md-12">
                        <div class="progress-info-card h-100">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="progress-icon-wrapper">
                                        <i class="mdi mdi-chart-arc"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0 fw-semibold text-dark">Progres Pembangunan KNMP</h5>
                                        <small class="text-muted">Status penyelesaian keseluruhan</small>
                                    </div>
                                </div>
                                <div class="progress-percentage">
                                    <span class="display-6 fw-bold text-primary">{{ $rataRataProgres }}</span>
                                    <span class="text-muted">%</span>
                                </div>
                            </div>

                            <div class="progress-wrapper">
                                <div class="progress progress-lg">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-gradient-primary"
                                        role="progressbar" style="width: {{ $rataRataProgres }}%"
                                        aria-valuenow="{{ $rataRataProgres }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <div class="progress-milestones mt-2">
                                    <span class="milestone {{ $rataRataProgres >= 0 ? 'active' : '' }}">0%</span>
                                    <span class="milestone {{ $rataRataProgres >= 25 ? 'active' : '' }}">25%</span>
                                    <span class="milestone {{ $rataRataProgres >= 50 ? 'active' : '' }}">50%</span>
                                    <span class="milestone {{ $rataRataProgres >= 75 ? 'active' : '' }}">75%</span>
                                    <span class="milestone {{ $rataRataProgres >= 100 ? 'active' : '' }}">100%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Survey Sections Accordion -->
<div class="row mb-4">
    <div class="col-12">
        <div class="survey-sections-wrapper">
            <div class="section-list-header mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="mdi mdi-format-list-bulleted-square text-primary me-2 fs-4"></i>
                        <h5 class="mb-0 fw-semibold">Bagian Kuesioner</h5>
                    </div>
                    <span class="badge bg-soft-primary text-primary rounded-pill px-3">10 Bagian</span>
                </div>
            </div>

            <div class="accordion survey-accordion" id="accordionExample">

                <!-- A. Profil KNMP -->
                <div class="accordion-item survey-accordion-item">
                    <h2 class="accordion-header" id="headingA">
                        <button class="accordion-button collapsed survey-accordion-btn" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseA" aria-expanded="false"
                            aria-controls="collapseA">
                            <div class="survey-section-indicator bg-primary">A</div>
                            <div class="survey-section-icon text-primary">
                                <i class="mdi mdi-account-card-details-outline"></i>
                            </div>
                            <div class="survey-section-content">
                                <span class="survey-section-title">Profil KNMP</span>
                                <span class="survey-section-desc">Data identitas kawasan nelayan</span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapseA" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body survey-accordion-body">
                            @include('survey.forms.form_layouts.profile_knmp')
                        </div>
                    </div>
                </div>

                <!-- B. Proses Pembangunan KNMP -->
                <div class="accordion-item survey-accordion-item">
                    <h2 class="accordion-header" id="headingB">
                        <button class="accordion-button collapsed survey-accordion-btn" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseB" aria-expanded="false"
                            aria-controls="collapseB">
                            <div class="survey-section-indicator bg-info">B</div>
                            <div class="survey-section-icon text-info">
                                <i class="mdi mdi-progress-wrench"></i>
                            </div>
                            <div class="survey-section-content">
                                <span class="survey-section-title">Proses Pembangunan KNMP</span>
                                <span class="survey-section-desc">Informasi progres pembangunan</span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapseB" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body survey-accordion-body">
                            @include('survey.forms.form_layouts.progres_pembangunan_knmp')
                        </div>
                    </div>
                </div>

                <!-- C. Tanggapan Masyarakat -->
                <div class="accordion-item survey-accordion-item">
                    <h2 class="accordion-header" id="headingC">
                        <button class="accordion-button collapsed survey-accordion-btn" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseC" aria-expanded="false"
                            aria-controls="collapseC">
                            <div class="survey-section-indicator bg-success">C</div>
                            <div class="survey-section-icon text-success">
                                <i class="mdi mdi-account-group-outline"></i>
                            </div>
                            <div class="survey-section-content">
                                <span class="survey-section-title">Tanggapan Masyarakat</span>
                                <span class="survey-section-desc">Terkait pembangunan KNMP</span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapseC" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body survey-accordion-body">
                            @include('survey.forms.form_layouts.tanggapan_masyarakat')
                        </div>
                    </div>
                </div>

                <!-- D. Tingkat Kebahagiaan Nelayan -->
                <div class="accordion-item survey-accordion-item">
                    <h2 class="accordion-header" id="headingD">
                        <button class="accordion-button collapsed survey-accordion-btn" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseD" aria-expanded="false"
                            aria-controls="collapseD">
                            <div class="survey-section-indicator bg-warning">D</div>
                            <div class="survey-section-icon text-warning">
                                <i class="mdi mdi-emoticon-happy-outline"></i>
                            </div>
                            <div class="survey-section-content">
                                <span class="survey-section-title">Tingkat Kebahagiaan Nelayan</span>
                                <span class="survey-section-desc">Survei kesejahteraan nelayan</span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapseD" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body survey-accordion-body">
                            @include('survey.forms.form_layouts.tingkat_kebahagiaan_nelayan')
                        </div>
                    </div>
                </div>

                <!-- E. Informasi Responden -->
                <div class="accordion-item survey-accordion-item">
                    <h2 class="accordion-header" id="headingE">
                        <button class="accordion-button collapsed survey-accordion-btn" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseE" aria-expanded="false"
                            aria-controls="collapseE">
                            <div class="survey-section-indicator bg-danger">E</div>
                            <div class="survey-section-icon text-danger">
                                <i class="mdi mdi-account-outline"></i>
                            </div>
                            <div class="survey-section-content">
                                <span class="survey-section-title">Informasi Responden</span>
                                <span class="survey-section-desc">Data pribadi responden</span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapseE" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body survey-accordion-body">
                            @include('survey.forms.form_layouts.informasi_responden')
                        </div>
                    </div>
                </div>

                <!-- F. Informasi Usaha -->
                <div class="accordion-item survey-accordion-item">
                    <h2 class="accordion-header" id="headingF">
                        <button class="accordion-button collapsed survey-accordion-btn" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseF" aria-expanded="false"
                            aria-controls="collapseF">
                            <div class="survey-section-indicator bg-secondary">F</div>
                            <div class="survey-section-icon text-secondary">
                                <i class="mdi mdi-store-outline"></i>
                            </div>
                            <div class="survey-section-content">
                                <span class="survey-section-title">Informasi Usaha</span>
                                <span class="survey-section-desc">Kondisi existing usaha</span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapseF" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body survey-accordion-body">
                            @include('survey.forms.form_layouts.informasi_usaha')
                        </div>
                    </div>
                </div>

                <!-- G. Informasi Pemasaran -->
                <div class="accordion-item survey-accordion-item">
                    <h2 class="accordion-header" id="headingG">
                        <button class="accordion-button collapsed survey-accordion-btn" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseG" aria-expanded="false"
                            aria-controls="collapseG">
                            <div class="survey-section-indicator" style="background-color: #6f42c1;">G</div>
                            <div class="survey-section-icon" style="color: #6f42c1;">
                                <i class="mdi mdi-fish"></i>
                            </div>
                            <div class="survey-section-content">
                                <span class="survey-section-title">Informasi Pemasaran Hasil Perikanan</span>
                                <span class="survey-section-desc">Data distribusi dan penjualan</span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapseG" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body survey-accordion-body">
                            @include('survey.forms.form_layouts.informasi_pemasaran_hasil_perikanan')
                        </div>
                    </div>
                </div>

                <!-- H. Informasi Pendapatan -->
                <div class="accordion-item survey-accordion-item">
                    <h2 class="accordion-header" id="headingH">
                        <button class="accordion-button collapsed survey-accordion-btn" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseH" aria-expanded="false"
                            aria-controls="collapseH">
                            <div class="survey-section-indicator" style="background-color: #20c997;">H</div>
                            <div class="survey-section-icon" style="color: #20c997;">
                                <i class="mdi mdi-cash-multiple"></i>
                            </div>
                            <div class="survey-section-content">
                                <span class="survey-section-title">Informasi Pendapatan Rumah Tangga</span>
                                <span class="survey-section-desc">Data ekonomi keluarga</span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapseH" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body survey-accordion-body">
                            @include('survey.forms.form_layouts.informasi_pendapatan_rumah_tangga')
                        </div>
                    </div>
                </div>

                <!-- I. Sosial dan Kelembagaan -->
                <div class="accordion-item survey-accordion-item">
                    <h2 class="accordion-header" id="headingI">
                        <button class="accordion-button collapsed survey-accordion-btn" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseI" aria-expanded="false"
                            aria-controls="collapseI">
                            <div class="survey-section-indicator" style="background-color: #e83e8c;">I</div>
                            <div class="survey-section-icon" style="color: #e83e8c;">
                                <i class="mdi mdi-account-multiple-outline"></i>
                            </div>
                            <div class="survey-section-content">
                                <span class="survey-section-title">Sosial dan Kelembagaan</span>
                                <span class="survey-section-desc">Struktur organisasi masyarakat</span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapseI" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body survey-accordion-body">
                            @include('survey.forms.form_layouts.sosial_dan_kelembagaan')
                        </div>
                    </div>
                </div>

                <!-- J. Bukti Pendukung -->
                <div class="accordion-item survey-accordion-item">
                    <h2 class="accordion-header" id="headingJ">
                        <button class="accordion-button collapsed survey-accordion-btn" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseJ" aria-expanded="false"
                            aria-controls="collapseJ">
                            <div class="survey-section-indicator" style="background-color: #fd7e14;">J</div>
                            <div class="survey-section-icon" style="color: #fd7e14;">
                                <i class="mdi mdi-file-document-multiple-outline"></i>
                            </div>
                            <div class="survey-section-content">
                                <span class="survey-section-title">Bukti Pendukung</span>
                                <span class="survey-section-desc">Upload dokumen dan foto</span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapseJ" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body survey-accordion-body">
                            {{-- UPLOAD ZONE --}}
                            <form action="{{ route('survey.forms.store_bukti_upload') }}" method="POST"
                                enctype="multipart/form-data" id="uploadForm">
                                @csrf
                                <input type="hidden" name="knmp_id" value="{{ $knmp->id }}">

                                <div class="upload-zone" id="uploadZone">
                                    <i class="mdi mdi-cloud-upload upload-icon"></i>
                                    <h5 class="text-primary fw-bold mb-2">Upload Bukti Pendukung</h5>
                                    <p class="text-muted mb-3">Drag & drop file atau klik untuk memilih</p>
                                    <p class="text-muted small mb-0">Format: JPG, PNG, PDF (Maks. 10MB)</p>
                                    <input type="file" name="file" id="fileInput" class="d-none" accept="image/*,.pdf"
                                        required>
                                </div>

                                {{-- PREVIEW FILE (SEBELUM UPLOAD) --}}
                                <div id="preview-container" class="mt-3 d-none">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0 fw-bold">
                                                    <i class="mdi mdi-image-multiple me-2 text-primary"></i>Preview File
                                                </h6>
                                                <div>
                                                    <button type="submit" class="btn btn-primary btn-sm px-3">
                                                        <i class="mdi mdi-upload me-1"></i>Upload
                                                    </button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm ms-2"
                                                        onclick="clearPreview()">
                                                        <i class="mdi mdi-close me-1"></i>Batal
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="preview-wrapper" id="preview-wrapper">
                                                {{-- Preview items akan ditambahkan secara dinamis --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let errorSection = "{{ old('active_section') ?? 'collapseOne' }}";
                let el = document.getElementById(errorSection);
                if (el) {
                    new bootstrap.Collapse(el, {
                        show: true
                    });
                }
            });
        </script>
    @endif

    <style>
        /* ================================================= */
        /* SURVEY HEADER CARD STYLES */
        /* ================================================= */
        .survey-header-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
        }

        .survey-card-header {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            padding: 1.5rem;
        }

        .survey-header-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .survey-header-icon i {
            font-size: 28px;
            color: #fff;
        }

        /* ================================================= */
        /* LOCATION INFO STYLES */
        /* ================================================= */
        .location-info-card {
            background: linear-gradient(145deg, #f8fafc, #f1f5f9);
            border-radius: 12px;
            padding: 1.25rem;
            height: 100%;
        }

        .location-header {
            display: flex;
            align-items: center;
            font-size: 0.95rem;
        }

        .location-grid {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .location-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px dashed #e2e8f0;
        }

        .location-item:last-child {
            border-bottom: none;
        }

        .location-label {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
        }

        .location-value .badge {
            font-weight: 500;
            font-size: 0.8rem;
        }

        /* ================================================= */
        /* PROGRESS INFO STYLES */
        /* ================================================= */
        .progress-info-card {
            background: linear-gradient(145deg, #f8fafc, #f1f5f9);
            border-radius: 12px;
            padding: 1.25rem;
        }

        .progress-icon-wrapper {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .progress-icon-wrapper i {
            font-size: 24px;
            color: #fff;
        }

        .progress-percentage {
            text-align: right;
        }

        .progress-wrapper .progress {
            height: 12px;
            border-radius: 6px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .bg-gradient-primary {
            background: linear-gradient(90deg, #3b82f6 0%, #1e40af 100%) !important;
        }

        .progress-milestones {
            display: flex;
            justify-content: space-between;
        }

        .progress-milestones .milestone {
            font-size: 0.75rem;
            color: #94a3b8;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .progress-milestones .milestone.active {
            color: #3b82f6;
            font-weight: 600;
        }

        /* ================================================= */
        /* SURVEY ACCORDION STYLES */
        /* ================================================= */
        .survey-sections-wrapper {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.06);
        }

        .survey-accordion {
            border: none !important;
        }

        .survey-accordion-item {
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            margin-bottom: 0.75rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .survey-accordion-item:hover {
            border-color: #cbd5e1 !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .survey-accordion-btn {
            background: #fff !important;
            padding: 1rem 1.25rem !important;
            display: flex !important;
            align-items: center !important;
            gap: 1rem;
            box-shadow: none !important;
        }

        .survey-accordion-btn:not(.collapsed) {
            background: linear-gradient(145deg, #f8fafc, #ffffff) !important;
        }

        .survey-accordion-btn::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%236b7280'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e") !important;
            width: 1rem;
            height: 1rem;
            flex-shrink: 0;
            margin-left: auto;
        }

        .survey-section-indicator {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            color: #fff;
            flex-shrink: 0;
        }

        .survey-section-icon {
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.03);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .survey-section-icon i {
            font-size: 20px;
        }

        .survey-section-content {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .survey-section-title {
            font-weight: 600;
            font-size: 0.95rem;
            color: #1e293b;
        }

        .survey-section-desc {
            font-size: 0.8rem;
            color: #64748b;
        }

        .survey-accordion-body {
            padding: 1.5rem;
            background: #fcfcfd;
            border-top: 1px solid #e2e8f0;
        }

        /* ================================================= */
        /* UPLOAD ZONE STYLES */
        /* ================================================= */
        .upload-zone {
            border: 2px dashed #3b82f6;
            border-radius: 16px;
            padding: 50px 40px;
            text-align: center;
            background: linear-gradient(145deg, #f0f7ff, #e8f2ff);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .upload-zone:hover {
            border-color: #1e40af;
            background: linear-gradient(145deg, #e8f2ff, #dbeafe);
            transform: translateY(-2px);
        }

        .upload-zone.dragover {
            border-color: #10b981;
            background: linear-gradient(145deg, #ecfdf5, #d1fae5);
        }

        .upload-icon {
            font-size: 64px;
            color: #3b82f6;
            margin-bottom: 15px;
            display: block;
        }

        /* ================================================= */
        /* PREVIEW WRAPPER STYLES */
        /* ================================================= */
        .preview-wrapper {
            display: flex;
            flex-wrap: nowrap;
            gap: 15px;
            overflow-x: auto;
            padding: 10px 0;
        }

        .preview-wrapper::-webkit-scrollbar {
            height: 6px;
        }

        .preview-wrapper::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .preview-wrapper::-webkit-scrollbar-thumb {
            background: linear-gradient(90deg, #3b82f6, #1e40af);
            border-radius: 3px;
        }

        .preview-item {
            flex: 0 0 auto;
            min-width: 200px;
            max-width: 250px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .preview-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .preview-item .preview-thumb {
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            overflow: hidden;
        }

        .preview-item .preview-thumb img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .preview-item .preview-thumb .pdf-preview {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-item .preview-thumb .pdf-preview i {
            font-size: 50px;
            color: #fff;
        }

        .preview-item .preview-details {
            padding: 12px;
        }

        .preview-item .preview-details .file-name {
            font-weight: 600;
            font-size: 13px;
            color: #1e293b;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .preview-item .preview-details .file-size {
            font-size: 11px;
            color: #64748b;
            margin-bottom: 0;
        }

        /* ================================================= */
        /* RESPONSIVE ADJUSTMENTS */
        /* ================================================= */
        @media (max-width: 768px) {
            .survey-card-header {
                padding: 1rem;
            }

            .survey-header-icon {
                width: 48px;
                height: 48px;
            }

            .survey-header-icon i {
                font-size: 22px;
            }

            .survey-accordion-btn {
                padding: 0.875rem 1rem !important;
                gap: 0.75rem;
            }

            .survey-section-indicator {
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }

            .survey-section-icon {
                display: none;
            }

            .survey-section-title {
                font-size: 0.875rem;
            }

            .survey-section-desc {
                font-size: 0.75rem;
            }
        }

        /* =============================== */
        /* FIX BREADCRUMB POSITION */
        /* =============================== */
        .page-title-right {
            margin-bottom: 0.35rem;
            /* beri jarak ke judul */
        }

        .page-title-right .breadcrumb {
            margin-top: -6px;
            /* naikkan breadcrumb */
        }
    </style>

    <script>
        // ==================================
        // UPLOAD ZONE HANDLERS
        // ==================================
        const uploadZone = document.getElementById('uploadZone');
        const fileInput = document.getElementById('fileInput');

        if (uploadZone) {
            // Drag & Drop
            uploadZone.addEventListener('click', () => {
                fileInput.click();
            });
            uploadZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadZone.classList.add('dragover');
            });

            uploadZone.addEventListener('dragleave', () => {
                uploadZone.classList.remove('dragover');
            });

            uploadZone.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadZone.classList.remove('dragover');
                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    previewFile(fileInput);
                }
            });

            fileInput.addEventListener('change', function () {
                previewFile(this);
            });
        }

        // ==================================
        // PREVIEW FUNCTIONS
        // ==================================
        function previewFile(input) {
            const file = input.files[0];
            const previewContainer = document.getElementById('preview-container');
            const previewWrapper = document.getElementById('preview-wrapper');

            if (!file) {
                previewContainer.classList.add('d-none');
                return;
            }

            previewContainer.classList.remove('d-none');
            previewWrapper.innerHTML = '';

            // Create preview item
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item';

            const fileSize = (file.size / 1024).toFixed(1) + ' KB';
            const fileName = file.name.length > 20 ? file.name.substring(0, 17) + '...' : file.name;

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewItem.innerHTML = `
                    <div class="preview-thumb">
                        <img src="${e.target.result}" alt="${file.name}">
                    </div>
                    <div class="preview-details">
                        <p class="file-name" title="${file.name}">${fileName}</p>
                        <p class="file-size"><i class="mdi mdi-file-outline me-1"></i>${fileSize}</p>
                    </div>
                `;
                };
                reader.readAsDataURL(file);
            } else if (file.type === 'application/pdf') {
                previewItem.innerHTML = `
                <div class="preview-thumb">
                    <div class="pdf-preview">
                        <i class="mdi mdi-file-pdf-box"></i>
                    </div>
                </div>
                <div class="preview-details">
                    <p class="file-name" title="${file.name}">${fileName}</p>
                    <p class="file-size"><i class="mdi mdi-file-outline me-1"></i>${fileSize}</p>
                </div>
            `;
            }

            previewWrapper.appendChild(previewItem);
        }

        function clearPreview() {
            document.getElementById('fileInput').value = '';
            document.getElementById('preview-container').classList.add('d-none');
            document.getElementById('preview-wrapper').innerHTML = '';
        }
    </script>

    @endsection