<form method="POST" action="{{ route('forms.store_tanggapan_masyarakat', ['knmp' => $knmp->id]) }}">
    @csrf
    <input type="hidden" name="knmp_id" value="{{ $knmp->id }}">

    {{-- 1. Apakah sesuai kebutuhan --}}
    <div class="mb-3">
        <label class="form-label"><strong>1. Apakah item rencana Pembangunan telah sesuai dengan kebutuhan
                masyarakat?</strong></label>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="kesesuaian_kebutuhan" id="yaSesuai" value="1"
                {{ old('kesesuaian_kebutuhan') == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="yaSesuai">Ya, sesuai</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="kesesuaian_kebutuhan" id="tidakSesuai" value="0"
                {{ old('kesesuaian_kebutuhan') === '0' ? 'checked' : '' }}>
            <label class="form-check-label" for="tidakSesuai">Tidak sesuai</label>
        </div>
    </div>

    {{-- 2. Jika tidak sesuai --}}
    <div class="mb-3">
        <label class="form-label"><strong>2. Jika tidak sesuai, item apa yang tidak sesuai?</strong></label>
        <textarea id="inputTidakSesuai" name="item_tidak_sesuai" rows="3" class="form-control">{{ old('item_tidak_sesuai') }}</textarea>
    </div>

    {{-- 3. Apakah senang --}}
    <div class="mb-3">
        <label class="form-label"><strong>3. Apakah Anda senang terhadap rencana pembangunan KNMP?</strong></label>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="tingkat_kesenangan" id="senang" value="Senang"
                {{ old('tingkat_kesenangan') == 'Senang' ? 'checked' : '' }}>
            <label class="form-check-label" for="senang">Senang</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="tingkat_kesenangan" id="biasa" value="Biasa saja"
                {{ old('tingkat_kesenangan') == 'Biasa saja' ? 'checked' : '' }}>
            <label class="form-check-label" for="biasa">Biasa saja</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="tingkat_kesenangan" id="tidakSenang"
                value="Tidak Senang" {{ old('tingkat_kesenangan') == 'Tidak Senang' ? 'checked' : '' }}>
            <label class="form-check-label" for="tidakSenang">Tidak Senang</label>
        </div>
    </div>

    {{-- 4. Jika tidak senang --}}
    <div class="mb-3">
        <label class="form-label"><strong>4. Jika tidak senang, apa alasan Anda?</strong></label>
        <textarea id="inputAlasan" name="alasan_tidak_senang" rows="3" class="form-control">{{ old('alasan_tidak_senang') }}</textarea>
    </div>

    {{-- 5 dan 6 tetap sama --}}
    <div class="mb-3">
        <label class="form-label"><strong>5. Harapan masyarakat setelah pembangunan?</strong></label>
        <textarea name="harapan_masyarakat" rows="3" class="form-control">{{ old('harapan_masyarakat') }}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>6. Masukan/saran dari masyarakat?</strong></label>
        <textarea name="masukan_saran_perbaikan" rows="3" class="form-control">{{ old('masukan_saran_perbaikan') }}</textarea>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary">Simpan Tanggapan</button>
    </div>
</form>

{{-- ========================== --}}
{{-- JAVASCRIPT CONDITIONAL --}}
{{-- ========================== --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const sesuai = document.getElementsByName("kesesuaian_kebutuhan");
        const inputTidakSesuai = document.getElementById("inputTidakSesuai");

        const senang = document.getElementsByName("tingkat_kesenangan");
        const inputAlasan = document.getElementById("inputAlasan");

        function toggleTidakSesuai() {
            if (document.getElementById("yaSesuai").checked) {
                inputTidakSesuai.value = "";
                inputTidakSesuai.readOnly = true;
                inputTidakSesuai.classList.add('bg-light');
            } else {
                inputTidakSesuai.readOnly = false;
                inputTidakSesuai.classList.remove('bg-light');
            }
        }

        function toggleAlasan() {
            const val = document.querySelector("input[name='tingkat_kesenangan']:checked")?.value;

            if (val === "Tidak Senang") {
                inputAlasan.readOnly = false;
                inputAlasan.classList.remove('bg-light');
            } else {
                inputAlasan.value = "";
                inputAlasan.readOnly = true;
                inputAlasan.classList.add('bg-light');
            }
        }

        sesuai.forEach(r => r.addEventListener("change", toggleTidakSesuai));
        senang.forEach(r => r.addEventListener("change", toggleAlasan));

        // Trigger on load (untuk kasus EDIT / old input)
        toggleTidakSesuai();
        toggleAlasan();
    });
</script>
