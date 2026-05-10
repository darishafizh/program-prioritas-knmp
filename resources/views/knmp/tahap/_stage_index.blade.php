{{-- Partial: Reusable stage index page --}}
{{-- Usage: @include('knmp.tahap._stage_index', ['title' => ..., 'icon' => ..., 'color' => ..., 'knmps' => ..., 'showRoute' => ..., 'stageName' => ...]) --}}

@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-left">
                <h4 class="page-title"><i class="mdi {{ $icon ?? 'mdi-clipboard-outline' }} me-2"></i>{{ $title }}</h4>
                <small class="text-muted">Daftar KNMP pada tahap {{ $stageName ?? $title }}.</small>
            </div>
            <div class="page-title-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item">KNMP</li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="row mb-2">
    <div class="col-lg-4 col-md-6">
        <div class="card widget-flat">
            <div class="card-body">
                <div class="widget-icon" style="background: linear-gradient(135deg, {{ $color ?? '#3b82f6' }}, {{ $colorEnd ?? '#1e40af' }}); box-shadow: 0 2px 8px {{ $colorShadow ?? 'rgba(59,130,246,.2)' }};">
                    <i class="mdi {{ $icon ?? 'mdi-clipboard-outline' }}"></i>
                </div>
                <div class="widget-content">
                    <h5>Total — {{ $stageName ?? $title }}</h5>
                    <h3>{{ $knmps->count() }}</h3>
                    <p class="widget-sub"><i class="mdi mdi-map-marker-radius text-primary me-1"></i>KNMP pada tahap ini</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Slot for extra content (e.g. import form on Usulan) --}}
@yield('stage_extra')

{{-- Table --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h4 class="header-title mb-0">Daftar KNMP — {{ $stageName ?? $title }}</h4>
                    @if(Auth::user()->isSuperAdmin())
                    <div class="d-flex align-items-center gap-1">
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#batchMoveModal">
                            <i class="mdi mdi-swap-horizontal me-1"></i>Batch Pindah Tahap
                        </button>
                        
                        <form action="{{ route('knmp_tahap.batch_destroy') }}" method="POST" id="batchDeleteForm" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data KNMP yang dipilih?')">
                            @csrf
                            @method('DELETE')
                            <div id="batchDeleteIds"></div>
                            <button type="button" class="btn btn-sm btn-outline-danger" id="btnBatchDelete" style="display:none;">
                                <i class="mdi mdi-trash-can-outline me-1"></i>Hapus Terpilih (<span id="batchDeleteCount">0</span>)
                            </button>
                        </form>
                    </div>
                    @endif
                </div>

                <div class="table-responsive">
                    <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap">
                        <thead>
                            <tr>
                                <th style="width:30px;"><input type="checkbox" id="checkAll"></th>
                                <th>Nama KNMP</th>
                                <th>Desa</th>
                                <th>Kecamatan</th>
                                <th>Kabupaten</th>
                                <th>Provinsi</th>
                                <th>Tahap</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($knmps as $knmp)
                                <tr>
                                    <td><input type="checkbox" class="knmp-check" value="{{ $knmp->id }}"></td>
                                    <td>{{ ucwords(strtolower($knmp->nama ?? 'N/A')) }}</td>
                                    <td>{{ ucwords(strtolower($knmp->desa_kelurahan ?? 'N/A')) }}</td>
                                    <td>{{ ucwords(strtolower($knmp->kecamatan ?? 'N/A')) }}</td>
                                    <td>{{ ucwords(strtolower($knmp->kabupaten_kota ?? 'N/A')) }}</td>
                                    <td>{{ ucwords(strtolower($knmp->provinsi ?? 'N/A')) }}</td>
                                    <td><span class="badge bg-primary text-uppercase">{{ $knmp->tahap_label }}</span></td>
                                    <td class="action-buttons">
                                        <a href="{{ route($showRoute, $knmp->nama) }}"
                                            class="btn btn-action btn-action-primary" title="Detail">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        @if(Auth::user()->isSuperAdmin())
                                        <button type="button" class="btn btn-action btn-action-outline-info btn-move-stage"
                                            data-bs-toggle="modal" data-bs-target="#moveStageModal"
                                            data-knmp-id="{{ $knmp->id }}"
                                            data-knmp-nama="{{ $knmp->nama }}"
                                            data-knmp-tahap="{{ $knmp->tahap }}"
                                            title="Pindah Tahap">
                                            <i class="mdi mdi-swap-horizontal"></i>
                                        </button>
                                        <form action="{{ route('knmp_tahap.destroy', $knmp->nama) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data KNMP ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-action btn-action-outline-danger" title="Hapus">
                                                <i class="mdi mdi-trash-can-outline"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">
                                        <i class="mdi mdi-information-outline me-1"></i>Belum ada KNMP pada tahap ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- MODALS — Single & Batch Move Stage                           --}}
{{-- ============================================================ --}}
@if(Auth::user()->isSuperAdmin())

