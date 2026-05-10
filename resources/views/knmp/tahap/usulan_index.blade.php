@extends('knmp.tahap._stage_index', [
    'title'       => 'Tahap Usulan',
    'stageName'   => 'Usulan',
    'icon'        => 'mdi-clipboard-outline',
    'color'       => '#3b82f6',
    'colorEnd'    => '#1e40af',
    'colorShadow' => 'rgba(59,130,246,.2)',
    'showRoute'   => 'usulan.show',
    'knmps'       => $knmps,
])

@section('stage_extra')
{{-- Import Excel Section --}}
<div class="row mb-2">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;">
                            <i class="mdi mdi-file-excel text-white" style="font-size:.95rem;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold" style="font-size:.75rem;">Import Data Usulan</h6>
                            <small class="text-muted" style="font-size:.625rem;">Upload file Excel untuk menambahkan KNMP baru ke tahap Usulan.</small>
                        </div>
                    </div>
                    <a href="{{ route('forms.download_template', ['section' => 'usulan-knmp']) }}" class="btn btn-sm btn-outline-primary no-loader" style="font-size:.65rem;">
                        <i class="mdi mdi-download me-1"></i>Download Template
                    </a>
                </div>

                <form action="{{ route('usulan.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex align-items-end gap-2 flex-wrap">
                        <div style="flex:1;min-width:200px;">
                            <label class="form-label">File Excel (.xlsx, .csv)</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="mdi mdi-upload me-1"></i>Import
                            </button>
                        </div>
                    </div>
                    <small class="text-muted d-block mt-1" style="font-size:.6rem;">
                        Format kolom: <code>nama</code>, <code>provinsi</code>, <code>kabupaten_kota</code>, <code>kecamatan</code>, <code>desa_kelurahan</code>, <code>status</code>, <code>tanggal</code>, <code>catatan</code>
                    </small>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
