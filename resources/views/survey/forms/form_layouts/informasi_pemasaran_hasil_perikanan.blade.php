<form method="POST" action="{{ route('forms.store_pemasaran_perikanan', ['knmp' => hashid($knmp->id)]) }}">
    @csrf
    <input type="hidden" name="active_section" value="collapseG">
    <input type="hidden" name="knmp_id" value="{{ hashid($knmp->id) }}">

    {{-- ========================= --}}
    {{-- PILIH RESPONDEN --}}
    {{-- ========================= --}}
    <div class="mb-4">
        <label class="form-label fw-bold">Responden</label>
        <select name="responden_id" class="form-select" required>
            <option value="">-- Pilih Responden --</option>
            @foreach ($respondenList as $r)
                @php
                    $isSelected = old('responden_id') == $r->id ||
                        ($selectedRespondenId && $selectedRespondenId == $r->id && !old('responden_id')) ||
                        (isset($selectedRespondenData['informasi_pemasaran']) && $selectedRespondenData['informasi_pemasaran'] && $selectedRespondenData['informasi_pemasaran']->responden_id == $r->id && !old('responden_id'));
                @endphp
                <option value="{{ $r->id }}" {{ $isSelected ? 'selected' : '' }}>
                    id = {{ $r->id }} - {{ $r->nama_responden }} ({{ $r->nik }})
                </option>
            @endforeach
        </select>
    </div>

    <label class="form-label">1. Sebutkan Penjualan Ikan Hasil Tangkapan Anda ke Setiap Pembeli selama satu trip
        penangkapan berikut</label>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3"><label class="form-label">Langsung ke pasar/pembeli eceran (Kg/Trip)</label>
                <input type="number" name="pemasaran_eceran_kg" class="form-control" step="any"
                    value="{{ old('pemasaran_eceran_kg') }}">
            </div>
            <div class="mb-3"><label class="form-label">Koperasi (Kg/Trip)</label>
                <input type="number" name="pemasaran_koperasi_kg" class="form-control" step="any"
                    value="{{ old('pemasaran_koperasi_kg') }}">
            </div>
            <div class="mb-3"><label class="form-label">Tengkulak (Kg/Trip)</label>
                <input type="number" name="pemasaran_tengkulak_kg" class="form-control" step="any"
                    value="{{ old('pemasaran_tengkulak_kg') }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3"><label class="form-label">Pengepul (Kg/Trip)</label>
                <input type="number" name="pemasaran_pengepul_kg" class="form-control" step="any"
                    value="{{ old('pemasaran_pengepul_kg') }}">
            </div>
            <div class="mb-3"><label class="form-label">Pedagang Besar (PT, CV, BUMD, BUMDES) (Kg/Trip)</label>
                <input type="number" name="pemasaran_pedagang_besar_kg" class="form-control" step="any"
                    value="{{ old('pemasaran_pedagang_besar_kg') }}">
            </div>
            <div class="mb-3"><label class="form-label">Lainnya (sebutkan) (Kg/Trip)</label>
                <input type="text" name="pemasaran_lainnya_ket" class="form-control" placeholder="Keterangan Lainnya"
                    value="{{ old('pemasaran_lainnya_ket') }}">
                <input type="number" name="pemasaran_lainnya_kg" class="form-control mt-2" placeholder="Kg/Trip"
                    step="any" value="{{ old('pemasaran_lainnya_kg') }}">
            </div>
        </div>
    </div>

    <hr>

    <div class="mb-3"><label class="form-label">2. Apakah terdapat kendala mekanisme pemasaran hasil tangkapan.
            Jelaskan Jawaban Anda!</label>
        <textarea name="kendala_pemasaran" class="form-control" rows="3">{{ old('kendala_pemasaran') }}</textarea>
    </div>

    <div class="mb-3"><label class="form-label">3. Bagaimana cara penanganan ikan. Jelaskan Jawaban Anda!</label>
        <textarea name="cara_penanganan_ikan" class="form-control" rows="3">{{ old('cara_penanganan_ikan') }}</textarea>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>