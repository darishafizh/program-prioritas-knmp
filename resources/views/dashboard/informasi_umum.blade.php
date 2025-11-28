@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Informasi Umum</h4>

                    <form method="POST" action="{{ route('informasi_umum.store') }}">
                        @csrf

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="row">
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="header-title mb-0">Informasi Umum</h4>
                                            <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">&larr; Kembali</a>
                                        </div>

                                        @include('dashboard._informasi_umum_form')

                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div> <!-- end col -->
                        </div> <!-- end row -->
    </div> <!-- end row -->
@endsection
