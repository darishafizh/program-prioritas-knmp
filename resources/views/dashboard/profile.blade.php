@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="header-title mb-0">Profile</h4>
                        <div>
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">Edit Profile</a>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm ms-2">&larr; Kembali</a>
                        </div>
                    </div>

                    @if(session('success'))
                        <div id="flash-card" style="position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); z-index:2000;">
                            <div style="background:#fff; border-radius:10px; padding:28px 36px; min-width:360px; box-shadow:0 12px 30px rgba(0,0,0,0.12); text-align:center;">
                                <div style="width:96px; height:96px; margin:0 auto 14px; border-radius:50%; background:#eafaf0; display:flex; align-items:center; justify-content:center;">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="12" fill="#eafaf0" />
                                        <path d="M7 12.5l2.5 2.5L17 8.5" stroke="#28a745" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <h4 style="margin:0 0 8px; font-weight:700; color:#343a40;">{{ session('success_title', 'Berhasil') }}</h4>
                                <p style="margin:0; color:#6c757d;">{{ session('success') }}</p>
                            </div>
                        </div>
                        <script>
                            (function(){
                                const el = document.getElementById('flash-card');
                                if (!el) return;
                                // Auto-hide after 3 seconds (3000ms)
                                setTimeout(() => {
                                    el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                                    el.style.opacity = '0';
                                    el.style.transform = 'translate(-50%, -45%) scale(0.98)';
                                    setTimeout(() => el.remove(), 500);
                                }, 3000);
                            })();
                        </script>
                    @endif

                    @if($profile)
                        <div class="profile-detail">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="text-muted font-weight-bold">Nama Kampung</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ $profile->nama_kampung ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="text-muted font-weight-bold">Lingkungan Kawasan</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ $profile->lingkungan_kawasan ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="text-muted font-weight-bold">Aktivitas Usaha Nelayan</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ $profile->aktivitas_usaha_nelayan ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="text-muted font-weight-bold">Sarana dan Prasarana yang Tersedia</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ $profile->sarana_prasarana ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="text-muted font-weight-bold">Status dan Kepemilikan Tanah Lokasi KNMP</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ $profile->status_kepemilikan_tanah ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="text-muted font-weight-bold">Nama Kopdeskel Merah Putih Pengelola KNMP</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ $profile->nama_kopdeskel ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="text-muted font-weight-bold">Dasar Hukum Kopdeskel</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ $profile->dasar_hukum_kopdeskel ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="text-muted font-weight-bold">Ketua Kopdeskel</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ $profile->ketua_kopdeskel ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="text-muted font-weight-bold">Status dalam e-Kusuka</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ $profile->status_e_kusuka ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="text-muted font-weight-bold">Jenis Usaha Sebelum KNMP</label>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ $profile->jenis_usaha_sebelum_knmp ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Belum ada data profile. <a href="{{ route('profile.edit') }}" class="alert-link">Buat profile sekarang</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
