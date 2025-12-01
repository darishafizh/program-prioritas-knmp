<form method="POST" action="">
    @csrf

    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="table-light text-center align-middle">
                <tr>
                    <th style="width:180px">INDIKATOR</th>
                    <th style="width:180px">VARIABEL</th>
                    <th style="width:220px">PARAMETER</th>
                    <th>JAWABAN</th>
                    <th style="width:200px">TARGET RESPONDEN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="2">Produktivitas</td>
                    <td>Produktivitas Usaha</td>
                    <td>Produksi Perikanan</td>
                    <td>
                        <div class="input-group">
                            <input type="number" step="any" name="kesejahteraan[produktivitas][produksi]" class="form-control" placeholder="… Ton/hari">
                            <span class="input-group-text">Ton/hari</span>
                        </div>
                    </td>
                    <td rowspan="2">
                        <input type="text" name="kesejahteraan[produktivitas][target_responden]" class="form-control" placeholder="Pelaku utama (nelayan, pembudidaya, ...)">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>Jumlah Armada</td>
                    <td>
                        <input type="number" name="kesejahteraan[produktivitas][jumlah_armada]" class="form-control" placeholder="… unit">
                    </td>
                </tr>

                <tr>
                    <td rowspan="1">Pendapatan</td>
                    <td>Pendapatan Perikanan & Non Perikanan</td>
                    <td>Pendapatan Rumah Tangga</td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" step="any" name="kesejahteraan[pendapatan][rumah_tangga]" class="form-control" placeholder="…/bulan">
                        </div>
                    </td>
                    <td>
                        <input type="text" name="kesejahteraan[pendapatan][target_responden]" class="form-control" placeholder="Pelaku utama">
                    </td>
                </tr>

                <tr>
                    <td rowspan="1">Serapan Tenaga Kerja</td>
                    <td>Jumlah Tenaga Kerja</td>
                    <td>Penyerapan tenaga kerja</td>
                    <td>
                        <input type="number" name="kesejahteraan[tenaga][penyerapan]" class="form-control" placeholder="… orang">
                    </td>
                    <td>
                        <input type="text" name="kesejahteraan[tenaga][target_responden]" class="form-control" placeholder="Pelaku utama">
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <a href="/forms" class="btn btn-secondary me-2">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
