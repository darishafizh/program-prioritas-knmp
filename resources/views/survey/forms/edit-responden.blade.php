@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/survey-custom.css') }}">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between"
                style="background: transparent; box-shadow: none; padding: 15px 0; margin-bottom: 20px;">
                <h4 class="page-title mb-0">
                    <i class="mdi mdi-account-edit-outline me-1"></i> Edit Data Responden
                </h4>
                <div class="page-title-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}"><i
                                        class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('survey.index') }}">Survey</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Responden</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Header Title -->
    <div class="page-title-box">
        <h4>
            <i class="mdi mdi-pencil-box"></i> Edit Data Responden
        </h4>
        <p>Edit dan kelola data responden per individu di {{ $knmp->nama ?? 'KNMP' }}</p>
    </div>

    <!-- Info Card -->
    <div class="info-card">
        <div class="row">
            <div class="col-md-4">
                <h6>Kampung Nelayan</h6>
                <p>{{ $knmp->nama ?? 'N/A' }}</p>
            </div>
            <div class="col-md-4">
                <h6>Total Responden</h6>
                <p>{{ count($responden) }} Responden</p>
            </div>
            <div class="col-md-4">
                <h6>Data Terisi</h6>
                <p>{{ $responden->filter(fn($r) => $r['is_complete'])->count() }}/{{ count($responden) }}</p>
            </div>
        </div>
    </div>

    <!-- Delete All Section -->
    @if(!$responden->isEmpty())
        <div class="delete-all-section">
            <button type="button" class="btn-delete-all" onclick="deleteAllResponden()">
                <i class="mdi mdi-trash-can"></i>
                Hapus Semua Responden
            </button>
        </div>
    @endif

    <!-- Bulk Actions Bar -->
    <div class="bulk-actions" id="bulkActions">
        <div class="d-flex align-items-center">
            <input type="checkbox" id="selectAll" class="me-3" style="width: 20px; height: 20px; cursor: pointer;">
            <span class="selected-count"><span id="selectedCount">0</span> responden dipilih</span>
        </div>
        <div>
            <button type="button" class="btn btn-light btn-sm me-2" onclick="deselectAll()">
                <i class="mdi mdi-close me-1"></i>Batal
            </button>
            <button type="button" class="btn btn-warning btn-sm" onclick="deleteSelected()">
                <i class="mdi mdi-trash-can me-1"></i>Hapus Terpilih
            </button>
        </div>
    </div>

    <!-- Responden List -->
    @if($responden->isEmpty())
        <div class="empty-state">
            <i class="mdi mdi-account-multiple"></i>
            <h5>Belum Ada Responden</h5>
            <p>Tidak ada responden yang telah didaftarkan untuk KNMP ini</p>
        </div>
    @else
        <div class="responden-list">
            @foreach($responden as $item)
                <div class="responden-card" id="responden-{{ $item['id'] }}" data-responden-id="{{ $item['id'] }}">
                    <!-- Checkbox -->
                    <label class="responden-checkbox">
                        <input type="checkbox" class="responden-check" value="{{ $item['id'] }}" onchange="updateSelection()">
                    </label>

                    <!-- Header -->
                    <div class="responden-header">
                        <div class="avatar">
                            @if($item['jenis_kelamin'] === 'Perempuan')
                                👩
                            @else
                                👨
                            @endif
                        </div>
                        <div class="info">
                            <h5>{{ $item['nama_responden'] }}</h5>
                            <p>NIK: {{ $item['nik'] }}</p>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="responden-body">
                        <div class="detail-row">
                            <span class="detail-label">Jenis Kelamin</span>
                            <span class="detail-value">{{ $item['jenis_kelamin'] }}</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Tanggal Wawancara</span>
                            <span class="detail-value">
                                {{ \Carbon\Carbon::parse($item['tanggal_wawancara'])->format('d/m/Y') }}
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Enumerator</span>
                            <span class="detail-value">{{ $item['nama_enumerator'] }}</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Form Terisi</span>
                            <span class="detail-value">{{ $item['filled_forms'] }}/{{ $item['total_forms'] }} Form</span>
                        </div>

                        @if($item['last_updated'])
                            <div class="detail-row">
                                <span class="detail-label">Terakhir Diperbarui</span>
                                <span class="detail-value">
                                    {{ \Carbon\Carbon::parse($item['last_updated'])->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        @if($item['is_complete'])
                            <span class="status-badge complete">
                                <i class="mdi mdi-check-circle"></i> Terisi
                            </span>
                        @else
                            <span class="status-badge incomplete">
                                <i class="mdi mdi-alert-circle"></i> Belum Terisi
                            </span>
                        @endif
                    </div>

                    <!-- Footer -->
                    <div class="responden-footer">
                        <a href="{{ route('survey.forms.index', $knmp->id) }}?responden={{ $item['id'] }}" class="btn-edit">
                            <i class="mdi mdi-pencil"></i>
                            Edit Data
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Form untuk Bulk Delete -->
    <form id="bulkDeleteForm" action="{{ route('survey.forms.delete_responden') }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>

    <!-- Custom Dialog Overlay -->
    <div id="customDialogOverlay" class="custom-dialog-overlay">
        <div id="customDialog" class="custom-dialog warning">
            <div class="custom-dialog-icon-circle">
                <span id="dialogIcon">⚠</span>
            </div>
            <h3 class="custom-dialog-title" id="dialogTitle">Konfirmasi Penghapusan</h3>
            <p class="custom-dialog-message" id="dialogMessage">Apakah Anda yakin ingin menghapus responden?</p>
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

    <!-- JavaScript -->
    <script src="{{ asset('js/survey-custom.js') }}"></script>

@endsection