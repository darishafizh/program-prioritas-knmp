<form method="POST" action="{{ route('survey.forms.store_profile_knmp', ['knmp' => $knmp->id]) }}">

    @csrf
    <input type="hidden" name="knmp_id" value="{{ $knmp->id }}">
    <div class="row">


        <div class="col-6">
            <div class="mb-3">
                <label class="form-label">Jumlah Penduduk Desa</label>
                <input type="number" name="jumlah_penduduk" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah Nelayan</label>
                <input type="number" name="jumlah_nelayan" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Pendapatan Rata-rata Nelayan Saat Ini (Rp)</label>
                <input type="number" name="pendapatan_rata_rata" class="form-control" step="any">
            </div>

            <div class="mb-3">
                <label class="form-label">Volume Produksi Saat Ini (ton/tahun)</label>
                <input type="number" name="volume_produksi" class="form-control" step="any">
            </div>

            <div class="mb-3">
                <label class="form-label">Nilai Produksi Saat Ini (Rp/tahun)</label>
                <input type="number" name="nilai_produksi" class="form-control" step="any">
            </div>

            <label class="form-label">Komoditas Utama Hasil Perikanan (sebutkan 2 jenis)</label>
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <input type="text" name="komoditas_1" class="form-control" placeholder="Komoditas 1">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <input type="text" name="komoditas_2" class="form-control" placeholder="Komoditas 1">
                    </div>
                </div>
            </div>

            <label class="form-label">Harga rata-rata ikan berdasarkan 2 jenis komoditas utama (Rp)</label>
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <input type="number" name="harga_komoditas_1" class="form-control" step="any"
                            placeholder="Harga komoditas 1">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <input type="number" name="harga_komoditas_2" class="form-control" step="any"
                            placeholder="Harga komoditas 2">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Ketersediaan Infrastruktur Pendukung</label>

                <div class="ms-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="infrastruktur_pendukung[]"
                            value="jalan_akses" id="infra_jalan">
                        <label class="form-check-label" for="infra_jalan">Jalan akses (ada/tidak)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="infrastruktur_pendukung[]" value="listrik"
                            id="infra_listrik">
                        <label class="form-check-label" for="infra_listrik">Listrik (ada/tidak)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="infrastruktur_pendukung[]"
                            value="air_bersih" id="infra_air">
                        <label class="form-check-label" for="infra_air">Air bersih (ada/tidak)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="infrastruktur_pendukung[]"
                            value="internet" id="infra_internet">
                        <label class="form-check-label" for="infra_internet">Internet (ada/tidak)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="infrastruktur_pendukung[]"
                            value="ipal" id="infra_ipal">
                        <label class="form-check-label" for="infra_ipal">IPAL (ada/tidak)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="infrastruktur_pendukung[]"
                            value="dermaga_tambat" id="infra_dermaga">
                        <label class="form-check-label" for="infra_dermaga">Dermaga/tambat labuh (ada/tidak)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="infrastruktur_pendukung[]"
                            value="tpi" id="infra_tpi">
                        <label class="form-check-label" for="infra_tpi">TPI (ada/tidak)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="infrastruktur_pendukung[]"
                            value="cold_storage" id="infra_cs">
                        <label class="form-check-label" for="infra_cs">Cold Storage (ada/tidak)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="infrastruktur_pendukung[]"
                            value="pabrik_es" id="infra_es">
                        <label class="form-check-label" for="infra_es">Pabrik es (ada/tidak)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="infrastruktur_pendukung[]"
                            value="kantor_koperasi" id="infra_koperasi">
                        <label class="form-check-label" for="infra_koperasi">Kantor Koperasi (ada/tidak)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="infrastruktur_pendukung[]"
                            value="bengkel_nelayan" id="infra_bengkel">
                        <label class="form-check-label" for="infra_bengkel">Bengkel Nelayan (ada/tidak)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="infrastruktur_pendukung[]"
                            value="waserda" id="infra_waserda">
                        <label class="form-check-label" for="infra_waserda">Warung Serba Ada (Waserda)</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="mb-3">
                <label class="form-label">Calon Koperasi Desa Merah Putih</label>
                <input type="text" name="calon_koperasi" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Ketua</label>
                <input type="text" name="nama_ketua" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">SK Kopdeskel</label>
                <input type="text" name="sk_kopdeskel" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Induk Kopdeskel</label>
                <input type="text" name="nomor_induk" class="form-control">
            </div>

            <label class="form-label">Jumlah Anggota Kopdeskel</label>
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <input type="number" name="jumlah_anggota_laki" class="form-control"
                            placeholder="Laki-laki">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <input type="number" name="jumlah_anggota_perempuan" class="form-control"
                            placeholder="Perempuan">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Koordinat Lokasi (GPS)</label>
                <input type="text" name="koordinat_lokasi" class="form-control">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 justify-content-end d-flex">
            <button type="submit" class="btn btn-primary m-2">Simpan Jawaban</button>
        </div>
    </div>
</form>