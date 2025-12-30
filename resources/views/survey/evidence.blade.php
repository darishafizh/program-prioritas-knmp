@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/evidence-custom.css') }}">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <h4 class="page-title"><i class="mdi mdi-file-image-marker me-2"></i>Bukti Pendukung</h4>
                    <small class="text-muted">{{ $knmp->nama ?? 'KNMP' }}</small>
                </div>
                <div class="page-title-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('survey.index') }}">Survey</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Bukti Pendukung</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Header Title -->
    <div class="page-title-box-evidence">
        <h4>
            <i class="mdi mdi-file-image-marker me-2"></i>Bukti Pendukung
        </h4>
        <p>Kelola bukti pendukung dan dokumentasi untuk {{ $knmp->nama ?? 'KNMP' }}</p>
    </div>

    <!-- Info Card -->
    <div class="info-card">
        <div class="row">
            <div class="col-md-4">
                <h6>Kampung Nelayan</h6>
                <p>{{ $knmp->nama ?? 'N/A' }}</p>
            </div>
            <div class="col-md-4">
                <h6>Lokasi</h6>
                <p>{{ $knmp->village->name ?? 'N/A' }}, {{ $knmp->district->name ?? 'N/A' }}</p>
            </div>
            <div class="col-md-4">
                <h6>Total File</h6>
                <p>{{ count($buktiUploads ?? []) }} File diupload</p>
            </div>
        </div>
    </div>

    <!-- Evidence Content -->
    <div class="card">
        <div class="card-body">
            @include('survey.forms.form_layouts.evidence')
        </div>
    </div>


    <script src="{{ asset('js/evidence-custom.js') }}"></script>
@endsection