@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/survey-custom.css') }}">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between"
                style="background: transparent; box-shadow: none; padding: 15px 0; margin-bottom: 20px;">
                <h4 class="page-title mb-0">
                    <i class="mdi mdi-file-pdf-box me-1"></i> Daftar Kuesioner PDF
                </h4>
                <div class="page-title-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('survey.index') }}">Survey</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kuesioner PDF</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Header Title -->
    <div class="page-title-box">
        <h4>
            <i class="mdi mdi-file-pdf-box"></i> Daftar Kuesioner PDF
        </h4>
        <p>Lihat dan kelola daftar kuesioner yang telah diisi per responden di {{ $knmp->nama_knmp ?? 'KNMP' }}</p>
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
                <h6>Kuesioner Terisi</h6>
                <p>{{ $responden->filter(fn($r) => $r['is_complete'])->count() }}/{{ count($responden) }}</p>
            </div>
        </div>
    </div>


    <!-- Questionnaire List -->
    @if($responden->isEmpty())
        <div class="empty-state">
            <i class="mdi mdi-file-pdf-box"></i>
            <h5>Belum Ada Kuesioner</h5>
            <p>Tidak ada responden yang telah didata untuk KNMP ini</p>
        </div>
    @else
        <div class="questionnaire-list">
            @foreach($responden as $item)
                <div class="questionnaire-card">
                    <!-- Header -->
                    <div class="questionnaire-header">
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
                    <div class="questionnaire-body">
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
                            <span class="detail-label">Form Terisi</span>
                            <span class="detail-value">{{ $item['filled_forms'] }}/{{ $item['total_forms'] }} Form</span>
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
                    <div class="questionnaire-footer">
                        @if($item['is_complete'])
                            <a href="{{ route('survey.questionnaire-pdf', ['knmp' => hashid($knmp->id), 'responden' => hashid($item['id'])]) }}"
                                class="btn-view-pdf" target="_blank">
                                <i class="mdi mdi-file-pdf-box"></i>
                                Lihat PDF
                            </a>
                        @else
                            <button class="btn-view-pdf" disabled>
                                <i class="mdi mdi-lock"></i>
                                Belum Terisi
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection