<form action="{{ route('survey.forms.store_progres_pembangunan_knmp', ['knmp' => $knmp->id]) }}" method="POST">

    @csrf

    {{-- ================================
    1. PROFIL PROYEK KNMP
================================ --}}
    <div class="card mb-3">
        <div class="card-header fw-bold">1. Profil Proyek KNMP</div>
        <div class="card-body">

            <div class="mb-3">
                <label class="form-label">Total Anggaran (Rp)</label>
                <input type="number" name="total_anggaran" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Anggaran Konstruksi (Rp)</label>
                <input type="number" name="anggaran_konstruksi" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Anggaran Pengadaan Sarpras (Rp)</label>
                <input type="number" name="anggaran_sarpras" class="form-control">
            </div>

        </div>
    </div>



    {{-- ================================
    2. DETAIL RENCANA PEMBANGUNAN
================================ --}}
    <div class="card mb-3">
        <div class="card-header fw-bold">2. Detail Rencana Pembangunan KNMP Tahun 2025</div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th style="width: 50px">No</th>
                            <th>Jenis Komponen</th>
                            <th style="width: 130px">Target (unit)</th>
                            <th style="width: 130px">Progres (%)</th>
                            <th>Keterangan (Estimasi penyelesaian s.d 31 Des)</th>
                        </tr>
                    </thead>
                    <tbody>

                        {{-- ===== A. KONSTRUKSI ===== --}}
                        <tr class="table-secondary fw-bold">
                            <td colspan="5">A. Konstruksi</td>
                        </tr>

                        @php
                        $konstruksi = [
                        'Tambatan Perahu / Dermaga — (Tuliskan dimensi bangunan)',
                        'Shelter pendaratan ikan',
                        'Bengkel / Docking kapal nelayan',
                        'Kantor pengelola',
                        'Sentra kuliner produk perikanan',
                        'Balai Pertemuan Nelayan',
                        'Shelter perbaikan jaring',
                        'Shelter Cool Box',
                        'Bangunan Tapak Cold Storage',
                        'Miniplan pengolahan ikan',
                        'Kios perbekalan',
                        'Tempat pembuangan sampah dan IPAL',
                        'Musholla',
                        'Sarana toilet umum',
                        'Jalan di kawasan lahan pembangunan',
                        'Penerangan umum',
                        'Pagar, gapura, dan/atau landmark',
                        'Parkir',
                        'Talud / Revetment Sungai dan Laut',
                        ];
                        @endphp

                        @foreach ($konstruksi as $i => $item)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>
                                {{ $item }}
                                <input type="hidden" name="konstruksi[{{ $i }}][komponen]" value="{{ $item }}">
                            </td>
                            <td><input type="number" name="konstruksi[{{ $i }}][target]" class="form-control"></td>
                            <td><input type="number" name="konstruksi[{{ $i }}][progress]" class="form-control"></td>
                            <td><textarea name="konstruksi[{{ $i }}][keterangan]" rows="2" class="form-control"></textarea></td>
                        </tr>
                        @endforeach



                        {{-- ===== B. Bantuan Kapal, Mesin, API ===== --}}
                        <tr class="table-secondary fw-bold">
                            <td colspan="5">B. Bantuan Kapal, Mesin dan API</td>
                        </tr>

                        @php
                        $bantuan_b = [
                        'Kapal penangkap ikan',
                        'Mesin kapal perikanan',
                        'Alat Penangkap Ikan',
                        ];
                        @endphp

                        @foreach ($bantuan_b as $i => $item)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>
                                {{ $item }}
                                <input type="hidden" name="bantuan_b[{{ $i }}][komponen]" value="{{ $item }}">
                            </td>

                            <td><input type="number" name="bantuan_b[{{ $i }}][target]" class="form-control"></td>
                            <td><input type="number" name="bantuan_b[{{ $i }}][progress]" class="form-control"></td>
                            <td><textarea name="bantuan_b[{{ $i }}][keterangan]" rows="2" class="form-control"></textarea></td>
                        </tr>
                        @endforeach



                        {{-- ===== C. Bantuan Sarana Rantai Dingin ===== --}}
                        <tr class="table-secondary fw-bold">
                            <td colspan="5">C. Bantuan Sarana Rantai Dingin</td>
                        </tr>

                        @php
                        $bantuan_c = [
                        'Cold Storage',
                        'Pabrik Es Balok',
                        'Pabrik Es Slurry',
                        'Kendaraan Berpendingin',
                        'Cool Box',
                        ];
                        @endphp

                        @foreach ($bantuan_c as $i => $item)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>
                                {{ $item }}
                                <input type="hidden" name="bantuan_c[{{ $i }}][komponen]" value="{{ $item }}">
                            </td>

                            <td><input type="number" name="bantuan_c[{{ $i }}][target]" class="form-control"></td>
                            <td><input type="number" name="bantuan_c[{{ $i }}][progress]" class="form-control"></td>
                            <td><textarea name="bantuan_c[{{ $i }}][keterangan]" rows="2" class="form-control"></textarea></td>
                        </tr>
                        @endforeach



                        {{-- ===== D. SPBU Nelayan ===== --}}
                        <tr class="table-secondary fw-bold">
                            <td colspan="5">D. SPBU Nelayan</td>
                        </tr>

                        <tr>
                            <td class="text-center">1</td>
                            <td>
                                SPBU Nelayan
                                <input type="hidden" name="spbu[komponen]" value="SPBU Nelayan">
                            </td>

                            <td><input type="number" name="spbu[target]" class="form-control"></td>
                            <td><input type="number" name="spbu[progress]" class="form-control"></td>
                            <td><textarea name="spbu[keterangan]" rows="2" class="form-control"></textarea></td>
                        </tr>


                    </tbody>
                </table>
            </div>

        </div>
    </div>



    {{-- ================================
    3. TENAGA KERJA
================================ --}}
    <div class="card mb-3">
        <div class="card-header fw-bold">3. Tenaga Kerja yang Terlibat</div>

        <div class="card-body">

            <div class="mb-2 fw-bold">1. Tenaga kerja terlibat dalam konstruksi KNMP:</div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>a. Laki-laki</label>
                    <input type="number" name="tk_konstruksi_l" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>b. Perempuan</label>
                    <input type="number" name="tk_konstruksi_p" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label>2. Upah tenaga kerja / hari (Rp)</label>
                <input type="number" name="upah_per_hari" class="form-control">
            </div>

            <div class="mb-3">
                <label>3. Lama bekerja di proyek (jumlah hari)</label>
                <input type="number" name="lama_bekerja" class="form-control">
            </div>

            <div class="mb-2 fw-bold">4. Tenaga kerja yang terlibat dalam konstruksi KNMP:</div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>a. Tenaga kerja lokal (orang)</label>
                    <input type="number" name="tk_lokal" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>b. Tenaga kerja dari luar (orang)</label>
                    <input type="number" name="tk_luar" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label>5. Tenaga kerja non-konstruksi (jika ada, sebutkan)</label>
                <textarea name="tk_non_konstruksi" rows="3" class="form-control"></textarea>
            </div>

        </div>
    </div>



    {{-- ================================
    4. KENDALA PEMBANGUNAN
================================ --}}
    <div class="card mb-3">
        <div class="card-header fw-bold">4. Kendala dalam proses pembangunan KNMP</div>

        <div class="card-body">

            @php
            $kendala = [
            'Faktor cuaca',
            'Ketersediaan tenaga kerja',
            'Ketersediaan material bahan bangunan',
            'Akses ke lokasi (jalan kurang memadai)',
            'Ketersediaan listrik',
            'Ketersediaan BBM',
            'Ketersediaan air bersih',
            'Jaringan internet',
            ];
            @endphp

            @foreach ($kendala as $i => $item)
            <div class="form-check mb-1">
                <input class="form-check-input" type="checkbox" name="kendala[]" value="{{ $item }}" id="kendala{{ $i }}">
                <label class="form-check-label" for="kendala{{ $i }}">
                    {{ $item }}
                </label>
            </div>
            @endforeach

        </div>
    </div>



    {{-- ================================
    5. CCTV TERPASANG ?
================================ --}}
    <div class="card mb-3">
        <div class="card-header fw-bold">5. Apakah CCTV telah terpasang?</div>

        <div class="card-body">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="cctv" value="Ya" id="cctvYes">
                <label class="form-check-label" for="cctvYes">Ya</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="cctv" value="Tidak" id="cctvNo">
                <label class="form-check-label" for="cctvNo">Tidak</label>
            </div>
        </div>
    </div>



    {{-- ================================
     BUTTON SIMPAN
================================ --}}
    <div class="text-end mt-3 mb-5">
        <button class="btn btn-primary px-4" type="submit">
            Simpan
        </button>
    </div>


</form>