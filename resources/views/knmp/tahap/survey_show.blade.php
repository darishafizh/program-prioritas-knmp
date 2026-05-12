@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-left">
                <h4 class="page-title"><i class="mdi mdi-clipboard-text-outline me-2"></i>Detail Tahap Survey</h4>
                <small class="text-muted">{{ $knmp->nama }}</small>
            </div>
            <div class="page-title-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('survey_tahap.index') }}">Survey</a></li>
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
            <div class="card-header" style="background: linear-gradient(135deg, #06b6d4, #0891b2); border: none;">
                <h5 class="card-title mb-0 text-white"><i class="mdi mdi-clipboard-text-outline me-2"></i>Data Tahap Survey</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('survey_tahap.store', $knmp->nama) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Latitude <span class="text-danger">*</span></label>
                            <input type="number" step="0.0000001" class="form-control" name="latitude" value="{{ $data->latitude ?? '' }}" placeholder="-6.1234567" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Longitude <span class="text-danger">*</span></label>
                            <input type="number" step="0.0000001" class="form-control" name="longitude" value="{{ $data->longitude ?? '' }}" placeholder="106.1234567" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Tanggal Survey</label>
                        <input type="date" class="form-control" name="tanggal" value="{{ $data->tanggal ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Catatan</label>
                        <textarea class="form-control" name="catatan" rows="4" placeholder="Catatan hasil survey...">{{ $data->catatan ?? '' }}</textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-info text-white">
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
                    <tr><td class="text-muted">Tahap</td><td><span class="badge bg-info text-uppercase">{{ $knmp->tahap_label }}</span></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
