@extends('layouts.app')

@section('content')
<div class="row mt-3">
    <div class="col-12"> {{-- FULL WIDTH seperti informasi_umum --}}
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">2. Keterangan Enumerator</h4>
                    <a href="{{ route('forms.keterangan_enumerator.create') }}" class="btn btn-sm btn-success">
                        Tambah
                    </a>
                </div>

                @include('forms._keterangan_enumerator_form')

                <div class="mt-4">
                    <a href="{{ route('forms.index') }}" class="btn btn-secondary">Kembali</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection