<form method="POST" action="{{ route('forms.informasi_responden.store') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label"><strong>1. Nama Responden</strong></label>
        <input type="text" name="nama_responden" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>2. Nomor Induk Kependudukan (NIK)</strong></label>
        <input type="text" name="nik" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>3. Nomor Kusuka</strong></label>
        <input type="text" name="nomor_kusuka" class="form-control">
    </div>

    <!-- Tempat dan Tanggal Lahir -->
    <div class="mb-3">
        <label class="form-label"><strong>4. Tempat Lahir</strong></label>
        <input type="text" name="tempat_lahir" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>5. Tanggal Lahir</strong></label>
        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>6. Umur</strong></label>
        <input type="number" name="umur" id="umur" class="form-control" readonly>
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>7. Jenis Kelamin</strong></label>
        <select name="jenis_kelamin" class="form-select">
            <option value="">-- Pilih --</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
    </div>

    <!-- Jumlah anggota keluarga -->
    <div class="mb-3">
        <label class="form-label"><strong>8. Jumlah anggota keluarga yang tinggal di rumah</strong></label>
        <input type="number" name="jumlah_anggota_rumah" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>9. Jumlah anggota keluarga perempuan yg tinggal di rumah</strong></label>
        <input type="number" name="jumlah_anggota_perempuan_rumah" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>10. Jumlah anggota keluarga yang bekerja</strong></label>
        <input type="number" name="jumlah_anggota_bekerja" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>11. Jumlah anggota keluarga perempuan yang bekerja</strong></label>
        <input type="number" name="jumlah_anggota_perempuan_bekerja" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>12. Suku Bangsa</strong></label>
        <input type="text" name="suku_bangsa" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>13. Pendidikan terakhir</strong></label>
        <input type="text" name="pendidikan_terakhir" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>14. Jumlah ABK dalam satu kapal</strong></label>
        <input type="number" name="jumlah_abk" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>15. Pengalaman Usaha (Tahun)</strong></label>
        <input type="number" name="pengalaman_usaha" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>16. WPP Penangkapan Ikan</strong></label>
        <input type="text" name="wpp" class="form-control">
    </div>

    <!-- Alamat cascading dropdown -->
    <div class="mb-3">
        <label class="form-label"><strong>17. Provinsi</strong></label>
        <select name="provinsi" id="provinsi" class="form-select select2">
            <option value="">-- Pilih Provinsi --</option>
            <!-- nanti diisi dari database -->
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>18. Kabupaten</strong></label>
        <select name="kabupaten" id="kabupaten" class="form-select select2">
            <option value="">-- Pilih Kabupaten --</option>
            <!-- otomatis filter berdasarkan provinsi -->
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>19. Kecamatan</strong></label>
        <select name="kecamatan" id="kecamatan" class="form-select select2">
            <option value="">-- Pilih Kecamatan --</option>
            <!-- otomatis filter berdasarkan kabupaten -->
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>20. Desa</strong></label>
        <select name="desa" id="desa" class="form-select select2">
            <option value="">-- Pilih Desa --</option>
            <!-- otomatis filter berdasarkan kecamatan -->
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>21. Alamat (Jl/RT/RW)</strong></label>
        <input type="text" name="alamat" class="form-control" placeholder="Jl/RT/RW">
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>22. No. Telp/HP Responden</strong></label>
        <input type="text" name="no_hp_responden" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>23. Tanggal Wawancara</strong></label>
        <input type="date" name="tanggal_wawancara" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>24. Nama Enumerator</strong></label>
        <input type="text" name="nama_enumerator" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>25. Jenis Kelamin Enumerator</strong></label>
        <select name="jenis_kelamin_enumerator" class="form-select">
            <option value="">-- Pilih --</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>26. No. HP Enumerator</strong></label>
        <input type="text" name="no_hp_enumerator" class="form-control">
    </div>

    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('forms.index') }}" class="btn btn-secondary me-2">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan Informasi</button>
    </div>
</form>

<!-- Script untuk menghitung umur otomatis dan cascading dropdown -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hitung umur otomatis
        const tanggalLahirInput = document.getElementById('tanggal_lahir');
        const umurInput = document.getElementById('umur');
        tanggalLahirInput.addEventListener('change', function() {
            const today = new Date();
            const birthDate = new Date(this.value);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            umurInput.value = age >= 0 ? age : '';
        });

        // Cascading dropdown kosong (nanti bisa pakai AJAX)
        const provinsi = document.getElementById('provinsi');
        const kabupaten = document.getElementById('kabupaten');
        const kecamatan = document.getElementById('kecamatan');
        const desa = document.getElementById('desa');

        provinsi.addEventListener('change', function() {
            // Kosongkan dropdown berikutnya
            kabupaten.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';
            kecamatan.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
            desa.innerHTML = '<option value="">-- Pilih Desa --</option>';
            // nanti bisa AJAX untuk load kabupaten
        });

        kabupaten.addEventListener('change', function() {
            kecamatan.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
            desa.innerHTML = '<option value="">-- Pilih Desa --</option>';
            // nanti bisa AJAX untuk load kecamatan
        });

        kecamatan.addEventListener('change', function() {
            desa.innerHTML = '<option value="">-- Pilih Desa --</option>';
            // nanti bisa AJAX untuk load desa
        });

        // Jika pakai Select2, inisialisasi
        $('.select2').select2({
            placeholder: 'Pilih...',
            allowClear: true,
            width: '100%'
        });
    });
</script>

<!-- Pastikan sudah include Select2 CSS & JS di layout -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>