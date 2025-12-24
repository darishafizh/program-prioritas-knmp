@php
use Illuminate\Support\Str;
@endphp

{{-- ===================== --}}
{{-- CUSTOM STYLES --}}
{{-- ===================== --}}
<style>
    .evidence-card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        max-width: 250px;
    }

    .evidence-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }

    .evidence-card.selected {
        border: 2px solid #dc3545;
        background: linear-gradient(145deg, #fff5f5, #ffe8e8);
    }

    .evidence-thumbnail {
        position: relative;
        height: 180px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .evidence-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: #f8f9fa;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
        transition: transform 0.3s ease;
    }

    .evidence-card:hover .evidence-thumbnail img {
        transform: scale(1.05);
    }

    .evidence-thumbnail .pdf-icon {
        font-size: 70px;
        color: rgba(255, 255, 255, 0.9);
        text-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .evidence-checkbox {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 10;
    }

    .evidence-checkbox input[type="checkbox"] {
        width: 22px;
        height: 22px;
        cursor: pointer;
        accent-color: #dc3545;
    }

    .evidence-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .evidence-card:hover .evidence-overlay {
        opacity: 1;
    }

    .evidence-overlay .btn-view {
        background: rgba(255, 255, 255, 0.95);
        color: #333;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .evidence-overlay .btn-view:hover {
        background: #fff;
        transform: scale(1.05);
    }

    .evidence-info {
        padding: 15px;
        background: #fff;
    }

    .evidence-info .file-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .evidence-info .file-size {
        font-size: 12px;
        color: #888;
    }

    .evidence-actions {
        padding: 0 15px 15px;
        display: flex;
        gap: 8px;
    }

    .evidence-actions .btn {
        flex: 1;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        padding: 8px 12px;
    }

    .bulk-actions {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 20px;
        display: none;
        align-items: center;
        justify-content: space-between;
        animation: slideDown 0.3s ease;
    }

    .bulk-actions.show {
        display: flex;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .bulk-actions .selected-count {
        color: #fff;
        font-weight: 600;
        font-size: 15px;
    }

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

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: linear-gradient(145deg, #f8f9fa, #fff);
        border-radius: 12px;
        border: 2px dashed #ddd;
    }

    .empty-state i {
        font-size: 80px;
        color: #ddd;
        margin-bottom: 20px;
    }

    /* Preview Container - Horizontal Layout */
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

    .preview-item .preview-actions {
        padding: 0 12px 12px;
        display: flex;
        gap: 8px;
    }

    .preview-item .preview-actions .btn {
        flex: 1;
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 6px;
    }

    /* ===============================
   FILE CANVAS (AREA BAWAH)
================================ */
    .file-canvas {
        background: #fff;
        padding: 0;
        border-radius: 12px;
        min-height: 260px;
        border: 1px solid #e9ecef;
        position: relative;
    }


    /* FOOTER BAWAH */
    .file-canvas-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 15px 20px;
        border-top: 1px solid #e9ecef;
        background: #f5f5f5;
    }

    .file-canvas-footer .btn {
        background-color: #d9d9d9;
        border: 1px solid #bdbdbd;
        color: #000;
        font-size: 13px;
        padding: 6px 14px;
        border-radius: 4px;
    }

    .file-canvas-footer .btn:hover {
        background-color: #cfcfcf;
    }

    .bulk-actions {
        margin-bottom: 80px;
    }




    /* ===============================
   FILE LIST HORIZONTAL
================================ */
    .file-list-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        padding: 20px;
        min-height: 260px;
    }

    .file-list-wrapper::-webkit-scrollbar {
        height: 6px;
    }

    .file-list-wrapper::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 3px;
    }

    .file-item {
        flex: 0 0 auto;
        min-width: 200px;
    }

    @media (max-width: 768px) {
        .file-list-wrapper {
            flex-direction: column;
            flex-wrap: nowrap;
        }

        .file-item {
            min-width: auto;
            width: 100%;
        }

        .evidence-card {
            max-width: 100%;
        }
    }
</style>

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

