<form method="POST" action="">
    @csrf

        <div class="mb-2 d-flex align-items-center">
            <button type="button" id="btn-add-aset" class="btn btn-sm btn-primary">Tambah Aset</button>
            <div id="add-aset-chooser" class="btn-group ms-2 d-none" role="group" aria-label="Pilih jenis aset">
                <button type="button" class="btn btn-sm btn-outline-primary choose-aset" data-section="A">Tambah A. Sarana dan Prasarana Produksi</button>
                <button type="button" class="btn btn-sm btn-outline-primary choose-aset" data-section="B">Tambah B. Sarana dan Prasarana Peningkatan Daya Saing</button>
                <button type="button" class="btn btn-sm btn-outline-primary choose-aset" data-section="C">Tambah C. Sarana Pengelola dan Penunjang</button>
            </div>
        </div>
        <div class="table-responsive">
                <table class="table table-bordered table-sm" id="penambahan-aset-table">
                <thead class="table-light text-center align-middle">
                    <tr>
                        <th style="width:40px">No</th>
                        <th>Jenis Aset</th>
                        <th>Sumber Pengadaan</th>
                        <th>Ukuran / Kapasitas</th>
                        <th style="width:90px">Jumlah</th>
                        <th style="width:140px">Status</th>
                        <th style="width:120px">Bantuan KNMP</th>
                        <th style="width:120px">Total</th>
                            <th style="width:140px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Section A -->
                    <tr class="table-secondary"><td colspan="9"><strong>A. Sarana dan Prasarana Produksi</strong></td></tr>
                    @php
                            // keep only predefined items; empty rows will be added dynamically by user
                            $asetA = [
                                1 => 'Kapal perikanan',
                                2 => 'Mesin',
                                3 => 'Alat Tangkap',
                            ];
                    @endphp
                    @foreach($asetA as $idx => $label)
                        <tr data-section="A" data-index="{{ $idx }}">
                        <td class="text-center align-middle">A.{{ $idx }}</td>
                        <td>
                            <input type="text" name="aset[A][{{ $idx }}][jenis]" class="form-control" value="{{ $label }}" placeholder="Jenis aset">
                        </td>
                        <td>
                            <input type="text" name="aset[A][{{ $idx }}][sumber]" class="form-control" placeholder="APBN/DAK/APBD atau sebutkan">
                        </td>
                        <td>
                            <input type="text" name="aset[A][{{ $idx }}][ukuran]" class="form-control" placeholder="GT/PK/Meter/Ton/...">
                        </td>
                        <td>
                            <input type="number" min="0" name="aset[A][{{ $idx }}][jumlah]" class="form-control">
                        </td>
                        <td>
                            <select name="aset[A][{{ $idx }}][status]" class="form-select">
                                <option value="">- pilih -</option>
                                <option value="1">1 - Mangkrak</option>
                                <option value="2">2 - Rusak</option>
                                <option value="3">3 - Baik</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="aset[A][{{ $idx }}][bantuan]" value="1" id="a{{ $idx }}_bantuan">
                                <label class="form-check-label" for="a{{ $idx }}_bantuan">YA</label>
                            </div>
                        </td>
                        <td>
                            <input type="number" min="0" name="aset[A][{{ $idx }}][total]" class="form-control">
                        </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-primary btn-edit" title="Edit" aria-label="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.193 9.193a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168L12.146.854zM11.207 2L3 10.207V13h2.793L14 4.793 11.207 2z"/>
                                    </svg>
                                </button>
                                <button type="button" class="btn btn-sm btn-success btn-save d-none" title="Save" aria-label="Save">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M13.485 1.929a.75.75 0 0 1 0 1.06L6.53 9.943a.75.75 0 0 1-1.06 0L2.515 6.99a.75.75 0 1 1 1.06-1.06L5 8.354l7.425-7.425a.75.75 0 0 1 1.06 0z"/>
                                    </svg>
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary btn-cancel d-none" title="Cancel" aria-label="Cancel">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger btn-delete ms-1" title="Delete" aria-label="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 1 1 0-2h3.086a1 1 0 0 1 .707.293l.707.707h2.414l.707-.707A1 1 0 0 1 11.414 1H14.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118z"/>
                                    </svg>
                                </button>
                            </td>
                    </tr>
                    @endforeach

                    <!-- Section B -->
                    <tr class="table-secondary"><td colspan="9"><strong>B. Sarana dan Prasarana Peningkatan Daya Saing</strong></td></tr>
                    @php
                        $asetB = [
                            1 => 'Cold storage',
                            2 => 'ABF',
                            3 => 'Pabrik Es',
                            4 => 'Gudang Beku Portable',
                            5 => 'Kendaraan Berpendingin',
                            6 => 'Sentra Kuliner',
                        ];
                    @endphp
                    @foreach($asetB as $idx => $label)
                    <tr data-section="B" data-index="{{ $idx }}">
                        <td class="text-center align-middle">B.{{ $idx }}</td>
                        <td>
                            <input type="text" name="aset[B][{{ $idx }}][jenis]" class="form-control" value="{{ $label }}" placeholder="Jenis aset" readonly data-original-value="{{ $label }}">
                        </td>
                        <td>
                            <input type="text" name="aset[B][{{ $idx }}][sumber]" class="form-control" placeholder="APBN/DAK/APBD atau sebutkan" readonly data-original-value="">
                        </td>
                        <td>
                            <input type="text" name="aset[B][{{ $idx }}][ukuran]" class="form-control" placeholder="GT/PK/Meter/Ton/..." readonly data-original-value="">
                        </td>
                        <td>
                            <input type="number" min="0" name="aset[B][{{ $idx }}][jumlah]" class="form-control" readonly data-original-value="">
                        </td>
                        <td>
                            <select name="aset[B][{{ $idx }}][status]" class="form-select" disabled data-original-value="">
                                <option value="">- pilih -</option>
                                <option value="1">1 - Mangkrak</option>
                                <option value="2">2 - Rusak</option>
                                <option value="3">3 - Baik</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="aset[B][{{ $idx }}][bantuan]" value="1" id="b{{ $idx }}_bantuan" disabled data-original-value="0">
                                <label class="form-check-label" for="b{{ $idx }}_bantuan">YA</label>
                            </div>
                        </td>
                        <td>
                            <input type="number" min="0" name="aset[B][{{ $idx }}][total]" class="form-control" readonly data-original-value="">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-primary btn-edit" title="Edit" aria-label="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.193 9.193a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168L12.146.854zM11.207 2L3 10.207V13h2.793L14 4.793 11.207 2z"/>
                                </svg>
                            </button>
                            <button type="button" class="btn btn-sm btn-success btn-save d-none" title="Save" aria-label="Save">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M13.485 1.929a.75.75 0 0 1 0 1.06L6.53 9.943a.75.75 0 0 1-1.06 0L2.515 6.99a.75.75 0 1 1 1.06-1.06L5 8.354l7.425-7.425a.75.75 0 0 1 1.06 0z"/>
                                </svg>
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary btn-cancel d-none" title="Cancel" aria-label="Cancel">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger btn-delete ms-1" title="Delete" aria-label="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 1 1 0-2h3.086a1 1 0 0 1 .707.293l.707.707h2.414l.707-.707A1 1 0 0 1 11.414 1H14.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach

                    <!-- Section C -->
                    <tr class="table-secondary"><td colspan="9"><strong>C. Sarana Pengelola dan Penunjang</strong></td></tr>
                    @php
                        $asetC = [
                            1 => 'Dockyard',
                            2 => 'Tambat Labuh',
                            3 => 'Bengkel Nelayan',
                            4 => 'Balai Nelayan',
                            5 => 'SPBN',
                        ];
                    @endphp
                    @foreach($asetC as $idx => $label)
                    <tr data-section="C" data-index="{{ $idx }}">
                        <td class="text-center align-middle">C.{{ $idx }}</td>
                        <td>
                            <input type="text" name="aset[C][{{ $idx }}][jenis]" class="form-control" value="{{ $label }}" placeholder="Jenis aset" readonly data-original-value="{{ $label }}">
                        </td>
                        <td>
                            <input type="text" name="aset[C][{{ $idx }}][sumber]" class="form-control" placeholder="APBN/DAK/APBD atau sebutkan" readonly data-original-value="">
                        </td>
                        <td>
                            <input type="text" name="aset[C][{{ $idx }}][ukuran]" class="form-control" placeholder="GT/PK/Meter/Ton/..." readonly data-original-value="">
                        </td>
                        <td>
                            <input type="number" min="0" name="aset[C][{{ $idx }}][jumlah]" class="form-control" readonly data-original-value="">
                        </td>
                        <td>
                            <select name="aset[C][{{ $idx }}][status]" class="form-select" disabled data-original-value="">
                                <option value="">- pilih -</option>
                                <option value="1">1 - Mangkrak</option>
                                <option value="2">2 - Rusak</option>
                                <option value="3">3 - Baik</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="aset[C][{{ $idx }}][bantuan]" value="1" id="c{{ $idx }}_bantuan" disabled data-original-value="0">
                                <label class="form-check-label" for="c{{ $idx }}_bantuan">YA</label>
                            </div>
                        </td>
                        <td>
                            <input type="number" min="0" name="aset[C][{{ $idx }}][total]" class="form-control" readonly data-original-value="">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-primary btn-edit" title="Edit" aria-label="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.193 9.193a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168L12.146.854zM11.207 2L3 10.207V13h2.793L14 4.793 11.207 2z"/>
                                </svg>
                            </button>
                            <button type="button" class="btn btn-sm btn-success btn-save d-none" title="Save" aria-label="Save">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M13.485 1.929a.75.75 0 0 1 0 1.06L6.53 9.943a.75.75 0 0 1-1.06 0L2.515 6.99a.75.75 0 1 1 1.06-1.06L5 8.354l7.425-7.425a.75.75 0 0 1 1.06 0z"/>
                                </svg>
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary btn-cancel d-none" title="Cancel" aria-label="Cancel">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger btn-delete ms-1" title="Delete" aria-label="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 1 1 0-2h3.086a1 1 0 0 1 .707.293l.707.707h2.414l.707-.707A1 1 0 0 1 11.414 1H14.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
                
                <template id="penambahan-aset-row-template">
                    <tr data-section="__SECTION__" data-index="__INDEX__">
                        <td class="text-center align-middle">__SECTION__.__INDEX__</td>
                        <td>
                            <input type="text" name="aset[__SECTION__][__INDEX__][jenis]" class="form-control" value="" placeholder="Jenis aset">
                        </td>
                        <td>
                            <input type="text" name="aset[__SECTION__][__INDEX__][sumber]" class="form-control" placeholder="APBN/DAK/APBD atau sebutkan">
                        </td>
                        <td>
                            <input type="text" name="aset[__SECTION__][__INDEX__][ukuran]" class="form-control" placeholder="GT/PK/Meter/Ton/...">
                        </td>
                        <td>
                            <input type="number" min="0" name="aset[__SECTION__][__INDEX__][jumlah]" class="form-control">
                        </td>
                        <td>
                            <select name="aset[__SECTION__][__INDEX__][status]" class="form-select">
                                <option value="">- pilih -</option>
                                <option value="1">1 - Mangkrak</option>
                                <option value="2">2 - Rusak</option>
                                <option value="3">3 - Baik</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="aset[__SECTION__][__INDEX__][bantuan]" value="1">
                                <label class="form-check-label">YA</label>
                            </div>
                        </td>
                        <td>
                            <input type="number" min="0" name="aset[__SECTION__][__INDEX__][total]" class="form-control">
                        </td>
                            <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-primary btn-edit d-none">Edit</button>
                            <button type="button" class="btn btn-sm btn-success btn-save">Save</button>
                            <button type="button" class="btn btn-sm btn-secondary btn-cancel">Cancel</button>
                            <button type="button" class="btn btn-sm btn-danger btn-delete ms-1">Delete</button>
                        </td>
                    </tr>
                </template>

                <script>
                (function(){
                    const table = document.getElementById('penambahan-aset-table');
                    const addBtn = document.getElementById('btn-add-aset');
                    const template = document.getElementById('penambahan-aset-row-template').innerHTML;
                    let newCounter = 1;

                    function toggleEditMode(row, editing){
                        const inputs = row.querySelectorAll('input, select');
                        inputs.forEach(input => {
                            if(editing){
                                input.removeAttribute('readonly');
                                input.removeAttribute('disabled');
                            } else {
                                if(input.type === 'checkbox'){
                                    input.disabled = true;
                                } else {
                                    input.setAttribute('readonly','');
                                }
                            }
                        });
                        row.querySelectorAll('.btn-edit,.btn-save,.btn-cancel').forEach(btn => {
                            if(btn.classList.contains('btn-edit')) btn.classList.toggle('d-none', editing);
                            if(btn.classList.contains('btn-save')) btn.classList.toggle('d-none', !editing);
                            if(btn.classList.contains('btn-cancel')) btn.classList.toggle('d-none', !editing);
                        });
                    }

                    function saveOriginalValues(row){
                        row.querySelectorAll('input, select').forEach(input => {
                            if(input.type === 'checkbox'){
                                input.dataset.originalValue = input.checked ? '1' : '0';
                            } else {
                                input.dataset.originalValue = input.value || '';
                            }
                        });
                    }

                    function restoreOriginalValues(row){
                        row.querySelectorAll('input, select').forEach(input => {
                            const val = input.dataset.originalValue || '';
                            if(input.type === 'checkbox'){
                                input.checked = val === '1';
                            } else {
                                input.value = val;
                            }
                        });
                    }

                    // Initialize existing rows: set checkboxes disabled and save originals
                    table.querySelectorAll('tbody tr').forEach(tr => {
                        saveOriginalValues(tr);
                        toggleEditMode(tr, false);
                    });

                    // Delegated click handler for edit/save/cancel/delete
                    table.addEventListener('click', function(e){
                        const el = e.target;
                        const tr = el.closest('tr');
                        if(!tr) return;
                        if(el.classList.contains('btn-edit')){
                            toggleEditMode(tr, true);
                        } else if(el.classList.contains('btn-save')){
                            // after save, store originals and switch to readonly
                            saveOriginalValues(tr);
                            toggleEditMode(tr, false);
                        } else if(el.classList.contains('btn-cancel')){
                            // restore previous values
                            restoreOriginalValues(tr);
                            toggleEditMode(tr, false);
                        } else if(el.classList.contains('btn-delete')){
                            const section = tr.dataset.section;
                            if(!confirm('Hapus baris ini?')) return;
                            tr.remove();
                            // reindex remaining rows in the section
                            reindexSection(section);
                        }
                    });

                    function reindexSection(section){
                        const rows = Array.from(table.querySelectorAll(`tr[data-section="${section}"]`));
                        rows.forEach((r, i) => {
                            const newIndex = i + 1;
                            r.dataset.index = newIndex;
                            // update first cell
                            const firstCell = r.querySelector('td');
                            if(firstCell) firstCell.textContent = `${section}.${newIndex}`;
                            // update names of inputs/selects
                            r.querySelectorAll('input, select').forEach(input => {
                                const name = input.name || '';
                                const m = name.match(/^aset\[(.*?)\]\[(.*?)\]\[(.*?)\]$/);
                                if(m){
                                    const field = m[3];
                                    input.name = `aset[${section}][${newIndex}][${field}]`;
                                }
                                // update checkbox id and label for attribute if present
                                if(input.type === 'checkbox'){
                                    const id = `${section}${newIndex}_bantuan`;
                                    input.id = id;
                                    const lbl = r.querySelector('label.form-check-label');
                                    if(lbl) lbl.htmlFor = id;
                                }
                            });
                        });
                    }

                    const chooser = document.getElementById('add-aset-chooser');

                    function addRowForSection(section){
                        // Determine numeric index for the new row within the section
                        const existingRows = table.querySelectorAll(`tr[data-section="${section}"]`);
                        const idxNum = existingRows.length + 1;
                        const idx = idxNum;

                        let html = template.replace(/__SECTION__/g, section).replace(/__INDEX__/g, idx);
                        const tmp = document.createElement('tbody');
                        tmp.innerHTML = html;
                        const newRow = tmp.querySelector('tr');

                        // Insert the new row after the last row in the section, or after the section header if none
                        const sectionRows = table.querySelectorAll(`tr[data-section="${section}"]`);
                        if(sectionRows.length){
                            const last = sectionRows[sectionRows.length - 1];
                            last.after(newRow);
                        } else {
                            // find header by order (A=0,B=1,C=2) fallback to appending
                            const headerIndexMap = { A:0, B:1, C:2 };
                            const headers = table.querySelectorAll('tr.table-secondary');
                            const header = headers[headerIndexMap[section]] || headers[headers.length - 1] || null;
                            if(header) header.after(newRow); else table.querySelector('tbody').appendChild(newRow);
                        }

                        // Newly added rows should be in editing mode
                        newRow.querySelectorAll('input, select').forEach(i=>{
                            i.removeAttribute('readonly');
                            i.removeAttribute('disabled');
                        });
                        // show save/cancel, hide edit
                        newRow.querySelectorAll('.btn-edit,.btn-save,.btn-cancel').forEach(btn=>{
                            if(btn.classList.contains('btn-edit')) btn.classList.add('d-none');
                            if(btn.classList.contains('btn-save')) btn.classList.remove('d-none');
                            if(btn.classList.contains('btn-cancel')) btn.classList.remove('d-none');
                        });
                        // update displayed number cell (No column)
                        const noCell = newRow.querySelector('td');
                        if(noCell) noCell.textContent = `${section}.${idx}`;
                        // focus first input
                        const firstInput = newRow.querySelector('input, select');
                        if(firstInput) firstInput.focus();
                    }

                    // toggle chooser on add button
                    addBtn.addEventListener('click', function(){
                        chooser.classList.toggle('d-none');
                    });

                    // handle chooser selection
                    chooser.querySelectorAll('.choose-aset').forEach(btn => {
                        btn.addEventListener('click', function(){
                            const section = this.dataset.section || 'X';
                            addRowForSection(section);
                            // hide chooser after selection
                            chooser.classList.add('d-none');
                        });
                    });
                })();
                </script>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <a href="/forms" class="btn btn-secondary me-2">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>

    </form>
