<form method="POST" action="{{ route('forms.store_sosial_kelembagaan', ['knmp' => $knmp->id]) }}">

        @csrf

        <input type="hidden" name="knmp_id" value="{{ $knmp->id }}">

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
                                                (isset($selectedRespondenData['sosial_kelembagaan']) && $selectedRespondenData['sosial_kelembagaan'] && $selectedRespondenData['sosial_kelembagaan']->responden_id == $r->id && !old('responden_id'));
                                @endphp
                                <option value="{{ $r->id }}" {{ $isSelected ? 'selected' : '' }}>
                                        id = {{ $r->id }} - {{ $r->nama_responden }} ({{ $r->nik }})
                                </option>
                        @endforeach
                </select>

                @error('responden_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                @enderror
        </div>

        <div class="mb-3">
                <label class="form-label">1. Apakah Anda ikut serta sebagai anggota kelompok nelayan atau KUB?</label>
                <div>
                        <div class="form-check form-check-inline"><input type="radio" name="anggota_kelompok"
                                        value="Ya, sangat aktif" class="form-check-input" required id="akl_1" {{ old('anggota_kelompok') == 'Ya, sangat aktif' ? 'checked' : '' }}><label
                                        class="form-check-label" for="akl_1">Ya, sangat aktif</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="anggota_kelompok"
                                        value="Ya, tidak aktif" class="form-check-input" required id="akl_2" {{ old('anggota_kelompok') == 'Ya, tidak aktif' ? 'checked' : '' }}><label
                                        class="form-check-label" for="akl_2">Ya, tidak aktif</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="anggota_kelompok"
                                        value="Tidak pernah bergabung" class="form-check-input" required id="akl_3" {{ old('anggota_kelompok') == 'Tidak pernah bergabung' ? 'checked' : '' }}><label
                                        class="form-check-label" for="akl_3">Tidak pernah bergabung</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="anggota_kelompok"
                                        value="Tidak ada kelompok nelayan/KUB di lokasi saya" class="form-check-input"
                                        required id="akl_4" {{ old('anggota_kelompok') == 'Tidak ada kelompok nelayan/KUB di lokasi saya' ? 'checked' : '' }}><label class="form-check-label"
                                        for="akl_4">Tidak ada
                                        kelompok nelayan/KUB di lokasi saya</label></div>
                </div>
        </div>

        <div class="mb-3">
                <label class="form-label">2. Apakah Anda merasa mendapatkan manfaat dari keanggotaan dalam kelompok
                        nelayan atau
                        KUB?</label>
                <div>
                        <div class="form-check form-check-inline"><input type="radio" name="manfaat_kelompok"
                                        value="Sangat Setuju" class="form-check-input" required id="mkl_1" {{ old('manfaat_kelompok') == 'Sangat Setuju' ? 'checked' : '' }}><label
                                        class="form-check-label" for="mkl_1">Sangat Setuju</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="manfaat_kelompok"
                                        value="Setuju" class="form-check-input" required id="mkl_2" {{ old('manfaat_kelompok') == 'Setuju' ? 'checked' : '' }}><label
                                        class="form-check-label" for="mkl_2">Setuju</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="manfaat_kelompok"
                                        value="Cukup Setuju" class="form-check-input" required id="mkl_3" {{ old('manfaat_kelompok') == 'Cukup Setuju' ? 'checked' : '' }}><label
                                        class="form-check-label" for="mkl_3">Cukup
                                        Setuju</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="manfaat_kelompok"
                                        value="Kurang Setuju" class="form-check-input" required id="mkl_4" {{ old('manfaat_kelompok') == 'Kurang Setuju' ? 'checked' : '' }}><label
                                        class="form-check-label" for="mkl_4">Kurang Setuju</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="manfaat_kelompok"
                                        value="Tidak Setuju" class="form-check-input" required id="mkl_5" {{ old('manfaat_kelompok') == 'Tidak Setuju' ? 'checked' : '' }}><label
                                        class="form-check-label" for="mkl_5">Tidak
                                        Setuju</label></div>
                </div>
        </div>

        <div class="mb-3">
                <label class="form-label">3. Apakah Anda ikut serta sebagai anggota koperasi perikanan di wilayah anda
                        ?</label>
                <div>
                        <div class="form-check form-check-inline"><input type="radio" name="anggota_koperasi"
                                        value="Ya, sangat aktif" class="form-check-input" required id="akp_1" {{ old('anggota_koperasi') == 'Ya, sangat aktif' ? 'checked' : '' }}><label
                                        class="form-check-label" for="akp_1">Ya, sangat aktif</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="anggota_koperasi"
                                        value="Ya, tidak aktif" class="form-check-input" required id="akp_2" {{ old('anggota_koperasi') == 'Ya, tidak aktif' ? 'checked' : '' }}><label
                                        class="form-check-label" for="akp_2">Ya, tidak aktif</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="anggota_koperasi"
                                        value="Tidak pernah bergabung" class="form-check-input" required id="akp_3" {{ old('anggota_koperasi') == 'Tidak pernah bergabung' ? 'checked' : '' }}><label
                                        class="form-check-label" for="akp_3">Tidak pernah bergabung</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="anggota_koperasi"
                                        value="Tidak ada koperasi perikanan di lokasi saya" class="form-check-input"
                                        required id="akp_4" {{ old('anggota_koperasi') == 'Tidak ada koperasi perikanan di lokasi saya' ? 'checked' : '' }}><label class="form-check-label"
                                        for="akp_4">Tidak ada
                                        koperasi perikanan di
                                        lokasi saya</label></div>
                </div>
        </div>

        <div class="mb-3">
                <label class="form-label">4. Jika anda belum menjadi anggota koperasi, apakah anda tertarik untuk
                        menjadi
                        Anggota Koperasi Perikanan?</label>
                <div>
                        <div class="form-check form-check-inline"><input type="radio" name="tertarik_koperasi"
                                        value="Sangat tidak tertarik" class="form-check-input" required id="tkp_1" {{ old('tertarik_koperasi') == 'Sangat tidak tertarik' ? 'checked' : '' }}><label
                                        class="form-check-label" for="tkp_1">Sangat tidak tertarik</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="tertarik_koperasi"
                                        value="Tidak tertarik" class="form-check-input" required id="tkp_2" {{ old('tertarik_koperasi') == 'Tidak tertarik' ? 'checked' : '' }}><label
                                        class="form-check-label" for="tkp_2">Tidak tertarik</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="tertarik_koperasi"
                                        value="Tertarik" class="form-check-input" required id="tkp_3" {{ old('tertarik_koperasi') == 'Tertarik' ? 'checked' : '' }}><label
                                        class="form-check-label" for="tkp_3">Tertarik</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="tertarik_koperasi"
                                        value="Sudah menjadi anggota" class="form-check-input" required id="tkp_4" {{ old('tertarik_koperasi') == 'Sudah menjadi anggota' ? 'checked' : '' }}><label
                                        class="form-check-label" for="tkp_4">Sudah menjadi anggota</label></div>
                </div>
        </div>

        <div class="mb-3">
                <label class="form-label">5. Apakah Anda merasa mendapatkan manfaat dari keanggotaan dari koperasi
                        perikanan?</label>
                <div>
                        <div class="form-check form-check-inline"><input type="radio" name="manfaat_koperasi"
                                        value="Sangat Setuju" class="form-check-input" required id="mkp_1" {{ old('manfaat_koperasi') == 'Sangat Setuju' ? 'checked' : '' }}><label
                                        class="form-check-label" for="mkp_1">Sangat Setuju</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="manfaat_koperasi"
                                        value="Setuju" class="form-check-input" required id="mkp_2" {{ old('manfaat_koperasi') == 'Setuju' ? 'checked' : '' }}><label
                                        class="form-check-label" for="mkp_2">Setuju</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="manfaat_koperasi"
                                        value="Cukup Setuju" class="form-check-input" required id="mkp_3" {{ old('manfaat_koperasi') == 'Cukup Setuju' ? 'checked' : '' }}><label
                                        class="form-check-label" for="mkp_3">Cukup Setuju</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="manfaat_koperasi"
                                        value="Kurang Setuju" class="form-check-input" required id="mkp_4" {{ old('manfaat_koperasi') == 'Kurang Setuju' ? 'checked' : '' }}><label
                                        class="form-check-label" for="mkp_4">Kurang Setuju</label></div>
                        <div class="form-check form-check-inline"><input type="radio" name="manfaat_koperasi"
                                        value="Tidak Setuju" class="form-check-input" required id="mkp_5" {{ old('manfaat_koperasi') == 'Tidak Setuju' ? 'checked' : '' }}><label
                                        class="form-check-label" for="mkp_5">Tidak Setuju</label></div>
                </div>
        </div>

        <div class="mb-3">
                <label class="form-label">6. Bagaimanakah pendapat anda secara umum tentang koperasi perikanan yang
                        terdapat di
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
                                                        <td class="text-center"><input type="radio"
                                                                        name="koperasi_rapat_tahunan" value="Ya"
                                                                        class="form-check-input" required {{ old('koperasi_rapat_tahunan') == 'Ya' ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="radio"
                                                                        name="koperasi_rapat_tahunan" value="Tidak"
                                                                        class="form-check-input" required {{ old('koperasi_rapat_tahunan') == 'Tidak' ? 'checked' : '' }}></td>
                                                </tr>
                                                <tr>
                                                        <td>Apakah anda saat ini sebagai anggota aktif berpartisipasi
                                                        </td>
                                                        <td class="text-center"><input type="radio"
                                                                        name="koperasi_partisipasi_aktif" value="Ya"
                                                                        class="form-check-input" required {{ old('koperasi_partisipasi_aktif') == 'Ya' ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="radio"
                                                                        name="koperasi_partisipasi_aktif" value="Tidak"
                                                                        class="form-check-input" required {{ old('koperasi_partisipasi_aktif') == 'Tidak' ? 'checked' : '' }}></td>
                                                </tr>
                                                <tr>
                                                        <td>Apakah Pengurus koperasi saat ini kompeten (mampu mengelola
                                                                koperasi)</td>
                                                        <td class="text-center"><input type="radio"
                                                                        name="koperasi_pengurus_kompeten" value="Ya"
                                                                        class="form-check-input" required {{ old('koperasi_pengurus_kompeten') == 'Ya' ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="radio"
                                                                        name="koperasi_pengurus_kompeten" value="Tidak"
                                                                        class="form-check-input" required {{ old('koperasi_pengurus_kompeten') == 'Tidak' ? 'checked' : '' }}></td>
                                                </tr>
                                                <tr>
                                                        <td>Apakah pengurus koperasi telah menjalankan koperasi dengan
                                                                transparan dan akuntabel
                                                        </td>
                                                        <td class="text-center"><input type="radio"
                                                                        name="koperasi_transparan" value="Ya"
                                                                        class="form-check-input" required {{ old('koperasi_transparan') == 'Ya' ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="radio"
                                                                        name="koperasi_transparan" value="Tidak"
                                                                        class="form-check-input" required {{ old('koperasi_transparan') == 'Tidak' ? 'checked' : '' }}></td>
                                                </tr>
                                                <tr>
                                                        <td>Apakah Keuangan koperasi sehat</td>
                                                        <td class="text-center"><input type="radio"
                                                                        name="koperasi_keuangan_sehat" value="Ya"
                                                                        class="form-check-input" required {{ old('koperasi_keuangan_sehat') == 'Ya' ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="radio"
                                                                        name="koperasi_keuangan_sehat" value="Tidak"
                                                                        class="form-check-input" required {{ old('koperasi_keuangan_sehat') == 'Tidak' ? 'checked' : '' }}></td>
                                                </tr>
                                                <tr>
                                                        <td>Apakah koperasi memiliki jaringan pasar yang luas</td>
                                                        <td class="text-center"><input type="radio"
                                                                        name="koperasi_jaringan_pasar" value="Ya"
                                                                        class="form-check-input" required {{ old('koperasi_jaringan_pasar') == 'Ya' ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="radio"
                                                                        name="koperasi_jaringan_pasar" value="Tidak"
                                                                        class="form-check-input" required {{ old('koperasi_jaringan_pasar') == 'Tidak' ? 'checked' : '' }}></td>
                                                </tr>
                                                <tr>
                                                        <td>Apakah anda dan Pelaku usaha lainnya percaya dengan
                                                                profesionalisme koperasi</td>
                                                        <td class="text-center"><input type="radio"
                                                                        name="koperasi_kepercayaan_usaha" value="Ya"
                                                                        class="form-check-input" required {{ old('koperasi_kepercayaan_usaha') == 'Ya' ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="radio"
                                                                        name="koperasi_kepercayaan_usaha" value="Tidak"
                                                                        class="form-check-input" required {{ old('koperasi_kepercayaan_usaha') == 'Tidak' ? 'checked' : '' }}></td>
                                                </tr>
                                        </tbody>
                                </table>
                        </div>
                </div>
        </div>


        <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
</form>