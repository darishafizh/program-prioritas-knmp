@extends('layouts.app')

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <h4 class="page-title"><i class="mdi mdi-account-edit-outline me-2"></i>Edit Data Responden</h4>
                    <!-- <small class="text-muted">{{ $knmp->nama ?? 'KNMP' }}</small> -->
                </div>
                <div class="page-title-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('survey.index') }}">Survey</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Responden</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Info Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center">
                                <i class="mdi mdi-map-marker-outline text-white" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted small text-uppercase">KNMP</h6>
                            <h5 class="mb-0 fw-semibold">{{ $knmp->nama ?? 'N/A' }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center">
                                <i class="mdi mdi-account-group-outline text-white" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted small text-uppercase">Total Responden</h6>
                            <h5 class="mb-0 fw-semibold">{{ count($responden) }} Orang</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center">
                                <i class="mdi mdi-clipboard-check-outline text-white" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted small text-uppercase">Data Terisi</h6>
                            <h5 class="mb-0 fw-semibold">{{ $responden->filter(fn($r) => $r['is_complete'])->count() }} / {{ count($responden) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Bar -->
    @if(!$responden->isEmpty())
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center">
                    <div class="form-check me-3">
                        <input type="checkbox" id="selectAll" class="form-check-input" style="width: 20px; height: 20px;">
                        <label class="form-check-label ms-1" for="selectAll">Pilih Semua</label>
                    </div>
                    <span class="text-muted small" id="selectedInfo">
                        <span id="selectedCount">0</span> responden dipilih
                    </span>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="deselectAll()" id="btnDeselect" style="display: none;">
                        <i class="mdi mdi-close me-1"></i>Batal Pilih
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteSelected()" id="btnDeleteSelected" style="display: none;">
                        <i class="mdi mdi-trash-can-outline me-1"></i>Hapus Terpilih
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteAllResponden()">
                        <i class="mdi mdi-trash-can-outline me-1"></i>Hapus Semua
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Responden List -->
    @if($responden->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="mb-3">
                    <i class="mdi mdi-account-multiple-outline text-muted" style="font-size: 4rem;"></i>
                </div>
                <h5 class="text-muted mb-2">Belum Ada Responden</h5>
                <p class="text-muted mb-0">Tidak ada responden yang telah didaftarkan untuk KNMP ini</p>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($responden as $item)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100 responden-card-item" id="responden-{{ $item['id'] }}" data-responden-id="{{ $item['id'] }}">
                        <div class="card-body">
                            <!-- Checkbox & Status -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input responden-check" value="{{ $item['id'] }}" onchange="updateSelection()" style="width: 18px; height: 18px;">
                                </div>
                                @if($item['is_complete'])
                                    <span class="badge bg-success-subtle text-success">
                                        <i class="mdi mdi-check-circle me-1"></i>Lengkap
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning">
                                        <i class="mdi mdi-alert-circle me-1"></i>Belum Lengkap
                                    </span>
                                @endif
                            </div>

                            <!-- Avatar & Name -->
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-md rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px; font-size: 1.5rem; background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);">
                                    @if($item['jenis_kelamin'] === 'Perempuan')
                                        <span>👩</span>
                                    @else
                                        <span>👨</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <h6 class="mb-1 fw-semibold text-truncate">{{ $item['nama_responden'] }}</h6>
                                    <small class="text-muted">NIK: {{ $item['nik'] }}</small>
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted small">Jenis Kelamin</span>
                                    <span class="fw-medium small">{{ $item['jenis_kelamin'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted small">Tanggal Wawancara</span>
                                    <span class="fw-medium small">{{ \Carbon\Carbon::parse($item['tanggal_wawancara'])->format('d/m/Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted small">Enumerator</span>
                                    <span class="fw-medium small">{{ $item['nama_enumerator'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="text-muted small">Form Terisi</span>
                                    <span class="fw-medium small">
                                        <span class="badge bg-primary-subtle text-primary">{{ $item['filled_forms'] }}/{{ $item['total_forms'] }}</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ route('forms.index', $knmp->id) }}?responden={{ $item['id'] }}" class="btn btn-primary btn-sm w-100">
                                <i class="mdi mdi-pencil-outline me-1"></i>Edit Data
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Form untuk Bulk Delete -->
    <form id="bulkDeleteForm" action="{{ route('forms.delete_responden') }}" method="POST" class="d-none">
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

    <style>
        .avatar-sm {
            width: 48px;
            height: 48px;
        }
        .responden-card-item {
            transition: all 0.3s ease;
        }
        .responden-card-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
        }
        .bg-success-subtle { background-color: rgba(16, 185, 129, 0.1) !important; }
        .bg-warning-subtle { background-color: rgba(245, 158, 11, 0.1) !important; }
        .bg-primary-subtle { background-color: rgba(59, 130, 246, 0.1) !important; }
        .text-success { color: #10b981 !important; }
        .text-warning { color: #f59e0b !important; }
        
        .custom-dialog-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
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
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
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

    <!-- JavaScript -->
    <script>
        function updateSelection() {
            const checkboxes = document.querySelectorAll('.responden-check:checked');
            const count = checkboxes.length;
            document.getElementById('selectedCount').textContent = count;
            
            const btnDeselect = document.getElementById('btnDeselect');
            const btnDeleteSelected = document.getElementById('btnDeleteSelected');
            
            if (count > 0) {
                btnDeselect.style.display = 'inline-flex';
                btnDeleteSelected.style.display = 'inline-flex';
            } else {
                btnDeselect.style.display = 'none';
                btnDeleteSelected.style.display = 'none';
            }
        }

        document.getElementById('selectAll')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.responden-check');
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateSelection();
        });

        function deselectAll() {
            document.querySelectorAll('.responden-check').forEach(cb => cb.checked = false);
            document.getElementById('selectAll').checked = false;
            updateSelection();
        }

        function deleteSelected() {
            const selected = document.querySelectorAll('.responden-check:checked');
            if (selected.length === 0) return;
            
            showCustomDialog(
                'Konfirmasi Hapus',
                `Apakah Anda yakin ingin menghapus ${selected.length} responden yang dipilih?`,
                () => {
                    const form = document.getElementById('bulkDeleteForm');
                    selected.forEach(cb => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'responden_ids[]';
                        input.value = cb.value;
                        form.appendChild(input);
                    });
                    form.submit();
                }
            );
        }

        function deleteAllResponden() {
            const allCheckboxes = document.querySelectorAll('.responden-check');
            if (allCheckboxes.length === 0) return;
            
            showCustomDialog(
                'Hapus Semua Responden',
                `Apakah Anda yakin ingin menghapus SEMUA ${allCheckboxes.length} responden?`,
                () => {
                    const form = document.getElementById('bulkDeleteForm');
                    allCheckboxes.forEach(cb => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'responden_ids[]';
                        input.value = cb.value;
                        form.appendChild(input);
                    });
                    form.submit();
                }
            );
        }

        function showCustomDialog(title, message, onConfirm) {
            document.getElementById('dialogTitle').textContent = title;
            document.getElementById('dialogMessage').textContent = message;
            document.getElementById('customDialogOverlay').classList.add('show');
            
            document.getElementById('confirmDialogBtn').onclick = () => {
                closeCustomDialog();
                onConfirm();
            };
        }

        function closeCustomDialog() {
            document.getElementById('customDialogOverlay').classList.remove('show');
        }
    </script>

@endsection