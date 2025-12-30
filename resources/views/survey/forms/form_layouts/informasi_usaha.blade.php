<form method="POST" action="{{ route('forms.store_informasi_usaha', ['knmp' => $knmp->id]) }}">
    @csrf
    <input type="hidden" name="knmp_id" value="{{ $knmp->id ?? 0 }}">

    {{-- ========================= --}}
    {{-- PILIH RESPONDEN --}}
    {{-- ========================= --}}
    <div class="mb-4">
        <label class="form-label fw-bold">
            Responden
        </label>

        <select name="responden_id" class="form-select @error('responden_id') is-invalid @enderror" required>
            <option value="">-- Pilih Responden --</option>
            @foreach ($respondenList as $r)
                @php
                    $isSelected = old('responden_id') == $r->id ||
                        ($selectedRespondenId && $selectedRespondenId == $r->id && !old('responden_id')) ||
                        (isset($selectedRespondenData['informasi_usaha']) && $selectedRespondenData['informasi_usaha'] && $selectedRespondenData['informasi_usaha']->responden_id == $r->id && !old('responden_id'));
                @endphp
                <option value="{{ $r->id }}" {{ $isSelected ? 'selected' : '' }}>
                    {{ $r->nama_responden }} ({{ $r->nik }})
                </option>
            @endforeach
        </select>

        @error('responden_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- ========================================================== --}}
    <h5 class="mt-3 mb-3 fw-bold text-primary">A. Kapal dan Jenis Alat Tangkap</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3"><label class="form-label">Nama Kapal Perikanan</label>
                <input type="text" name="nama_kapal" class="form-control" value="{{ old('nama_kapal') }}">
            </div>
            <div class="mb-3"><label class="form-label">Tahun Pembuatan Kapal</label>
                <input type="number" name="tahun_pembuatan" class="form-control" value="{{ old('tahun_pembuatan') }}">
            </div>
            <div class="mb-3"><label class="form-label">Ukuran Perahu/ Tonase Kotor (GT)</label>
                <input type="number" name="ukuran_gt" class="form-control" step="any" value="{{ old('ukuran_gt') }}">
            </div>
            <div class="mb-3"><label class="form-label">Dimensi Perahu (Panjang x Lebar x Dalam)</label>
                <input type="text" name="dimensi_perahu" class="form-control" placeholder="Contoh: 10 x 3 x 1.5"
                    value="{{ old('dimensi_perahu') }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Jenis bahan baku kapal</label>
                <div>
                    <div class="form-check form-check-inline"><input type="radio" name="jenis_bahan_baku" value="Fiber"
                            class="form-check-input" id="bb_fiber" {{ old('jenis_bahan_baku') == 'Fiber' ? 'checked' : '' }}><label class="form-check-label" for="bb_fiber">Fiber</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="jenis_bahan_baku" value="Kayu"
                            class="form-check-input" id="bb_kayu" {{ old('jenis_bahan_baku') == 'Kayu' ? 'checked' : '' }}><label class="form-check-label" for="bb_kayu">Kayu</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="jenis_bahan_baku" value="Besi"
                            class="form-check-input" id="bb_besi" {{ old('jenis_bahan_baku') == 'Besi' ? 'checked' : '' }}><label class="form-check-label" for="bb_besi">Besi</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="jenis_bahan_baku"
                            value="Kayu Laminasi" class="form-check-input" id="bb_kayulam" {{ old('jenis_bahan_baku') == 'Kayu Laminasi' ? 'checked' : '' }}><label class="form-check-label"
                            for="bb_kayulam">Kayu Laminasi</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="jenis_bahan_baku"
                            value="Lainnya" class="form-check-input" id="bb_lain" {{ old('jenis_bahan_baku') == 'Lainnya' ? 'checked' : '' }}><label class="form-check-label" for="bb_lain">Lainnya</label></div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Mesin Motor</label>
                <div>
                    <div class="form-check form-check-inline"><input type="radio" name="jenis_mesin"
                            value="Motor Tempel Bantuan" class="form-check-input" id="jm_bantuan" {{ old('jenis_mesin') == 'Motor Tempel Bantuan' ? 'checked' : '' }}><label
                            class="form-check-label" for="jm_bantuan">Motor Tempel Bantuan</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="jenis_mesin"
                            value="Motor Tempel Pribadi" class="form-check-input" id="jm_pribadi" {{ old('jenis_mesin') == 'Motor Tempel Pribadi' ? 'checked' : '' }}><label
                            class="form-check-label" for="jm_pribadi">Motor Tempel Pribadi</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="jenis_mesin"
                            value="Sampan (tanpa motor)" class="form-check-input" id="jm_sampan" {{ old('jenis_mesin') == 'Sampan (tanpa motor)' ? 'checked' : '' }}><label
                            class="form-check-label" for="jm_sampan">Sampan (tanpa motor)</label></div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Alat Penyimpanan Ikan yang Dimiliki</label>
                <div>
                    <div class="form-check form-check-inline"><input type="radio" name="alat_penyimpanan" value="Palka"
                            class="form-check-input" id="ap_palka" {{ old('alat_penyimpanan') == 'Palka' ? 'checked' : '' }}><label class="form-check-label" for="ap_palka">Palka</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="alat_penyimpanan"
                            value="Coolbox" class="form-check-input" id="ap_coolbox" {{ old('alat_penyimpanan') == 'Coolbox' ? 'checked' : '' }}><label class="form-check-label"
                            for="ap_coolbox">Coolbox</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="alat_penyimpanan"
                            value="Stereofoam Box" class="form-check-input" id="ap_stereo" {{ old('alat_penyimpanan') == 'Stereofoam Box' ? 'checked' : '' }}><label
                            class="form-check-label" for="ap_stereo">Stereofoam Box</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="alat_penyimpanan"
                            value="Tong plastik" class="form-check-input" id="ap_tong" {{ old('alat_penyimpanan') == 'Tong plastik' ? 'checked' : '' }}><label class="form-check-label" for="ap_tong">Tong
                            plastik</label></div>
                    <div class="form-check form-check-inline"><input type="radio" name="alat_penyimpanan"
                            value="Lainnya" class="form-check-input" id="ap_lain" {{ old('alat_penyimpanan') == 'Lainnya' ? 'checked' : '' }}><label class="form-check-label" for="ap_lain">Lainnya</label></div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Alat Tangkap yang digunakan</label>
                <select name="jenis_alat_tangkap" class="form-select">
                    <option value="" {{ old('jenis_alat_tangkap') == '' ? 'selected' : '' }}>Pilih Jenis Alat Tangkap
                    </option>
                    <option value="Handline/Pancing Ulur" {{ old('jenis_alat_tangkap') == 'Handline/Pancing Ulur' ? 'selected' : '' }}>Handline/Pancing Ulur</option>
                    <option value="Rawai Dasar" {{ old('jenis_alat_tangkap') == 'Rawai Dasar' ? 'selected' : '' }}>Rawai
                        Dasar</option>
                    <option value="Pancing Dasar" {{ old('jenis_alat_tangkap') == 'Pancing Dasar' ? 'selected' : '' }}>
                        Pancing Dasar</option>
                    <option value="Jaring Insang/Gillnett" {{ old('jenis_alat_tangkap') == 'Jaring Insang/Gillnett' ? 'selected' : '' }}>Jaring Insang/Gillnett</option>
                    <option value="Pole and Line" {{ old('jenis_alat_tangkap') == 'Pole and Line' ? 'selected' : '' }}>
                        Pole and Line</option>
                    <option value="Purse Seine" {{ old('jenis_alat_tangkap') == 'Purse Seine' ? 'selected' : '' }}>Purse
                        Seine</option>
                    <option value="Lainnya" {{ old('jenis_alat_tangkap') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                    </option>
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
                <input type="number" name="hari_per_trip" class="form-control" step="any"
                    value="{{ old('hari_per_trip') }}">
            </div>
            <div class="mb-3"><label class="form-label">2. Lama waktu melaut setiap trip (jam/trip)</label>
                <input type="number" name="waktu_melaut_jam" class="form-control" step="any"
                    value="{{ old('waktu_melaut_jam') }}">
            </div>
            <div class="mb-3"><label class="form-label">3. Jarak ke daerah penangkapan (mil)</label>
                <input type="number" name="jarak_penangkapan_mil" class="form-control" step="any"
                    value="{{ old('jarak_penangkapan_mil') }}">
            </div>
            <div class="mb-3"><label class="form-label">4. Waktu tempuh ke daerah penangkapan (jam)</label>
                <input type="number" name="waktu_tempuh_jam" class="form-control" step="any"
                    value="{{ old('waktu_tempuh_jam') }}">
            </div>
            <div class="mb-3"><label class="form-label">5. Jumlah trip/bulan (trip/bulan)</label>
                <input type="number" name="jml_trip_per_bulan" class="form-control" step="any"
                    value="{{ old('jml_trip_per_bulan') }}">
            </div>
            <div class="mb-3"><label class="form-label">6. Jumlah bulan melaut (bulan/tahun)</label>
                <input type="number" name="jml_bulan_melaut" class="form-control" step="any"
                    value="{{ old('jml_bulan_melaut') }}">
            </div>
            <div class="mb-3"><label class="form-label">7. Rata-rata Produksi Per Trip (Kg/Trip)</label>
                <input type="number" name="produksi_kg_per_trip" class="form-control" step="any"
                    value="{{ old('produksi_kg_per_trip') }}">
            </div>
            <div class="mb-3"><label class="form-label">8. Rata-rata Penjualan Ikan Per Trip (Rp/Trip)</label>
                <input type="number" name="penjualan_rp_per_trip" class="form-control" step="any"
                    value="{{ old('penjualan_rp_per_trip') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3"><label class="form-label">9. Biaya Solar Per Trip (Rp/Trip)</label>
                <input type="number" name="biaya_solar_rp" class="form-control" step="any"
                    value="{{ old('biaya_solar_rp') }}">
            </div>
            <div class="mb-3"><label class="form-label">10. Volume Solar Per Trip (Liter/Trip)</label>
                <input type="number" name="volume_solar_liter" class="form-control" step="any"
                    value="{{ old('volume_solar_liter') }}">
            </div>
            <div class="mb-3"><label class="form-label">11. Biaya Bensin Per Trip (Rp/Trip)</label>
                <input type="number" name="biaya_bensin_rp" class="form-control" step="any"
                    value="{{ old('biaya_bensin_rp') }}">
            </div>
            <div class="mb-3"><label class="form-label">12. Volume Bensin Per Trip (Liter/Trip)</label>
                <input type="number" name="volume_bensin_liter" class="form-control" step="any"
                    value="{{ old('volume_bensin_liter') }}">
            </div>
            <div class="mb-3"><label class="form-label">13. Biaya Es Balok dari Pabrik Per Trip (Rp/Trip)</label>
                <input type="number" name="biaya_es_balok_rp" class="form-control" step="any"
                    value="{{ old('biaya_es_balok_rp') }}">
            </div>
            <div class="mb-3"><label class="form-label">14. Volume Es Balok dari Pabrik Per Trip
                    (Balok/Trip)</label>
                <input type="number" name="volume_es_balok" class="form-control" step="any"
                    value="{{ old('volume_es_balok') }}">
            </div>
            <div class="mb-3"><label class="form-label">15. Biaya Es Kantong Per Trip (Rp/Trip)</label>
                <input type="number" name="biaya_es_kantong_rp" class="form-control" step="any"
                    value="{{ old('biaya_es_kantong_rp') }}">
            </div>
            <div class="mb-3"><label class="form-label">16. Volume Es Kantong Per Trip (Kantong/Trip)</label>
                <input type="number" name="volume_es_kantong" class="form-control" step="any"
                    value="{{ old('volume_es_kantong') }}">
            </div>
            <div class="mb-3"><label class="form-label">17. Total Biaya Operasional Tiap Melaut (Rp/Trip)</label>
                <input type="number" name="total_biaya_operasional" class="form-control" step="any"
                    value="{{ old('total_biaya_operasional') }}">
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
                @php
                    $ikanData = isset($selectedRespondenData['informasi_usaha']) && $selectedRespondenData['informasi_usaha'] && $selectedRespondenData['informasi_usaha']->ikan
                        ? $selectedRespondenData['informasi_usaha']->ikan->values()
                        : collect([]);
                    $ikan1 = $ikanData->get(0);
                    $ikan2 = $ikanData->get(1);
                @endphp
                <tr>
                    <td>1.</td>
                    <td><input type="text" name="ikan_utama[1][jenis]" class="form-control"
                            value="{{ old('ikan_utama.1.jenis', $ikan1->jenis ?? '') }}"></td>
                    <td><input type="number" name="ikan_utama[1][kg_trip]" class="form-control" step="any"
                            value="{{ old('ikan_utama.1.kg_trip', $ikan1->kg_trip ?? '') }}">
                    </td>
                    <td><input type="number" name="ikan_utama[1][persen]" class="form-control" step="any"
                            placeholder="Auto atau Manual"
                            value="{{ old('ikan_utama.1.persen', $ikan1->persen ?? '') }}"></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td><input type="text" name="ikan_utama[2][jenis]" class="form-control"
                            value="{{ old('ikan_utama.2.jenis', $ikan2->jenis ?? '') }}"></td>
                    <td><input type="number" name="ikan_utama[2][kg_trip]" class="form-control" step="any"
                            value="{{ old('ikan_utama.2.kg_trip', $ikan2->kg_trip ?? '') }}">
                    </td>
                    <td><input type="number" name="ikan_utama[2][persen]" class="form-control" step="any"
                            placeholder="Auto atau Manual"
                            value="{{ old('ikan_utama.2.persen', $ikan2->persen ?? '') }}"></td>
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

    <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>