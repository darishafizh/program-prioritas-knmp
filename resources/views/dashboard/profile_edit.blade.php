@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="header-title mb-0">Edit Profile</h4>
                        <a href="{{ route('profile.index') }}" class="btn btn-secondary btn-sm">&larr; Kembali</a>
                    </div>

                    @include('dashboard._profile_form')

                </div>
            </div>
        </div>
    </div>
@endsection
