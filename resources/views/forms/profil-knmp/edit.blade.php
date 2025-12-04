@extends('layouts.app')

@section('content')
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-4">Edit Profil KNMP</h4>

                <form method="POST" action="{{ route('forms.profil_knmp.update', $profilKnmp->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- 1. Jumlah penduduk desa -->
                    <div class="mb-3">
                        <label class="form-label">Jumlah Penduduk Desa</label>
                        <input type="number" name="jumlah_penduduk_desa" class="form-control" value="{{ $profilKnmp->jumlah_penduduk_desa }}">
                    </div>

                    <!-- 2. Jumlah nelayan -->
                    <div class="mb-3">
                        <label class="form-label">Jumlah Nelayan</label>
                        <input type="number" name="jumlah_nelayan" class="form-control" value="{{ $profilKnmp->jumlah_nelayan }}">
                    </div>

                    <!-- 3. Pendapatan rata-rata -->
                    <div class="mb-3">
                        <label class="form-label">Pendapatan Rata-rata Nelayan Saat Ini (Rp)</label>
                        <input type="number" name="pendapatan_rata_rata" class="form-control" value="{{ $profilKnmp->pendapatan_rata_rata }}">
                    </div>

                    <!-- 4. Alokasi Anggaran -->
                    <div class="mb-3">
                        <label class="form-label">Alokasi Konstruksi (Rp)</label>
                        <input type="number" name="alokasi_konstruksi" class="form-control" value="{{ $profilKnmp->alokasi_konstruksi }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alokasi Upah Tenaga Kerja (Rp)</label>
                        <input type="number" name="alokasi_upah" class="form-control" value="{{ $profilKnmp->alokasi_upah }}">
                    </div>

                    <!-- 5. Tenaga Kerja -->
                    <div class="mb-3">
                        <label class="form-label">Tenaga Kerja Laki-laki</label>
                        <input type="number" name="tk_laki_laki" class="form-control" value="{{ $profilKnmp->tk_laki_laki }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tenaga Kerja Perempuan</label>
                        <input type="number" name="tk_perempuan" class="form-control" value="{{ $profilKnmp->tk_perempuan }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tenaga Kerja Lokal</label>
                        <input type="number" name="tk_lokal" class="form-control" value="{{ $profilKnmp->tk_lokal }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tenaga Kerja Luar</label>
                        <input type="number" name="tk_luar" class="form-control" value="{{ $profilKnmp->tk_luar }}">
                    </div>

                    <!-- 6. Volume Produksi -->
                    <div class="mb-3">
                        <label class="form-label">Volume Produksi (ton/tahun)</label>
                        <input type="number" name="volume_produksi" class="form-control" value="{{ $profilKnmp->volume_produksi }}">
                    </div>

                    <!-- 7. Nilai Produksi -->
                    <div class="mb-3">
                        <label class="form-label">Nilai Produksi (Rp/tahun)</label>
                        <input type="number" name="nilai_produksi" class="form-control" value="{{ $profilKnmp->nilai_produksi }}">
                    </div>

                    <!-- 8. Calon Koperasi -->
                    <div class="mb-3">
                        <label class="form-label">Calon Koperasi Desa Merah Putih</label>
                        <input type="text" name="calon_kopdesmp" class="form-control" value="{{ $profilKnmp->calon_kopdesmp }}">
                    </div>

                    <!-- 9. Nama Ketua -->
                    <div class="mb-3">
                        <label class="form-label">Nama Ketua</label>
                        <input type="text" name="nama_ketua" class="form-control" value="{{ $profilKnmp->nama_ketua }}">
                    </div>

                    <!-- 10. SK Kopdeskel -->
                    <div class="mb-3">
                        <label class="form-label">SK Kopdeskel</label>
                        <input type="text" name="sk_kopdeskel" class="form-control" value="{{ $profilKnmp->sk_kopdeskel }}">
                    </div>

                    <!-- 11. Nomor Induk Kopdeskel -->
                    <div class="mb-3">
                        <label class="form-label">Nomor Induk Kopdeskel</label>
                        <input type="text" name="nomor_induk_kopdeskel" class="form-control" value="{{ $profilKnmp->nomor_induk_kopdeskel }}">
                    </div>

                    <!-- 12. Jumlah anggota -->
                    <div class="mb-3">
                        <label class="form-label">Jumlah Anggota Laki-laki</label>
                        <input type="number" name="jumlah_anggota_laki" class="form-control" value="{{ $profilKnmp->jumlah_anggota_laki }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Anggota Perempuan</label>
                        <input type="number" name="jumlah_anggota_perempuan" class="form-control" value="{{ $profilKnmp->jumlah_anggota_perempuan }}">
                    </div>

                    <!-- 13. Koordinat Lokasi -->
                    <div class="mb-3">
                        <label class="form-label">Koordinat Lokasi</label>
                        <input type="text" name="koordinat_lokasi" class="form-control" value="{{ $profilKnmp->koordinat_lokasi }}">
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('forms.profil_knmp.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary ms-2">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection