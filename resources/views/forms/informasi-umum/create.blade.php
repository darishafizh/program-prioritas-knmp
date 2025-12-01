@extends('layouts.app')

@section('content')
<div class="row mt-3">
    {{-- Menggunakan col-12 untuk full width dan responsif --}}
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Tambah Informasi Umum</h4>

                {{-- Ganti action dengan route store yang sesuai --}}
                <form method="POST" action="{{ route('forms.informasi_umum.store') }}">
                    @csrf

                    {{-- 1. Nama Responden --}}
                    <div class="mb-3">
                        <label for="nama_responden" class="form-label">Nama Responden</label>
                        <input type="text" name="nama_responden" id="nama_responden" class="form-control" placeholder="Masukkan data responden" required>
                    </div>

                    {{-- 2. Wilayah (Provinsi, Kabupaten, Kecamatan, Desa/Kelurahan) --}}
                    {{-- Menggunakan row dan col-lg-3 agar 4 dropdown berada dalam 1 baris di layar besar --}}
                    <div class="row g-2 mb-3">

                        {{-- Provinsi --}}
                        <div class="col-lg-3 col-md-6 col-12">
                            <label for="provinsi" class="form-label">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="form-select" required>
                                <option value="">Pilih Provinsi...</option>
                                {{-- Data Hardcoded --}}
                                <option value="Jawa Barat">Jawa Barat</option>
                                <option value="Jawa Tengah">Jawa Tengah</option>
                                <option value="Jawa Timur">Jawa Timur</option>
                                <option value="DKI Jakarta">DKI Jakarta</option>
                            </select>
                        </div>

                        {{-- Kabupaten --}}
                        <div class="col-lg-3 col-md-6 col-12">
                            <label for="kabupaten" class="form-label">Kabupaten</label>
                            <select name="kabupaten" id="kabupaten" class="form-select" required>
                                <option value="">Pilih Kabupaten...</option>
                                {{-- Data Hardcoded --}}
                                <option value="Bandung">Bandung</option>
                                <option value="Semarang">Semarang</option>
                                <option value="Surabaya">Surabaya</option>
                                <option value="Jakarta Pusat">Jakarta Pusat</option>
                            </select>
                        </div>

                        {{-- Kecamatan --}}
                        <div class="col-lg-3 col-md-6 col-12">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" class="form-select" required>
                                <option value="">Pilih Kecamatan...</option>
                                {{-- Data Hardcoded --}}
                                <option value="Coblong">Coblong</option>
                                <option value="Gajahmungkur">Gajahmungkur</option>
                                <option value="Gubeng">Gubeng</option>
                                <option value="Gambir">Gambir</option>
                            </select>
                        </div>

                        {{-- Desa/Kelurahan --}}
                        <div class="col-lg-3 col-md-6 col-12">
                            <label for="desa_kelurahan" class="form-label">Desa / Kelurahan</label>
                            <select name="desa_kelurahan" id="desa_kelurahan" class="form-select" required>
                                <option value="">Pilih Desa...</option>
                                {{-- Data Hardcoded --}}
                                <option value="Dago">Dago</option>
                                <option value="Bendan">Bendan</option>
                                <option value="Gubeng">Gubeng</option>
                                <option value="Gambir">Gambir</option>
                            </select>
                        </div>
                    </div>

                    {{-- 3. Pekerjaan/Jabatan Responden --}}
                    <div class="mb-3">
                        <label for="pekerjaan_jabatan" class="form-label">Pekerjaan / Jabatan Responden</label>
                        <input type="text" name="pekerjaan_jabatan" id="pekerjaan_jabatan" class="form-control" placeholder="Masukkan pekerjaan / jabatan responden" required>
                    </div>

                    {{-- 4. Jenis Program --}}
                    <div class="mb-3">
                        <label for="jenis_program" class="form-label">Jenis Program</label>
                        <input type="text" name="jenis_program" id="jenis_program" class="form-control" placeholder="Masukkan jenis program" required>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="mt-4">
                        {{-- Tombol Batal --}}
                        <a href="{{ route('forms.informasi_umum') }}" class="btn btn-secondary">Batal</a>

                        {{-- Tombol Simpan --}}
                        <button type="submit" class="btn btn-primary ms-2">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection