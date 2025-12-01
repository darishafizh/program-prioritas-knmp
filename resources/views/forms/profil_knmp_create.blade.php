@extends('layouts.app')

@section('content')
    <div class="row mt-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Tambah Profil KNMP</h4>

                    <form method="POST" action="#">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="nama-kampung" class="form-label">Nama kampung</label>
                                    <input type="text" id="nama-kampung" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="lingkungan-kawasan" class="form-label">Lingkungan Kawasan</label>
                                    <input type="text" id="lingkungan-kawasan" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="aktivitas-usaha" class="form-label">Aktivitas usaha nelayan</label>
                                    <input type="text" id="aktivitas-usaha" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="sarana-prasarana" class="form-label">Sarana dan Prasarana yang tersedia</label>
                                    <input type="text" id="sarana-prasarana" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="status-tanah" class="form-label">Status dan Kepemilikan Tanah lokasi KNMP</label>
                                    <input type="text" id="status-tanah" class="form-control">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="nama-kopdeskel" class="form-label">Nama Kopdeskel Merah Putih Pengelola KNMP</label>
                                    <input type="text" id="nama-kopdeskel" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="dasar-hukum" class="form-label">Dasar Hukum Kopdeskel</label>
                                    <input type="text" id="dasar-hukum" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="ketua-kopdeskel" class="form-label">Ketua Kopdeskel</label>
                                    <input type="text" id="ketua-kopdeskel" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="status-ekusuka" class="form-label">Status dalam e-Kusuka</label>
                                    <input type="text" id="status-ekusuka" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="jenis-usaha-sebelum" class="form-label">Jenis usaha sebelum KNMP</label>
                                    <input type="text" id="jenis-usaha-sebelum" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('forms.profil_knmp') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary ms-2">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
