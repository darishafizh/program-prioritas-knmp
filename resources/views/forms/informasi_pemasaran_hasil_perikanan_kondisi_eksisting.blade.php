@extends('layouts.app')

@section('content')
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Informasi Pemasaran Hasil Perikanan (Kondisi Eksisting)</h4>
                    <a href="{{ route('forms.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>

                <form method="POST" action="{{ $route }}">
                    @csrf
                    @if(isset($method) && $method === 'PUT')
                    @method('PUT')
                    @endif

                    @include('forms._informasi_pemasaran_hasil_perikanan_kondisi_eksisting_form', ['data' => $data ?? null])

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('forms.index') }}" class="btn btn-secondary ms-2">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection