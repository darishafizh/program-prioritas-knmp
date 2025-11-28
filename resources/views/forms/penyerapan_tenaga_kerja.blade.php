@extends('layouts.app')

@section('content')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Penyerapan Tenaga Kerja</h4>
                    <p class="text-muted mb-3">Form Penyerapan Tenaga Kerja.</p>

                    @include('forms._penyerapan_tenaga_kerja_form')

                </div>
            </div>
        </div>
    </div>
@endsection
