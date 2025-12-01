@extends('layouts.app')

@section('content')
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">3. Target & Realisasi</h4>

                    <a href="{{ route('forms.target_realisasi.create') }}" class="btn btn-sm btn-success">
                        Tambah
                    </a>

                </div>

                {{-- include tabel --}}
                @include('forms._target_realisasi_form', ['targets' => $targets])

                <div class="mt-4">
                    <a href="{{ route('forms.index') }}" class="btn btn-secondary ms-2">Kembali</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection