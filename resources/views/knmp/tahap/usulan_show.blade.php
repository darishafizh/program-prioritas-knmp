@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-left">
                <h4 class="page-title"><i class="mdi mdi-clipboard-outline me-2"></i>Detail Tahap Usulan</h4>
                <small class="text-muted">{{ $knmp->nama }}</small>
            </div>
            <div class="page-title-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('usulan.index') }}">Usulan</a></li>
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
            <div class="card-header" style="background: linear-gradient(135deg, #3b82f6, #1e40af); border: none;">
                <h5 class="card-title mb-0 text-white"><i class="mdi mdi-clipboard-outline me-2"></i>Data Tahap Usulan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('usulan.store', $knmp->nama) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-medium">Tanggal Usulan</label>
                        <input type="date" class="form-control" name="tanggal" value="{{ $data->tanggal ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Catatan</label>
                        <textarea class="form-control" name="catatan" rows="4" placeholder="Catatan terkait usulan...">{{ $data->catatan ?? '' }}</textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
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
                    <tr><td class="text-muted">Kabupaten</td><td>{{ $knmp->kabupaten_kota ?? 'N/A' }}</td></tr>
                    <tr><td class="text-muted">Kecamatan</td><td>{{ $knmp->kecamatan ?? 'N/A' }}</td></tr>
                    <tr><td class="text-muted">Desa</td><td>{{ $knmp->desa_kelurahan ?? 'N/A' }}</td></tr>
                    <tr><td class="text-muted">Tahap</td><td><span class="badge bg-primary text-uppercase">{{ $knmp->tahap_label }}</span></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
