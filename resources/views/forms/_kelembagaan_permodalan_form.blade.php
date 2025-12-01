<form method="POST" action="">
    @csrf

    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="table-light text-center align-middle">
                <tr>
                    <th style="width:40px">No</th>
                    <th>Jenis Aset</th>
                    <th>Sumber Permodalan untuk Operasional</th>
                    <th>Jika Pinjam di Lembaga Keuangan, Sebutkan Namanya</th>
                    <th style="width:220px">Rencana Permodalan Kopdeskel KNMP</th>
                </tr>
            </thead>
            <tbody>
                <!-- Section A -->
                <tr class="table-secondary"><td colspan="5"><strong>A. Usaha Perikanan</strong></td></tr>
                @php
                    $aItems = [
                        1 => 'Usaha Penangkapan Ikan (nelayan)',
                        2 => 'Pengolahan',
                        3 => 'Pemasar',
                        4 => 'Perikanan Budidaya',
                        5 => '...',
                        6 => '...'
                    ];
                @endphp
                @foreach($aItems as $i => $label)
                <tr>
                    <td class="text-center">A.{{ $i }}</td>
                    <td><input type="text" name="permodalan[A][{{ $i }}][jenis]" class="form-control" value="{{ $label }}"></td>
                    <td><input type="text" name="permodalan[A][{{ $i }}][sumber]" class="form-control" placeholder="Pribadi / Pinjam Koperasi / Bank / dll"></td>
                    <td><input type="text" name="permodalan[A][{{ $i }}][lembaga]" class="form-control" placeholder="Nama lembaga jika pinjam"></td>
                    <td>
                        <select name="permodalan[A][{{ $i }}][rencana]" class="form-select">
                            <option value="">- pilih -</option>
                            <option value="1">1 - Pribadi/Sendiri</option>
                            <option value="2">2 - Pinjam Koperasi</option>
                            <option value="3">3 - Pinjam Bank (formal)</option>
                            <option value="4">4 - Pinjam Saudara/Keluarga</option>
                            <option value="5">5 - Pinjam Juragan/Tauke/ tengkulak</option>
                        </select>
                    </td>
                </tr>
                @endforeach

                <!-- Section B -->
                <tr class="table-secondary"><td colspan="5"><strong>B. Sarana dan Prasarana Peningkatan Daya Saing</strong></td></tr>
                @php
                    $bItems = [
                        1 => 'Cold storage',
                        2 => 'ABF',
                        3 => 'Pabrik Es',
                        4 => 'Gudang Beku Portable',
                        5 => 'Kendaraan Berpendingin',
                        6 => 'Sentra Kuliner',
                        7 => '',8=>'',9=>''
                    ];
                @endphp
                @foreach($bItems as $i => $label)
                <tr>
                    <td class="text-center">B.{{ $i }}</td>
                    <td><input type="text" name="permodalan[B][{{ $i }}][jenis]" class="form-control" value="{{ $label }}"></td>
                    <td><input type="text" name="permodalan[B][{{ $i }}][sumber]" class="form-control" placeholder="Pribadi / Pinjam Koperasi / Bank / dll"></td>
                    <td><input type="text" name="permodalan[B][{{ $i }}][lembaga]" class="form-control" placeholder="Nama lembaga jika pinjam"></td>
                    <td>
                        <select name="permodalan[B][{{ $i }}][rencana]" class="form-select">
                            <option value="">- pilih -</option>
                            <option value="1">1 - Pribadi/Sendiri</option>
                            <option value="2">2 - Pinjam Koperasi</option>
                            <option value="3">3 - Pinjam Bank (formal)</option>
                            <option value="4">4 - Pinjam Saudara/Keluarga</option>
                            <option value="5">5 - Pinjam Juragan/Tauke/ tengkulak</option>
                        </select>
                    </td>
                </tr>
                @endforeach

                <!-- Section C -->
                <tr class="table-secondary"><td colspan="5"><strong>C. Sarana Pengelola dan Penunjang</strong></td></tr>
                @php
                    $cItems = [
                        1 => 'Dockyard',
                        2 => 'Tambat Labuh',
                        3 => 'Bengkel Nelayan',
                        4 => 'Balai Nelayan',
                        5 => 'SPBN',
                        6 => ''
                    ];
                @endphp
                @foreach($cItems as $i => $label)
                <tr>
                    <td class="text-center">C.{{ $i }}</td>
                    <td><input type="text" name="permodalan[C][{{ $i }}][jenis]" class="form-control" value="{{ $label }}"></td>
                    <td><input type="text" name="permodalan[C][{{ $i }}][sumber]" class="form-control" placeholder="Pribadi / Pinjam Koperasi / Bank / dll"></td>
                    <td><input type="text" name="permodalan[C][{{ $i }}][lembaga]" class="form-control" placeholder="Nama lembaga jika pinjam"></td>
                    <td>
                        <select name="permodalan[C][{{ $i }}][rencana]" class="form-select">
                            <option value="">- pilih -</option>
                            <option value="1">1 - Pribadi/Sendiri</option>
                            <option value="2">2 - Pinjam Koperasi</option>
                            <option value="3">3 - Pinjam Bank (formal)</option>
                            <option value="4">4 - Pinjam Saudara/Keluarga</option>
                            <option value="5">5 - Pinjam Juragan/Tauke/ tengkulak</option>
                        </select>
                    </td>
                </tr>
                @endforeach

                <!-- Section D -->
                <tr class="table-secondary"><td colspan="5"><strong>D. Usaha Non Perikanan</strong></td></tr>
                @php
                    $dItems = [
                        1 => 'Penyedia Jasa Foto',
                        2 => 'Penyedia Jasa Wisata',
                        3 => '...'
                    ];
                @endphp
                @foreach($dItems as $i => $label)
                <tr>
                    <td class="text-center">D.{{ $i }}</td>
                    <td><input type="text" name="permodalan[D][{{ $i }}][jenis]" class="form-control" value="{{ $label }}"></td>
                    <td><input type="text" name="permodalan[D][{{ $i }}][sumber]" class="form-control" placeholder="Pribadi / Pinjam Koperasi / Bank / dll"></td>
                    <td><input type="text" name="permodalan[D][{{ $i }}][lembaga]" class="form-control" placeholder="Nama lembaga jika pinjam"></td>
                    <td>
                        <select name="permodalan[D][{{ $i }}][rencana]" class="form-select">
                            <option value="">- pilih -</option>
                            <option value="1">1 - Pribadi/Sendiri</option>
                            <option value="2">2 - Pinjam Koperasi</option>
                            <option value="3">3 - Pinjam Bank (formal)</option>
                            <option value="4">4 - Pinjam Saudara/Keluarga</option>
                            <option value="5">5 - Pinjam Juragan/Tauke/ tengkulak</option>
                        </select>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <a href="/forms" class="btn btn-secondary me-2">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>

</form>
