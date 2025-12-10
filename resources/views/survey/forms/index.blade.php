@extends('layouts.app')

@section('content')

{{-- ===================================================== --}}
{{-- AUTO CREATE ERROR ALERT IF VALIDATION FAILS --}}
{{-- ===================================================== --}}
@if($errors->any())
@php
session()->flash('error', 'Lengkapi semua form wajib diisi!');
@endphp
@endif


{{-- ===================================================== --}}
{{-- MODERN CARD ALERT --}}
{{-- ===================================================== --}}
@if(session('success') || session('error'))
<div id="customAlert" class="alert-overlay">
    <div class="alert-card {{ session('success') ? 'success' : 'error' }}">

        {{-- Icon Bulat --}}
        <div class="alert-icon-wrapper">
            <div class="alert-icon-circle">
                @if(session('success'))
                <span class="alert-icon">✓</span>
                @else
                <span class="alert-icon">✕</span>
                @endif
            </div>
        </div>

        {{-- Title --}}
        <h3 class="alert-title">
            {{ session('success') ? 'Success!' : 'Failed!' }}
        </h3>

        {{-- Subtitle --}}
        <p class="alert-subtitle">
            {{ session('success') ?? session('error') }}
        </p>

        {{-- Progress bar tipis --}}
        <div class="alert-progress">
            <div class="alert-progress-bar"></div>
        </div>

        {{-- Button --}}
        <button class="alert-btn">
            {{ session('success') ? 'DONE' : 'TRY AGAIN' }}
        </button>

    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const overlay = document.getElementById("customAlert");

        // Fade-in
        setTimeout(() => overlay.classList.add("show"), 10);

        // Auto close
        setTimeout(() => {
            overlay.classList.remove("show");
            setTimeout(() => overlay.remove(), 500);
        }, 3000);
    });
</script>
@endif




<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <form class="d-flex">
                </form>
            </div>
            <h4 class="page-title">Kuesioner KNMP</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">{{ $knmp->nama ?? 'Nama KNMP Tidak Ditemukan' }}</h4>

                <div class="row">
                    <div class="col-5">
                        <div class="row">
                            <div class="col-3">
                                <p class="mb-0 fw-bold">Desa</p>
                                <p class="mb-0 fw-bold">Kecamatan</p>
                                <p class="mb-0 fw-bold">Kabupaten</p>
                                <p class="mb-0 fw-bold">Provinsi</p>
                            </div>

                            <div class="col-1">
                                <p class="mb-0"><span class="fw-bold me-2">:</span></p>
                                <p class="mb-0"><span class="fw-bold me-2">:</span></p>
                                <p class="mb-0"><span class="fw-bold me-2">:</span></p>
                                <p class="mb-0"><span class="fw-bold me-2">:</span></p>
                            </div>

                            <div class="col-8">
                                <p class="mb-0">{{ $knmp->village->name ?? 'N/A' }}</p>
                                <p class="mb-0">{{ $knmp->district->name ?? 'N/A' }}</p>
                                <p class="mb-0">{{ $knmp->regency->name ?? 'N/A' }}</p>
                                <p class="mb-0">{{ $knmp->province->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-progress-wrench widget-icon bg-primary-lighten text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h5 class="my-0 fw-semibold">Progres Pembangunan KNMP</h5>
                                </div>
                                <h5 class="my-0">145/160</h5>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 58%" aria-valuenow="91"
                                    aria-valuemin="0" aria-valuemax="100">58%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="accordion" id="accordionExample">
            <div class="card mb-0">
                <div class="card-header" id="headingOne">
                    <h5 class="m-0">
                        <a class="custom-accordion-title d-block pt-2 pb-2" data-bs-toggle="collapse"
                            href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            A. Profil KNMP
                        </a>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.profile_knmp')
                    </div>
                </div>
            </div>
            <div class="card mb-0">
                <div class="card-header" id="headingTwo">
                    <h5 class="m-0">
                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                            href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            B. Proses Pembangunan KNMP
                        </a>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.progres_pembangunan_knmp')
                    </div>
                </div>
            </div>
            <div class="card mb-0">
                <div class="card-header" id="headingThree">
                    <h5 class="m-0">
                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                            href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            C. Tanggapan Masyarakat Terkait Pembangunan KNMP
                        </a>
                    </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.tanggapan_masyarakat')
                    </div>
                </div>
            </div>

            <div class="card mb-0">
                <div class="card-header" id="headingThree">
                    <h5 class="m-0">
                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                            href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            D. Tingkat Kebahagiaan Nelayan
                        </a>
                    </h5>
                </div>
                <div id="collapseFour" class="collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.tingkat_kebahagiaan_nelayan')
                    </div>
                </div>
            </div>

            <div class="card mb-0">
                <div class="card-header" id="headingThree">
                    <h5 class="m-0">
                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                            href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            E. Informasi Responden
                        </a>
                    </h5>
                </div>
                <div id="collapseFive" class="collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.informasi_responden')
                    </div>
                </div>
            </div>

            <div class="card mb-0">
                <div class="card-header" id="headingThree">
                    <h5 class="m-0">
                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                            href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            F. Informasi Usaha (Kondisi Existing)
                        </a>
                    </h5>
                </div>
                <div id="collapseSix" class="collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.informasi_usaha')
                    </div>
                </div>
            </div>

            <div class="card mb-0">
                <div class="card-header" id="headingThree">
                    <h5 class="m-0">
                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                            href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                            G. Informasi Pemasaran Hasil Perikanan (Kondisi Existing)
                        </a>
                    </h5>
                </div>
                <div id="collapseSeven" class="collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.informasi_pemasaran_hasil_perikanan')
                    </div>
                </div>
            </div>

            <div class="card mb-0">
                <div class="card-header" id="headingThree">
                    <h5 class="m-0">
                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                            href="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                            H. Informasi Pendapatan Rumah Tangga (Kondisi Existing)
                        </a>
                    </h5>
                </div>
                <div id="collapseEight" class="collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.informasi_pendapatan_rumah_tangga')
                    </div>
                </div>
            </div>

            <div class="card mb-0">
                <div class="card-header" id="headingThree">
                    <h5 class="m-0">
                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                            href="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                            I. Sosial dan Kelembagaan (Kondisi Existing)
                        </a>
                    </h5>
                </div>
                <div id="collapseNine" class="collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.sosial_dan_kelembagaan')
                    </div>
                </div>
            </div>

            <div class="card mb-0">
                <div class="card-header" id="headingThree">
                    <h5 class="m-0">
                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                            href="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                            J. Bukti Pendukung
                        </a>
                    </h5>
                </div>
                <div id="collapseEleven" class="collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="card-body">
                        @include('survey.forms.form_layouts.evidence')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection