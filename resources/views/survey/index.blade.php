@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <h4 class="page-title">Survey KNMP</h4>
                    <p class="text-muted mb-0" style="font-size: 0.875rem;">
                        Daftar Kampung Nelayan Merah Putih (KNMP) yang menjadi target survei.
                    </p>
                </div>
                <div class="page-title-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Survey KNMP</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="mdi mdi-alert-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="row">
                    <div class="col-4">
                        <label for="exampleInputEmail1" class="form-label">Pilih Provinsi</label>
                        <select class="form-control select2" data-toggle="select2">
                            <option>Select</option>
                            <optgroup label="Alaskan/Hawaiian Time Zone">
                                <option value="AK">Alaska</option>
                                <option value="HI">Hawaii</option>
                            </optgroup>
                            <optgroup label="Pacific Time Zone">
                                <option value="CA">California</option>
                                <option value="NV">Nevada</option>
                                <option value="OR">Oregon</option>
                                <option value="WA">Washington</option>
                            </optgroup>
                            <optgroup label="Mountain Time Zone">
                                <option value="AZ">Arizona</option>
                                <option value="CO">Colorado</option>
                                <option value="ID">Idaho</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NM">New Mexico</option>
                                <option value="ND">North Dakota</option>
                                <option value="UT">Utah</option>
                                <option value="WY">Wyoming</option>
                            </optgroup>
                            <optgroup label="Central Time Zone">
                                <option value="AL">Alabama</option>
                                <option value="AR">Arkansas</option>
                                <option value="IL">Illinois</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="OK">Oklahoma</option>
                                <option value="SD">South Dakota</option>
                                <option value="TX">Texas</option>
                                <option value="TN">Tennessee</option>
                                <option value="WI">Wisconsin</option>
                            </optgroup>
                            <optgroup label="Eastern Time Zone">
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="IN">Indiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="OH">Ohio</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WV">West Virginia</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="col-4">
                        <label for="exampleInputEmail1" class="form-label">Pilih Kabupaten</label>
                        <select class="form-control select2" data-toggle="select2">
                            <option>Select</option>
                            <optgroup label="Alaskan/Hawaiian Time Zone">
                                <option value="AK">Alaska</option>
                                <option value="HI">Hawaii</option>
                            </optgroup>
                            <optgroup label="Pacific Time Zone">
                                <option value="CA">California</option>
                                <option value="NV">Nevada</option>
                                <option value="OR">Oregon</option>
                                <option value="WA">Washington</option>
                            </optgroup>
                            <optgroup label="Mountain Time Zone">
                                <option value="AZ">Arizona</option>
                                <option value="CO">Colorado</option>
                                <option value="ID">Idaho</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NM">New Mexico</option>
                                <option value="ND">North Dakota</option>
                                <option value="UT">Utah</option>
                                <option value="WY">Wyoming</option>
                            </optgroup>
                            <optgroup label="Central Time Zone">
                                <option value="AL">Alabama</option>
                                <option value="AR">Arkansas</option>
                                <option value="IL">Illinois</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="OK">Oklahoma</option>
                                <option value="SD">South Dakota</option>
                                <option value="TX">Texas</option>
                                <option value="TN">Tennessee</option>
                                <option value="WI">Wisconsin</option>
                            </optgroup>
                            <optgroup label="Eastern Time Zone">
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="IN">Indiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="OH">Ohio</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WV">West Virginia</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="col-4 d-flex float-end justify-content-start">
                        <button type="button" class="btn btn-primary align-self-end">Filter</button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-sm-6">
                            <h4 class="header-title">Daftar Kuesioner KNMP</h4>
                            <p class="text-muted font-13 mb-0">
                                Kelola data detail kuesioner untuk setiap Kampung Nelayan.
                            </p>
                        </div>
                        @if(Auth::user()->isSuperAdmin())
                            <div class="col-sm-6 text-end">
                                <button type="button" class="btn btn-success me-2" data-bs-toggle="modal"
                                    data-bs-target="#importKnmpModal">
                                    <i class="mdi mdi-file-excel me-1"></i>Import Excel
                                </button>

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addKnmpModal">
                                    <i class="mdi mdi-plus me-1"></i>Tambah KNMP
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap">
                            <thead>
                                <tr>
                                    <th>Nama KNMP</th>
                                    <th>Desa</th>
                                    <th>Kecamatan</th>
                                    <th>Kabupaten</th>
                                    <th>Provinsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($knmps as $knmp)
                                    <tr>
                                        <td>{{ $knmp->nama ?? 'N/A' }}</td>
                                        <td>{{ $knmp->village->name ?? 'N/A' }}</td>
                                        <td>{{ $knmp->district->name ?? 'N/A' }}</td>
                                        <td>{{ $knmp->regency->name ?? 'N/A' }}</td>
                                        <td>{{ $knmp->province->name ?? 'N/A' }}</td>
                                        <td class="action-buttons">
                                            @if(Auth::user()->canInputData())
                                                <a href="{{ route('forms.index', $knmp->id) }}"
                                                    class="btn btn-action btn-action-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Input Survey">
                                                    <i class="mdi mdi-pencil-box"></i>
                                                </a>
                                                <a href="{{ route('forms.edit-responden', $knmp->id) }}"
                                                    class="btn btn-action btn-action-outline-success" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit Responden">
                                                    <i class="mdi mdi-account-edit"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('survey.questionnaires-pdf', $knmp->id) }}"
                                                class="btn btn-action btn-action-outline-danger" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Lihat PDF">
                                                <i class="mdi mdi-file-pdf-box"></i>
                                            </a>
                                            <button type="button" class="btn btn-action btn-action-outline-info"
                                                data-bs-toggle="modal" data-bs-target="#evidenceModal{{ $knmp->id }}"
                                                title="Image">
                                                <i class="mdi mdi-image"></i>
                                            </button>
                                            @if(Auth::user()->isSuperAdmin())
                                                <form action="{{ route('survey.destroy', $knmp->id) }}" method="POST"
                                                    class="d-inline delete-knmp-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-action btn-action-outline-danger btn-delete-knmp"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus KNMP"
                                                        data-knmp-name="{{ $knmp->nama }}">
                                                        <i class="mdi mdi-trash-can"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->

    <!-- Add KNMP Modal (Admin Only) -->
    @if(Auth::user()->isSuperAdmin())
        <div class="modal fade" id="addKnmpModal" tabindex="-1" aria-labelledby="addKnmpModalLabel" aria-hidden="true"
            style="z-index: 1055;">
            <div class="modal-dialog modal-dialog-centered" style="display: flex; justify-content: center; margin: auto;">
                <div class="modal-content"
                    style="border-radius: 16px; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.25);">
                    <form action="{{ route('survey.store') }}" method="POST" id="addKnmpForm" novalidate>
                        @csrf
                        <div class="modal-header"
                            style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); padding: 1.25rem 1.5rem; border: none;">
                            <div class="d-flex align-items-center">
                                <div
                                    style="width: 48px; height: 48px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="mdi mdi-map-marker-plus" style="font-size: 1.5rem; color: #fff;"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="modal-title mb-0 text-white" id="addKnmpModalLabel">Tambah KNMP</h5>
                                    <small style="color: rgba(255,255,255,0.7);">Tambah desa KNMP baru</small>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-medium">Nama KNMP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" placeholder="Masukkan nama KNMP" required
                                    autocomplete="off">
                                <div class="invalid-feedback">
                                    Nama KNMP wajib diisi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Provinsi <span class="text-danger">*</span></label>
                                <select class="form-select" name="province_id" id="addProvinceSelect" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Silakan pilih provinsi.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Kabupaten/Kota <span class="text-danger">*</span></label>
                                <select class="form-select" name="regency_id" id="addRegencySelect" required>
                                    <option value="">Pilih Kabupaten/Kota</option>
                                </select>
                                <div class="invalid-feedback">
                                    Silakan pilih kabupaten/kota.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Kecamatan <span class="text-danger">*</span></label>
                                <select class="form-select" name="district_id" id="addDistrictSelect" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                <div class="invalid-feedback">
                                    Silakan pilih kecamatan.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Desa <span class="text-danger">*</span></label>
                                <select class="form-select" name="village_id" id="addVillageSelect" required>
                                    <option value="">Pilih Desa</option>
                                </select>
                                <div class="invalid-feedback">
                                    Silakan pilih desa.
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center gap-2"
                            style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0; background: #f8fafc;">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-plus me-1"></i>Tambah KNMP
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Import KNMP Modal (Admin Only) -->
    @if(Auth::user()->isSuperAdmin())
        <div class="modal fade" id="importKnmpModal" tabindex="-1" aria-labelledby="importKnmpModalLabel" aria-hidden="true"
            style="z-index: 1055;">
            <div class="modal-dialog modal-dialog-centered" style="display: flex; justify-content: center; margin: auto;">
                <div class="modal-content"
                    style="border-radius: 16px; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.25);">
                    <form action="{{ route('survey.import') }}" method="POST" enctype="multipart/form-data" id="importKnmpForm">
                        @csrf
                        <div class="modal-header"
                            style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 1.25rem 1.5rem; border: none;">
                            <div class="d-flex align-items-center">
                                <div
                                    style="width: 48px; height: 48px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="mdi mdi-file-excel" style="font-size: 1.5rem; color: #fff;"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="modal-title mb-0 text-white" id="importKnmpModalLabel">Import KNMP</h5>
                                    <small style="color: rgba(255,255,255,0.7);">Import data KNMP dari file Excel</small>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="alert alert-info mb-3" style="border-radius: 10px;">
                                <i class="mdi mdi-information-outline me-1"></i>
                                <strong>Format file:</strong> Excel/CSV dengan kolom: <code>nama</code>, <code>provinsi</code>, <code>kabupaten</code>, <code>kecamatan</code>, <code>desa</code>, <code>latitude</code> (opsional), <code>longitude</code> (opsional)
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">File Excel/CSV <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="file" accept=".xlsx,.xls,.csv" required>
                                <div class="form-text">Format: .xlsx, .xls, atau .csv (Maks. 10MB)</div>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('survey.template') }}" class="btn btn-outline-success btn-sm">
                                    <i class="mdi mdi-download me-1"></i>Download Template
                                </a>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center gap-2"
                            style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0; background: #f8fafc;">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">
                                <i class="mdi mdi-upload me-1"></i>Import Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    @foreach ($knmps as $knmp)
        <div class="modal fade evidence-modal" id="evidenceModal{{ $knmp->id }}" tabindex="-1"
            aria-labelledby="evidenceModalLabel{{ $knmp->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content evidence-modal-content">
                    <div class="modal-header evidence-modal-header">
                        <div class="d-flex align-items-center">
                            <div class="evidence-header-icon">
                                <i class="mdi mdi-image-multiple"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="modal-title mb-0" id="evidenceModalLabel{{ $knmp->id }}">Evidence</h5>
                                <small class="text-white-50">{{ $knmp->nama }}</small>
                            </div>
                        </div>
                        <button type="button" class="evidence-close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="mdi mdi-close"></i>
                        </button>
                    </div>
                    <div class="modal-body evidence-modal-body">
                        @if($knmp->buktiUploads && $knmp->buktiUploads->count() > 0)
                            <div class="row g-3">
                                @foreach($knmp->buktiUploads as $bukti)
                                    <div class="col-6 col-md-4">
                                        @php
                                            $isImage = $bukti->tipe_file && str_starts_with($bukti->tipe_file, 'image/');
                                            $fileExists = \Illuminate\Support\Facades\Storage::disk('public')->exists($bukti->path_file);
                                            $imageUrl = $fileExists ? asset('storage/' . $bukti->path_file) : '';
                                        @endphp
                                        <div class="evidence-card" @if($fileExists)
                                            onclick="openImagePreview('{{ $imageUrl }}', '{{ $bukti->nama_file ?? 'Evidence' }}')"
                                        @endif>
                                            @if($isImage && $fileExists)
                                                <img src="{{ $imageUrl }}" alt="Evidence"
                                                    onerror="this.onerror=null; this.parentNode.innerHTML='<div class=\'evidence-placeholder\'><i class=\'mdi mdi-image-off-outline\'></i></div>';">
                                            @elseif($isImage && !$fileExists)
                                                <div class="evidence-placeholder">
                                                    <i class="mdi mdi-image-off-outline"></i>
                                                </div>
                                            @else
                                                <div class="evidence-pdf">
                                                    <i class="mdi mdi-file-pdf-box"></i>
                                                </div>
                                            @endif
                                            @if($fileExists)
                                                <div class="evidence-card-overlay">
                                                    <i class="mdi mdi-magnify-plus-outline"></i>
                                                </div>
                                            @endif
                                        </div>
                                        @if($bukti->nama_file)
                                            <p class="evidence-caption">{{ $bukti->nama_file }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="evidence-empty">
                                <div class="evidence-empty-icon">
                                    <i class="mdi mdi-image-off-outline"></i>
                                </div>
                                <h6>Belum Ada Evidence</h6>
                                <p>Silakan upload evidence terlebih dahulu</p>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer evidence-modal-footer">
                        @if(Auth::user()->canInputData())
                            <a href="{{ route('survey.evidence', $knmp->id) }}" class="btn btn-evidence-primary">
                                <i class="mdi mdi-open-in-new me-1"></i>Kelola Evidence
                            </a>
                        @endif
                        <button type="button" class="btn btn-evidence-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content preview-modal-content">
                <button type="button" class="preview-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="mdi mdi-close"></i>
                </button>
                <div class="modal-body p-0">
                    <img src="" id="previewImage" class="preview-image">
                    <p class="preview-caption" id="previewCaption"></p>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Evidence Modal Styles */
        .evidence-modal {
            z-index: 1060 !important;
        }

        .evidence-modal .modal-dialog {
            max-width: 600px;
            margin: 1.75rem auto;
            z-index: 1061;
        }

        .evidence-modal-content {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.25);
            z-index: 1062;
        }

        .evidence-modal-header {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            padding: 1.25rem 1.5rem;
            border: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .evidence-header-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .evidence-header-icon i {
            font-size: 1.5rem;
            color: #fff;
        }

        .evidence-close-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .evidence-close-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        .evidence-close-btn i {
            font-size: 1.25rem;
        }

        .evidence-modal-body {
            padding: 1.5rem;
            max-height: 400px;
            overflow-y: auto;
            background: #f8fafc;
        }

        .evidence-card {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .evidence-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .evidence-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
        }

        .evidence-pdf {
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        }

        .evidence-pdf i {
            font-size: 3rem;
            color: #dc2626;
        }

        .evidence-placeholder {
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        }

        .evidence-placeholder i {
            font-size: 3rem;
            color: #94a3b8;
        }

        .evidence-card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(59, 130, 246, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .evidence-card-overlay i {
            color: #fff;
            font-size: 2rem;
        }

        .evidence-card:hover .evidence-card-overlay {
            opacity: 1;
        }

        .evidence-caption {
            font-size: 0.75rem;
            color: #64748b;
            margin: 0.5rem 0 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .evidence-empty {
            text-align: center;
            padding: 3rem 1rem;
        }

        .evidence-empty-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .evidence-empty-icon i {
            font-size: 2.5rem;
            color: #94a3b8;
        }

        .evidence-empty h6 {
            color: #475569;
            margin-bottom: 0.5rem;
        }

        .evidence-empty p {
            color: #94a3b8;
            font-size: 0.875rem;
            margin: 0;
        }

        .evidence-modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e2e8f0;
            background: #fff;
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
        }

        .btn-evidence-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: #fff;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-evidence-primary:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .btn-evidence-secondary {
            background: #e2e8f0;
            color: #475569;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-evidence-secondary:hover {
            background: #cbd5e1;
        }

        /* Preview Modal Styles */
        .preview-modal-content {
            background: transparent !important;
            border: none;
        }

        .preview-close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.6);
            border: none;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.2s;
        }

        .preview-close-btn:hover {
            background: rgba(0, 0, 0, 0.8);
            transform: scale(1.1);
        }

        .preview-close-btn i {
            font-size: 1.5rem;
        }

        .preview-image {
            max-width: 100%;
            max-height: 85vh;
            display: block;
            margin: 0 auto;
            border-radius: 12px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.5);
        }

        .preview-caption {
            color: #fff;
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        #imagePreviewModal .modal-dialog {
            max-width: 90vw;
        }

        #imagePreviewModal {
            z-index: 1070 !important;
        }

        #imagePreviewModal .modal-backdrop {
            background: rgba(0, 0, 0, 0.9);
        }

        /* Custom Dialog Styles (matching edit-responden) */
        .custom-dialog-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .custom-dialog-overlay.show {
            display: flex;
        }

        .custom-dialog {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .custom-dialog-icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #fef3cd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
        }

        .custom-dialog-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .custom-dialog-message {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .custom-dialog-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .custom-dialog-btn {
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .custom-dialog-btn.cancel {
            background: #e5e7eb;
            color: #374151;
        }

        .custom-dialog-btn.confirm {
            background: #ef4444;
            color: #fff;
        }

        .custom-dialog-btn:hover {
            transform: translateY(-2px);
        }
    </style>

    <script>
        function openImagePreview(src, caption) {
            // Close the evidence modal first
            var evidenceModals = document.querySelectorAll('.evidence-modal.show');
            evidenceModals.forEach(function (modal) {
                var bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) bsModal.hide();
            });

            // Set image source and caption
            document.getElementById('previewImage').src = src;
            document.getElementById('previewCaption').textContent = caption;

            // Show preview modal after a short delay to allow evidence modal to close
            setTimeout(function () {
                var previewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
                previewModal.show();
            }, 300);
        }
    </script>

    <!-- Custom Dialog Overlay for Delete KNMP -->
    <div id="customDialogOverlay" class="custom-dialog-overlay">
        <div id="customDialog" class="custom-dialog warning">
            <div class="custom-dialog-icon-circle">
                <span id="dialogIcon">⚠</span>
            </div>
            <h3 class="custom-dialog-title" id="dialogTitle">Hapus KNMP?</h3>
            <p class="custom-dialog-message" id="dialogMessage">Apakah Anda yakin ingin menghapus KNMP ini?</p>
            <div class="custom-dialog-actions" id="dialogActions">
                <button type="button" class="custom-dialog-btn cancel" onclick="closeCustomDialog()">
                    Batal
                </button>
                <button type="button" class="custom-dialog-btn confirm" id="confirmDialogBtn">
                    Hapus
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            "use strict";
            $("#scroll-horizontal-datatable").DataTable({
                scrollX: true,
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    }
                },
                drawCallback: function () {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                }
            });
            $(".dataTables_length select").addClass("form-select form-select-sm");
            $(".dataTables_length label").addClass("form-label");

            // Cascade dropdown logic for Add KNMP Modal
            $('#addProvinceSelect').on('change', function () {
                var provinceId = $(this).val();
                var regencySelect = $('#addRegencySelect');
                var districtSelect = $('#addDistrictSelect');
                var villageSelect = $('#addVillageSelect');

                // Reset dependent dropdowns
                regencySelect.html('<option value="">Pilih Kabupaten/Kota</option>');
                districtSelect.html('<option value="">Pilih Kecamatan</option>');
                villageSelect.html('<option value="">Pilih Desa</option>');

                if (provinceId) {
                    $.get('/survey/locations/regencies/' + provinceId, function (data) {
                        data.forEach(function (regency) {
                            regencySelect.append('<option value="' + regency.id + '">' + regency.name + '</option>');
                        });
                    });
                }
            });

            $('#addRegencySelect').on('change', function () {
                var regencyId = $(this).val();
                var districtSelect = $('#addDistrictSelect');
                var villageSelect = $('#addVillageSelect');

                // Reset dependent dropdowns
                districtSelect.html('<option value="">Pilih Kecamatan</option>');
                villageSelect.html('<option value="">Pilih Desa</option>');

                if (regencyId) {
                    $.get('/survey/locations/districts/' + regencyId, function (data) {
                        data.forEach(function (district) {
                            districtSelect.append('<option value="' + district.id + '">' + district.name + '</option>');
                        });
                    });
                }
            });

            $('#addDistrictSelect').on('change', function () {
                var districtId = $(this).val();
                var villageSelect = $('#addVillageSelect');

                // Reset dependent dropdown
                villageSelect.html('<option value="">Pilih Desa</option>');

                if (districtId) {
                    $.get('/survey/locations/villages/' + districtId, function (data) {
                        data.forEach(function (village) {
                            villageSelect.append('<option value="' + village.id + '">' + village.name + '</option>');
                        });
                    });
                }
            });

            // Form validation for Add KNMP
            var form = document.querySelector('#addKnmpForm');
            if (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            }

            // Reset form when modal is closed
            var addKnmpModal = document.getElementById('addKnmpModal');
            if (addKnmpModal) {
                addKnmpModal.addEventListener('hidden.bs.modal', function () {
                    // Reset text inputs and validation styles
                    form.reset();
                    form.classList.remove('was-validated');

                    // Reset dropdowns manually
                    $('#addRegencySelect').html('<option value="">Pilih Kabupaten/Kota</option>');
                    $('#addDistrictSelect').html('<option value="">Pilih Kecamatan</option>');
                    $('#addVillageSelect').html('<option value="">Pilih Desa</option>');
                });
            }
        });

        // Delete KNMP Custom Dialog Confirmation
        let currentDeleteForm = null;

        $(document).on('click', '.btn-delete-knmp', function (e) {
            e.preventDefault();
            currentDeleteForm = $(this).closest('form');
            const knmpName = $(this).data('knmp-name') || 'ini';

            document.getElementById('dialogTitle').textContent = 'Hapus KNMP?';
            document.getElementById('dialogMessage').textContent = `Apakah Anda yakin ingin menghapus KNMP "${knmpName}"?`;
            document.getElementById('customDialogOverlay').classList.add('show');

            document.getElementById('confirmDialogBtn').onclick = function () {
                closeCustomDialog();
                if (currentDeleteForm) {
                    currentDeleteForm.submit();
                }
            };
        });

        function closeCustomDialog() {
            document.getElementById('customDialogOverlay').classList.remove('show');
            currentDeleteForm = null;
        }
    </script>
@endpush