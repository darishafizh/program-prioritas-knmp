@csrf

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('informasi_umum.store') }}">
    @csrf

    <div class="mb-3">
        <label for="nama_responden" class="form-label">1. Nama Responden / No HP</label>
        <input type="text" class="form-control" id="nama_responden" name="nama_responden" value="{{ old('nama_responden') }}" placeholder="Nama responden atau nomor HP">
    </div>

    <div class="mb-3">
        <label for="desa" class="form-label">2. Desa / Kelurahan</label>
        <input type="text" class="form-control" id="desa" name="desa" value="{{ old('desa') }}" placeholder="Nama desa atau kelurahan">
    </div>

    <div class="mb-3">
        <label for="kecamatan" class="form-label">3. Kecamatan</label>
        <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}" placeholder="Kecamatan">
    </div>

    <div class="mb-3">
        <label for="kabupaten" class="form-label">4. Kabupaten</label>
        <input type="text" class="form-control" id="kabupaten" name="kabupaten" value="{{ old('kabupaten') }}" placeholder="Kabupaten / Kota">
    </div>

    <div class="mb-3">
        <label for="provinsi" class="form-label">5. Provinsi</label>
        <input type="text" class="form-control" id="provinsi" name="provinsi" value="{{ old('provinsi') }}" placeholder="Provinsi">
    </div>

    <div class="mb-3">
        <label for="status_responden" class="form-label">6. Status Responden <small class="text-muted">(Nama pekerjaan / Jabatan)</small></label>
        <input type="text" class="form-control" id="status_responden" name="status_responden" value="{{ old('status_responden') }}" placeholder="Contoh: Pemilik usaha / Kepala kelompok">
    </div>

    <div class="mb-3">
        <label for="jenis_program" class="form-label">7. Jenis Program</label>
        <input type="text" class="form-control" id="jenis_program" name="jenis_program" value="{{ old('jenis_program') }}" placeholder="Jenis program">
    </div>

    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-secondary me-2">Simpan Draft</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
