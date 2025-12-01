@extends('layouts.app')

@section('content')
<div class="row mt-3">
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">Tambah Target & Realisasi</h4>

                <form action="{{ route('forms.target_realisasi.store') }}" method="POST">

                    @csrf

                    <div class="mb-2">
                        <label>Nama KNMP</label>
                        <input type="text" name="nama_knmp" class="form-control" value="{{ old('nama_knmp') }}">
                        @error('nama_knmp') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-2">
                        <label>PPK</label>
                        <input type="text" name="ppk" class="form-control" value="{{ old('ppk') }}">
                        @error('ppk') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-2">
                        <label>Kontraktor Pelaksana</label>
                        <input type="text" name="kontraktor" class="form-control" value="{{ old('kontraktor') }}">
                        @error('kontraktor') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-2">
                        <label>Target Fisik</label>
                        <input type="number" name="target_fisik" class="form-control" value="{{ old('target_fisik') }}">
                        @error('target_fisik') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-2">
                        <label>Realisasi Fisik</label>
                        <input type="number" name="realisasi_fisik" class="form-control" value="{{ old('realisasi_fisik') }}">
                        @error('realisasi_fisik') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('forms.target_realisasi.index') }}" class="btn btn-secondary">Batal</a>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection