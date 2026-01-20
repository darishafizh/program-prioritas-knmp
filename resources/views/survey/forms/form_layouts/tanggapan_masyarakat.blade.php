<form method="POST"
    action="{{ route('forms.store_tanggapan_masyarakat', [
        'knmp' => $knmp->id,
    ]) }}">
    @csrf


    <input type="hidden" name="active_form" value="tanggapan">
    <input type="hidden" name="active_section" value="collapseThree">

    {{-- ========================= --}}
    {{-- PILIH RESPONDEN --}}
    {{-- ========================= --}}
    <div class="mb-4">
        <label class="form-label fw-bold">
            Responden
        </label>

        <select name="responden_id"
            class="form-select @error('responden_id') is-invalid @enderror"
            required>
            <option value="">-- Pilih Responden --</option>
            @foreach ($respondenList as $r)
            @php
                $isSelected = old('responden_id') == $r->id || 
                             ($selectedRespondenId && $selectedRespondenId == $r->id && !old('responden_id')) ||
                             (isset($selectedRespondenData['tanggapan_masyarakat']) && $selectedRespondenData['tanggapan_masyarakat'] && $selectedRespondenData['tanggapan_masyarakat']->responden_id == $r->id && !old('responden_id'));
            @endphp
            <option value="{{ $r->id }}" {{ $isSelected ? 'selected' : '' }}>
                id = {{ $r->id }} - {{ $r->nama_responden }} ({{ $r->nik }})
            </option>
            @endforeach
        </select>

        @error('responden_id')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    {{-- ========================= --}}
    {{-- 1. Kesesuaian Kebutuhan --}}
    {{-- ========================= --}}
    <div class="mb-3">
        <label class="form-label fw-bold">
            1. Apakah item rencana pembangunan telah sesuai dengan kebutuhan masyarakat?
        </label>

        <div class="form-check">
            <input class="form-check-input"
                type="radio"
                name="kesesuaian_kebutuhan"
                id="yaSesuai"
                value="1"
                {{ old('kesesuaian_kebutuhan') == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="yaSesuai">
                Ya, sesuai
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input"
                type="radio"
                name="kesesuaian_kebutuhan"
                id="tidakSesuai"
                value="0"
                {{ old('kesesuaian_kebutuhan') == '0' ? 'checked' : '' }}>
            <label class="form-check-label" for="tidakSesuai">
                Tidak sesuai
            </label>
        </div>

        @error('kesesuaian_kebutuhan')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- ========================= --}}
    {{-- 2. Item Tidak Sesuai --}}
    {{-- ========================= --}}
    <div class="mb-3">
        <label class="form-label fw-bold">
            2. Jika tidak sesuai, item apa yang tidak sesuai?
        </label>
        <textarea id="inputTidakSesuai"
            name="item_tidak_sesuai"
            rows="3"
            class="form-control @error('item_tidak_sesuai') is-invalid @enderror"
            disabled>{{ old('item_tidak_sesuai') ?? $selectedRespondenData['tanggapan_masyarakat']?->item_tidak_sesuai ?? '' }}</textarea>

        @error('item_tidak_sesuai')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- ========================= --}}
    {{-- 3. Tingkat Kesenangan --}}
    {{-- ========================= --}}
    <div class="mb-3">
        <label class="form-label fw-bold">
            3. Apakah Anda senang terhadap rencana pembangunan KNMP?
        </label>

        @foreach (['Senang', 'Biasa saja', 'Tidak Senang'] as $opsi)
        <div class="form-check">
            <input class="form-check-input"
                type="radio"
                name="tingkat_kesenangan"
                id="kesenangan_{{ Str::slug($opsi) }}"
                value="{{ $opsi }}"
                {{ old('tingkat_kesenangan') == $opsi ? 'checked' : '' }}>
            <label class="form-check-label" for="kesenangan_{{ Str::slug($opsi) }}">
                {{ $opsi }}
            </label>
        </div>
        @endforeach

        @error('tingkat_kesenangan')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- ========================= --}}
    {{-- 4. Alasan Tidak Senang --}}
    {{-- ========================= --}}
    <div class="mb-3">
        <label class="form-label fw-bold">
            4. Jika tidak senang, apa alasan Anda?
        </label>
        <textarea id="inputAlasan"
            name="alasan_tidak_senang"
            rows="3"
            class="form-control @error('alasan_tidak_senang') is-invalid @enderror"
            disabled>{{ old('alasan_tidak_senang') ?? $selectedRespondenData['tanggapan_masyarakat']?->alasan_tidak_senang ?? '' }}</textarea>

        @error('alasan_tidak_senang')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- ========================= --}}
    {{-- 5. Harapan --}}
    {{-- ========================= --}}
    <div class="mb-3">
        <label class="form-label fw-bold">
            5. Harapan masyarakat setelah pembangunan?
        </label>
        <textarea name="harapan_masyarakat"
            rows="3"
            class="form-control @error('harapan_masyarakat') is-invalid @enderror">{{ old('harapan_masyarakat') ?? $selectedRespondenData['tanggapan_masyarakat']?->harapan_masyarakat ?? '' }}</textarea>

        @error('harapan_masyarakat')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- ========================= --}}
    {{-- 6. Masukan --}}
    {{-- ========================= --}}
    <div class="mb-3">
        <label class="form-label fw-bold">
            6. Masukan / saran dari masyarakat?
        </label>
        <textarea name="masukan_saran_perbaikan"
            rows="3"
            class="form-control @error('masukan_saran_perbaikan') is-invalid @enderror">{{ old('masukan_saran_perbaikan') ?? $selectedRespondenData['tanggapan_masyarakat']?->masukan_saran_perbaikan ?? '' }}</textarea>

        @error('masukan_saran_perbaikan')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-primary">
            Simpan Tanggapan
        </button>
    </div>
</form>

{{-- ========================= --}}
{{-- JAVASCRIPT CONDITIONAL --}}
{{-- ========================= --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const radioSesuai = document.querySelectorAll("input[name='kesesuaian_kebutuhan']");
        const radioSenang = document.querySelectorAll("input[name='tingkat_kesenangan']");
        const inputTidakSesuai = document.getElementById("inputTidakSesuai");
        const inputAlasan = document.getElementById("inputAlasan");

        function toggleTidakSesuai() {
            const value = document.querySelector("input[name='kesesuaian_kebutuhan']:checked")?.value;
            if (value === "0") {
                inputTidakSesuai.disabled = false;
            } else {
                inputTidakSesuai.value = "";
                inputTidakSesuai.disabled = true;
            }
        }

        function toggleAlasan() {
            const value = document.querySelector("input[name='tingkat_kesenangan']:checked")?.value;
            if (value === "Tidak Senang") {
                inputAlasan.disabled = false;
            } else {
                inputAlasan.value = "";
                inputAlasan.disabled = true;
            }
        }

        radioSesuai.forEach(el => el.addEventListener("change", toggleTidakSesuai));
        radioSenang.forEach(el => el.addEventListener("change", toggleAlasan));

        // trigger saat load (old input / error)
        toggleTidakSesuai();
        toggleAlasan();
    });
</script>