@php
    // Check if progresKnmp data exists
    $hasData = isset($progresKnmp) && $progresKnmp && $progresKnmp->id;
@endphp

{{-- ALERT ERROR VALIDASI --}}
@if ($errors->any())
<div class="alert alert-danger">
    <strong>Terjadi kesalahan:</strong>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- View Mode (when data exists) --}}
<div id="progresKnmpViewMode" class="{{ $hasData ? '' : 'd-none' }}">

    {{-- BAGIAN 1: PROFIL PROYEK --}}
    <h5 class="mb-1">1. Profil Proyek KNMP</h5>
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <label class="form-label">Total Anggaran (Rp)</label>
            <input type="text" class="form-control" value="{{ number_format($progresKnmp->anggaran_total ?? 0, 0, ',', '.') }}" readonly disabled>
        </div>
        <div class="col-md-4">
            <label class="form-label">Anggaran Konstruksi (Rp)</label>
            <input type="text" class="form-control" value="{{ number_format($progresKnmp->anggaran_konstruksi ?? 0, 0, ',', '.') }}" readonly disabled>
        </div>
        <div class="col-md-4">
            <label class="form-label">Anggaran Pengadaan Sarpras (Rp)</label>
            <input type="text" class="form-control" value="{{ number_format($progresKnmp->anggaran_sarpras ?? 0, 0, ',', '.') }}" readonly disabled>
        </div>
    </div>

    {{-- BAGIAN 2: PROGRESS PEMBANGUNAN --}}
    <h5 class="mb-1">2. Detail Rencana Pembangunan KNMP</h5>

    <div class="table-responsive">
        <table class="table table-bordered table-striped mb-3 align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Jenis Komponen</th>
                    <th>Target (unit)</th>
                    <th>Progres (%)</th>
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
                    <td colspan="5">{{ $code }}. {{ $section['title'] }}</td>
                </tr>

                @foreach ($section['items'] as $index => $item)
                @php
                    $existingDetail = null;
                    if (isset($progresKnmp) && $progresKnmp && $progresKnmp->details) {
                        $existingDetail = $progresKnmp->details->where('kode', $code)->where('komponen', $item)->first();
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item }}</td>
                    <td class="text-center">{{ $existingDetail->target ?? '-' }}</td>
                    <td class="text-center">{{ isset($existingDetail->persen) ? $existingDetail->persen . '%' : '-' }}</td>
                    <td>{{ $existingDetail->keterangan ?? '-' }}</td>
                </tr>
                @endforeach

                @endforeach
            </tbody>
        </table>
    </div>

    {{-- BAGIAN 3: TENAGA KERJA --}}
    <h5 class="mb-1">3. Tenaga Kerja</h5>

    <table class="table table-bordered mb-3 align-middle">
        <thead class="table-primary text-center">
            <tr>
                <th>No</th>
                <th>Rincian</th>
                <th>Jawaban</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="text-center">1.</td>
                <td>Tenaga Kerja yang terlibat dalam konstruksi KNMP</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="ps-4">a. Laki-Laki</td>
                <td>{{ $progresKnmp->tk_laki ?? '-' }}</td>
            </tr>
            <tr>
                <td></td>
                <td class="ps-4">b. Perempuan</td>
                <td>{{ $progresKnmp->tk_perempuan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="text-center">2.</td>
                <td>Upah tenaga kerja/hari (Rp)</td>
                <td>{{ number_format($progresKnmp->tk_upah ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-center">3.</td>
                <td>Lama bekerja di proyek (jumlah hari)</td>
                <td>{{ $progresKnmp->tk_durasi ?? '-' }}</td>
            </tr>
            <tr>
                <td class="text-center">4.</td>
                <td>Asal Tenaga Kerja:</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td class="ps-4">a. Lokal</td>
                <td>{{ $progresKnmp->tk_lokal ?? '-' }}</td>
            </tr>
            <tr>
                <td></td>
                <td class="ps-4">b. Dari luar</td>
                <td>{{ $progresKnmp->tk_luar ?? '-' }}</td>
            </tr>
            <tr>
                <td class="text-center">5.</td>
                <td>Tenaga kerja non konstruksi</td>
                <td>{{ ($progresKnmp->tk_non_konstruksi_jumlah ?? '-') }} {{ ($progresKnmp->tk_non_konstruksi_ket ?? null) ? '(' . $progresKnmp->tk_non_konstruksi_ket . ')' : '' }}</td>
            </tr>
        </tbody>
    </table>

    {{-- BAGIAN 4: KENDALA & CCTV --}}
    <div class="row">
        <div class="col-md-6 mb-4">
            <h5 class="mb-1">4. Kendala</h5>
            @php
            $existingKendala = [];
            if (isset($progresKnmp) && $progresKnmp && $progresKnmp->kendala) {
                $existingKendala = is_array($progresKnmp->kendala) ? $progresKnmp->kendala : json_decode($progresKnmp->kendala, true) ?? [];
            }
            @endphp
            <div class="ms-3">
                @if(count($existingKendala) > 0)
                    @foreach($existingKendala as $k)
                        <span class="badge bg-warning text-white me-1 mb-1">{{ $k }}</span>
                    @endforeach
                @else
                    <span class="text-muted">Tidak ada kendala</span>
                @endif
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <h5 class="mb-1">5. CCTV</h5>
            <p>Status CCTV: <span class="badge {{ ($progresKnmp->cctv ?? '') == 'Ya' ? 'bg-success' : 'bg-secondary' }}">{{ $progresKnmp->cctv ?? 'Belum ditentukan' }}</span></p>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <button type="button" class="btn btn-warning text-white" id="btnEditProgresKnmp">
            <i class="mdi mdi-pencil me-1"></i>Edit
        </button>
    </div>
</div>

{{-- Edit/Create Mode --}}
<div id="progresKnmpEditMode" class="{{ $hasData ? 'd-none' : '' }}">
    <form action="{{ $hasData ? route('forms.update_progres_knmp', ['knmp' => $knmp->id]) : route('forms.store_progres_knmp', ['knmp' => $knmp->id]) }}" method="POST" id="formProgresKnmp">
        @csrf

        {{-- BAGIAN 1: PROFIL PROYEK --}}
        <h5 class="mb-1">1. Profil Proyek KNMP</h5>
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label">Total Anggaran (Rp)</label>
                <input type="number" name="anggaran_total" class="form-control"
                    value="{{ old('anggaran_total', $progresKnmp->anggaran_total ?? '') }}" placeholder="22.000.000.000">
            </div>
            <div class="col-md-4">
                <label class="form-label">Anggaran Konstruksi (Rp)</label>
                <input type="number" name="anggaran_konstruksi" class="form-control"
                    value="{{ old('anggaran_konstruksi', $progresKnmp->anggaran_konstruksi ?? '') }}" placeholder="2.000.000.000">
            </div>
            <div class="col-md-4">
                <label class="form-label">Anggaran Pengadaan Sarpras (Rp)</label>
                <input type="number" name="anggaran_sarpras" class="form-control"
                    value="{{ old('anggaran_sarpras', $progresKnmp->anggaran_sarpras ?? '') }}" placeholder="200.000.000">
            </div>
        </div>

        {{-- BAGIAN 2: PROGRESS PEMBANGUNAN --}}
        <h5 class="mb-1">2. Detail Rencana Pembangunan KNMP</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-3 align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Jenis Komponen</th>
                        <th>Target (unit)</th>
                        <th>Progres (%)</th>
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
                        <td colspan="5">{{ $code }}. {{ $section['title'] }}</td>
                    </tr>

                    @foreach ($section['items'] as $index => $item)
                    @php
                        // Find existing data for this komponen from $progresKnmp->details
                        $existingDetail = null;
                        if (isset($progresKnmp) && $progresKnmp && $progresKnmp->details) {
                            $existingDetail = $progresKnmp->details->where('kode', $code)->where('komponen', $item)->first();
                        }
                    @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}
                            <input type="hidden"
                                name="progress[{{ $code }}][{{ $index }}][kode]"
                                value="{{ $code }}">
                        </td>

                        <td>{{ $item }}
                            <input type="hidden"
                                name="progress[{{ $code }}][{{ $index }}][komponen]"
                                value="{{ $item }}">
                        </td>

                        <td>
                            <input type="number"
                                name="progress[{{ $code }}][{{ $index }}][target]"
                                class="form-control form-control-sm"
                                value="{{ old('progress.' . $code . '.' . $index . '.target', $existingDetail->target ?? '') }}">
                        </td>

                        <td>
                            <div class="input-group input-group-sm">
                                <input type="number"
                                    name="progress[{{ $code }}][{{ $index }}][persen]"
                                    class="form-control"
                                    value="{{ old('progress.' . $code . '.' . $index . '.persen', $existingDetail->persen ?? '') }}"
                                    max="100">
                                <span class="input-group-text">%</span>
                            </div>
                        </td>

                        <td>
                            <input type="text"
                                name="progress[{{ $code }}][{{ $index }}][keterangan]"
                                class="form-control form-control-sm"
                                value="{{ old('progress.' . $code . '.' . $index . '.keterangan', $existingDetail->keterangan ?? '') }}"
                                placeholder="Contoh: Dimensi bangunan...">
                        </td>
                    </tr>
                    @endforeach

                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- BAGIAN 3: TENAGA KERJA --}}
        <h5 class="mb-1">3. Tenaga Kerja</h5>

        <table class="table table-bordered mb-3 align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Rincian</th>
                    <th>Jawaban</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td class="text-center">1.</td>
                    <td>Tenaga Kerja yang terlibat dalam konstruksi KNMP</td>
                </tr>

                <tr>
                    <td></td>
                    <td class="ps-4">a. Laki-Laki</td>
                    <td><input type="number" name="tk_laki" class="form-control" value="{{ old('tk_laki', $progresKnmp->tk_laki ?? '') }}"></td>
                </tr>

                <tr>
                    <td></td>
                    <td class="ps-4">b. Perempuan</td>
                    <td><input type="number" name="tk_perempuan" class="form-control" value="{{ old('tk_perempuan', $progresKnmp->tk_perempuan ?? '') }}"></td>
                </tr>

                <tr>
                    <td class="text-center">2.</td>
                    <td>Upah tenaga kerja/hari (Rp)</td>
                    <td><input type="number" name="tk_upah" class="form-control" value="{{ old('tk_upah', $progresKnmp->tk_upah ?? '') }}"></td>
                </tr>

                <tr>
                    <td class="text-center">3.</td>
                    <td>Lama bekerja di proyek (jumlah hari)</td>
                    <td><input type="number" name="tk_durasi" class="form-control" value="{{ old('tk_durasi', $progresKnmp->tk_durasi ?? '') }}"></td>
                </tr>

                <tr>
                    <td class="text-center">4.</td>
                    <td>Asal Tenaga Kerja:</td>
                    <td></td>
                </tr>

                <tr>
                    <td></td>
                    <td class="ps-4">a. Lokal</td>
                    <td><input type="number" name="tk_lokal" class="form-control" value="{{ old('tk_lokal', $progresKnmp->tk_lokal ?? '') }}"></td>
                </tr>

                <tr>
                    <td></td>
                    <td class="ps-4">b. Dari luar</td>
                    <td><input type="number" name="tk_luar" class="form-control" value="{{ old('tk_luar', $progresKnmp->tk_luar ?? '') }}"></td>
                </tr>

                <tr>
                    <td class="text-center">5.</td>
                    <td>Tenaga kerja non konstruksi</td>
                    <td>
                        <div class="input-group">
                            <input type="number" name="tk_non_konstruksi_jumlah" class="form-control"
                                value="{{ old('tk_non_konstruksi_jumlah', $progresKnmp->tk_non_konstruksi_jumlah ?? '') }}">
                            <input type="text" name="tk_non_konstruksi_ket" class="form-control w-50"
                                value="{{ old('tk_non_konstruksi_ket', $progresKnmp->tk_non_konstruksi_ket ?? '') }}" placeholder="Jenis pekerjaan">
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>

        {{-- BAGIAN 4: KENDALA --}}
        <div class="row">
            <div class="col-md-6 mb-4">
                <h5 class="mb-1">4. Kendala</h5>

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
                // Parse existing kendala from $progresKnmp
                $existingKendala = [];
                if (isset($progresKnmp) && $progresKnmp && $progresKnmp->kendala) {
                    $existingKendala = is_array($progresKnmp->kendala) ? $progresKnmp->kendala : json_decode($progresKnmp->kendala, true) ?? [];
                }
                $kendalaChecked = is_array(old('kendala')) ? old('kendala') : $existingKendala;
                @endphp

                @foreach ($kendalas as $k)
                <div class="form-check">
                    <input class="form-check-input"
                        type="checkbox"
                        name="kendala[]"
                        value="{{ $k }}"
                        id="k_{{ Str::slug($k) }}"
                        {{ in_array($k, $kendalaChecked) ? 'checked' : '' }}>
                    <label class="form-check-label" for="k_{{ Str::slug($k) }}">{{ $k }}</label>
                </div>
                @endforeach
            </div>

            {{-- BAGIAN 5: CCTV --}}
            <div class="col-md-6 mb-4">
                <h5 class="mb-1">5. CCTV</h5>

                <p>Apakah CCTV sudah terpasang?</p>

                @php
                $cctvValue = old('cctv', $progresKnmp->cctv ?? null);
                @endphp

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="cctv" id="cctv_ya" value="Ya"
                        {{ $cctvValue == 'Ya' ? 'checked' : '' }}>
                    <label class="form-check-label" for="cctv_ya">Ya</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="cctv" id="cctv_tidak" value="Tidak"
                        {{ $cctvValue == 'Tidak' ? 'checked' : '' }}>
                    <label class="form-check-label" for="cctv_tidak">Tidak</label>
                </div>

            </div>
        </div>

        <div class="d-flex justify-content-end mt-3 gap-2">
            @if($hasData)
                <button type="button" class="btn btn-secondary" id="btnCancelEditProgresKnmp">
                    <i class="mdi mdi-close me-1"></i>Batal
                </button>
                <button type="submit" class="btn btn-success text-white">
                    <i class="mdi mdi-content-save me-1"></i>Update
                </button>
            @else
                <button type="submit" class="btn btn-primary">Simpan</button>
            @endif
        </div>
    </form>
</div>

{{-- JavaScript for toggle View/Edit mode --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewMode = document.getElementById('progresKnmpViewMode');
    const editMode = document.getElementById('progresKnmpEditMode');
    const btnEdit = document.getElementById('btnEditProgresKnmp');
    const btnCancel = document.getElementById('btnCancelEditProgresKnmp');

    if (btnEdit) {
        btnEdit.addEventListener('click', function() {
            viewMode.classList.add('d-none');
            editMode.classList.remove('d-none');
        });
    }

    if (btnCancel) {
        btnCancel.addEventListener('click', function() {
            editMode.classList.add('d-none');
            viewMode.classList.remove('d-none');
        });
    }
});
</script>