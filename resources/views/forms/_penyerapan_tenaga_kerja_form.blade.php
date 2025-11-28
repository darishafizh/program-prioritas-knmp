<form method="POST" action="">
    @csrf

    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <label class="form-label">Target Total Tenaga Kerja di lokasi</label>
                <input type="number" name="tenaga[target_total]" class="form-control" placeholder="Jumlah target total">
            </div>

            <div class="mb-3">
                <label class="form-label">Realisasi Tenaga Kerja Konstruksi (saat ini)</label>
                <input type="number" name="tenaga[realisasi_konstruksi_saat_ini]" class="form-control" placeholder="Realisasi saat ini">
            </div>

            <div class="mb-3">
                <label class="form-label">Realisasi Tenaga Kerja Konstruksi (kumulatif)</label>
                <input type="number" name="tenaga[realisasi_konstruksi_kumulatif]" class="form-control" placeholder="Realisasi kumulatif">
            </div>

            <hr />
            <h6>Target Tenaga Kerja Nelayan</h6>
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="form-label">Bantuan kapal</label>
                    <input type="number" name="tenaga[nelayan][bantuan_kapal]" class="form-control" placeholder="Jumlah">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nelayan eksisting</label>
                    <input type="number" name="tenaga[nelayan][eksisting]" class="form-control" placeholder="Jumlah">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tenaga Kerja baru</label>
                    <input type="number" name="tenaga[nelayan][baru]" class="form-control" placeholder="Jumlah">
                </div>
            </div>

            <hr />
            <h6>Target Tenaga Kerja Operasional</h6>
            <div class="row g-2">
                <div class="col-md-6">
                    <label class="form-label">Cold Storage</label>
                    <input type="number" name="tenaga[operasional][cold_storage]" class="form-control" placeholder="Jumlah tenaga kerja">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mobil pengangkut</label>
                    <input type="number" name="tenaga[operasional][mobil_pengangkut]" class="form-control" placeholder="Jumlah tenaga kerja">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pabrik Es</label>
                    <input type="number" name="tenaga[operasional][pabrik_es]" class="form-control" placeholder="Jumlah tenaga kerja">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Bengkel</label>
                    <input type="number" name="tenaga[operasional][bengkel]" class="form-control" placeholder="Jumlah tenaga kerja">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tambatan Kapal</label>
                    <input type="number" name="tenaga[operasional][tambatan_kapal]" class="form-control" placeholder="Jumlah tenaga kerja">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kios Perbekalan</label>
                    <input type="number" name="tenaga[operasional][kios_perbekalan]" class="form-control" placeholder="Jumlah tenaga kerja">
                </div>
                <div class="col-md-6">
                    <label class="form-label">SPBN</label>
                    <input type="number" name="tenaga[operasional][spbn]" class="form-control" placeholder="Jumlah tenaga kerja">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sentra Kuliner</label>
                    <input type="number" name="tenaga[operasional][sentra_kuliner]" class="form-control" placeholder="Jumlah tenaga kerja">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Koperasi</label>
                    <input type="number" name="tenaga[operasional][koperasi]" class="form-control" placeholder="Jumlah tenaga kerja">
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <a href="/forms" class="btn btn-secondary me-2">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
