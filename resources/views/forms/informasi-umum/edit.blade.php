@extends('layouts.app')

@section('content')
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Edit Informasi Umum</h4>

                <form method="POST" action="{{ route('forms.informasi_umum.update', $item->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Nama Responden --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Responden</label>
                        <input type="text" name="nama_responden" class="form-control"
                            value="{{ $item->nama_responden }}" required>
                    </div>

                    {{-- Wilayah --}}
                    <div class="row g-2 mb-3">
                        <div class="col-lg-3 col-md-6 col-12">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="provinsi" class="form-control"
                                value="{{ $item->provinsi }}" required>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12">
                            <label class="form-label">Kabupaten</label>
                            <input type="text" name="kabupaten" class="form-control"
                                value="{{ $item->kabupaten }}" required>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control"
                                value="{{ $item->kecamatan }}" required>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12">
                            <label class="form-label">Desa / Kelurahan</label>
                            <input type="text" name="desa_kelurahan" class="form-control"
                                value="{{ $item->desa }}" required>
                        </div>
                    </div>

                    {{-- Pekerjaan --}}
                    <div class="mb-3">
                        <label class="form-label">Pekerjaan / Jabatan</label>
                        <input type="text" name="pekerjaan_jabatan" class="form-control"
                            value="{{ $item->status_responden }}" required>
                    </div>

                    {{-- Jenis Program --}}
                    <div class="mb-3">
                        <label class="form-label">Jenis Program</label>
                        <input type="text" name="jenis_program" class="form-control"
                            value="{{ $item->jenis_program }}" required>
                    </div>

                    {{-- Tombol --}}
                    <div class="mt-4">
                        <a href="{{ route('forms.informasi_umum') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary ms-2">Update</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection