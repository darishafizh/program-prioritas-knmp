@php
    use Illuminate\Support\Str;
@endphp

{{-- ===================== --}}
{{-- CUSTOM STYLES --}}
{{-- ===================== --}}


{{-- ===================== --}}
{{-- FILE LIST --}}
{{-- ===================== --}}
<div class="mb-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="fw-bold mb-0">
            <i class="mdi mdi-file-multiple me-2 text-primary"></i>File yang Telah Diupload
        </h5>
        <span class="badge bg-light text-dark">{{ count($buktiUploads ?? []) }} File</span>
    </div>
</div>

{{-- Delete All Section --}}
@if(count($buktiUploads ?? []) > 0)
    <div class="delete-all-section">
        <button type="button" class="btn-delete-all" onclick="deleteAllFiles()">
            <i class="mdi mdi-trash-can"></i>
            Hapus Semua File
        </button>
    </div>
@endif

{{-- BULK ACTIONS BAR --}}
<div class="bulk-actions" id="bulkActions">
    <div class="d-flex align-items-center">
        <input type="checkbox" id="selectAll" class="me-3" style="width: 20px; height: 20px; cursor: pointer;">
        <span class="selected-count"><span id="selectedCount">0</span> file dipilih</span>
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

<div class="file-canvas">
    <div class="file-list-wrapper">
        @forelse ($buktiUploads ?? [] as $file)
            <div class="file-item" id="file-{{ $file->id }}">
                <div class="evidence-card" data-file-id="{{ $file->id }}">
                    <div class="evidence-thumbnail">
                        <label class="evidence-checkbox">
                            <input type="checkbox" class="file-checkbox" value="{{ $file->id }}"
                                onchange="updateSelection()">
                        </label>

                        @if(Str::startsWith($file->tipe_file, 'image'))
                            <img src="{{ asset('storage/' . $file->path_file) }}" alt="{{ $file->nama_file }}">
                        @else
                            <i class="mdi mdi-file-pdf-box pdf-icon"></i>
                        @endif
                    </div>

                    <div class="evidence-info">
                        <p class="file-name" title="{{ $file->nama_file }}">{{ $file->nama_file }}</p>
                        <p class="file-size">
                            <i
                                class="mdi mdi-file-document-outline me-1"></i>{{ number_format($file->ukuran_file / 1024, 1) }}
                            KB
                        </p>
                        <a href="{{ asset('storage/' . $file->path_file) }}" download class="text-primary small fw-500">
                            <i class="mdi mdi-download me-1"></i>Download
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 w-100">
                <i class="mdi mdi-file-document-outline"
                    style="font-size: 64px; color: #ddd; display: block; margin-bottom: 15px;"></i>
                <p class="text-muted mb-0">Belum ada file diupload</p>
            </div>
        @endforelse
    </div>

</div>

{{-- FORM UNTUK BULK DELETE --}}
<form id="bulkDeleteForm" action="{{ route('forms.delete_bukti_upload') }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

{{-- CUSTOM DIALOG OVERLAY --}}
<div id="customDialogOverlay" class="custom-dialog-overlay">
    <div id="customDialog" class="custom-dialog warning">
        <div class="custom-dialog-icon-circle">
            <span id="dialogIcon">⚠</span>
        </div>
        <h3 class="custom-dialog-title" id="dialogTitle">Konfirmasi Penghapusan</h3>
        <p class="custom-dialog-message" id="dialogMessage">Apakah Anda yakin ingin menghapus file?</p>
        <div class="custom-dialog-progress" id="dialogProgress" style="display: none;">
            <div class="custom-dialog-progress-bar"></div>
        </div>
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

{{-- ===================== --}}
{{-- SCRIPTS --}}
{{-- ===================== --}}