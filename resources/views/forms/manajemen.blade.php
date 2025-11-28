@extends('layouts.app')

@section('content')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Manajemen</h4>
                    <p class="text-muted mb-3">Form Manajemen — Keragaan Manajemen dan Efektivitas Pengelolaan Aset.</p>

                    @include('forms._manajemen_form')

                </div>
            </div>
        </div>
    </div>
@endsection
