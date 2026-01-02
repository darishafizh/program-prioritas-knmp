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
                <h4 class="page-title">Survey KNMP</h4>
                <p class="text-muted font-14">
                    Menu ini adalah daftar Kampung Nelayan Merah Putih (KNMP) yang menjadi target survei. Di halaman
                    ini,
                    Anda dapat melihat daftar KNMP beserta informasi terkait seperti desa, kecamatan, kabupaten, dan
                    provinsi.
                    Untuk memulai pengisian survei, klik tombol "Input Survey" pada baris KNMP yang diinginkan.
                </p>
            </div>
        </div>
    </div>
    <!-- end page title -->

    {{-- <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="row">
                    <div class="col-4">
                        <label for="exampleInputEmail1" class="form-label">Pilih Provinsi</label>
                        <select class="form-control select2" data-toggle="select2">
                            <option>Select</option>
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

                    <div class="col-4">
                        <label for="exampleInputEmail1" class="form-label">Pilih Kabupaten</label>
                        <select class="form-control select2" data-toggle="select2">
                            <option>Select</option>
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

                    <div class="col-4 d-flex float-end justify-content-start">
                        <button type="button" class="btn btn-primary align-self-end">Filter</button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Daftar knmp</h4>

                    <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap">
                        <thead>
                            <tr>
                                <th>Nama KNMP</th>
                                <th>Desa</th>
                                <th>Kecamatan</th>
                                <th>Kabupaten</th>
                                <th>Provinsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($knmps as $knmp)
                                <tr>
                                    <td>{{ $knmp->nama ?? 'N/A' }}</td>
                                    <td>{{ $knmp->village->name ?? 'N/A' }}</td>
                                    <td>{{ $knmp->district->name ?? 'N/A' }}</td>
                                    <td>{{ $knmp->regency->name ?? 'N/A' }}</td>
                                    <td>{{ $knmp->province->name ?? 'N/A' }}</td>
                                    <td>
                                        <a type="button" href="{{ route('survey.forms.index', $knmp->id) }}"
                                            class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="left"
                                            title="Input Survey"><i class="mdi mdi-clipboard-edit-outline font-16"></i>
                                        </a>
                                        <a type="button" href="{{ route('survey.forms.edit-responden', $knmp->id) }}"
                                            class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Edit Responden"><i class="mdi mdi-account-group-outline font-16"></i>
                                        </a>
                                        {{-- <a type="button" href="" class="btn btn-sm btn-success" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Lihat Detail"><i
                                                class="mdi mdi-eye-outline font-16"></i>
                                        </a> --}}
                                        <a type="button" href="{{ route('survey.questionnaires-pdf', $knmp->id) }}"
                                            class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Lihat PDF"><i class="mdi mdi-file-pdf-box font-16"></i>
                                        </a>
                                        <a href="{{ route('survey.evidence', $knmp->id) }}" class="btn btn-sm btn-info"
                                            data-bs-toggle="tooltip" title="Evidence (Galeri)">
                                            <i class="mdi mdi-image-multiple-outline font-16"></i>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            "use strict";
            $("#scroll-horizontal-datatable").DataTable({
                scrollX: true,
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    }
                },
                drawCallback: function () {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                }
            });
            $(".dataTables_length select").addClass("form-select form-select-sm");
            $(".dataTables_length label").addClass("form-label");
        });
    </script>
@endpush