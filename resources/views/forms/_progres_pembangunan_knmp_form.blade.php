<form method="POST" action="">
    @csrf

    {{-- Bagian 1: Detail Rencana Pembangunan KNMP --}}
    <div class="mb-2 d-flex align-items-center">
        <button type="button" id="btn-add-komponen" class="btn btn-sm btn-primary">Tambah Komponen</button>
        <div id="add-komponen-chooser" class="btn-group ms-2 d-none" role="group" aria-label="Pilih jenis komponen">
            <button type="button" class="btn btn-sm btn-outline-primary choose-komponen" data-section="A">Konstruksi</button>
            <button type="button" class="btn btn-sm btn-outline-primary choose-komponen" data-section="B">Bantuan Kapal, Mesin, API</button>
            <button type="button" class="btn btn-sm btn-outline-primary choose-komponen" data-section="C">Bantuan Sarana Rantai Dingin</button>
            <button type="button" class="btn btn-sm btn-outline-primary choose-komponen" data-section="D">SPBU Nelayan</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-sm" id="progres-knmp-table">
            <thead class="table-light text-center align-middle">
                <tr>
                    <th style="width:40px">No</th>
                    <th>Jenis Komponen</th>
                    <th>Target (unit)</th>
                    <th>Realisasi (unit)</th>
                    <th>% Realisasi</th>
                    <th>Anggaran (Rp)</th>
                    <th>Realisasi Anggaran (Rp)</th>
                    <th>% Realisasi Anggaran</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                $sections = [
                'A' => [
                'Konstruksi' => [
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
                'Bantuan Kapal, Mesin dan API' => [
                'Kapal penangkap ikan',
                'Mesin kapal perikanan',
                'Alat Penangkap Ikan',
                ],
                ],
                'C' => [
                'Bantuan Sarana Rantai Dingin' => [
                'Cold Storage',
                'Pabrik Es Balok',
                'Pabrik Es Slurry',
                'Kendaraan Berpendingin',
                'Cool Box',
                ],
                ],
                'D' => [
                'SPBU Nelayan' => []
                ],
                ];
                @endphp

                @foreach($sections as $sectionCode => $sectionData)
                @foreach($sectionData as $judul => $items)
                <tr class="table-secondary">
                    <td>{{ $sectionCode }}</td>
                    <td colspan="8">{{ $judul }}</td>
                </tr>
                @if(!empty($items))
                @foreach($items as $idx => $item)
                <tr data-section="{{ $sectionCode }}" data-index="{{ $idx + 1 }}">
                    <td class="text-center">{{ $sectionCode }}.{{ $idx + 1 }}</td>
                    <td><input type="text" name="komponen[{{ $sectionCode }}][{{ $idx + 1 }}][nama]" class="form-control" value="{{ $item }}" readonly></td>
                    <td><input type="number" name="komponen[{{ $sectionCode }}][{{ $idx + 1 }}][target]" class="form-control"></td>
                    <td><input type="number" name="komponen[{{ $sectionCode }}][{{ $idx + 1 }}][realisasi]" class="form-control"></td>
                    <td><input type="number" name="komponen[{{ $sectionCode }}][{{ $idx + 1 }}][persen]" class="form-control" readonly></td>
                    <td><input type="number" name="komponen[{{ $sectionCode }}][{{ $idx + 1 }}][anggaran]" class="form-control"></td>
                    <td><input type="number" name="komponen[{{ $sectionCode }}][{{ $idx + 1 }}][realisasi_anggaran]" class="form-control"></td>
                    <td><input type="number" name="komponen[{{ $sectionCode }}][{{ $idx + 1 }}][persen_anggaran]" class="form-control" readonly></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-primary btn-edit">Edit</button>
                        <button type="button" class="btn btn-sm btn-success btn-save d-none">Save</button>
                        <button type="button" class="btn btn-sm btn-secondary btn-cancel d-none">Cancel</button>
                        <button type="button" class="btn btn-sm btn-danger btn-delete ms-1">Delete</button>
                    </td>
                </tr>
                @endforeach
                @else
                <tr data-section="{{ $sectionCode }}" data-index="1">
                    <td class="text-center">{{ $sectionCode }}.1</td>
                    <td><input type="text" name="komponen[{{ $sectionCode }}][1][nama]" class="form-control" value="-" readonly></td>
                    <td><input type="number" name="komponen[{{ $sectionCode }}][1][target]" class="form-control"></td>
                    <td><input type="number" name="komponen[{{ $sectionCode }}][1][realisasi]" class="form-control"></td>
                    <td><input type="number" name="komponen[{{ $sectionCode }}][1][persen]" class="form-control" readonly></td>
                    <td><input type="number" name="komponen[{{ $sectionCode }}][1][anggaran]" class="form-control"></td>
                    <td><input type="number" name="komponen[{{ $sectionCode }}][1][realisasi_anggaran]" class="form-control"></td>
                    <td><input type="number" name="komponen[{{ $sectionCode }}][1][persen_anggaran]" class="form-control" readonly></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-primary btn-edit">Edit</button>
                        <button type="button" class="btn btn-sm btn-success btn-save d-none">Save</button>
                        <button type="button" class="btn btn-sm btn-secondary btn-cancel d-none">Cancel</button>
                        <button type="button" class="btn btn-sm btn-danger btn-delete ms-1">Delete</button>
                    </td>
                </tr>
                @endif
                @endforeach
                @endforeach
            </tbody>
        </table>

        <template id="progres-knmp-row-template">
            <tr data-section="__SECTION__" data-index="__INDEX__">
                <td class="text-center">__SECTION__.__INDEX__</td>
                <td><input type="text" name="komponen[__SECTION__][__INDEX__][nama]" class="form-control"></td>
                <td><input type="number" name="komponen[__SECTION__][__INDEX__][target]" class="form-control"></td>
                <td><input type="number" name="komponen[__SECTION__][__INDEX__][realisasi]" class="form-control"></td>
                <td><input type="number" name="komponen[__SECTION__][__INDEX__][persen]" class="form-control" readonly></td>
                <td><input type="number" name="komponen[__SECTION__][__INDEX__][anggaran]" class="form-control"></td>
                <td><input type="number" name="komponen[__SECTION__][__INDEX__][realisasi_anggaran]" class="form-control"></td>
                <td><input type="number" name="komponen[__SECTION__][__INDEX__][persen_anggaran]" class="form-control" readonly></td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit">Edit</button>
                    <button type="button" class="btn btn-sm btn-success btn-save">Save</button>
                    <button type="button" class="btn btn-sm btn-secondary btn-cancel">Cancel</button>
                    <button type="button" class="btn btn-sm btn-danger btn-delete ms-1">Delete</button>
                </td>
            </tr>
        </template>
    </div>

    {{-- Bagian 2: Kendala --}}
    <div class="mt-3">
        <label><strong>Kendala dalam proses pembangunan KNMP:</strong></label>
        @php
        $kendalaOptions = [
        'Faktor cuaca','Ketersediaan material bahan bangunan','Akses ke lokasi (jalan kurang memadai)',
        'Ketersediaan Listrik','Ketersediaan BBM','Ketersediaan air bersih','Jaringan Internet'
        ];
        @endphp
        @foreach($kendalaOptions as $idx => $k)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="kendala[]" value="{{ $k }}" id="kendala{{ $idx }}">
            <label class="form-check-label" for="kendala{{ $idx }}">{{ $k }}</label>
        </div>
        @endforeach
    </div>

    {{-- Bagian 3: CCTV --}}
    <div class="mt-3">
        <label><strong>Apakah sudah CCTV terpasang?</strong></label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="cctv" value="Ya" id="cctv1">
            <label class="form-check-label" for="cctv1">Ya</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="cctv" value="Tidak" id="cctv2">
            <label class="form-check-label" for="cctv2">Tidak</label>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <a href="/forms" class="btn btn-secondary me-2">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>

</form>

<script>
    (function() {
        const table = document.getElementById('progres-knmp-table');
        const addBtn = document.getElementById('btn-add-komponen');
        const chooser = document.getElementById('add-komponen-chooser');
        const template = document.getElementById('progres-knmp-row-template').innerHTML;

        function toggleEditMode(row, editing) {
            row.querySelectorAll('input').forEach(i => i.readOnly = !editing);
            row.querySelectorAll('.btn-edit,.btn-save,.btn-cancel').forEach(btn => {
                if (btn.classList.contains('btn-edit')) btn.classList.toggle('d-none', editing);
                if (btn.classList.contains('btn-save')) btn.classList.toggle('d-none', !editing);
                if (btn.classList.contains('btn-cancel')) btn.classList.toggle('d-none', !editing);
            });
        }

        table.querySelectorAll('tr[data-section]').forEach(tr => toggleEditMode(tr, false));

        table.addEventListener('click', e => {
            const tr = e.target.closest('tr');
            if (!tr) return;
            if (e.target.classList.contains('btn-edit')) toggleEditMode(tr, true);
            if (e.target.classList.contains('btn-save')) toggleEditMode(tr, false);
            if (e.target.classList.contains('btn-cancel')) toggleEditMode(tr, false);
            if (e.target.classList.contains('btn-delete')) tr.remove();
        });

        addBtn.addEventListener('click', () => chooser.classList.toggle('d-none'));
        chooser.querySelectorAll('.choose-komponen').forEach(btn => {
            btn.addEventListener('click', () => {
                const section = btn.dataset.section;
                const idx = table.querySelectorAll(`tr[data-section="${section}"]`).length + 1;
                const tmp = document.createElement('tbody');
                tmp.innerHTML = template.replace(/__SECTION__/g, section).replace(/__INDEX__/g, idx);
                table.querySelector('tbody').appendChild(tmp.querySelector('tr'));
                toggleEditMode(table.querySelector(`tr[data-section="${section}"]:last-child`), true);
                chooser.classList.add('d-none');
            });
        });
    })();
</script>