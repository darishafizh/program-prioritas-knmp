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



{{-- BULK ACTIONS BAR (Matches edit-responden style) --}}
@if(count($buktiUploads ?? []) > 0)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center">
                    <div class="form-check me-3">
                        <input type="checkbox" id="selectAll" class="form-check-input"
                            style="width: 20px; height: 20px; cursor: pointer;">
                        <label class="form-check-label ms-1" for="selectAll">Pilih Semua</label>
                    </div>
                    <span class="text-muted small" id="selectedInfo">
                        <span id="selectedCount">0</span> file dipilih
                    </span>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="deselectAll()" id="btnDeselect"
                        style="display: none;">
                        <i class="mdi mdi-close me-1"></i>Batal Pilih
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteSelected()"
                        id="btnDeleteSelected" style="display: none;">
                        <i class="mdi mdi-trash-can-outline me-1"></i>Hapus Terpilih
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteAllFiles()">
                        <i class="mdi mdi-trash-can-outline me-1"></i>Hapus Semua
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="file-canvas">
    <div class="file-list-wrapper">
        @php /** @var \App\Models\BuktiUpload[]|\Illuminate\Database\Eloquent\Collection $buktiUploads */ @endphp
        @forelse ($buktiUploads ?? [] as $file)
            @php
                /** @var \App\Models\BuktiUpload $file */
                $isImage = Str::startsWith($file->tipe_file, 'image');
                $fileExists = \Illuminate\Support\Facades\Storage::disk('public')->exists($file->path_file);
                $imageUrl = $fileExists ? asset('storage/' . $file->path_file) : '';
            @endphp
            <div class="file-item" id="file-{{ $file->id }}">
                <div class="evidence-card" data-file-id="{{ $file->id }}">
                    <div class="evidence-thumbnail">
                        <label class="evidence-checkbox">
                            <input type="checkbox" class="file-checkbox" value="{{ hashid($file->id) }}"
                                onchange="updateSelection()">
                        </label>

                        @if($isImage && $fileExists)
                            <img src="{{ $imageUrl }}" alt="{{ $file->nama_file }}"
                                onerror="this.onerror=null; this.src=''; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="evidence-placeholder-icon" style="display: none;">
                                <i class="mdi mdi-image-off-outline"></i>
                            </div>
                        @elseif($isImage && !$fileExists)
                            <div class="evidence-placeholder-icon">
                                <i class="mdi mdi-image-off-outline"></i>
                            </div>
                        @else
                            <i class="mdi mdi-file-pdf-box pdf-icon"></i>
                        @endif
                    </div>

                    <div class="evidence-info">
                        <div class="mb-1">
                            @if($file->kondisi == 'before')
                                <span class="badge bg-primary"><i class="mdi mdi-image-outline me-1"></i>Before</span>
                            @elseif($file->kondisi == 'after')
                                <span class="badge bg-success"><i class="mdi mdi-image-check-outline me-1"></i>After</span>
                            @endif
                        </div>
                        <p class="file-name" title="{{ $file->nama_file }}">{{ $file->nama_file }}</p>
                        <p class="file-size">
                            <i
                                class="mdi mdi-file-document-outline me-1"></i>{{ number_format($file->ukuran_file / 1024, 1) }}
                            KB
                            @if(!$fileExists)
                                <span class="badge bg-danger ms-1">File tidak ditemukan</span>
                            @endif
                        </p>
                        <div class="d-flex gap-2 mt-2">
                            @if($fileExists)
                                <a href="{{ $imageUrl }}" download class="btn btn-sm btn-outline-primary flex-fill">
                                    <i class="mdi mdi-download me-1"></i>Download
                                </a>
                            @else
                                <button class="btn btn-sm btn-outline-secondary flex-fill" disabled>
                                    <i class="mdi mdi-alert-circle-outline me-1"></i>Hilang
                                </button>
                            @endif

                            <button type="button" class="btn btn-sm btn-outline-danger flex-fill"
                                onclick="confirmDeleteSingle('{{ hashid($file->id) }}')">
                                <i class="mdi mdi-trash-can-outline me-1"></i>Hapus
                            </button>
                        </div>
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
    <div id="customDialog" class="custom-dialog error">
        <div class="custom-dialog-icon-circle">
            <span id="dialogIcon">!</span>
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

{{-- FORM UNTUK SINGLE DELETE --}}
<form id="singleDeleteForm" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

{{-- ===================== --}}
{{-- SCRIPTS --}}
{{-- ===================== --}}
<script>
    function confirmDeleteSingle(fileId) {
        // Set action form ke route delete single
        const form = document.getElementById('singleDeleteForm');
        form.action = "{{ route('forms.delete_bukti_single', ':id') }}".replace(':id', fileId);

        // Tampilkan dialog konfirmasi (menggunakan custom dialog yang sudah ada)
        const dialogTitle = document.getElementById('dialogTitle');
        const dialogMessage = document.getElementById('dialogMessage');
        const confirmBtn = document.getElementById('confirmDialogBtn');
        const dialogIcon = document.getElementById('dialogIcon');
        const customDialog = document.getElementById('customDialog');

        // Reset state
        customDialog.className = 'custom-dialog error';
        dialogIcon.innerText = '!';
        dialogTitle.innerText = 'Hapus File?';
        dialogMessage.innerText = 'Apakah Anda yakin ingin menghapus file ini secara permanen?';

        // Show overlay
        const overlay = document.getElementById('customDialogOverlay');
        overlay.classList.add('show');

        // Handle confirm button
        confirmBtn.onclick = function () {
            // Show loading state
            document.getElementById('dialogProgress').style.display = 'block';

            // Submit form
            form.submit();
        };
    }
</script>