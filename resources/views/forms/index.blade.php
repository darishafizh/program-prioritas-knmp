@extends('layouts.app')

@section('content')
    <div class="row mt-3">
        <div class="col-xl-6">
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
                                            <label for="simpleinput" class="form-label">Nama Responden</label>
                                            <input type="text" id="simpleinput" class="form-control"
                                                placeholder="Masukan data responden">
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-3">
                                                <label for="simpleinput" class="form-label">Provinsi</label>
                                                <select class="form-control select2" data-toggle="select2">
                                                    <option selected disabled>Pilih provinsi</option>
                                                    <optgroup label="Alaskan/Hawaiian Time Zone">
                                                        <option value="AK">Alaska</option>
                                                        <option value="HI">Hawaii</option>
                                                    </optgroup>
                                                    <optgroup label="Pacific Time Zone">
                                                        <option value="CA">California</option>
                                                        <option value="NV">Nevada</option>
                                                        <option value="OR">Oregon</option>
                                                        <option value="WA">Washington</option>
                                                    </optgroup>
                                                    <optgroup label="Mountain Time Zone">
                                                        <option value="AZ">Arizona</option>
                                                        <option value="CO">Colorado</option>
                                                        <option value="ID">Idaho</option>
                                                        <option value="MT">Montana</option>
                                                        <option value="NE">Nebraska</option>
                                                        <option value="NM">New Mexico</option>
                                                        <option value="ND">North Dakota</option>
                                                        <option value="UT">Utah</option>
                                                        <option value="WY">Wyoming</option>
                                                    </optgroup>
                                                    <optgroup label="Central Time Zone">
                                                        <option value="AL">Alabama</option>
                                                        <option value="AR">Arkansas</option>
                                                        <option value="IL">Illinois</option>
                                                        <option value="IA">Iowa</option>
                                                        <option value="KS">Kansas</option>
                                                        <option value="KY">Kentucky</option>
                                                        <option value="LA">Louisiana</option>
                                                        <option value="MN">Minnesota</option>
                                                        <option value="MS">Mississippi</option>
                                                        <option value="MO">Missouri</option>
                                                        <option value="OK">Oklahoma</option>
                                                        <option value="SD">South Dakota</option>
                                                        <option value="TX">Texas</option>
                                                        <option value="TN">Tennessee</option>
                                                        <option value="WI">Wisconsin</option>
                                                    </optgroup>
                                                    <optgroup label="Eastern Time Zone">
                                                        <option value="CT">Connecticut</option>
                                                        <option value="DE">Delaware</option>
                                                        <option value="FL">Florida</option>
                                                        <option value="GA">Georgia</option>
                                                        <option value="IN">Indiana</option>
                                                        <option value="ME">Maine</option>
                                                        <option value="MD">Maryland</option>
                                                        <option value="MA">Massachusetts</option>
                                                        <option value="MI">Michigan</option>
                                                        <option value="NH">New Hampshire</option>
                                                        <option value="NJ">New Jersey</option>
                                                        <option value="NY">New York</option>
                                                        <option value="NC">North Carolina</option>
                                                        <option value="OH">Ohio</option>
                                                        <option value="PA">Pennsylvania</option>
                                                        <option value="RI">Rhode Island</option>
                                                        <option value="SC">South Carolina</option>
                                                        <option value="VT">Vermont</option>
                                                        <option value="VA">Virginia</option>
                                                        <option value="WV">West Virginia</option>
                                                    </optgroup>
                                                </select>
                                            </div>

                                            <div class="col-3">
                                                <label for="simpleinput" class="form-label">Kabupaten</label>
                                                <select class="form-control select2" data-toggle="select2">
                                                    <option selected disabled>Pilih Kabupaten</option>
                                                    <optgroup label="Alaskan/Hawaiian Time Zone">
                                                        <option value="AK">Alaska</option>
                                                        <option value="HI">Hawaii</option>
                                                    </optgroup>
                                                    <optgroup label="Pacific Time Zone">
                                                        <option value="CA">California</option>
                                                        <option value="NV">Nevada</option>
                                                        <option value="OR">Oregon</option>
                                                        <option value="WA">Washington</option>
                                                    </optgroup>
                                                    <optgroup label="Mountain Time Zone">
                                                        <option value="AZ">Arizona</option>
                                                        <option value="CO">Colorado</option>
                                                        <option value="ID">Idaho</option>
                                                        <option value="MT">Montana</option>
                                                        <option value="NE">Nebraska</option>
                                                        <option value="NM">New Mexico</option>
                                                        <option value="ND">North Dakota</option>
                                                        <option value="UT">Utah</option>
                                                        <option value="WY">Wyoming</option>
                                                    </optgroup>
                                                    <optgroup label="Central Time Zone">
                                                        <option value="AL">Alabama</option>
                                                        <option value="AR">Arkansas</option>
                                                        <option value="IL">Illinois</option>
                                                        <option value="IA">Iowa</option>
                                                        <option value="KS">Kansas</option>
                                                        <option value="KY">Kentucky</option>
                                                        <option value="LA">Louisiana</option>
                                                        <option value="MN">Minnesota</option>
                                                        <option value="MS">Mississippi</option>
                                                        <option value="MO">Missouri</option>
                                                        <option value="OK">Oklahoma</option>
                                                        <option value="SD">South Dakota</option>
                                                        <option value="TX">Texas</option>
                                                        <option value="TN">Tennessee</option>
                                                        <option value="WI">Wisconsin</option>
                                                    </optgroup>
                                                    <optgroup label="Eastern Time Zone">
                                                        <option value="CT">Connecticut</option>
                                                        <option value="DE">Delaware</option>
                                                        <option value="FL">Florida</option>
                                                        <option value="GA">Georgia</option>
                                                        <option value="IN">Indiana</option>
                                                        <option value="ME">Maine</option>
                                                        <option value="MD">Maryland</option>
                                                        <option value="MA">Massachusetts</option>
                                                        <option value="MI">Michigan</option>
                                                        <option value="NH">New Hampshire</option>
                                                        <option value="NJ">New Jersey</option>
                                                        <option value="NY">New York</option>
                                                        <option value="NC">North Carolina</option>
                                                        <option value="OH">Ohio</option>
                                                        <option value="PA">Pennsylvania</option>
                                                        <option value="RI">Rhode Island</option>
                                                        <option value="SC">South Carolina</option>
                                                        <option value="VT">Vermont</option>
                                                        <option value="VA">Virginia</option>
                                                        <option value="WV">West Virginia</option>
                                                    </optgroup>
                                                </select>
                                            </div>

                                            <div class="col-3">
                                                <label for="simpleinput" class="form-label">Kecamatan</label>
                                                <select class="form-control select2" data-toggle="select2">
                                                    <option selected disabled>Pilih Kecamatan</option>
                                                    <optgroup label="Alaskan/Hawaiian Time Zone">
                                                        <option value="AK">Alaska</option>
                                                        <option value="HI">Hawaii</option>
                                                    </optgroup>
                                                    <optgroup label="Pacific Time Zone">
                                                        <option value="CA">California</option>
                                                        <option value="NV">Nevada</option>
                                                        <option value="OR">Oregon</option>
                                                        <option value="WA">Washington</option>
                                                    </optgroup>
                                                    <optgroup label="Mountain Time Zone">
                                                        <option value="AZ">Arizona</option>
                                                        <option value="CO">Colorado</option>
                                                        <option value="ID">Idaho</option>
                                                        <option value="MT">Montana</option>
                                                        <option value="NE">Nebraska</option>
                                                        <option value="NM">New Mexico</option>
                                                        <option value="ND">North Dakota</option>
                                                        <option value="UT">Utah</option>
                                                        <option value="WY">Wyoming</option>
                                                    </optgroup>
                                                    <optgroup label="Central Time Zone">
                                                        <option value="AL">Alabama</option>
                                                        <option value="AR">Arkansas</option>
                                                        <option value="IL">Illinois</option>
                                                        <option value="IA">Iowa</option>
                                                        <option value="KS">Kansas</option>
                                                        <option value="KY">Kentucky</option>
                                                        <option value="LA">Louisiana</option>
                                                        <option value="MN">Minnesota</option>
                                                        <option value="MS">Mississippi</option>
                                                        <option value="MO">Missouri</option>
                                                        <option value="OK">Oklahoma</option>
                                                        <option value="SD">South Dakota</option>
                                                        <option value="TX">Texas</option>
                                                        <option value="TN">Tennessee</option>
                                                        <option value="WI">Wisconsin</option>
                                                    </optgroup>
                                                    <optgroup label="Eastern Time Zone">
                                                        <option value="CT">Connecticut</option>
                                                        <option value="DE">Delaware</option>
                                                        <option value="FL">Florida</option>
                                                        <option value="GA">Georgia</option>
                                                        <option value="IN">Indiana</option>
                                                        <option value="ME">Maine</option>
                                                        <option value="MD">Maryland</option>
                                                        <option value="MA">Massachusetts</option>
                                                        <option value="MI">Michigan</option>
                                                        <option value="NH">New Hampshire</option>
                                                        <option value="NJ">New Jersey</option>
                                                        <option value="NY">New York</option>
                                                        <option value="NC">North Carolina</option>
                                                        <option value="OH">Ohio</option>
                                                        <option value="PA">Pennsylvania</option>
                                                        <option value="RI">Rhode Island</option>
                                                        <option value="SC">South Carolina</option>
                                                        <option value="VT">Vermont</option>
                                                        <option value="VA">Virginia</option>
                                                        <option value="WV">West Virginia</option>
                                                    </optgroup>
                                                </select>
                                            </div>

                                            <div class="col-3">
                                                <label for="simpleinput" class="form-label">Desa / Kelurahan</label>
                                                <select class="form-control select2" data-toggle="select2">
                                                    <option selected disabled>Pilih Desa/Kelurahan</option>
                                                    <optgroup label="Alaskan/Hawaiian Time Zone">
                                                        <option value="AK">Alaska</option>
                                                        <option value="HI">Hawaii</option>
                                                    </optgroup>
                                                    <optgroup label="Pacific Time Zone">
                                                        <option value="CA">California</option>
                                                        <option value="NV">Nevada</option>
                                                        <option value="OR">Oregon</option>
                                                        <option value="WA">Washington</option>
                                                    </optgroup>
                                                    <optgroup label="Mountain Time Zone">
                                                        <option value="AZ">Arizona</option>
                                                        <option value="CO">Colorado</option>
                                                        <option value="ID">Idaho</option>
                                                        <option value="MT">Montana</option>
                                                        <option value="NE">Nebraska</option>
                                                        <option value="NM">New Mexico</option>
                                                        <option value="ND">North Dakota</option>
                                                        <option value="UT">Utah</option>
                                                        <option value="WY">Wyoming</option>
                                                    </optgroup>
                                                    <optgroup label="Central Time Zone">
                                                        <option value="AL">Alabama</option>
                                                        <option value="AR">Arkansas</option>
                                                        <option value="IL">Illinois</option>
                                                        <option value="IA">Iowa</option>
                                                        <option value="KS">Kansas</option>
                                                        <option value="KY">Kentucky</option>
                                                        <option value="LA">Louisiana</option>
                                                        <option value="MN">Minnesota</option>
                                                        <option value="MS">Mississippi</option>
                                                        <option value="MO">Missouri</option>
                                                        <option value="OK">Oklahoma</option>
                                                        <option value="SD">South Dakota</option>
                                                        <option value="TX">Texas</option>
                                                        <option value="TN">Tennessee</option>
                                                        <option value="WI">Wisconsin</option>
                                                    </optgroup>
                                                    <optgroup label="Eastern Time Zone">
                                                        <option value="CT">Connecticut</option>
                                                        <option value="DE">Delaware</option>
                                                        <option value="FL">Florida</option>
                                                        <option value="GA">Georgia</option>
                                                        <option value="IN">Indiana</option>
                                                        <option value="ME">Maine</option>
                                                        <option value="MD">Maryland</option>
                                                        <option value="MA">Massachusetts</option>
                                                        <option value="MI">Michigan</option>
                                                        <option value="NH">New Hampshire</option>
                                                        <option value="NJ">New Jersey</option>
                                                        <option value="NY">New York</option>
                                                        <option value="NC">North Carolina</option>
                                                        <option value="OH">Ohio</option>
                                                        <option value="PA">Pennsylvania</option>
                                                        <option value="RI">Rhode Island</option>
                                                        <option value="SC">South Carolina</option>
                                                        <option value="VT">Vermont</option>
                                                        <option value="VA">Virginia</option>
                                                        <option value="WV">West Virginia</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Pekerjaan / Jabaran
                                                Responden</label>
                                            <input type="text" id="simpleinput" class="form-control"
                                                placeholder="Masukan pekerjaan / jabatan responden">
                                        </div>

                                        <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Jenis Program</label>
                                            <input type="text" id="simpleinput" class="form-control"
                                                placeholder="Masukan jenis program">
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-0">
                            <div class="card-header" id="headingTwo">
                                <h5 class="m-0">
                                    <a class="custom-accordion-title collapsed d-block pt-2 pb-2"
                                        data-bs-toggle="collapse" href="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        2. Keterangan Enumerator
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="card-body">
                                    <form>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label for="simpleinput" class="form-label">Nama Enumerator</label>
                                                <input type="text" id="simpleinput" class="form-control"
                                                    placeholder="Masukan nama enumerator">
                                            </div>

                                            <div class="col-6">
                                                <label for="simpleinput" class="form-label">Tanggal Wawancara</label>
                                                <input class="form-control" id="example-date" type="date"
                                                    name="date">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label for="simpleinput" class="form-label">Tanggal Editing</label>
                                                <input class="form-control" id="example-date" type="date"
                                                    name="date">
                                            </div>

                                            <div class="col-6">
                                                <label for="simpleinput" class="form-label">Nama Pemvalidasi</label>
                                                <input type="text" id="simpleinput" class="form-control"
                                                    placeholder="Masukan nama pemvalidasi">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-0">
                            <div class="card-header" id="headingThree">
                                <h5 class="m-0">
                                    <a class="custom-accordion-title collapsed d-block pt-2 pb-2"
                                        data-bs-toggle="collapse" href="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        3. Target & Relasi
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample">
                                <div class="card-body">
                                    <form>
                                        <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Nama KNMP</label>
                                            <input type="text" id="simpleinput" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="simpleinput" class="form-label">PPK</label>
                                            <input type="text" id="simpleinput" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Kontraktor Pelaksana</label>
                                            <input type="text" id="simpleinput" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Kontraktor Pengawas</label>
                                            <input type="text" id="simpleinput" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Target Fisik</label>
                                            <input type="number" id="simpleinput" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Realisasi Fisik</label>
                                            <input type="number" id="simpleinput" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Deviasi</label>
                                            <input type="number" id="simpleinput" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Target Keuangan</label>
                                            <input type="number" id="simpleinput" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="simpleinput" class="form-label">Realisasi Keuangan</label>
                                            <input type="number" id="simpleinput" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-textarea" class="form-label">Permasalahan 1</label>
                                            <textarea class="form-control" id="example-textarea" rows="1"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="example-textarea" class="form-label">Rekomendasi 1</label>
                                            <textarea class="form-control" id="example-textarea" rows="1"></textarea>
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
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="simpleinput" class="form-label">Nama kampung</label>
                                                    <input type="text" id="simpleinput" class="form-control">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="simpleinput" class="form-label">Lingkungan Kawasan</label>
                                                    <input type="text" id="simpleinput" class="form-control">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="simpleinput" class="form-label">Aktivitas usaha
                                                        nelayan</label>
                                                    <input type="text" id="simpleinput" class="form-control">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="simpleinput" class="form-label">Sarana dan Prasarana yang
                                                        tersedia</label>
                                                    <input type="text" id="simpleinput" class="form-control">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="simpleinput" class="form-label">Status dan Kepemilikan
                                                        Tanah lokasi KNMP</label>
                                                    <input type="text" id="simpleinput" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="simpleinput" class="form-label">Nama Kopdeskel Merah Putih
                                                        Pengelola KNMP</label>
                                                    <input type="text" id="simpleinput" class="form-control">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="simpleinput" class="form-label">Dasar Hukum
                                                        Kopdeskel</label>
                                                    <input type="text" id="simpleinput" class="form-control">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="simpleinput" class="form-label">Ketua Kopdeskel</label>
                                                    <input type="text" id="simpleinput" class="form-control">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="simpleinput" class="form-label">Status dalam
                                                        e-Kusuka</label>
                                                    <input type="text" id="simpleinput" class="form-control">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="simpleinput" class="form-label">Jenis usaha sebelum
                                                        KNMP</label>
                                                    <input type="text" id="simpleinput" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-0">
                            <div class="card-header" id="headingSix">
                                <h5 class="m-0">
                                    <a class="custom-accordion-title collapsed d-block pt-2 pb-2"
                                        data-bs-toggle="collapse" href="#collapseSix" aria-expanded="false"
                                        aria-controls="collapseSix">
                                        6. Penambahan Aset
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseSix" class="collapse" aria-labelledby="headingSix"
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
                            <div class="card-header" id="headingSeven">
                                <h5 class="m-0">
                                    <a class="custom-accordion-title collapsed d-block pt-2 pb-2"
                                        data-bs-toggle="collapse" href="#collapseSeven" aria-expanded="false"
                                        aria-controls="collapseSeven">
                                        7. Kelembagaan & Permodalan
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven"
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
                            <div class="card-header" id="headingEight">
                                <h5 class="m-0">
                                    <a class="custom-accordion-title collapsed d-block pt-2 pb-2"
                                        data-bs-toggle="collapse" href="#collapseEight" aria-expanded="false"
                                        aria-controls="collapseEight">
                                        8. Penyerapan Tenaga Kerja
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseEight" class="collapse" aria-labelledby="headingEight"
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
                            <div class="card-header" id="headingNine">
                                <h5 class="m-0">
                                    <a class="custom-accordion-title collapsed d-block pt-2 pb-2"
                                        data-bs-toggle="collapse" href="#collapseNine" aria-expanded="false"
                                        aria-controls="collapseNine">
                                        9. Kesejahteraan
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseNine" class="collapse" aria-labelledby="headingNine"
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
                            <div class="card-header" id="headingTen">
                                <h5 class="m-0">
                                    <a class="custom-accordion-title collapsed d-block pt-2 pb-2"
                                        data-bs-toggle="collapse" href="#collapseTen" aria-expanded="false"
                                        aria-controls="collapseTen">
                                        10. Manajemen
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseTen" class="collapse" aria-labelledby="headingTen"
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

                    <div class="float-end">
                        <button type="button" class="btn btn-secondary mt-3">Simpan Draft</button>
                        <button type="button" class="btn btn-primary mt-3">Submit</button>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
@endsection