{{-- Single Move Modal --}}
<div class="modal fade" id="moveStageModal" tabindex="-1" aria-labelledby="moveStageLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content border-0 shadow">
            <form method="POST" id="moveStageForm">
                @csrf
                <div class="modal-header py-2 px-3" style="background:linear-gradient(135deg,#f59e0b,#d97706);border:none;">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:32px;height:32px;background:rgba(255,255,255,.2);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                            <i class="mdi mdi-swap-horizontal text-white" style="font-size:1rem;"></i>
                        </div>
                        <div>
                            <h6 class="modal-title mb-0 text-white" id="moveStageLabel" style="font-size:.8rem;">Pindah Tahap</h6>
                            <small style="color:rgba(255,255,255,.7);font-size:.65rem;" id="moveStageKnmpName"></small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="font-size:.6rem;"></button>
                </div>
                <div class="modal-body px-3 py-3">
                    <div class="mb-2">
                        <label class="form-label">Tahap Tujuan <span class="text-danger">*</span></label>
                        <select class="form-select" name="tahap_baru" required>
                            <option value="">Pilih Tahap</option>
                            <option value="usulan">Usulan</option>
                            <option value="survey">Survey</option>
                            <option value="ded">DED</option>
                            <option value="lelang">Lelang</option>
                            <option value="konstruksi">Konstruksi</option>
                            <option value="serah_terima">Serah Terima</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="2" placeholder="Alasan perpindahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer px-3 py-2" style="background:#f8fafc;">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white btn-sm">
                        <i class="mdi mdi-swap-horizontal me-1"></i>Pindah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Batch Move Modal --}}
<div class="modal fade" id="batchMoveModal" tabindex="-1" aria-labelledby="batchMoveLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="{{ route('knmp_tahap.batch_move') }}" id="batchMoveForm">
                @csrf
                <div class="modal-header py-2 px-3" style="background:linear-gradient(135deg,#8b5cf6,#6d28d9);border:none;">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:32px;height:32px;background:rgba(255,255,255,.2);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                            <i class="mdi mdi-swap-horizontal-bold text-white" style="font-size:1rem;"></i>
                        </div>
                        <div>
                            <h6 class="modal-title mb-0 text-white" id="batchMoveLabel" style="font-size:.8rem;">Batch Pindah Tahap</h6>
                            <small style="color:rgba(255,255,255,.7);font-size:.65rem;" id="batchCount">0 KNMP dipilih</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="font-size:.6rem;"></button>
                </div>
                <div class="modal-body px-3 py-3">
                    <div id="batchKnmpIds"></div>
                    <div class="mb-2">
                        <label class="form-label">Tahap Tujuan <span class="text-danger">*</span></label>
                        <select class="form-select" name="tahap_baru" required>
                            <option value="">Pilih Tahap</option>
                            <option value="usulan">Usulan</option>
                            <option value="survey">Survey</option>
                            <option value="ded">DED</option>
                            <option value="lelang">Lelang</option>
                            <option value="konstruksi">Konstruksi</option>
                            <option value="serah_terima">Serah Terima</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="2" placeholder="Alasan perpindahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer px-3 py-2" style="background:#f8fafc;">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm text-white" style="background:#8b5cf6;">
                        <i class="mdi mdi-swap-horizontal-bold me-1"></i>Batch Pindah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Single move stage
    document.querySelectorAll('.btn-move-stage').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var nama = this.dataset.knmpNama;
            document.getElementById('moveStageKnmpName').textContent = nama;
            document.getElementById('moveStageForm').action = '/knmp-tahap/' + encodeURIComponent(nama) + '/move';
        });
    });

    // Checkbox & Batch actions logic
    var checkAll = document.getElementById('checkAll');
    var btnBatchDelete = document.getElementById('btnBatchDelete');
    var batchDeleteCount = document.getElementById('batchDeleteCount');
    var batchDeleteIdsContainer = document.getElementById('batchDeleteIds');

    function updateBatchButtons() {
        var checked = document.querySelectorAll('.knmp-check:checked');
        if (btnBatchDelete) {
            if (checked.length > 0) {
                btnBatchDelete.style.display = 'inline-block';
                batchDeleteCount.textContent = checked.length;
            } else {
                btnBatchDelete.style.display = 'none';
            }
        }
    }

    if (checkAll) {
        checkAll.addEventListener('change', function() {
            document.querySelectorAll('.knmp-check').forEach(function(cb) { 
                cb.checked = checkAll.checked; 
            });
            updateBatchButtons();
        });
    }

    document.querySelectorAll('.knmp-check').forEach(function(cb) {
        cb.addEventListener('change', updateBatchButtons);
    });

    if (btnBatchDelete) {
        btnBatchDelete.addEventListener('click', function() {
            var checked = document.querySelectorAll('.knmp-check:checked');
            if (checked.length === 0) return;
            
            batchDeleteIdsContainer.innerHTML = '';
            checked.forEach(function(cb) {
                var inp = document.createElement('input');
                inp.type = 'hidden'; 
                inp.name = 'knmp_ids[]'; 
                inp.value = cb.value;
                batchDeleteIdsContainer.appendChild(inp);
            });
            
            document.getElementById('batchDeleteForm').submit();
        });
    }

    // Batch move — populate hidden inputs
    var batchMoveModal = document.getElementById('batchMoveModal');
    if (batchMoveModal) {
        batchMoveModal.addEventListener('show.bs.modal', function() {
            var container = document.getElementById('batchKnmpIds');
            container.innerHTML = '';
            var checked = document.querySelectorAll('.knmp-check:checked');
            document.getElementById('batchCount').textContent = checked.length + ' KNMP dipilih';
            checked.forEach(function(cb) {
                var inp = document.createElement('input');
                inp.type = 'hidden'; inp.name = 'knmp_ids[]'; inp.value = cb.value;
                container.appendChild(inp);
            });
        });
    }
});
</script>

@endsection
