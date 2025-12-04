<form method="POST" action="{{ route('forms.store_tanggapan_masyarakat', ['knmp' => $knmp->id]) }}">
    @csrf
    <input type="hidden" name="knmp_id" value="{{ $knmp->id }}">

    <!-- 1. Apakah sesuai dengan kebutuhan masyarakat -->
    <div class="mb-3">
        <label class="form-label">1. Apakah item rencana Pembangunan telah sesuai dengan kebutuhan masyarakat?</label>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="sesuai_kebutuhan" id="sesuai1" value="Ya, sesuai"
                onclick="toggleTidakSesuai(false)">
            <label class="form-check-label" for="sesuai1">Ya, sesuai</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="sesuai_kebutuhan" id="sesuai2" value="Tidak sesuai"
                onclick="toggleTidakSesuai(true)">
            <label class="form-check-label" for="sesuai2">Tidak sesuai</label>
        </div>
    </div>

    <!-- Hidden input agar nilai tetap terkirim -->
    <input type="hidden" name="tidak_sesuai_item" value="">

    <!-- 2. Input muncul hanya jika "Tidak sesuai" -->
    <div class="mb-3">
        <label for="tidak_sesuai_item" class="form-label">
            2. Apabila tidak sesuai, item apa yang menurut Anda tidak sesuai?
        </label>
        <textarea id="tidak_sesuai_item" rows="3" class="form-control" name="tidak_sesuai_item_visible" readonly>{{ old('tidak_sesuai_item', $tanggapan['tidak_sesuai_item'] ?? '') }}</textarea>
    </div>


    <!-- 3. Apakah senang -->
    <div class="mb-3">
        <label class="form-label">3. Apakah anda senang terhadap rencana Pembangunan KNMP?</label>

        @php $senang = old('senang', $tanggapan['senang'] ?? ''); @endphp

        <div class="form-check">
            <input class="form-check-input" type="radio" name="senang" id="senang1" value="Senang"
                onclick="toggleTidakSenang(false)" {{ $senang == 'Senang' ? 'checked' : '' }}>
            <label class="form-check-label" for="senang1">Senang</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="senang" id="senang2" value="Biasa saja"
                onclick="toggleTidakSenang(false)" {{ $senang == 'Biasa saja' ? 'checked' : '' }}>
            <label class="form-check-label" for="senang2">Biasa saja</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="senang" id="senang3" value="Tidak Senang"
                onclick="toggleTidakSenang(true)" {{ $senang == 'Tidak Senang' ? 'checked' : '' }}>
            <label class="form-check-label" for="senang3">Tidak Senang</label>
        </div>
    </div>

    <!-- Hidden input agar selalu terkirim -->
    <input type="hidden" name="alasan_tidak_senang" value="">

    <!-- 4. Input muncul hanya jika "Tidak Senang" -->
    <div class="mb-3">
        <label for="alasan_tidak_senang" class="form-label">
            4. Jika tidak senang, apa alasan Anda?
        </label>
        <textarea id="alasan_tidak_senang" rows="3" class="form-control" name="alasan_tidak_senang_visible" readonly>{{ old('alasan_tidak_senang', $tanggapan['alasan_tidak_senang'] ?? '') }}</textarea>
    </div>

    <!-- 5 -->
    <div class="mb-3">
        <label for="harapan_masyarakat" class="form-label">5. Harapan masyarakat setelah terbangun?</label>
        <textarea name="harapan_masyarakat" id="harapan_masyarakat" rows="3" class="form-control">
            {{ old('harapan_masyarakat', $tanggapan['harapan_masyarakat'] ?? '') }}
        </textarea>
    </div>

    <!-- 6 -->
    <div class="mb-3">
        <label for="masukan_saran" class="form-label">6. Masukan/saran masyarakat?</label>
        <textarea name="masukan_saran" id="masukan_saran" rows="3" class="form-control">
            {{ old('masukan_saran', $tanggapan['masukan_saran'] ?? '') }}
        </textarea>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary">Simpan Tanggapan</button>
    </div>
</form>


<script>
    function toggleTidakSesuai(show) {
        const field = document.getElementById('tidak_sesuai_item');
        field.readOnly = !show;
        if (!show) field.value = "";
    }

    function toggleTidakSenang(show) {
        const field = document.getElementById('alasan_tidak_senang');
        field.readOnly = !show;
        if (!show) field.value = "";
    }

    document.addEventListener('DOMContentLoaded', () => {
        const sesuai = document.querySelector('input[name="sesuai_kebutuhan"]:checked');
        toggleTidakSesuai(sesuai && sesuai.value === "Tidak sesuai");

        const senang = document.querySelector('input[name="senang"]:checked');
        toggleTidakSenang(senang && senang.value === "Tidak Senang");
    });
</script>
