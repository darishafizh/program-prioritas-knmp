@extends('layouts.app')

@section('content')
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Tambah Keterangan Enumerator</h4>

                <form method="POST" action="{{ route('forms.keterangan-enumerator.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Enumerator</label>
                        <input type="text" name="nama_enumerator" class="form-control" placeholder="Masukkan nama enumerator" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Wawancara</label>
                        <input type="date" name="tanggal_wawancara" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Editing</label>
                        <input type="date" name="tanggal_editing" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Pemvalidasi</label>
                        <input type="text" name="nama_pemvalidasi" class="form-control" placeholder="Masukkan nama pemvalidasi">
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('forms.keterangan-enumerator.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary ms-2">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection