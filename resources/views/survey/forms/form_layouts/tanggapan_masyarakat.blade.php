<form method="POST" action="{{ route('forms.store_tanggapan_masyarakat', ['knmp' => $knmp->id]) }}">
    @csrf
    <input type="text" hidden name="knmp_id" value="{{ $knmp->id ?? '' }}">
    {{-- 1. Apakah sesuai dengan kebutuhan masyarakat --}}
    <div class="mb-3">
        <label class="form-label"><strong>1. Apakah item rencana Pembangunan telah sesuai dengan kebutuhan
                masyarakat?</strong></label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="sesuai_kebutuhan" id="sesuai1" value="Ya, sesuai">
            <label class="form-check-label" for="sesuai1">Ya, sesuai</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="sesuai_kebutuhan" id="sesuai2" value="Tidak sesuai">
            <label class="form-check-label" for="sesuai2">Tidak sesuai</label>
        </div>
    </div>

    {{-- 2. Apabila tidak sesuai --}}
    <div class="mb-3">
        <label for="tidak_sesuai_item" class="form-label"><strong>2. Apabila tidak sesuai, item apa yang menurut Anda
                tidak sesuai dengan kebutuhan masyarakat?</strong></label>
        <textarea name="tidak_sesuai_item" id="tidak_sesuai_item" rows="3" class="form-control">{{ old('tidak_sesuai_item', $tanggapan['tidak_sesuai_item'] ?? '') }}</textarea>
    </div>

    {{-- 3. Apakah senang --}}
    <div class="mb-3">
        <label class="form-label"><strong>3. Apakah anda senang terhadap rencana Pembangunan KNMP?</strong></label>
        @php
            $senang = old('senang', $tanggapan['senang'] ?? '');
        @endphp
        <div class="form-check">
            <input class="form-check-input" type="radio" name="senang" id="senang1" value="Senang"
                {{ $senang == 'Senang' ? 'checked' : '' }}>
            <label class="form-check-label" for="senang1">Senang</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="senang" id="senang2" value="Biasa saja"
                {{ $senang == 'Biasa saja' ? 'checked' : '' }}>
            <label class="form-check-label" for="senang2">Biasa saja</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="senang" id="senang3" value="Tidak Senang"
                {{ $senang == 'Tidak Senang' ? 'checked' : '' }}>
            <label class="form-check-label" for="senang3">Tidak Senang</label>
        </div>
    </div>

    {{-- 4. Apabila tidak senang --}}
    <div class="mb-3">
        <label for="alasan_tidak_senang" class="form-label"><strong>4. Apabila anda tidak senang dengan rencana
                Pembangunan KNMP tersebut, apa alasan anda?</strong></label>
        <textarea name="alasan_tidak_senang" id="alasan_tidak_senang" rows="3" class="form-control">{{ old('alasan_tidak_senang', $tanggapan['alasan_tidak_senang'] ?? '') }}</textarea>
    </div>

    {{-- 5. Harapan masyarakat --}}
    <div class="mb-3">
        <label for="harapan_masyarakat" class="form-label"><strong>5. Harapan masyarakat setelah
                terbangun?</strong></label>
        <textarea name="harapan_masyarakat" id="harapan_masyarakat" rows="3" class="form-control">{{ old('harapan_masyarakat', $tanggapan['harapan_masyarakat'] ?? '') }}</textarea>
    </div>

    {{-- 6. Masukan/saran --}}
    <div class="mb-3">
        <label for="masukan_saran" class="form-label"><strong>6. Masukan/saran perbaikan dari masyarakat terhadap
                Pembangunan KNMP?</strong></label>
        <textarea name="masukan_saran" id="masukan_saran" rows="3" class="form-control">{{ old('masukan_saran', $tanggapan['masukan_saran'] ?? '') }}</textarea>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary">Simpan Tanggapan</button>
    </div>
</form>
