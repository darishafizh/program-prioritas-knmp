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
                    <h4 class="header-title mb-3">Daftar knmp</h4>

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
                                        <a href="{{ route('forms.index', $knmp->id) }}" class="btn btn-action btn-action-primary"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Input Survey">
                                            <i class="mdi mdi-pencil-box"></i>
                                        </a>
                                        <a href="{{ route('forms.edit-responden', $knmp->id) }}"
                                            class="btn btn-action btn-action-outline-success" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Edit Responden">
                                            <i class="mdi mdi-account-edit"></i>
                                        </a>
                                        <a href="{{ route('survey.questionnaires-pdf', $knmp->id) }}"
                                            class="btn btn-action btn-action-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Lihat PDF">
                                            <i class="mdi mdi-file-pdf-box"></i>
                                        </a>
                                        <button type="button" class="btn btn-action btn-action-outline-info"
                                            data-bs-toggle="modal" data-bs-target="#evidenceModal{{ $knmp->id }}"
                                            title="Evidence">
                                            <i class="mdi mdi-file-image-marker"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->

    <!-- Evidence Modals for each KNMP -->
    @foreach ($knmps as $knmp)
    <div class="modal fade evidence-modal" id="evidenceModal{{ $knmp->id }}" tabindex="-1" aria-labelledby="evidenceModalLabel{{ $knmp->id }}" aria-hidden="true">
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
                                    <div class="evidence-card" onclick="openImagePreview('{{ asset('storage/' . $bukti->path_file) }}', '{{ $bukti->nama_file ?? 'Evidence' }}')">
                                        @php
                                            $isImage = $bukti->tipe_file && str_starts_with($bukti->tipe_file, 'image/');
                                        @endphp
                                        @if($isImage)
                                            <img src="{{ asset('storage/' . $bukti->path_file) }}" alt="Evidence">
                                        @else
                                            <div class="evidence-pdf">
                                                <i class="mdi mdi-file-pdf-box"></i>
                                            </div>
                                        @endif
                                        <div class="evidence-card-overlay">
                                            <i class="mdi mdi-magnify-plus-outline"></i>
                                        </div>
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
                    <a href="{{ route('survey.evidence', $knmp->id) }}" class="btn btn-evidence-primary">
                        <i class="mdi mdi-open-in-new me-1"></i>Kelola Evidence
                    </a>
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
            box-shadow: 0 25px 80px rgba(0,0,0,0.25);
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
            background: rgba(255,255,255,0.2);
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
            background: rgba(255,255,255,0.15);
            border: none;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .evidence-close-btn:hover {
            background: rgba(255,255,255,0.3);
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
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .evidence-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .evidence-card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            display: block;
        }
        
        .evidence-pdf {
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        }
        
        .evidence-pdf i {
            font-size: 3rem;
            color: #dc2626;
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
            background: rgba(0,0,0,0.6);
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
            background: rgba(0,0,0,0.8);
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
            box-shadow: 0 25px 80px rgba(0,0,0,0.5);
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
            background: rgba(0,0,0,0.9);
        }
    </style>

    <script>
        function openImagePreview(src, caption) {
            // Close the evidence modal first
            var evidenceModals = document.querySelectorAll('.evidence-modal.show');
            evidenceModals.forEach(function(modal) {
                var bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) bsModal.hide();
            });
            
            // Set image source and caption
            document.getElementById('previewImage').src = src;
            document.getElementById('previewCaption').textContent = caption;
            
            // Show preview modal after a short delay to allow evidence modal to close
            setTimeout(function() {
                var previewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
                previewModal.show();
            }, 300);
        }
    </script>
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
        });
    </script>
@endpush