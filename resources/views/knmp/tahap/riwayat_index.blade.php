@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-left">
                <h4 class="page-title"><i class="mdi mdi-history me-2"></i>Riwayat Tahap KNMP</h4>
                <p class="text-muted mb-0" style="font-size:0.875rem;">Log perpindahan tahap seluruh KNMP.</p>
            </div>
            <div class="page-title-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Beranda</a></li>
                        <li class="breadcrumb-item">KNMP</li>
                        <li class="breadcrumb-item active">Riwayat Tahap</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

@if(request('batch_id'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <i class="mdi mdi-filter me-1"></i>Menampilkan riwayat untuk Batch ID: <code>{{ request('batch_id') }}</code>
    <a href="{{ route('riwayat_tahap.index') }}" class="ms-2 text-decoration-underline">Reset Filter</a>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>KNMP</th>
                                <th>Dari</th>
                                <th>Ke</th>
                                <th>Keterangan</th>
                                <th>Batch</th>
                                <th>Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $r)
                            <tr>
                                <td>{{ $r->created_at->format('d/m/Y H:i') }}</td>
                                <td class="fw-medium">{{ $r->knmp->nama ?? 'N/A' }}</td>
                                <td><span class="badge bg-secondary text-uppercase">{{ $r->tahap_dari ?? '-' }}</span></td>
                                <td><span class="badge bg-primary text-uppercase">{{ $r->tahap_ke }}</span></td>
                                <td>{{ $r->keterangan ?? '-' }}</td>
                                <td>
                                    @if($r->batch_id)
                                    <a href="{{ route('riwayat_tahap.index', ['batch_id' => $r->batch_id]) }}" class="text-primary" style="font-size:0.75rem;">{{ Str::limit($r->batch_id, 8) }}</a>
                                    @else - @endif
                                </td>
                                <td>{{ $r->created_by ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada riwayat perpindahan tahap.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $riwayat->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
