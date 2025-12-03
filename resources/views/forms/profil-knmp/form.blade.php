<div class="row">

    <div class="col-md-6 mb-3">
        <label>Jumlah penduduk desa</label>
        <input type="number" name="jumlah_penduduk_desa" class="form-control"
            value="{{ $item->jumlah_penduduk_desa ?? old('jumlah_penduduk_desa') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Jumlah nelayan</label>
        <input type="number" name="jumlah_nelayan" class="form-control"
            value="{{ $item->jumlah_nelayan ?? old('jumlah_nelayan') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Pendapatan rata-rata nelayan</label>
        <input type="number" name="pendapatan_rata_rata" class="form-control"
            value="{{ $item->pendapatan_rata_rata ?? old('pendapatan_rata_rata') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Alokasi Konstruksi (Rp)</label>
        <input type="number" name="alokasi_konstruksi" class="form-control"
            value="{{ $item->alokasi_konstruksi ?? old('alokasi_konstruksi') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Upah Tenaga Kerja (Rp)</label>
        <input type="number" name="alokasi_upah" class="form-control"
            value="{{ $item->alokasi_upah ?? old('alokasi_upah') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>TK Laki-laki</label>
        <input type="number" name="tk_laki_laki" class="form-control"
            value="{{ $item->tk_laki_laki ?? old('tk_laki_laki') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>TK Perempuan</label>
        <input type="number" name="tk_perempuan" class="form-control"
            value="{{ $item->tk_perempuan ?? old('tk_perempuan') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>TK Lokal</label>
        <input type="number" name="tk_lokal" class="form-control"
            value="{{ $item->tk_lokal ?? old('tk_lokal') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>TK dari luar</label>
        <input type="number" name="tk_luar" class="form-control"
            value="{{ $item->tk_luar ?? old('tk_luar') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Volume Produksi (ton/tahun)</label>
        <input type="number" name="volume_produksi" class="form-control"
            value="{{ $item->volume_produksi ?? old('volume_produksi') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Nilai Produksi (Rp/tahun)</label>
        <input type="number" name="nilai_produksi" class="form-control"
            value="{{ $item->nilai_produksi ?? old('nilai_produksi') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Calon Koperasi Desa Merah Putih</label>
        <input type="text" name="calon_kopdesmp" class="form-control"
            value="{{ $item->calon_kopdesmp ?? old('calon_kopdesmp') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Nama Ketua</label>
        <input type="text" name="nama_ketua" class="form-control"
            value="{{ $item->nama_ketua ?? old('nama_ketua') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>SK Kopdeskel</label>
        <input type="text" name="sk_kopdeskel" class="form-control"
            value="{{ $item->sk_kopdeskel ?? old('sk_kopdeskel') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Nomor Induk Kopdeskel</label>
        <input type="text" name="nomor_induk_kopdeskel" class="form-control"
            value="{{ $item->nomor_induk_kopdeskel ?? old('nomor_induk_kopdeskel') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Jumlah Anggota Laki-laki</label>
        <input type="number" name="jumlah_anggota_laki" class="form-control"
            value="{{ $item->jumlah_anggota_laki ?? old('jumlah_anggota_laki') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Jumlah Anggota Perempuan</label>
        <input type="number" name="jumlah_anggota_perempuan" class="form-control"
            value="{{ $item->jumlah_anggota_perempuan ?? old('jumlah_anggota_perempuan') }}">
    </div>

    <div class="col-md-12 mb-3">
        <label>Koordinat Lokasi</label>
        <input type="text" name="koordinat_lokasi" class="form-control"
            value="{{ $item->koordinat_lokasi ?? old('koordinat_lokasi') }}">
    </div>

</div>