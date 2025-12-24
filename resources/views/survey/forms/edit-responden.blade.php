@extends('layouts.app')

@section('content')
<style>
    .page-title-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px 0;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .page-title-box h4 {
        color: white;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .page-title-box p {
        color: rgba(255, 255, 255, 0.9);
        margin: 0;
        font-size: 14px;
    }

    .breadcrumb-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
    }

    .breadcrumb-nav a {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .breadcrumb-nav a:hover {
        color: #764ba2;
    }

    .breadcrumb-nav span {
        color: #999;
    }

    /* Header Info */
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-left: 4px solid #667eea;
    }

    .info-card h6 {
        font-size: 12px;
        font-weight: 600;
        color: #999;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .info-card p {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    /* Responden List */
    .responden-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .responden-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 2px solid #f0f0f0;
    }

    .responden-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
        border-color: #667eea;
    }

    .responden-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .avatar {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .responden-header .info {
        flex: 1;
    }

    .responden-header h5 {
        margin: 0 0 5px 0;
        font-weight: 700;
        font-size: 16px;
    }

    .responden-header p {
        margin: 0;
        font-size: 13px;
        opacity: 0.9;
    }

    /* Responden Body */
    .responden-body {
        padding: 20px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f5f5f5;
        font-size: 13px;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .responden-body .detail-label {
        color: #999;
        font-weight: 500;
    }

    .responden-body .detail-value {
        color: #333;
        font-weight: 600;
        text-align: right;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        margin-top: 10px;
    }

    .status-badge.complete {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.incomplete {
        background: #f8d7da;
        color: #721c24;
    }

    .responden-footer {
        padding: 20px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        gap: 10px;
    }

    .btn-edit {
        flex: 1;
        padding: 10px 15px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #f8f9fa;
        border-radius: 12px;
        margin-top: 30px;
    }

    .empty-state i {
        font-size: 80px;
        color: #ddd;
        display: block;
        margin-bottom: 20px;
    }

    .empty-state h5 {
        color: #999;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #ccc;
        margin: 0;
    }

    /* Back Button */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        color: #333;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        font-size: 13px;
        margin-bottom: 20px;
    }

    .btn-back:hover {
        background: #f5f5f5;
        border-color: #667eea;
        color: #667eea;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .responden-list {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .responden-list {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }

        .page-title-box {
            padding: 20px 0;
        }

        .page-title-box h4 {
            font-size: 20px;
        }

        .info-card {
            padding: 15px;
        }

        .info-card p {
            font-size: 14px;
        }
    }

    @media (max-width: 576px) {
        .responden-list {
            grid-template-columns: 1fr;
        }

        .responden-footer {
            flex-direction: column;
        }

        .btn-edit {
            width: 100%;
        }

        .page-title-box h4 {
            font-size: 18px;
        }

        .breadcrumb-nav {
            font-size: 12px;
        }
    }
</style>

<!-- Breadcrumb -->
<div class="breadcrumb-nav">
    <a href="{{ route('survey.index') }}">Survey</a>
    <span>/</span>
    <span>Edit Responden</span>
</div>

<!-- Header Title -->
<div class="page-title-box">
    <h4>
        <i class="mdi mdi-pencil-box"></i> Edit Data Responden
    </h4>
    <p>Edit dan kelola data responden per individu di {{ $knmp->nama ?? 'KNMP' }}</p>
</div>

<!-- Info Card -->
<div class="info-card">
    <div class="row">
        <div class="col-md-4">
            <h6>Kampung Nelayan</h6>
            <p>{{ $knmp->nama ?? 'N/A' }}</p>
        </div>
        <div class="col-md-4">
            <h6>Total Responden</h6>
            <p>{{ count($responden) }} Responden</p>
        </div>
        <div class="col-md-4">
            <h6>Data Terisi</h6>
            <p>{{ $responden->filter(fn($r) => $r['is_complete'])->count() }}/{{ count($responden) }}</p>
        </div>
    </div>
</div>

<!-- Back Button -->
<a href="{{ route('survey.index') }}" class="btn-back">
    <i class="mdi mdi-arrow-left"></i>
    Kembali ke Menu Survey
</a>

<!-- Responden List -->
@if($responden->isEmpty())
    <div class="empty-state">
        <i class="mdi mdi-account-multiple"></i>
        <h5>Belum Ada Responden</h5>
        <p>Tidak ada responden yang telah didaftarkan untuk KNMP ini</p>
    </div>
@else
    <div class="responden-list">
        @foreach($responden as $item)
            <div class="responden-card">
                <!-- Header -->
                <div class="responden-header">
                    <div class="avatar">
                        @if($item['jenis_kelamin'] === 'Perempuan')
                            👩
                        @else
                            👨
                        @endif
                    </div>
                    <div class="info">
                        <h5>{{ $item['nama_responden'] }}</h5>
                        <p>NIK: {{ $item['nik'] }}</p>
                    </div>
                </div>

                <!-- Body -->
                <div class="responden-body">
                    <div class="detail-row">
                        <span class="detail-label">Jenis Kelamin</span>
                        <span class="detail-value">{{ $item['jenis_kelamin'] }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Tanggal Wawancara</span>
                        <span class="detail-value">
                            {{ \Carbon\Carbon::parse($item['tanggal_wawancara'])->format('d/m/Y') }}
                        </span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Enumerator</span>
                        <span class="detail-value">{{ $item['nama_enumerator'] }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Jawaban Terisi</span>
                        <span class="detail-value">{{ $item['total_answers'] }} Soal</span>
                    </div>

                    @if($item['last_updated'])
                        <div class="detail-row">
                            <span class="detail-label">Terakhir Diperbarui</span>
                            <span class="detail-value">
                                {{ \Carbon\Carbon::parse($item['last_updated'])->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    @endif

                    <!-- Status Badge -->
                    @if($item['is_complete'])
                        <span class="status-badge complete">
                            <i class="mdi mdi-check-circle"></i> Terisi
                        </span>
                    @else
                        <span class="status-badge incomplete">
                            <i class="mdi mdi-alert-circle"></i> Belum Terisi
                        </span>
                    @endif
                </div>

                <!-- Footer -->
                <div class="responden-footer">
                    <a href="{{ route('forms.index', $knmp->id) }}?responden={{ $item['id'] }}" class="btn-edit">
                        <i class="mdi mdi-pencil"></i>
                        Edit Data
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
