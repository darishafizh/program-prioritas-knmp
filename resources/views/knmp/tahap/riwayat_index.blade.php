@extends('layouts.app')
@section('content')
<div class="row mb-3">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h4 class="page-title mb-0 d-flex align-items-center gap-2">
                    <i data-lucide="history" class="text-primary"></i>Riwayat Tahap KNMP
                </h4>
                <p class="text-muted mb-0 mt-1" style="font-size:0.875rem;">Log perpindahan tahap seluruh KNMP.</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Beranda</a></li>
                    <li class="breadcrumb-item">KNMP</li>
                    <li class="breadcrumb-item active">Riwayat Tahap</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

@if(request('batch_id'))
<div class="alert alert-info alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 10px;">
    <div class="d-flex align-items-center">
        <i data-lucide="filter" class="me-2 text-info" style="width: 18px; height: 18px;"></i>
        <span>Menampilkan riwayat untuk Batch ID: <code>{{ request('batch_id') }}</code></span>
        <a href="{{ route('riwayat_tahap.index') }}" class="ms-3 text-info text-decoration-underline" style="font-size: 0.85rem;">Reset Filter</a>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover table-centered mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="border-top-left-radius: 8px;">Waktu</th>
                                <th>Nama KNMP</th>
                                <th>Dari Tahap</th>
                                <th>Ke Tahap</th>
                                <th>Keterangan</th>
                                <th>Batch ID</th>
                                <th style="border-top-right-radius: 8px;">Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $r)
                            <tr>
                                <td class="text-muted" style="font-size: 0.85rem;">{{ $r->created_at->format('d/m/Y H:i') }}</td>
                                <td class="fw-medium text-dark">{{ $r->knmp->nama ?? 'N/A' }}</td>
                                <td>
                                    @if($r->tahap_dari)
                                        <span class="badge bg-secondary text-uppercase">{{ $r->tahap_dari }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-primary text-uppercase">{{ $r->tahap_ke }}</span></td>
                                <td>{{ $r->keterangan ?? '-' }}</td>
                                <td>
                                    @if($r->batch_id)
                                    <a href="{{ route('riwayat_tahap.index', ['batch_id' => $r->batch_id]) }}" class="badge bg-info text-white text-decoration-none" title="{{ $r->batch_id }}">
                                        {{ Str::limit($r->batch_id, 8) }}
                                    </a>
                                    @else 
                                    <span class="text-muted">-</span> 
                                    @endif
                                </td>
                                <td class="text-muted" style="font-size: 0.85rem;">{{ $r->created_by ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <i data-lucide="inbox" class="text-muted mb-2" style="width: 48px; height: 48px; opacity: 0.5;"></i>
                                        <span>Belum ada riwayat perpindahan tahap.</span>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $riwayat->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endpush
@endsection
