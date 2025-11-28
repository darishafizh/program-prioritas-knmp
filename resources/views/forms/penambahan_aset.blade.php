@extends('layouts.app')

@section('content')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Penambahan Aset</h4>
                    <p class="text-muted mb-3">Isi data penambahan aset sesuai tabel. Simpan setelah selesai.</p>

                    @include('forms._penambahan_aset_form')

                </div>
            </div>
        </div>
    </div>
@endsection
