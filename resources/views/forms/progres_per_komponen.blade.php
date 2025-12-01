@extends('layouts.app')

@section('content')
    <div class="row mt-3">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">4. Progress Per Komponen</h4>
                        <a href="{{ route('forms.progres_per_komponen.create') }}" class="btn btn-sm btn-success">Tambah</a>
                    </div>

                    @include('forms._progres_per_komponen_form')

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary ms-2">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
