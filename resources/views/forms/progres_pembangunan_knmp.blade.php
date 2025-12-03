@extends('layouts.app')

@section('content')
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Progres Pembangunan KNMP</h4>
                </div>

                {{-- Include Form --}}
                @include('forms._progres_pembangunan_knmp', [
                'komponen' => $komponen ?? [],
                'kendala' => $kendala ?? [],
                'cctv' => $cctv ?? ''
                ])

                <div class="mt-4">
                    <a href="{{ route('forms.index') }}" class="btn btn-secondary ms-2">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection