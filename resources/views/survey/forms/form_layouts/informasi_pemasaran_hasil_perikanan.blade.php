<form method="POST" action="{{ route('survey.forms.store_pemasaran_perikanan', ['knmp' => $knmp->id]) }}">
    @csrf
    <input type="hidden" name="knmp_id" value="{{ $knmp->id ?? 0 }}">

    <label class="form-label">1. Sebutkan Penjualan Ikan Hasil Tangkapan Anda ke Setiap Pembeli selama satu trip
        penangkapan berikut</label>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3"><label class="form-label">Langsung ke pasar/pembeli eceran (Kg/Trip)</label>
                <input type="number" name="pemasaran_eceran_kg" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">Koperasi (Kg/Trip)</label>
                <input type="number" name="pemasaran_koperasi_kg" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">Tengkulak (Kg/Trip)</label>
                <input type="number" name="pemasaran_tengkulak_kg" class="form-control" step="any">
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3"><label class="form-label">Pengepul (Kg/Trip)</label>
                <input type="number" name="pemasaran_pengepul_kg" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">Pedagang Besar (PT, CV, BUMD, BUMDES) (Kg/Trip)</label>
                <input type="number" name="pemasaran_pedagang_besar_kg" class="form-control" step="any">
            </div>
            <div class="mb-3"><label class="form-label">Lainnya (sebutkan) (Kg/Trip)</label>
                <input type="text" name="pemasaran_lainnya_ket" class="form-control"
                    placeholder="Keterangan Lainnya">
                <input type="number" name="pemasaran_lainnya_kg" class="form-control mt-2" placeholder="Kg/Trip"
                    step="any">
            </div>
        </div>
    </div>

    <hr>

    <div class="mb-3"><label class="form-label">2. Apakah terdapat kendala mekanisme pemasaran hasil tangkapan.
            Jelaskan Jawaban Anda!</label>
        <textarea name="kendala_pemasaran" class="form-control" rows="3"></textarea>
    </div>

    <div class="mb-3"><label class="form-label">3. Bagaimana cara penanganan ikan. Jelaskan Jawaban Anda!</label>
        <textarea name="cara_penanganan_ikan" class="form-control" rows="3"></textarea>
    </div>

    <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-primary">Simpan Informasi Pemasaran</button>
    </div>
</form>
