@extends('layouts.app')

@section('content')
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">
                    {{ isset($item) ? 'Edit Target & Realisasi' : 'Tambah Target & Realisasi' }}
                </h4>

                <form action="{{ isset($item) ? route('forms.target_realisasi.update', $item->id) : route('forms.target_realisasi.store') }}" method="POST">
                    @csrf
                    @if(isset($item))
                    @method('PUT')
                    @endif

                    {{-- Nama KNMP --}}
                    <div class="mb-3">
                        <label class="form-label">Nama KNMP</label>
                        <input type="text" name="nama_knmp" class="form-control"
                            value="{{ old('nama_knmp', $item->nama_knmp ?? '') }}" required>
                        @error('nama_knmp')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- PPK --}}
                    <div class="mb-3">
                        <label class="form-label">PPK</label>
                        <input type="text" name="ppk" class="form-control"
                            value="{{ old('ppk', $item->ppk ?? '') }}" required>
                        @error('ppk')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Kontraktor Pelaksana --}}
                    <div class="mb-3">
                        <label class="form-label">Kontraktor Pelaksana</label>
                        <input type="text" name="kontraktor" class="form-control"
                            value="{{ old('kontraktor', $item->kontraktor ?? '') }}" required>
                        @error('kontraktor')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Target Fisik --}}
                    <div class="mb-3">
                        <label class="form-label">Target Fisik</label>
                        <input type="number" name="target_fisik" class="form-control"
                            value="{{ old('target_fisik', $item->target_fisik ?? '') }}" required>
                        @error('target_fisik')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Realisasi Fisik --}}
                    <div class="mb-3">
                        <label class="form-label">Realisasi Fisik</label>
                        <input type="number" name="realisasi_fisik" class="form-control"
                            value="{{ old('realisasi_fisik', $item->realisasi_fisik ?? '') }}" required>
                        @error('realisasi_fisik')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="mt-4">
                        <a href="{{ route('forms.target_realisasi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left-circle"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary ms-2">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection