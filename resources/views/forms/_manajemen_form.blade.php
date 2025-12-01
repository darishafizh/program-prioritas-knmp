<form method="POST" action="">
    @csrf

    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="table-light text-center align-middle">
                <tr>
                    <th style="width:140px">DIMENSI</th>
                    <th style="width:200px">INDIKATOR</th>
                    <th style="width:220px">VARIABEL</th>
                    <th style="width:220px">PARAMETER</th>
                    <th style="width:300px">PERTANYAAN</th>
                    <th>JAWABAN</th>
                    <th style="width:200px">TARGET RESPONDEN</th>
                </tr>
            </thead>
            <tbody>
                <!-- MANAJEMEN: indicator 1 (5 questions) + indicator 2 (6 questions) -->
                <tr>
                    <td rowspan="11" class="align-middle text-center">MANAJEMEN</td>
                    <td rowspan="5" class="align-middle">1. Keragaan Manajemen</td>
                    <td class="align-middle">Kemitraan; Kemandirian; Capaian Target Bisnis/PNBP</td>
                    <td class="align-middle">Jumlah dan Jenis kemitraan; Sumber Pembiayaan; Target Profit/PNBP</td>
                    <td>1. Jumlah dan siapa mitra dalam pengelolaan aset (pemilik-pengelola)</td>
                    <td><textarea name="manajemen[1][q1]" class="form-control" rows="2"></textarea></td>
                    <td><input type="text" name="manajemen[1][target1]" class="form-control" placeholder="Pengelola aset (mis. Koperasi, Dinas)"></td>
                </tr>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td>2. Berapa jumlah dan siapa mitra dalam pemanfaatan aset (Pengelola-Pengguna)?</td>
                    <td><textarea name="manajemen[1][q2]" class="form-control" rows="2"></textarea></td>
                    <td><input type="text" name="manajemen[1][target2]" class="form-control"></td>
                </tr>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td>3. Berapa jumlah, besaran dan siapa mitra dalam pembiayaan (pengelola dan mitra pembiayaan)?</td>
                    <td><textarea name="manajemen[1][q3]" class="form-control" rows="2"></textarea></td>
                    <td><input type="text" name="manajemen[1][target3]" class="form-control"></td>
                </tr>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td>4. Berapa Target Profit yang ditetapkan (Rp/Thn) dan realisasinya (Rp/Thn)?</td>
                    <td><textarea name="manajemen[1][q4]" class="form-control" rows="2"></textarea></td>
                    <td><input type="text" name="manajemen[1][target4]" class="form-control" placeholder="Rp/Thn"></td>
                </tr>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td>5. Berapa Target PNBP yang ditetapkan (Rp/Thn) dan realisasinya (Rp/Thn)?</td>
                    <td><textarea name="manajemen[1][q5]" class="form-control" rows="2"></textarea></td>
                    <td><input type="text" name="manajemen[1][target5]" class="form-control" placeholder="Rp/Thn"></td>
                </tr>

                <tr>
                    <td rowspan="6" class="align-middle">2. Efektivitas Pengelolaan Aset</td>
                    <td class="align-middle">Kecukupan anggaran pengelolaan; Ketersediaan Dokumen; SOP; Ketersediaan SDM</td>
                    <td class="align-middle">Rasio Anggaran; Ketersediaan Dokumen Perizinan; Rasio SDM/Kebutuhan SDM</td>
                    <td>1. Berapa kebutuhan dan ketersediaan anggaran operasional?</td>
                    <td><textarea name="manajemen[2][q1]" class="form-control" rows="2"></textarea></td>
                    <td><input type="text" name="manajemen[2][target1]" class="form-control"></td>
                </tr>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td>2. Berapa kebutuhan (kewajiban) dokumen yang harus dipenuhi dalam rangka operasionalisasi Aset?</td>
                    <td><textarea name="manajemen[2][q2]" class="form-control" rows="2"></textarea></td>
                    <td><input type="text" name="manajemen[2][target2]" class="form-control"></td>
                </tr>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td>3. Berapa jumlah dokumen yang sudah terpenuhi dalam rangka operasionalisasi Aset?</td>
                    <td><textarea name="manajemen[2][q3]" class="form-control" rows="2"></textarea></td>
                    <td><input type="text" name="manajemen[2][target3]" class="form-control"></td>
                </tr>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td>4. Ketersediaan dokumen pengembangan Bisnis?</td>
                    <td><textarea name="manajemen[2][q4]" class="form-control" rows="2"></textarea></td>
                    <td><input type="text" name="manajemen[2][target4]" class="form-control"></td>
                </tr>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td>5. Ketersediaan Dokumen SOP bisnis ?</td>
                    <td><textarea name="manajemen[2][q5]" class="form-control" rows="2"></textarea></td>
                    <td><input type="text" name="manajemen[2][target5]" class="form-control"></td>
                </tr>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td>6. Berapa kebutuhan dan ketersediaan SDM?</td>
                    <td><textarea name="manajemen[2][q6]" class="form-control" rows="2"></textarea></td>
                    <td><input type="text" name="manajemen[2][target6]" class="form-control"></td>
                </tr>

            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <a href="/forms" class="btn btn-secondary me-2">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
