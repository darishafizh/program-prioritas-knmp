<form action="{{ route('forms.store_progres_knmp', ['knmp' => $knmp->id]) }}" method="POST">
    @csrf

    {{-- BAGIAN 1: PROFIL PROYEK --}}
    <h5 class="mb-1">1. Profil Proyek KNMP</h5>
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <label class="form-label">Total Anggaran (Rp)</label>
            <input type="number" name="anggaran_total" class="form-control" placeholder="22.000.000.000">
        </div>
        <div class="col-md-4">
            <label class="form-label">Anggaran Konstruksi (Rp)</label>
            <input type="number" name="anggaran_konstruksi" class="form-control" placeholder="2.000.000.000">
        </div>
        <div class="col-md-4">
            <label class="form-label">Anggaran Pengadaan Sarpras (Rp)</label>
            <input type="number" name="anggaran_sarpras" class="form-control" placeholder="200.000.000">
        </div>
    </div>

    {{-- BAGIAN 2: PROGRESS PEMBANGUNAN (TABEL UTAMA) --}}
    <h5 class="mb-1">2. Detail Rencana Pembangunan KNMP</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-striped mb-3 align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th width="5%">No</th>
                    <th width="30%">Jenis Komponen</th>
                    <th width="15%">Target (unit)</th>
                    <th width="15%">Progres (%)</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $components = [
                        'A' => [
                            'title' => 'Konstruksi',
                            'items' => [
                                'Tambatan Perahu / Dermaga',
                                'Shelter pendaratan ikan',
                                'Bengkel/ Docking kapal nelayan',
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
                            ],
                        ],
                        'B' => [
                            'title' => 'Bantuan Kapal, Mesin dan API',
                            'items' => ['Kapal penangkap ikan', 'Mesin kapal perikanan', 'Alat Penangkap Ikan'],
                        ],
                        'C' => [
                            'title' => 'Bantuan Sarana Rantai Dingin',
                            'items' => [
                                'Cold Storage',
                                'Pabrik Es Balok',
                                'Pabrik Es Slurry',
                                'Kendaraan Berpendingin',
                                'Cool Box',
                            ],
                        ],
                        'D' => [
                            'title' => 'SPBU Nelayan',
                            'items' => ['SPBU Nelayan'],
                        ],
                    ];
                @endphp

                @foreach ($components as $code => $section)
                    <tr class="table-secondary fw-bold">
                        <td colspan="5" class="text-dark">{{ $code }}. {{ $section['title'] }}</td>
                    </tr>
                    @foreach ($section['items'] as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}. <input type="hidden"
                                    name="progress[{{ $code }}][{{ $index }}][kode]"
                                    value="{{ $code }}">
                            </td>
                            <td>{{ $item }} <input type="hidden"
                                    name="progress[{{ $code }}][{{ $index }}][komponen]"
                                    value="{{ $item }}">
                            </td>
                            <td>
                                <input type="number"
                                    name="progress[{{ $code }}][{{ $index }}][target]"
                                    class="form-control form-control-sm">
                            </td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <input type="number"
                                        name="progress[{{ $code }}][{{ $index }}][persen]"
                                        class="form-control" max="100">
                                    <span class="input-group-text">%</span>
                                </div>
                            </td>
                            <td>
                                <input type="text"
                                    name="progress[{{ $code }}][{{ $index }}][keterangan]"
                                    class="form-control form-control-sm" placeholder="Contoh: Dimensi bangunan...">
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- BAGIAN 3: TENAGA KERJA --}}
    <h5 class="mb-1">3. Tenaga Kerja yang Terlibat</h5>
    <table class="table table-bordered mb-3 align-middle">
        <thead class="table-primary text-center">
            <tr>
                <th width="5%">No</th>
                <th>Rincian</th>
                <th width="30%">Jawaban</th>
            </tr>
        </thead>
        <tbody>
            {{-- Poin 1 --}}
            <tr>
                <td class="text-center">1.</td>
                <td>Tenaga Kerja yang terlibat dalam konstruksi KNMP</td>
                <td><input type="number" name="tk_total" class="form-control"></td>
            </tr>
            <tr>
                <td></td>
                <td class="ps-4">a. Laki-Laki</td>
                <td><input type="number" name="tk_laki" class="form-control"></td>
            </tr>
            <tr>
                <td></td>
                <td class="ps-4">b. Perempuan</td>
                <td><input type="number" name="tk_perempuan" class="form-control"></td>
            </tr>

            {{-- Poin 2 & 3 --}}
            <tr>
                <td class="text-center">2.</td>
                <td>Upah tenaga kerja/hari (Rp)</td>
                <td><input type="number" name="tk_upah" class="form-control"></td>
            </tr>
            <tr>
                <td class="text-center">3.</td>
                <td>Lama bekerja di proyek (jumlah hari)</td>
                <td><input type="number" name="tk_durasi" class="form-control"></td>
            </tr>

            {{-- Poin 4 (Duplikasi teks di gambar, diasumsikan Breakdown Asal TK) --}}
            <tr>
                <td class="text-center">4.</td>
                <td>Asal Tenaga Kerja:</td>
                <td></td> {{-- Spacer --}}
            </tr>
            <tr>
                <td></td>
                <td class="ps-4">a. Jumlah tenaga kerja lokal (orang)</td>
                <td><input type="number" name="tk_lokal" class="form-control"></td>
            </tr>
            <tr>
                <td></td>
                <td class="ps-4">b. Jumlah tenaga kerja dari luar (orang)</td>
                <td><input type="number" name="tk_luar" class="form-control"></td>
            </tr>

            {{-- Poin 5 --}}
            <tr>
                <td class="text-center">5.</td>
                <td>Jumlah Tenaga Kerja yang terlibat Non konstruksi KNMP (jika ada sebutkan jenis pekerjaannya)
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" name="tk_non_konstruksi_jumlah" class="form-control" placeholder="Jml">
                        <input type="text" name="tk_non_konstruksi_ket" class="form-control w-50"
                            placeholder="Ket: Pedagang, dll">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="row">
        {{-- BAGIAN 4: KENDALA --}}
        <div class="col-md-6 mb-4">
            <h5 class="mb-1">4. Kendala dalam proses pembangunan</h5>

            @php
                $kendalas = [
                    'Faktor cuaca',
                    'Ketersediaan tenaga kerja',
                    'Ketersediaan material bahan bangunan',
                    'Akses ke lokasi (jalan kurang memadai)',
                    'Ketersediaan Listrik',
                    'Ketersediaan BBM',
                    'Ketersediaan air bersih',
                    'Jaringan Internet',
                ];
            @endphp
            @foreach ($kendalas as $k)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="kendala[]" value="{{ $k }}"
                        id="k_{{ Str::slug($k) }}">
                    <label class="form-check-label" for="k_{{ Str::slug($k) }}">{{ $k }}</label>
                </div>
            @endforeach
        </div>

        {{-- BAGIAN 5: CCTV --}}
        <div class="col-md-6 mb-4">
            <h5 class="mb-1">5. CCTV</h5>

            <p>Apakah CCTV sudah terpasang?</p>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="cctv" id="cctv_ya" value="Ya">
                <label class="form-check-label" for="cctv_ya">Ya</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="cctv" id="cctv_tidak" value="Tidak">
                <label class="form-check-label" for="cctv_tidak">Tidak</label>
            </div>
        </div>
    </div>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
        <button type="submit" class="btn btn-primary px-5">Simpan</button>
    </div>
</form>
