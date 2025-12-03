@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h4>Informasi Usaha Kondisi Eksisting</h4>

    @include('forms._informasi_usaha_kondisi_eksisting_form', [
    'data' => $data ?? null,
    'route' => $route ?? route('forms.informasi_usaha.store'),
    'method' => $method ?? 'POST'
    ])
</div>
@endsection