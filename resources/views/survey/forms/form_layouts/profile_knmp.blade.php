<form method="POST" action="{{ route('survey.forms.store_profile_knmp', ['knmp' => $knmp->id]) }}">
    @csrf
    <input type="hidden" name="knmp_id" value="{{ $knmp->id ?? 0 }}">

    <div class="row">
        <div class="col-6">

            {{-- Jumlah Penduduk --}}
            <div class="mb-3">
                <label class="form-label">Jumlah Penduduk Desa</label>
                <input type="number" name="jumlah_penduduk" class="form-control"
                    value="{{ old('jumlah_penduduk', $profileKnmp->jml_penduduk_des ?? '') }}">
            </div>

            {{-- Jumlah Nelayan --}}
            <div class="mb-3">
                <label class="form-label">Jumlah Nelayan</label>
                <input type="number" name="jumlah_nelayan" class="form-control"
                    value="{{ old('jumlah_nelayan', $profileKnmp->jml_nelayan ?? '') }}">
            </div>

            {{-- Pendapatan --}}
            <div class="mb-3">
                <label class="form-label">Pendapatan Rata-rata Nelayan Saat Ini (Rp)</label>
                <input type="number" name="pendapatan_rata_rata" class="form-control" step="any"
                    value="{{ old('pendapatan_rata_rata', $profileKnmp->pendapatan_rata_rata_nelayan ?? '') }}">
            </div>

            {{-- Volume Produksi --}}
            <div class="mb-3">
                <label class="form-label">Volume Produksi Saat Ini (ton/tahun)</label>
                <input type="number" name="volume_produksi" class="form-control" step="any"
                    value="{{ old('volume_produksi', $profileKnmp->volume_produksi_ton ?? '') }}">
            </div>

            {{-- Nilai Produksi --}}
            <div class="mb-3">
                <label class="form-label">Nilai Produksi Saat Ini (Rp/tahun)</label>
                <input type="number" name="nilai_produksi" class="form-control" step="any"
                    value="{{ old('nilai_produksi', $profileKnmp->nilai_produksi ?? '') }}">
            </div>

            {{-- Komoditas --}}
            <label class="form-label">Komoditas Utama Hasil Perikanan (2 jenis)</label>
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <input type="text" name="komoditas_1" class="form-control"
                            placeholder="Komoditas 1" value="{{ old('komoditas_1', $profileKnmp->komoditas_utama_1 ?? '') }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <input type="text" name="komoditas_2" class="form-control"
                            placeholder="Komoditas 2" value="{{ old('komoditas_2', $profileKnmp->komoditas_utama_2 ?? '') }}">
                    </div>
                </div>
            </div>

            {{-- Harga komoditas --}}
            <label class="form-label">Harga rata-rata ikan (Rp)</label>
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <input type="number" name="harga_komoditas_1" class="form-control" step="any"
                            placeholder="Harga komoditas 1" value="{{ old('harga_komoditas_1', $profileKnmp->harga_rata_komoditas_1 ?? '') }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <input type="number" name="harga_komoditas_2" class="form-control" step="any"
                            placeholder="Harga komoditas 2" value="{{ old('harga_komoditas_2', $profileKnmp->harga_rata_komoditas_2 ?? '') }}">
                    </div>
                </div>
            </div>

            {{-- Infrastruktur --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Ketersediaan Infrastruktur Pendukung</label>

                @php
                $oldInfra = old('infrastruktur_pendukung', []);
                // Build existing infra array from $profileKnmp if available
                $existingInfra = [];
                if (isset($profileKnmp) && $profileKnmp) {
                    if ($profileKnmp->infra_jalan_akses) $existingInfra[] = 'jalan_akses';
                    if ($profileKnmp->infra_listrik) $existingInfra[] = 'listrik';
                    if ($profileKnmp->infra_air_bersih) $existingInfra[] = 'air_bersih';
                    if ($profileKnmp->infra_internet) $existingInfra[] = 'internet';
                    if ($profileKnmp->infra_ipal) $existingInfra[] = 'ipal';
                    if ($profileKnmp->infra_dermaga_tambat) $existingInfra[] = 'dermaga_tambat';
                    if ($profileKnmp->infra_tpi) $existingInfra[] = 'tpi';
                    if ($profileKnmp->infra_cold_storage) $existingInfra[] = 'cold_storage';
                    if ($profileKnmp->infra_pabrik_es) $existingInfra[] = 'pabrik_es';
                    if ($profileKnmp->infra_kantor_koperasi) $existingInfra[] = 'kantor_koperasi';
                    if ($profileKnmp->infra_bengkel_nelayan) $existingInfra[] = 'bengkel_nelayan';
                    if ($profileKnmp->infra_waserda) $existingInfra[] = 'waserda';
                }
                $infraChecked = !empty($oldInfra) ? $oldInfra : $existingInfra;
                @endphp

                <div class="ms-3">
                    @foreach([
                    'jalan_akses' => 'Jalan akses',
                    'listrik' => 'Listrik',
                    'air_bersih' => 'Air bersih',
                    'internet' => 'Internet',
                    'ipal' => 'IPAL',
                    'dermaga_tambat' => 'Dermaga/tambat labuh',
                    'tpi' => 'TPI',
                    'cold_storage' => 'Cold Storage',
                    'pabrik_es' => 'Pabrik es',
                    'kantor_koperasi' => 'Kantor Koperasi',
                    'bengkel_nelayan' => 'Bengkel Nelayan',
                    'waserda' => 'Waserda'
                    ] as $key => $label)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                            name="infrastruktur_pendukung[]" value="{{ $key }}"
                            id="infra_{{ $key }}"
                            {{ in_array($key, $infraChecked) ? 'checked' : '' }}>
                        <label class="form-check-label" for="infra_{{ $key }}">{{ $label }}</label>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        <div class="col-6">

            <div class="mb-3">
                <label class="form-label">Calon Koperasi Desa Merah Putih</label>
                <input type="text" name="calon_koperasi" class="form-control"
                    value="{{ old('calon_koperasi', $profileKnmp->calon_koperasi ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Ketua</label>
                <input type="text" name="nama_ketua" class="form-control"
                    value="{{ old('nama_ketua', $profileKnmp->nama_ketua ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">SK Kopdeskel</label>
                <input type="text" name="sk_kopdeskel" class="form-control"
                    value="{{ old('sk_kopdeskel', $profileKnmp->sk_kopdeskel ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Induk Kopdeskel</label>
                <input type="text" name="nomor_induk" class="form-control"
                    value="{{ old('nomor_induk', $profileKnmp->nomor_induk_kopdeskel ?? '') }}">
            </div>

            {{-- Anggota --}}
            <label class="form-label">Jumlah Anggota Kopdeskel</label>
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <input type="number" name="jumlah_anggota_laki" class="form-control"
                            placeholder="Laki-laki" value="{{ old('jumlah_anggota_laki', $profileKnmp->jumlah_anggota_laki ?? '') }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <input type="number" name="jumlah_anggota_perempuan" class="form-control"
                            placeholder="Perempuan" value="{{ old('jumlah_anggota_perempuan', $profileKnmp->jumlah_anggota_perempuan ?? '') }}">
                    </div>
                </div>
            </div>

            {{-- Koordinat --}}
            <div class="mb-3">
                <label class="form-label">Koordinat Lokasi (GPS)</label>
                <input type="text" name="koordinat_lokasi" class="form-control"
                    value="{{ old('koordinat_lokasi', $profileKnmp->koordinat_lokasi ?? '') }}">
            </div>

        </div>
    </div>

    <div class="row">
        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>