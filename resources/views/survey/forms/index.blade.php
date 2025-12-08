@extends('layouts.app')

@section('content')
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
                        <div class="col-6">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <p class="mb-2"><span class="fw-bold me-2">Desa:</span> {{ $knmp->desa ?? 'N/A' }}
                                    </p>
                                    <p class="mb-0"><span class="fw-bold me-2">Kecamatan:</span>
                                        {{ $knmp->kecamatan ?? 'N/A' }}</p>
                                </li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <p class="mb-2"><span class="fw-bold me-2">Kabupaten:</span>
                                        {{ $knmp->kabupaten ?? 'N/A' }}</p>
                                    <p class="mb-0"><span class="fw-bold me-2">Provinsi:</span>
                                        {{ $knmp->provinsi ?? 'N/A' }}</p>
                                </li>
                            </ul>
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
                                1. Profil KNMP
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
                                2. Progres Pembangunan KNMP
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
                                3. Tanggapan Masyarakat Terkait Pembangunan KNMP
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
                                4. Tingkat Kebahagiaan Nelayan
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
                                5. Informasi Responden
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
                                6. Informasi Usaha (Kondisi Existing)
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
                                7. Informasi Pemasaran Hasil Perikanan (Kondisi Existing)
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
                                8. Informasi Pendapatan Rumah Tangga (Kondisi Existing)
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
                                9. Sosial dan Kelembagaan (Kondisi Existing)
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
                                10. Evidence
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

        <div class="col-12">
            <div class="card d-flex justify-content-end">
                <button type="button" class="btn btn-secondary m-2">Simpan Draft</button>
                <button type="submit" class="btn btn-primary m-2">Simpan Jawaban</button>
            </div>
        </div>
    </div>
@endsection
