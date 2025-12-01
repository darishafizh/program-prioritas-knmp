@extends('layouts.app')

@section('content')
    <div class="row mt-3">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Tambah Progres Per Komponen</h4>

                    <form method="POST" action="#">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:6%">No</th>
                                        <th>Jenis Komponen</th>
                                        <th style="width:12%">Jumlah Unit</th>
                                        <th style="width:16%">Realisasi Progres (%)</th>
                                        <th style="width:30%">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-secondary"><td colspan="5"><strong>A. Konstruksi</strong></td></tr>
                                    <tr>
                                        <td>A.1</td>
                                        <td>Tambatan Perahu / Dermaga</td>
                                        <td><input type="number" class="form-control form-control-sm" name="komponen[A][1][jumlah]"></td>
                                        <td><input type="number" min="0" max="100" class="form-control form-control-sm" name="komponen[A][1][progres]"></td>
                                        <td><input type="text" class="form-control form-control-sm" name="komponen[A][1][keterangan]"></td>
                                    </tr>
                                    <tr>
                                        <td>A.2</td>
                                        <td>Shelter pendaratan ikan</td>
                                        <td><input type="number" class="form-control form-control-sm" name="komponen[A][2][jumlah]"></td>
                                        <td><input type="number" min="0" max="100" class="form-control form-control-sm" name="komponen[A][2][progres]"></td>
                                        <td><input type="text" class="form-control form-control-sm" name="komponen[A][2][keterangan]"></td>
                                    </tr>
                                    <tr>
                                        <td>B.1</td>
                                        <td>Kapal penangkap ikan</td>
                                        <td><input type="number" class="form-control form-control-sm" name="komponen[B][1][jumlah]"></td>
                                        <td><input type="number" min="0" max="100" class="form-control form-control-sm" name="komponen[B][1][progres]"></td>
                                        <td><input type="text" class="form-control form-control-sm" name="komponen[B][1][keterangan]"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('forms.progres_per_komponen') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary ms-2">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
