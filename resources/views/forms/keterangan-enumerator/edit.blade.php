@extends('layouts.app')

@section('content')
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Edit Keterangan Enumerator</h4>

                <form method="POST" action="{{ route('forms.keterangan-enumerator.update', $enumerator->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Enumerator</label>
                        <input type="text" name="nama_enumerator" class="form-control" value="{{ $enumerator->nama_enumerator }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Wawancara</label>
                        <input type="date" name="tanggal_wawancara" class="form-control" value="{{ $enumerator->tanggal_wawancara }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Editing</label>
                        <input type="date" name="tanggal_editing" class="form-control" value="{{ $enumerator->tanggal_editing }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Pemvalidasi</label>
                        <input type="text" name="nama_pemvalidasi" class="form-control" value="{{ $enumerator->nama_pemvalidasi }}">
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('forms.keterangan-enumerator.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary ms-2">Update</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection