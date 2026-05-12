@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-left">
                <h4 class="page-title"><i class="mdi mdi-gavel me-2"></i>Detail Tahap Lelang</h4>
                <small class="text-muted">{{ $knmp->nama }}</small>
            </div>
            <div class="page-title-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('lelang.index') }}">Lelang</a></li>
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
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-alert-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    {{-- Data Lelang --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, #f59e0b, #d97706); border: none;">
                <h5 class="card-title mb-0 text-white"><i class="mdi mdi-gavel me-2"></i>Data Tahap Lelang</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('lelang.store', $knmp->nama) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-medium">Nomor Paket <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nomor_paket" value="{{ $data->nomor_paket ?? '' }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Nilai HPS (Rp)</label>
                            <input type="number" step="0.01" class="form-control" name="nilai_hps" value="{{ $data->nilai_hps ?? '' }}" placeholder="0.00">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Nilai Kontrak (Rp)</label>
                            <input type="number" step="0.01" class="form-control" name="nilai_kontrak" value="{{ $data->nilai_kontrak ?? '' }}" placeholder="0.00">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Tanggal Penetapan</label>
                        <input type="date" class="form-control" name="tanggal_penetapan" value="{{ $data->tanggal_penetapan ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Catatan</label>
                        <textarea class="form-control" name="catatan" rows="3">{{ $data->catatan ?? '' }}</textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="mdi mdi-content-save me-1"></i>Simpan Data Lelang
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Penyedia Jasa Konstruksi --}}
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0"><i class="mdi mdi-account-hard-hat me-2"></i>Penyedia Jasa Konstruksi</h5>
            </div>
            <div class="card-body">
                @if($knmpKonstruksi->count() > 0)
                <div class="table-responsive mb-3">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Penyedia</th>
                                <th>Peran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($knmpKonstruksi as $kk)
                            <tr>
                                <td>{{ $kk->penyedia->nama ?? 'N/A' }}</td>
                                <td><span class="badge {{ $kk->peran === 'utama' ? 'bg-primary' : 'bg-secondary' }} text-uppercase">{{ $kk->peran }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted mb-3"><i class="mdi mdi-information-outline me-1"></i>Belum ada penyedia jasa konstruksi.</p>
                @endif

                @if($knmpKonstruksi->count() < 2)
                <form action="{{ route('lelang.penyedia.store', $knmp->nama) }}" method="POST">
                    @csrf
                    <div class="row g-2 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label fw-medium">Penyedia <span class="text-danger">*</span></label>
                            <select class="form-select" name="konstruksi_id" required>
                                <option value="">Pilih Penyedia</option>
                                @foreach($penyediaList as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Peran <span class="text-danger">*</span></label>
                            <select class="form-select" name="peran" required>
                                <option value="">Pilih Peran</option>
                                @if(!$knmpKonstruksi->where('peran', 'utama')->first())
                                    <option value="utama">Utama</option>
                                @endif
                                @if(!$knmpKonstruksi->where('peran', 'pendamping')->first())
                                    <option value="pendamping">Pendamping</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="mdi mdi-plus me-1"></i>Tambah
                            </button>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
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
                    <tr><td class="text-muted">Tahap</td><td><span class="badge bg-warning text-uppercase">{{ $knmp->tahap_label }}</span></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
