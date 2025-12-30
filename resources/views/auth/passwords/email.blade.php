@extends('layouts.auth_simple')

@section('content')
    <div class="card login-card">
        <div class="card-body">
            <h4 class="login-title text-center">Reset Password</h4>
            <p class="login-subtitle text-center">Masukan email Anda dan kami akan mengirimkan link untuk mereset password.
            </p>

            @if (session('status'))
                <div class="alert alert-success" role="alert" style="border-radius: 12px;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-0 text-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-email-outline me-1"></i> Kirim Link Reset Password
                    </button>
                </div>

                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}" class="text-muted"><i class="mdi mdi-arrow-left me-1"></i>Kembali ke
                        Login</a>
                </div>
            </form>
        </div>
    </div>
@endsection