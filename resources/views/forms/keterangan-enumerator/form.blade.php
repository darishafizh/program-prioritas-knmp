@csrf
<div class="mb-3">
    <label for="nama_enumerator" class="form-label">Nama Enumerator</label>
    <input type="text" name="nama_enumerator" id="nama_enumerator" class="form-control" value="{{ old('nama_enumerator', $enumerator->nama_enumerator ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="keterangan" class="form-label">Keterangan</label>
    <textarea name="keterangan" id="keterangan" class="form-control" rows="3" required>{{ old('keterangan', $enumerator->keterangan ?? '') }}</textarea>
</div>

<button type="submit" class="btn btn-success">Simpan</button>
<a href="{{ route('forms.keterangan-enumerator.index') }}" class="btn btn-secondary">Batal</a>