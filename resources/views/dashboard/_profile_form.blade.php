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

<form method="POST" action="{{ route('profile.store') }}">
    @csrf

    <div class="mb-3">
        <label for="nama_kampung" class="form-label">Nama kampung</label>
        <input type="text" class="form-control" id="nama_kampung" name="nama_kampung" value="{{ old('nama_kampung', $profile?->nama_kampung ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="lingkungan_kawasan" class="form-label">Lingkungan Kawasan</label>
        <textarea class="form-control" id="lingkungan_kawasan" name="lingkungan_kawasan">{{ old('lingkungan_kawasan', $profile?->lingkungan_kawasan ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="aktivitas_usaha_nelayan" class="form-label">Aktivitas usaha nelayan</label>
        <textarea class="form-control" id="aktivitas_usaha_nelayan" name="aktivitas_usaha_nelayan">{{ old('aktivitas_usaha_nelayan', $profile?->aktivitas_usaha_nelayan ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="sarana_prasarana" class="form-label">Sarana dan Prasarana yang tersedia</label>
        <textarea class="form-control" id="sarana_prasarana" name="sarana_prasarana">{{ old('sarana_prasarana', $profile?->sarana_prasarana ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="status_kepemilikan_tanah" class="form-label">Status dan Kepemilikan Tanah lokasi KNMP</label>
        <textarea class="form-control" id="status_kepemilikan_tanah" name="status_kepemilikan_tanah">{{ old('status_kepemilikan_tanah', $profile?->status_kepemilikan_tanah ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="nama_kopdeskel" class="form-label">Nama Kopdeskel Merah Putih Pengelola KNMP</label>
        <input type="text" class="form-control" id="nama_kopdeskel" name="nama_kopdeskel" value="{{ old('nama_kopdeskel', $profile?->nama_kopdeskel ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="dasar_hukum_kopdeskel" class="form-label">Dasar Hukum Kopdeskel</label>
        <textarea class="form-control" id="dasar_hukum_kopdeskel" name="dasar_hukum_kopdeskel">{{ old('dasar_hukum_kopdeskel', $profile?->dasar_hukum_kopdeskel ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="ketua_kopdeskel" class="form-label">Ketua Kopdeskel</label>
        <input type="text" class="form-control" id="ketua_kopdeskel" name="ketua_kopdeskel" value="{{ old('ketua_kopdeskel', $profile?->ketua_kopdeskel ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="status_e_kusuka" class="form-label">Status dalam e-Kusuka</label>
        <input type="text" class="form-control" id="status_e_kusuka" name="status_e_kusuka" value="{{ old('status_e_kusuka', $profile?->status_e_kusuka ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="jenis_usaha_sebelum_knmp" class="form-label">Jenis usaha sebelum KNMP</label>
        <textarea class="form-control" id="jenis_usaha_sebelum_knmp" name="jenis_usaha_sebelum_knmp">{{ old('jenis_usaha_sebelum_knmp', $profile?->jenis_usaha_sebelum_knmp ?? '') }}</textarea>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Simpan Profile</button>
    </div>
</form>
