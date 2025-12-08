<form method="POST" action="{{ route('survey.forms.store_informasi_usaha', ['knmp' => $knmp->id]) }}">
    @csrf
    <input type="hidden" name="knmp_id" value="{{ $knmp->id ?? 0 }}">

    {{-- ========================================================== --}}
    <h5 class="mt-3 mb-3 fw-bold text-primary">A. Kapal dan Jenis Alat Tangkap</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3"><label class="form-label">Nama Kapal Perikanan</label>
                <input type="text" name="nama_kapal" class="form-control">
            </div>
            <div class="mb-3"><label class="form-label">Tahun Pembuatan Kapal</label>
                <input type="number" name="tahun_pembuatan" class="form-control">
            </div>
            <div class="mb-3"><label class="form-label">Ukuran Perahu/ Tonase Kotor (GT)</label>
                <input type="number" name="ukuran_gt" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">Dimensi Perahu (Panjang x Lebar x Dalam)</label>
                <input type="text" name="dimensi_perahu" class="form-control" placeholder="Contoh: 10 x 3 x 1.5">
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Jenis bahan baku kapal</label>
                <div>
                    <div class="form-check form-check-inline"><input type="radio" name="jenis_bahan_baku"
                            value="Fiber" class="form-check-input" id="bb_fiber"><label class="form-check-label"
                            for="bb_fiber">Fiber</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="jenis_bahan_baku"
                            value="Kayu" class="form-check-input" id="bb_kayu"><label class="form-check-label"
                            for="bb_kayu">Kayu</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="jenis_bahan_baku"
                            value="Besi" class="form-check-input" id="bb_besi"><label class="form-check-label"
                            for="bb_besi">Besi</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="jenis_bahan_baku"
                            value="Kayu Laminasi" class="form-check-input" id="bb_kayulam"><label
                            class="form-check-label" for="bb_kayulam">Kayu Laminasi</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="jenis_bahan_baku"
                            value="Lainnya" class="form-check-input" id="bb_lain"><label class="form-check-label"
                            for="bb_lain">Lainnya</label></div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Mesin Motor</label>
                <div>
                    <div class="form-check form-check-inline"><input type="radio" name="jenis_mesin"
                            value="Motor Tempel Bantuan" class="form-check-input" id="jm_bantuan"><label
                            class="form-check-label" for="jm_bantuan">Motor Tempel Bantuan</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="jenis_mesin"
                            value="Motor Tempel Pribadi" class="form-check-input" id="jm_pribadi"><label
                            class="form-check-label" for="jm_pribadi">Motor Tempel Pribadi</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="jenis_mesin"
                            value="Sampan (tanpa motor)" class="form-check-input" id="jm_sampan"><label
                            class="form-check-label" for="jm_sampan">Sampan (tanpa motor)</label></div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Alat Penyimpanan Ikan yang Dimiliki</label>
                <div>
                    <div class="form-check form-check-inline"><input type="radio" name="alat_penyimpanan"
                            value="Palka" class="form-check-input" id="ap_palka"><label class="form-check-label"
                            for="ap_palka">Palka</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="alat_penyimpanan"
                            value="Coolbox" class="form-check-input" id="ap_coolbox"><label class="form-check-label"
                            for="ap_coolbox">Coolbox</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="alat_penyimpanan"
                            value="Stereofoam Box" class="form-check-input" id="ap_stereo"><label
                            class="form-check-label" for="ap_stereo">Stereofoam Box</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="alat_penyimpanan"
                            value="Tong plastik" class="form-check-input" id="ap_tong"><label
                            class="form-check-label" for="ap_tong">Tong plastik</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="alat_penyimpanan"
                            value="Lainnya" class="form-check-input" id="ap_lain"><label class="form-check-label"
                            for="ap_lain">Lainnya</label></div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Alat Tangkap yang digunakan</label>
                <select name="jenis_alat_tangkap" class="form-select">
                    <option value="">Pilih Jenis Alat Tangkap</option>
                    <option value="Handline/Pancing Ulur">Handline/Pancing Ulur</option>
                    <option value="Rawai Dasar">Rawai Dasar</option>
                    <option value="Pancing Dasar">Pancing Dasar</option>
                    <option value="Jaring Insang/Gillnett">Jaring Insang/Gillnett</option>
                    <option value="Pole and Line">Pole and Line</option>
                    <option value="Purse Seine">Purse Seine</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
        </div>
    </div>

    <hr>

    {{-- ========================================================== --}}
    <h5 class="mt-3 mb-3 fw-bold text-primary">B. Data Produksi Perikanan</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3"><label class="form-label">1. Jumlah hari per trip (hari/trip)</label>
                <input type="number" name="hari_per_trip" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">2. Lama waktu melaut setiap trip (jam/trip)</label>
                <input type="number" name="waktu_melaut_jam" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">3. Jarak ke daerah penangkapan (mil)</label>
                <input type="number" name="jarak_penangkapan_mil" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">4. Waktu tempuh ke daerah penangkapan (jam)</label>
                <input type="number" name="waktu_tempuh_jam" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">5. Jumlah trip/bulan (trip/bulan)</label>
                <input type="number" name="jml_trip_per_bulan" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">6. Jumlah bulan melaut (bulan/tahun)</label>
                <input type="number" name="jml_bulan_melaut" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">7. Rata-rata Produksi Per Trip (Kg/Trip)</label>
                <input type="number" name="produksi_kg_per_trip" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">8. Rata-rata Penjualan Ikan Per Trip (Rp/Trip)</label>
                <input type="number" name="penjualan_rp_per_trip" class="form-control" step="any">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3"><label class="form-label">9. Biaya Solar Per Trip (Rp/Trip)</label>
                <input type="number" name="biaya_solar_rp" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">10. Volume Solar Per Trip (Liter/Trip)</label>
                <input type="number" name="volume_solar_liter" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">11. Biaya Bensin Per Trip (Rp/Trip)</label>
                <input type="number" name="biaya_bensin_rp" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">12. Volume Bensin Per Trip (Liter/Trip)</label>
                <input type="number" name="volume_bensin_liter" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">13. Biaya Es Balok dari Pabrik Per Trip (Rp/Trip)</label>
                <input type="number" name="biaya_es_balok_rp" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">14. Volume Es Balok dari Pabrik Per Trip
                    (Balok/Trip)</label>
                <input type="number" name="volume_es_balok" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">15. Biaya Es Kantong Per Trip (Rp/Trip)</label>
                <input type="number" name="biaya_es_kantong_rp" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">16. Volume Es Kantong Per Trip (Kantong/Trip)</label>
                <input type="number" name="volume_es_kantong" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">17. Total Biaya Operasional Tiap Melaut (Rp/Trip)</label>
                <input type="number" name="total_biaya_operasional" class="form-control" step="any">
            </div>
        </div>
    </div>

    <hr>

    {{-- ========================================================== --}}
    <h5 class="mt-3 mb-3 fw-bold text-primary">C. Data Jenis Ikan Hasil Produksi</h5>
    <p class="text-muted">Sebutkan Hasil Produksi Ikan Utama berdasarkan rata-rata setiap trip penangkapan (Hanya 2
        Ikan Utama).</p>

    <div class="table-responsive">
        <table class="table w-100">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Jenis Ikan (Sebutkan 2 Ikan Utama)</th>
                    <th>Kondisi Saat Ini (Kg/Trip)</th>
                    <th>% dari Total Produksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1.</td>
                    <td><input type="text" name="ikan_utama[1][jenis]" class="form-control"></td>
                    <td><input type="number" name="ikan_utama[1][kg_trip]" class="form-control" step="any">
                    </td>
                    <td><input type="number" name="ikan_utama[1][persen]" class="form-control" step="any"
                            placeholder="Auto atau Manual"></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td><input type="text" name="ikan_utama[2][jenis]" class="form-control"></td>
                    <td><input type="number" name="ikan_utama[2][kg_trip]" class="form-control" step="any">
                    </td>
                    <td><input type="number" name="ikan_utama[2][persen]" class="form-control" step="any"
                            placeholder="Auto atau Manual"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end fw-bold">Total Ikan</td>
                    <td class="fw-bold">100%</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-primary">Simpan Informasi Usaha</button>
    </div>
</form>
