<form method="POST" action="{{ route('forms.store_sosial_kelembagaan', ['knmp' => $knmp->id]) }}">
    @csrf
    <input type="hidden" name="knmp_id" value="{{ $knmp->id ?? 0 }}">

    <div class="mb-3">
        <label class="form-label">1. Apakah Anda ikut serta sebagai anggota kelompok nelayan atau KUB?</label>
        <div>
            <div class="form-check form-check-inline"><input type="radio" name="anggota_kelompok"
                    value="Ya, sangat aktif" class="form-check-input" id="akl_1"><label class="form-check-label"
                    for="akl_1">Ya, sangat aktif</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="anggota_kelompok"
                    value="Ya, tidak aktif" class="form-check-input" id="akl_2"><label class="form-check-label"
                    for="akl_2">Ya, tidak aktif</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="anggota_kelompok"
                    value="Tidak pernah bergabung" class="form-check-input" id="akl_3"><label
                    class="form-check-label" for="akl_3">Tidak pernah bergabung</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="anggota_kelompok"
                    value="Tidak ada kelompok nelayan/KUB di lokasi saya" class="form-check-input" id="akl_4"><label
                    class="form-check-label" for="akl_4">Tidak ada kelompok nelayan/KUB di lokasi saya</label></div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">2. Apakah Anda merasa mendapatkan manfaat dari keanggotaan dalam kelompok nelayan atau
            KUB?</label>
        <div>
            <div class="form-check form-check-inline"><input type="radio" name="manfaat_kelompok"
                    value="Sangat Setuju" class="form-check-input" id="mkl_1"><label class="form-check-label"
                    for="mkl_1">Sangat Setuju</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="manfaat_kelompok" value="Setuju"
                    class="form-check-input" id="mkl_2"><label class="form-check-label"
                    for="mkl_2">Setuju</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="manfaat_kelompok" value="Cukup Setuju"
                    class="form-check-input" id="mkl_3"><label class="form-check-label" for="mkl_3">Cukup
                    Setuju</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="manfaat_kelompok"
                    value="Kurang Setuju" class="form-check-input" id="mkl_4"><label class="form-check-label"
                    for="mkl_4">Kurang Setuju</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="manfaat_kelompok" value="Tidak Setuju"
                    class="form-check-input" id="mkl_5"><label class="form-check-label" for="mkl_5">Tidak
                    Setuju</label></div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">3. Apakah Anda ikut serta sebagai anggota koperasi perikanan di wilayah anda ?</label>
        <div>
            <div class="form-check form-check-inline"><input type="radio" name="anggota_koperasi"
                    value="Ya, sangat aktif" class="form-check-input" id="akp_1"><label class="form-check-label"
                    for="akp_1">Ya, sangat aktif</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="anggota_koperasi"
                    value="Ya, tidak aktif" class="form-check-input" id="akp_2"><label class="form-check-label"
                    for="akp_2">Ya, tidak aktif</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="anggota_koperasi"
                    value="Tidak pernah bergabung" class="form-check-input" id="akp_3"><label
                    class="form-check-label" for="akp_3">Tidak pernah bergabung</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="anggota_koperasi"
                    value="Tidak ada koperasi perikanan di lokasi saya" class="form-check-input"
                    id="akp_4"><label class="form-check-label" for="akp_4">Tidak ada koperasi perikanan di
                    lokasi saya</label></div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">4. Jika anda belum menjadi anggota koperasi, apakah anda tertarik untuk menjadi
            Anggota Koperasi Perikanan?</label>
        <div>
            <div class="form-check form-check-inline"><input type="radio" name="tertarik_koperasi"
                    value="Sangat tidak tertarik" class="form-check-input" id="tkp_1"><label
                    class="form-check-label" for="tkp_1">Sangat tidak tertarik</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="tertarik_koperasi"
                    value="Tidak tertarik" class="form-check-input" id="tkp_2"><label class="form-check-label"
                    for="tkp_2">Tidak tertarik</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="tertarik_koperasi"
                    value="Tertarik" class="form-check-input" id="tkp_3"><label class="form-check-label"
                    for="tkp_3">Tertarik</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="tertarik_koperasi"
                    value="Sudah menjadi anggota" class="form-check-input" id="tkp_4"><label
                    class="form-check-label" for="tkp_4">Sudah menjadi anggota</label></div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">5. Apakah Anda merasa mendapatkan manfaat dari keanggotaan dari koperasi
            perikanan?</label>
        <div>
            <div class="form-check form-check-inline"><input type="radio" name="manfaat_koperasi"
                    value="Sangat Setuju" class="form-check-input" id="mkp_1"><label class="form-check-label"
                    for="mkp_1">Sangat Setuju</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="manfaat_koperasi" value="Setuju"
                    class="form-check-input" id="mkp_2"><label class="form-check-label"
                    for="mkp_2">Setuju</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="manfaat_koperasi"
                    value="Cukup Setuju" class="form-check-input" id="mkp_3"><label class="form-check-label"
                    for="mkp_3">Cukup Setuju</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="manfaat_koperasi"
                    value="Kurang Setuju" class="form-check-input" id="mkp_4"><label class="form-check-label"
                    for="mkp_4">Kurang Setuju</label></div>
            <div class="form-check form-check-inline"><input type="radio" name="manfaat_koperasi"
                    value="Tidak Setuju" class="form-check-input" id="mkp_5"><label class="form-check-label"
                    for="mkp_5">Tidak Setuju</label></div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">6. Bagaimanakah pendapat anda secara umum tentang koperasi perikanan yang terdapat di
            wilayah Anda?</label>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 50%;">Aktivitas</th>
                            <th class="text-center" style="width: 25%;">Ya</th>
                            <th class="text-center" style="width: 25%;">Tidak</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Apakah koperasi Rutin melakukan rapat anggota tahunan</td>
                            <td class="text-center"><input type="radio" name="koperasi_rapat_tahunan"
                                    value="Ya" class="form-check-input"></td>
                            <td class="text-center"><input type="radio" name="koperasi_rapat_tahunan"
                                    value="Tidak" class="form-check-input"></td>
                        </tr>
                        <tr>
                            <td>Apakah anda saat ini sebagai anggota aktif berpartisipasi</td>
                            <td class="text-center"><input type="radio" name="koperasi_partisipasi_aktif"
                                    value="Ya" class="form-check-input"></td>
                            <td class="text-center"><input type="radio" name="koperasi_partisipasi_aktif"
                                    value="Tidak" class="form-check-input"></td>
                        </tr>
                        <tr>
                            <td>Apakah Pengurus koperasi saat ini kompeten (mampu mengelola koperasi)</td>
                            <td class="text-center"><input type="radio" name="koperasi_pengurus_kompeten"
                                    value="Ya" class="form-check-input"></td>
                            <td class="text-center"><input type="radio" name="koperasi_pengurus_kompeten"
                                    value="Tidak" class="form-check-input"></td>
                        </tr>
                        <tr>
                            <td>Apakah pengurus koperasi telah menjalankan koperasi dengan transparan dan akuntabel
                            </td>
                            <td class="text-center"><input type="radio" name="koperasi_transparan" value="Ya"
                                    class="form-check-input"></td>
                            <td class="text-center"><input type="radio" name="koperasi_transparan" value="Tidak"
                                    class="form-check-input"></td>
                        </tr>
                        <tr>
                            <td>Apakah Keuangan koperasi sehat</td>
                            <td class="text-center"><input type="radio" name="koperasi_keuangan_sehat"
                                    value="Ya" class="form-check-input"></td>
                            <td class="text-center"><input type="radio" name="koperasi_keuangan_sehat"
                                    value="Tidak" class="form-check-input"></td>
                        </tr>
                        <tr>
                            <td>Apakah koperasi memiliki jaringan pasar yang luas</td>
                            <td class="text-center"><input type="radio" name="koperasi_jaringan_pasar"
                                    value="Ya" class="form-check-input"></td>
                            <td class="text-center"><input type="radio" name="koperasi_jaringan_pasar"
                                    value="Tidak" class="form-check-input"></td>
                        </tr>
                        <tr>
                            <td>Apakah anda dan Pelaku usaha lainnya percaya dengan profesionalisme koperasi</td>
                            <td class="text-center"><input type="radio" name="koperasi_kepercayaan_usaha"
                                    value="Ya" class="form-check-input"></td>
                            <td class="text-center"><input type="radio" name="koperasi_kepercayaan_usaha"
                                    value="Tidak" class="form-check-input"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-primary">Simpan Sosial & Kelembagaan</button>
    </div>
</form>
