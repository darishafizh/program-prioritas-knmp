<form method="POST" action="{{ route('forms.store_pendapatan_rt', ['knmp' => $knmp->id]) }}">
        @csrf

        <input type="hidden" name="knmp_id" value="{{ $knmp->id }}">

        {{-- ========================= --}}
        {{-- PILIH RESPONDEN --}}
        {{-- ========================= --}}
        <div class="mb-4">
                <label class="form-label fw-bold">
                        Responden
                </label>

                <select name="responden_id"
                        class="form-select @error('responden_id') is-invalid @enderror"
                        required>
                        <option value="">-- Pilih Responden --</option>

                        @foreach ($respondenList as $r)
                        @php
                            $isSelected = old('responden_id') == $r->id || 
                                         ($selectedRespondenId && $selectedRespondenId == $r->id && !old('responden_id')) ||
                                         (isset($selectedRespondenData['pendapatan_rumah_tangga']) && $selectedRespondenData['pendapatan_rumah_tangga'] && $selectedRespondenData['pendapatan_rumah_tangga']->responden_id == $r->id && !old('responden_id'));
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



        <label class="form-label">1. Jelaskan pendapatan rata-rata seluruh anggota rumah tangga anda dalam sebulan
                (Rp/bulan)</label>
        <div class="row">
                <div class="col-md-6">
                        <div class="mb-3">
                                <label class="form-label">Pendapatan Perikanan (Rp/bulan) (A)</label>
                                <input type="number" id="pendapatan_perikanan" name="pendapatan_perikanan" class="form-control"
                                        step="any" value="{{ old('pendapatan_perikanan') }}">
                        </div>

                        <div class="mb-3">
                                <label class="form-label">Pendapatan di luar Perikanan (Rp/bulan) (B)</label>
                                <input type="number" id="pendapatan_non_perikanan" name="pendapatan_non_perikanan" class="form-control"
                                        step="any" value="{{ old('pendapatan_non_perikanan') }}">
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="mb-3">
                                <label class="form-label">Total pendapatan rumah tangga (Rp/bulan) (A+B)</label>
                                <input type="number" id="pendapatan_total" name="pendapatan_total" class="form-control" readonly
                                        placeholder="Otomatis dihitung (A+B)" step="any">
                        </div>
                </div>
        </div>

        <div class="mb-3">
                <label class="form-label">2. Berapa persentase kontribusi dari pendapatan sebagai nelayan terhadap total
                        pendapatan keluarga?</label>
                <div>
                        <div class="form-check form-check-inline"><input type="radio" name="kontribusi_nelayan_persen"
                                        value="Kurang dari 50%" class="form-check-input" id="kn_1" {{ old('kontribusi_nelayan_persen') == 'Kurang dari 50%' ? 'checked' : '' }}><label class="form-check-label"
                                        for="kn_1">Kurang dari 50%</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="kontribusi_nelayan_persen"
                                        value="50-80%" class="form-check-input" id="kn_2" {{ old('kontribusi_nelayan_persen') == '50-80%' ? 'checked' : '' }}><label class="form-check-label"
                                        for="kn_2">50-80%</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="kontribusi_nelayan_persen"
                                        value="Lebih dari 80%" class="form-check-input" id="kn_3" {{ old('kontribusi_nelayan_persen') == 'Lebih dari 80%' ? 'checked' : '' }}><label class="form-check-label"
                                        for="kn_3">Lebih dari 80%</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="kontribusi_nelayan_persen"
                                        value="100% (satu-satunya sumber pendapatan)" class="form-check-input" id="kn_4" {{ old('kontribusi_nelayan_persen') == '100% (satu-satunya sumber pendapatan)' ? 'checked' : '' }}><label
                                        class="form-check-label" for="kn_4">100% (satu-satunya sumber pendapatan)</label></div>
                </div>
        </div>

        <div class="mb-3">
                <label class="form-label">3. Berapakah jumlah sumber penghasilan yang dimiliki oleh rumah tangga Anda?</label>
                <div>
                        <div class="form-check form-check-inline"><input type="radio" name="jumlah_sumber_penghasilan"
                                        value="1 (hanya satu sumber) dari nelayan" class="form-check-input" id="js_1" {{ old('jumlah_sumber_penghasilan') == '1 (hanya satu sumber) dari nelayan' ? 'checked' : '' }}><label
                                        class="form-check-label" for="js_1">1 (hanya satu sumber) dari nelayan</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="jumlah_sumber_penghasilan"
                                        value="2 sumber" class="form-check-input" id="js_2" {{ old('jumlah_sumber_penghasilan') == '2 sumber' ? 'checked' : '' }}><label class="form-check-label"
                                        for="js_2">2 sumber</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="jumlah_sumber_penghasilan"
                                        value="3 sumber" class="form-check-input" id="js_3" {{ old('jumlah_sumber_penghasilan') == '3 sumber' ? 'checked' : '' }}><label class="form-check-label"
                                        for="js_3">3 sumber</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="jumlah_sumber_penghasilan"
                                        value="Lebih dari 3 sumber" class="form-check-input" id="js_4" {{ old('jumlah_sumber_penghasilan') == 'Lebih dari 3 sumber' ? 'checked' : '' }}><label class="form-check-label"
                                        for="js_4">Lebih dari 3 sumber</label></div>
                </div>
        </div>

        <div class="mb-3">
                <label class="form-label">4. Seberapa besar keluarga Anda bergantung pada penghasilan dari kegiatan
                        perikanan?</label>
                <div>
                        <div class="form-check form-check-inline"><input type="radio" name="ketergantungan_perikanan"
                                        value="Sangat bergantung" class="form-check-input" id="kp_1" {{ old('ketergantungan_perikanan') == 'Sangat bergantung' ? 'checked' : '' }}><label
                                        class="form-check-label" for="kp_1">Sangat bergantung</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="ketergantungan_perikanan"
                                        value="Cukup bergantung" class="form-check-input" id="kp_2" {{ old('ketergantungan_perikanan') == 'Cukup bergantung' ? 'checked' : '' }}><label class="form-check-label"
                                        for="kp_2">Cukup bergantung</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="ketergantungan_perikanan"
                                        value="Sedikit bergantung" class="form-check-input" id="kp_3" {{ old('ketergantungan_perikanan') == 'Sedikit bergantung' ? 'checked' : '' }}><label
                                        class="form-check-label" for="kp_3">Sedikit bergantung</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="ketergantungan_perikanan"
                                        value="Tidak bergantung" class="form-check-input" id="kp_4" {{ old('ketergantungan_perikanan') == 'Tidak bergantung' ? 'checked' : '' }}><label class="form-check-label"
                                        for="kp_4">Tidak bergantung</label></div>
                </div>
        </div>

        <div class="mb-3">
                <label class="form-label">5. Bagaimana Anda menilai tingkat stabilitas pendapatan nelayan?</label>
                <div>
                        <div class="form-check form-check-inline"><input type="radio" name="stabilitas_pendapatan"
                                        value="Stabil sepanjang tahun" class="form-check-input" id="sp_1" {{ old('stabilitas_pendapatan') == 'Stabil sepanjang tahun' ? 'checked' : '' }}><label
                                        class="form-check-label" for="sp_1">Stabil sepanjang tahun</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="stabilitas_pendapatan"
                                        value="Cenderung stabil" class="form-check-input" id="sp_2" {{ old('stabilitas_pendapatan') == 'Cenderung stabil' ? 'checked' : '' }}><label class="form-check-label"
                                        for="sp_2">Cenderung stabil</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="stabilitas_pendapatan"
                                        value="Tidak stabil" class="form-check-input" id="sp_3" {{ old('stabilitas_pendapatan') == 'Tidak stabil' ? 'checked' : '' }}><label class="form-check-label"
                                        for="sp_3">Tidak stabil</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="stabilitas_pendapatan"
                                        value="Sangat tidak stabil" class="form-check-input" id="sp_4" {{ old('stabilitas_pendapatan') == 'Sangat tidak stabil' ? 'checked' : '' }}><label
                                        class="form-check-label" for="sp_4">Sangat tidak stabil</label></div>
                </div>
        </div>

        <div class="mb-3">
                <label class="form-label">6. Menurut Anda, apakah perempuan/istri nelayan diikutsertakan dalam kegiatan ekonomi
                        rumah tangga?</label>
                <div>
                        <div class="form-check form-check-inline"><input type="radio" name="keterlibatan_perempuan"
                                        value="Selalu" class="form-check-input" id="kprm_1" {{ old('keterlibatan_perempuan') == 'Selalu' ? 'checked' : '' }}><label class="form-check-label"
                                        for="kprm_1">Selalu</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="keterlibatan_perempuan"
                                        value="Sering" class="form-check-input" id="kprm_2" {{ old('keterlibatan_perempuan') == 'Sering' ? 'checked' : '' }}><label class="form-check-label"
                                        for="kprm_2">Sering</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="keterlibatan_perempuan"
                                        value="Jarang" class="form-check-input" id="kprm_3" {{ old('keterlibatan_perempuan') == 'Jarang' ? 'checked' : '' }}><label class="form-check-label"
                                        for="kprm_3">Jarang</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="keterlibatan_perempuan"
                                        value="Tidak pernah" class="form-check-input" id="kprm_4" {{ old('keterlibatan_perempuan') == 'Tidak pernah' ? 'checked' : '' }}><label class="form-check-label"
                                        for="kprm_4">Tidak pernah</label></div>
                </div>
        </div>

        <div class="mb-3">
                <label class="form-label">7. Berapa rata-rata kontribusi perempuan dalam pendapatan rumah tangga?</label>
                <div>
                        <div class="form-check form-check-inline"><input type="radio" name="kontribusi_perempuan_persen"
                                        value="Lebih dari 75%" class="form-check-input" id="kp_prs_1" {{ old('kontribusi_perempuan_persen') == 'Lebih dari 75%' ? 'checked' : '' }}><label class="form-check-label"
                                        for="kp_prs_1">Lebih dari 75%</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="kontribusi_perempuan_persen"
                                        value="51%–75%" class="form-check-input" id="kp_prs_2" {{ old('kontribusi_perempuan_persen') == '51%–75%' ? 'checked' : '' }}><label class="form-check-label"
                                        for="kp_prs_2">51%–75%</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="kontribusi_perempuan_persen"
                                        value="25%–50%" class="form-check-input" id="kp_prs_3" {{ old('kontribusi_perempuan_persen') == '25%–50%' ? 'checked' : '' }}><label class="form-check-label"
                                        for="kp_prs_3">25%–50%</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="kontribusi_perempuan_persen"
                                        value="Kurang dari 25%" class="form-check-input" id="kp_prs_4" {{ old('kontribusi_perempuan_persen') == 'Kurang dari 25%' ? 'checked' : '' }}><label class="form-check-label"
                                        for="kp_prs_4">Kurang dari 25%</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="kontribusi_perempuan_persen"
                                        value="Perempuan tidak dilibatkan dalam kegiatan ekonomi rumah tangga" class="form-check-input"
                                        id="kp_prs_5" {{ old('kontribusi_perempuan_persen') == 'Perempuan tidak dilibatkan dalam kegiatan ekonomi rumah tangga' ? 'checked' : '' }}><label class="form-check-label" for="kp_prs_5">Perempuan tidak dilibatkan dalam
                                        kegiatan ekonomi rumah tangga</label></div>
                </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pendPerikanan = document.getElementById('pendapatan_perikanan');
        const pendNonPerikanan = document.getElementById('pendapatan_non_perikanan');
        const pendTotal = document.getElementById('pendapatan_total');

        function hitungTotal() {
            const a = parseFloat(pendPerikanan.value) || 0;
            const b = parseFloat(pendNonPerikanan.value) || 0;
            if (pendTotal) {
                pendTotal.value = a + b;
            }
        }

        if (pendPerikanan) {
            pendPerikanan.addEventListener('input', hitungTotal);
        }

        if (pendNonPerikanan) {
            pendNonPerikanan.addEventListener('input', hitungTotal);
        }
    });
</script>