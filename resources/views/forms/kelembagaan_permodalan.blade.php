@extends('layouts.app')

@section('content')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Kelembagaan & Permodalan</h4>
                    <p class="text-muted mb-3">Form Kelembagaan dan Permodalan.</p>

                    @include('forms._kelembagaan_permodalan_form')

                </div>
            </div>
        </div>
    </div>
@endsection
