@extends('layouts.app')

@section('content')

<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Input data knmp</h4>
                <p class="text-muted font-14 mb-3">
                    Using the card component, you can
                    extend the default collapse behavior to create an accordion. To properly achieve
                    the accordion style, be sure to use <code>.accordion</code> as a wrapper.
                </p>

                <div class="accordion" id="accordionExample">
                    <div class="card mb-0">
                        <div class="card-header" id="headingOne">
                            <h5 class="m-0">
                                <a class="custom-accordion-title d-block pt-2 pb-2" data-bs-toggle="collapse"
                                    href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    1. Informasi Umum
                                </a>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="card-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter email">
                                        <small id="emailHelp" class="form-text text-muted">We'll never share
                                            your email with anyone else.</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1"
                                            placeholder="Password">
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-0">
                        <div class="card-header" id="headingTwo">
                            <h5 class="m-0">
                                <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                                    href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    2. Keterangan Enumerator
                                </a>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="card-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter email">
                                        <small id="emailHelp" class="form-text text-muted">We'll never share
                                            your email with anyone else.</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1"
                                            placeholder="Password">
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-0">
                        <div class="card-header" id="headingThree">
                            <h5 class="m-0">
                                <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                                    href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    3. Target & Relasi
                                </a>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                            data-bs-parent="#accordionExample">
                            <div class="card-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email
                                            address</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter email">
                                        <small id="emailHelp" class="form-text text-muted">We'll never share
                                            your email with anyone else.</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1"
                                            placeholder="Password">
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-0">
                        <div class="card-header" id="headingFour">
                            <h5 class="m-0">
                                <a class="custom-accordion-title collapsed d-block pt-2 pb-2"
                                    data-bs-toggle="collapse" href="#collapseFour" aria-expanded="false"
                                    aria-controls="collapseFour">
                                    4. Progress Per Komponen
                                </a>
                            </h5>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                            data-bs-parent="#accordionExample">
                            <div class="card-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email
                                            address</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter email">
                                        <small id="emailHelp" class="form-text text-muted">We'll never share
                                            your email with anyone else.</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1"
                                            placeholder="Password">
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-0">
                        <div class="card-header" id="headingFive">
                            <h5 class="m-0">
                                <a class="custom-accordion-title collapsed d-block pt-2 pb-2"
                                    data-bs-toggle="collapse" href="#collapseFive" aria-expanded="false"
                                    aria-controls="collapseFive">
                                    5. Profil KNMP
                                </a>
                            </h5>
                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive"
                            data-bs-parent="#accordionExample">
                            <div class="card-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email
                                            address</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter email">
                                        <small id="emailHelp" class="form-text text-muted">We'll never share
                                            your email with anyone else.</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1"
                                            placeholder="Password">
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-0">
                    <div class="card-header" id="headingSix">
                        <h5 class="m-0">
                            <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                                href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                6. Penambahan Aset
                            </a>
                        </h5>
                    </div>
                    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                        <div class="card-body">
                            @include('forms._penambahan_aset_form')
                        </div>
                    </div>
                </div>

                <div class="card mb-0">
                    <div class="card-header" id="headingSeven">
                        <h5 class="m-0">
                            <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                                href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                7. Kelembagaan & Permodalan
                            </a>
                        </h5>
                    </div>
                    <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                        <div class="card-body">
                            @include('forms._kelembagaan_permodalan_form')
                        </div>
                    </div>
                </div>

                <div class="card mb-0">
                    <div class="card-header" id="headingEight">
                        <h5 class="m-0">
                            <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                                href="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                8. Penyerapan Tenaga Kerja
                            </a>
                        </h5>
                    </div>
                    <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                        <div class="card-body">
                            @include('forms._penyerapan_tenaga_kerja_form')
                        </div>
                    </div>
                </div>

                <div class="card mb-0">
                    <div class="card-header" id="headingNine">
                        <h5 class="m-0">
                            <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                                href="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                9. Kesejahteraan
                            </a>
                        </h5>
                    </div>
                    <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-bs-parent="#accordionExample">
                        <div class="card-body">
                            @include('forms._kesejahteraan_form')
                        </div>
                    </div>
                </div>

                <div class="card mb-0">
                    <div class="card-header" id="headingTen">
                        <h5 class="m-0">
                            <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-bs-toggle="collapse"
                                href="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                10. Manajemen
                            </a>
                        </h5>
                    </div>
                    <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-bs-parent="#accordionExample">
                        <div class="card-body">
                            @include('forms._manajemen_form')
                        </div>
                    </div>
                </div>

                <div class="float-end">
                    <button type="button" class="btn btn-secondary mt-3">Simpan Draft</button>
                    <button type="button" class="btn btn-primary mt-3">Submit</button>
                </div>

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>

@endsection