@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-left">
                <h4 class="page-title"><i class="mdi mdi-handshake me-2"></i>Detail Serah Terima</h4>
                <small class="text-muted">{{ $knmp->nama }}</small>
            </div>
            <div class="page-title-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('serah_terima.index') }}">Serah Terima</a></li>
                        <li class="breadcrumb-item active">{{ $knmp->nama }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header" style="background:linear-gradient(135deg,#8b5cf6,#6d28d9);border:none;">
                <h5 class="card-title mb-0 text-white"><i class="mdi mdi-handshake me-2"></i>Data Serah Terima</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('serah_terima.store', $knmp->nama) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-medium">Nomor Kontrak <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nomor_kontrak" value="{{ $data->nomor_kontrak ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Nilai Kontrak (Rp)</label>
                        <input type="number" step="0.01" class="form-control" name="nilai_kontrak" value="{{ $data->nilai_kontrak ?? '' }}">
                        @if($lelang && $lelang->nilai_kontrak)
                        <small class="text-muted"><i class="mdi mdi-information-outline me-1"></i>Referensi dari tahap lelang: Rp {{ number_format($lelang->nilai_kontrak, 2, ',', '.') }}</small>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Tanggal Serah Terima</label>
                        <input type="date" class="form-control" name="tanggal_serah" value="{{ $data->tanggal_serah ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Catatan</label>
                        <textarea class="form-control" name="catatan" rows="4">{{ $data->catatan ?? '' }}</textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn text-white" style="background:#8b5cf6;">
                            <i class="mdi mdi-content-save me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0"><i class="mdi mdi-information-outline me-2"></i>Info KNMP</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr><td class="text-muted">Nama</td><td class="fw-medium">{{ $knmp->nama }}</td></tr>
                    <tr><td class="text-muted">Provinsi</td><td>{{ $knmp->provinsi ?? 'N/A' }}</td></tr>
                    <tr><td class="text-muted">Kabupaten</td><td>{{ $knmp->kabupaten ?? 'N/A' }}</td></tr>
                    <tr><td class="text-muted">Tahap</td><td><span class="badge text-white text-uppercase" style="background:#8b5cf6;">{{ $knmp->tahap_label }}</span></td></tr>
                </table>
            </div>
        </div>
        @if($knmpKonstruksi->count() > 0)
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0"><i class="mdi mdi-account-hard-hat me-2"></i>Penyedia Jasa</h5>
            </div>
            <div class="card-body">
                @foreach($knmpKonstruksi as $kk)
                <div class="d-flex align-items-center mb-2">
                    <span class="badge {{ $kk->peran==='utama' ? 'bg-primary' : 'bg-secondary' }} me-2 text-uppercase">{{ $kk->peran }}</span>
                    <span>{{ $kk->penyedia->nama ?? 'N/A' }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
