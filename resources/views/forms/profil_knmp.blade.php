@extends('layouts.app')

@section('content')
    <div class="row mt-3">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">5. Profil KNMP</h4>
                        <a href="{{ route('forms.profil_knmp.create') }}" class="btn btn-sm btn-success">Tambah</a>
                    </div>

                    @include('forms._profil_knmp_form')

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary ms-2">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