<class="file-canvas">
    <div class="file-list-wrapper">
        @forelse ($buktiUploads ?? [] as $file)
        <div class="file-item" id="file-{{ $file->id }}">
            <div class="evidence-card" data-file-id="{{ $file->id }}">
                <div class="evidence-thumbnail">
                    <label class="evidence-checkbox">
                        <input type="checkbox"
                            class="file-checkbox"
                            value="{{ $file->id }}"
                            onchange="updateSelection()">
                    </label>

                    @if(Str::startsWith($file->tipe_file, 'image'))
                    <img src="{{ asset('storage/'.$file->path_file) }}" alt="{{ $file->nama_file }}">
                    @else
                    <i class="mdi mdi-file-pdf-box pdf-icon"></i>
                    @endif
                </div>

                <div class="evidence-info">
                    <p class="file-name" title="{{ $file->nama_file }}">{{ $file->nama_file }}</p>
                    <p class="file-size">
                        <i class="mdi mdi-file-document-outline me-1"></i>{{ number_format($file->ukuran_file / 1024, 1) }} KB
                    </p>
                    <a href="{{ asset('storage/'.$file->path_file) }}"
                        download
                        class="text-primary small fw-500">
                        <i class="mdi mdi-download me-1"></i>Download
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5 w-100">
            <i class="mdi mdi-file-document-outline" style="font-size: 64px; color: #ddd; display: block; margin-bottom: 15px;"></i>
            <p class="text-muted mb-0">Belum ada file diupload</p>
        </div>
        @endforelse
    </div>

    {{-- FOOTER ACTIONS --}}
    @if(count($buktiUploads ?? []) > 0)
    <div class="file-footer-actions">
        <button type="button"
            class="btn btn-footer"
            onclick="deleteAllFiles()">
            Hapus semua file
        </button>

        <form action="{{ route('survey.index') }}" method="GET" class="m-0">
            <button type="submit" class="btn btn-footer">
                Kembali ke Survey
            </button>
        </form>
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
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteSelected()">
                <i class="mdi mdi-trash-can me-1"></i>Hapus Terpilih
            </button>
        </div>
    </div>

    {{-- FORM UNTUK BULK DELETE --}}
    <form id="bulkDeleteForm" action="{{ route('forms.delete_bukti_upload', 0) }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
        <input type="hidden" name="file_ids" id="bulkDeleteIds">
    </form>

    {{-- ===================== --}}
    {{-- SCRIPTS --}}
    {{-- ===================== --}}
    <script>
        // ==================================
        // SELECTION FUNCTIONS
        // ==================================
        function updateSelection() {
            const checkboxes = document.querySelectorAll('.file-checkbox:checked');
            const count = checkboxes.length;
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');

            selectedCount.textContent = count;

            if (count > 0) {
                bulkActions.classList.add('show');
            } else {
                bulkActions.classList.remove('show');
            }

            // Update card selection style
            document.querySelectorAll('.evidence-card').forEach(card => {
                const checkbox = card.querySelector('.file-checkbox');
                if (checkbox && checkbox.checked) {
                    card.classList.add('selected');
                } else {
                    card.classList.remove('selected');
                }
            });

            // Update select all checkbox
            const allCheckboxes = document.querySelectorAll('.file-checkbox');
            document.getElementById('selectAll').checked = count === allCheckboxes.length && count > 0;
        }

        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.file-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateSelection();
        });

        function deselectAll() {
            document.querySelectorAll('.file-checkbox').forEach(cb => cb.checked = false);
            document.getElementById('selectAll').checked = false;
            updateSelection();
        }

        function deleteSelected() {
            const checkboxes = document.querySelectorAll('.file-checkbox:checked');
            const ids = Array.from(checkboxes).map(cb => cb.value);

            if (ids.length === 0) {
                alert('Pilih file yang ingin dihapus');
                return;
            }

            if (confirm(`Hapus ${ids.length} file yang dipilih?`)) {
                // Delete files one by one
                ids.forEach(id => {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/survey/forms/bukti-upload/${id}`;
                    form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                    document.body.appendChild(form);
                    form.submit();
                });
            }
        }

        function deleteAllFiles() {
            const ids = Array.from(document.querySelectorAll('.file-checkbox'))
                .map(cb => cb.value);

            if (ids.length === 0) {
                alert('Tidak ada file untuk dihapus');
                return;
            }

            if (!confirm(`Hapus SEMUA ${ids.length} file? Tindakan ini tidak dapat dibatalkan!`)) {
                return;
            }

            // Delete files one by one with delay
            let index = 0;
            const deleteNext = () => {
                if (index < ids.length) {
                    const id = ids[index];
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/survey/forms/bukti-upload/${id}`;
                    form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                    document.body.appendChild(form);
                    form.submit();
                    index++;

                    // Delay before deleting next file (3 seconds)
                    setTimeout(deleteNext, 3000);
                }
            };

            deleteNext();
        }
    </script>