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
                <form class="d-flex">
                </form>
            </div>
            <h4 class="page-title">Kuesioner KNMP</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">{{ $knmp->nama ?? 'Nama KNMP Tidak Ditemukan' }}</h4>

                <div class="row">
                    <div class="col-5">
                        <div class="row">
                            <div class="col-3">
                                <p class="mb-0 fw-bold">Desa</p>
                                <p class="mb-0 fw-bold">Kecamatan</p>
                                <p class="mb-0 fw-bold">Kabupaten</p>
                                <p class="mb-0 fw-bold">Provinsi</p>
                            </div>

                            <div class="col-1">
                                <p class="mb-0"><span class="fw-bold me-2">:</span></p>
                                <p class="mb-0"><span class="fw-bold me-2">:</span></p>
                                <p class="mb-0"><span class="fw-bold me-2">:</span></p>
                                <p class="mb-0"><span class="fw-bold me-2">:</span></p>
                            </div>

                            <div class="col-8">
                                <p class="mb-0">{{ $knmp->village->name ?? 'N/A' }}</p>
                                <p class="mb-0">{{ $knmp->district->name ?? 'N/A' }}</p>
                                <p class="mb-0">{{ $knmp->regency->name ?? 'N/A' }}</p>
                                <p class="mb-0">{{ $knmp->province->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-progress-wrench widget-icon bg-primary-lighten text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h5 class="my-0 fw-semibold">Progres Pembangunan KNMP</h5>
                                </div>
                                <h5 class="my-0">{{ $rataRataProgres }}%</h5>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $rataRataProgres }}%"
                                    aria-valuenow="{{ $rataRataProgres }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $rataRataProgres }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="accordion" id="accordionExample">

            <!-- A -->
            <div class="card mb-0">
                <div class="card-header" id="headingA">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-0">
                            <a class="custom-accordion-title d-block pt-2 pb-2" data-bs-toggle="collapse"
                                href="#collapseA" aria-expanded="false" aria-controls="collapseA">
                                A. Profil KNMP
                            </a>
                        </h5>
                    </div>
                </div>
                <div id="collapseA" class="collapse" data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.profile_knmp')
                    </div>
                </div>
            </div>

            <!-- B -->
            <div class="card mb-0">
                <div class="card-header" id="headingB">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-0">
                            <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                                href="#collapseB" aria-expanded="false" aria-controls="collapseB">
                                B. Proses Pembangunan KNMP
                            </a>
                        </h5>
                    </div>
                </div>
                <div id="collapseB" class="collapse" data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.progres_pembangunan_knmp')
                    </div>
                </div>
            </div>

            <!-- C -->
            <div class="card mb-0">
                <div class="card-header" id="headingC">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-0">
                            <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                                href="#collapseC" aria-expanded="false" aria-controls="collapseC">
                                C. Tanggapan Masyarakat Terkait Pembangunan KNMP
                            </a>
                        </h5>
                    </div>
                </div>
                <div id="collapseC" class="collapse" data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.tanggapan_masyarakat')
                    </div>
                </div>
            </div>

            <!-- D -->
            <div class="card mb-0">
                <div class="card-header" id="headingD">
                    <h5 class="m-0">
                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                            href="#collapseD" aria-expanded="false" aria-controls="collapseD">
                            D. Tingkat Kebahagiaan Nelayan
                        </a>
                    </h5>
                </div>
                <div id="collapseD" class="collapse" data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.tingkat_kebahagiaan_nelayan')
                    </div>
                </div>
            </div>

            <!-- E -->
            <div class="card mb-0">
                <div class="card-header" id="headingE">
                    <h5 class="m-0">
                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                            href="#collapseE" aria-expanded="false" aria-controls="collapseE">
                            E. Informasi Responden
                        </a>
                    </h5>
                </div>
                <div id="collapseE" class="collapse" data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.informasi_responden')
                    </div>
                </div>
            </div>

            <!-- F -->
            <div class="card mb-0">
                <div class="card-header" id="headingF">
                    <h5 class="m-0">
                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                            href="#collapseF" aria-expanded="false" aria-controls="collapseF">
                            F. Informasi Usaha (Kondisi Existing)
                        </a>
                    </h5>
                </div>
                <div id="collapseF" class="collapse" data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.informasi_usaha')
                    </div>
                </div>
            </div>

            <!-- G -->
            <div class="card mb-0">
                <div class="card-header" id="headingG">
                    <h5 class="m-0">
                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                            href="#collapseG" aria-expanded="false" aria-controls="collapseG">
                            G. Informasi Pemasaran Hasil Perikanan
                        </a>
                    </h5>
                </div>
                <div id="collapseG" class="collapse" data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.informasi_pemasaran_hasil_perikanan')
                    </div>
                </div>
            </div>

            <!-- H -->
            <div class="card mb-0">
                <div class="card-header" id="headingH">
                    <h5 class="m-0">
                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                            href="#collapseH" aria-expanded="false" aria-controls="collapseH">
                            H. Informasi Pendapatan Rumah Tangga
                        </a>
                    </h5>
                </div>
                <div id="collapseH" class="collapse" data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.informasi_pendapatan_rumah_tangga')
                    </div>
                </div>
            </div>

            <!-- I -->
            <div class="card mb-0">
                <div class="card-header" id="headingI">
                    <h5 class="m-0">
                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                            href="#collapseI" aria-expanded="false" aria-controls="collapseI">
                            I. Sosial dan Kelembagaan
                        </a>
                    </h5>
                </div>
                <div id="collapseI" class="collapse" data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.sosial_dan_kelembagaan')
                    </div>
                </div>
            </div>

            <!-- J -->
            <div class="card mb-0">
                <div class="card-header" id="headingJ">
                    <h5 class="m-0">
                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                            href="#collapseJ" aria-expanded="false" aria-controls="collapseJ">
                            J. Bukti Pendukung
                        </a>
                    </h5>
                </div>
                <div id="collapseJ" class="collapse" data-bs-parent="#accordionExample">
                    <div class="card-body">
                        {{-- UPLOAD ZONE --}}
                        <form action="{{ route('forms.store_bukti_upload') }}" method="POST"
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
    .upload-zone {
        border: 2px dashed #667eea;
        border-radius: 12px;
        padding: 40px;
        text-align: center;
        background: linear-gradient(145deg, #f8f9ff, #eef1ff);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .upload-zone:hover {
        border-color: #764ba2;
        background: linear-gradient(145deg, #eef1ff, #e8edff);
    }

    .upload-zone.dragover {
        border-color: #28a745;
        background: linear-gradient(145deg, #e8fff0, #d4f5e0);
    }

    .upload-icon {
        font-size: 60px;
        color: #667eea;
        margin-bottom: 15px;
    }

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
        background: #f1f1f1;
        border-radius: 3px;
    }

    .preview-wrapper::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 3px;
    }

    .preview-item {
        flex: 0 0 auto;
        min-width: 200px;
        max-width: 250px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .preview-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }

    .preview-item .preview-thumb {
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        overflow: hidden;
    }

    .preview-item .preview-thumb img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .preview-item .preview-thumb .pdf-preview {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
        color: #333;
        margin-bottom: 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .preview-item .preview-details .file-size {
        font-size: 11px;
        color: #888;
        margin-bottom: 0;
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