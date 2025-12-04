@extends('layouts.app')

@section('content')
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Tambah Profil KNMP</h4>

                <form method="POST" action="{{ route('forms.profil_knmp.store') }}">

                    @csrf

                    <!-- 1. Jumlah penduduk desa -->
                    <div class="mb-3">
                        <label class="form-label">Jumlah Penduduk Desa</label>
                        <input type="number" name="jumlah_penduduk" class="form-control" placeholder="Masukkan jumlah penduduk">
                    </div>

                    <!-- 2. Jumlah nelayan -->
                    <div class="mb-3">
                        <label class="form-label">Jumlah Nelayan</label>
                        <input type="number" name="jumlah_nelayan" class="form-control" placeholder="Masukkan jumlah nelayan">
                    </div>

                    <!-- 3. Pendapatan rata-rata nelayan saat ini -->
                    <div class="mb-3">
                        <label class="form-label">Pendapatan Rata-rata Nelayan Saat Ini (Rp)</label>
                        <input type="number" name="pendapatan_rata_rata" class="form-control" placeholder="Masukkan pendapatan rata-rata">
                    </div>

                    <!-- 4. Alokasi Anggaran Pembangunan KNMP -->
                    <div class="mb-3">
                        <label class="form-label">Alokasi Anggaran - Konstruksi (Rp)</label>
                        <input type="number" name="alokasi_konstruksi" class="form-control" placeholder="Masukkan alokasi konstruksi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alokasi Anggaran - Upah Tenaga Kerja (Rp)</label>
                        <input type="number" name="alokasi_upah_tenaga_kerja" class="form-control" placeholder="Masukkan alokasi upah tenaga kerja">
                    </div>

                    <!-- 5. Tenaga Kerja yang terlibat dalam konstruksi KNMP -->
                    <div class="mb-3">
                        <label class="form-label">Tenaga Kerja - Laki-Laki</label>
                        <input type="number" name="tenaga_kerja_laki" class="form-control" placeholder="Masukkan jumlah tenaga kerja laki-laki">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tenaga Kerja - Perempuan</label>
                        <input type="number" name="tenaga_kerja_perempuan" class="form-control" placeholder="Masukkan jumlah tenaga kerja perempuan">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tenaga Kerja Lokal</label>
                        <input type="number" name="tenaga_kerja_lokal" class="form-control" placeholder="Masukkan jumlah tenaga kerja lokal">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tenaga Kerja dari Luar</label>
                        <input type="number" name="tenaga_kerja_luar" class="form-control" placeholder="Masukkan jumlah tenaga kerja dari luar">
                    </div>

                    <!-- 6. Volume Produksi Saat ini (ton/tahun) -->
                    <div class="mb-3">
                        <label class="form-label">Volume Produksi Saat Ini (ton/tahun)</label>
                        <input type="number" name="volume_produksi" class="form-control" placeholder="Masukkan volume produksi">
                    </div>

                    <!-- 7. Nilai Produksi Saat ini (Rp/tahun) -->
                    <div class="mb-3">
                        <label class="form-label">Nilai Produksi Saat Ini (Rp/tahun)</label>
                        <input type="number" name="nilai_produksi" class="form-control" placeholder="Masukkan nilai produksi">
                    </div>

                    <!-- 8. Calon Koperasi Desa Merah Putih -->
                    <div class="mb-3">
                        <label class="form-label">Calon Koperasi Desa Merah Putih</label>
                        <input type="text" name="calon_koperasi" class="form-control" placeholder="Masukkan nama calon koperasi">
                    </div>

                    <!-- 9. Nama Ketua -->
                    <div class="mb-3">
                        <label class="form-label">Nama Ketua</label>
                        <input type="text" name="nama_ketua" class="form-control" placeholder="Masukkan nama ketua">
                    </div>

                    <!-- 10. SK Kopdeskel -->
                    <div class="mb-3">
                        <label class="form-label">SK Kopdeskel</label>
                        <input type="text" name="sk_kopdeskel" class="form-control" placeholder="Masukkan SK Kopdeskel">
                    </div>

                    <!-- 11. Nomor Induk Kopdeskel -->
                    <div class="mb-3">
                        <label class="form-label">Nomor Induk Kopdeskel</label>
                        <input type="text" name="nomor_induk" class="form-control" placeholder="Masukkan nomor induk">
                    </div>

                    <!-- 12. Jumlah anggota Kopdeskel -->
                    <div class="mb-3">
                        <label class="form-label">Jumlah Anggota - Laki-Laki</label>
                        <input type="number" name="jumlah_anggota_laki" class="form-control" placeholder="Masukkan jumlah anggota laki-laki">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Anggota - Perempuan</label>
                        <input type="number" name="jumlah_anggota_perempuan" class="form-control" placeholder="Masukkan jumlah anggota perempuan">
                    </div>

                    <!-- 13. Koordinat Lokasi -->
                    <div class="mb-3">
                        <label class="form-label">Koordinat Lokasi</label>
                        <input type="text" name="koordinat_lokasi" class="form-control" placeholder="Masukkan koordinat lokasi">
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('forms.profil_knmp.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary ms-2">Simpan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection