<form method="POST" action="{{ route('survey.forms.store_informasi_responden', ['knmp' => $knmp->id]) }}">
    @csrf
    {{-- Hidden field untuk knmp_id (asumsi) --}}
    <input type="hidden" name="knmp_id" value="{{ $knmp->id ?? '' }}">

    <div class="row">
        <div class="col-md-6">

            <div class="mb-3">
                <label class="form-label">Nama Responden</label>
                <input type="text" name="nama_responden" class="form-control" value="{{ old('nama_responden') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Induk Kependudukan (NIK)</label>
                <input type="text" name="nik" class="form-control" value="{{ old('nik') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Kusuka</label>
                <input type="text" name="nomor_kusuka" class="form-control" value="{{ old('nomor_kusuka') }}">
            </div>

            <label class="form-label">Tempat, Tanggal Lahir</label>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir"
                            value="{{ old('tempat_lahir') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                            value="{{ old('tanggal_lahir') }}">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Umur</label>
                <input type="number" name="umur" id="umur" class="form-control" readonly value="{{ old('umur') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select">
                    <option value="" {{ old('jenis_kelamin') == '' ? 'selected' : '' }}>-- Pilih --</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                    </option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Suku Bangsa</label>
                <input type="text" name="suku_bangsa" class="form-control" value="{{ old('suku_bangsa') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Pendidikan terakhir</label>
                <input type="text" name="pendidikan_terakhir" class="form-control"
                    value="{{ old('pendidikan_terakhir') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">WPP Penangkapan Ikan</label>
                <input type="text" name="wpp" class="form-control" value="{{ old('wpp') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat (Jl/RT/RW)</label>
                <input type="text" name="alamat" class="form-control" placeholder="Jl/RT/RW"
                    value="{{ old('alamat') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah anggota keluarga yang tinggal di rumah</label>
                <input type="number" name="jumlah_anggota_rumah" class="form-control"
                    value="{{ old('jumlah_anggota_rumah') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah anggota keluarga perempuan yg tinggal di rumah</label>
                <input type="number" name="jumlah_anggota_perempuan_rumah" class="form-control"
                    value="{{ old('jumlah_anggota_perempuan_rumah') }}">
            </div>
        </div>

        <div class="col-md-6">

            <div class="mb-3">
                <label class="form-label">Jumlah anggota keluarga yang bekerja</label>
                <input type="number" name="jumlah_anggota_bekerja" class="form-control"
                    value="{{ old('jumlah_anggota_bekerja') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah anggota keluarga perempuan yang bekerja</label>
                <input type="number" name="jumlah_anggota_perempuan_bekerja" class="form-control"
                    value="{{ old('jumlah_anggota_perempuan_bekerja') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah ABK dalam satu kapal</label>
                <input type="number" name="jumlah_abk" class="form-control" value="{{ old('jumlah_abk') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Pengalaman Usaha (Tahun)</label>
                <input type="number" name="pengalaman_usaha" class="form-control" value="{{ old('pengalaman_usaha') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Provinsi</label>
                <select class="form-control select2" name="province_id" id="province_id" data-toggle="select2">
                    @foreach ($provinces as $prov)
                        <option value="{{ $prov->id }}" {{ $knmp->province_id == $prov->id ? 'selected' : '' }}>
                            {{ $prov->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Kabupaten</label>
                <select class="form-control select2" name="regency_id" id="regency_id" data-toggle="select2">
                    @foreach ($regencies as $kab)
                        <option value="{{ $kab->id }}" {{ $knmp->regency_id == $kab->id ? 'selected' : '' }}>
                            {{ $kab->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Kecamatan</label>
                <select class="form-control select2" name="district_id" id="district_id" data-toggle="select2">
                    @foreach ($districts as $kec)
                        <option value="{{ $kec->id }}" {{ $knmp->district_id == $kec->id ? 'selected' : '' }}>
                            {{ $kec->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Desa</label>
                <select class="form-control select2" name="village_id" id="village_id" data-toggle="select2">
                    @foreach ($villages as $desa)
                        <option value="{{ $desa->id }}" {{ $knmp->village_id == $desa->id ? 'selected' : '' }}>
                            {{ $desa->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">No. Telp/HP Responden</label>
                <input type="text" name="no_hp_responden" class="form-control" value="{{ old('no_hp_responden') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Wawancara</label>
                <input type="date" name="tanggal_wawancara" class="form-control" value="{{ old('tanggal_wawancara') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Enumerator</label>
                <input type="text" name="nama_enumerator" class="form-control" value="{{ old('nama_enumerator') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Kelamin Enumerator</label>
                <select name="jenis_kelamin_enumerator" class="form-select">
                    <option value="" {{ old('jenis_kelamin_enumerator') == '' ? 'selected' : '' }}>-- Pilih --</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin_enumerator') == 'Laki-laki' ? 'selected' : '' }}>
                        Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin_enumerator') == 'Perempuan' ? 'selected' : '' }}>
                        Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">No. HP Enumerator</label>
                <input type="text" name="no_hp_enumerator" class="form-control" value="{{ old('no_hp_enumerator') }}">
            </div>

        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Hitung umur otomatis
        const tanggalLahirInput = document.getElementById('tanggal_lahir');
        const umurInput = document.getElementById('umur');

        if (tanggalLahirInput) {
            // Memanggil fungsi kalkulasi saat DOM dimuat (untuk kasus edit)
            if (tanggalLahirInput.value) {
                hitungUmur();
            }

            tanggalLahirInput.addEventListener('change', hitungUmur);
        }

        function hitungUmur() {
            if (!tanggalLahirInput || !tanggalLahirInput.value) {
                if (umurInput) umurInput.value = '';
                return;
            }
            const today = new Date();
            const birthDate = new Date(tanggalLahirInput.value);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            if (umurInput) umurInput.value = age >= 0 ? age : '';
        }

        // Cascading dropdown
        const provinsi = document.getElementById('province_id');
        const kabupaten = document.getElementById('regency_id');
        const kecamatan = document.getElementById('district_id');
        const desa = document.getElementById('village_id');

        if (provinsi && kabupaten && kecamatan && desa) {
            provinsi.addEventListener('change', function () {
                kabupaten.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';
                kecamatan.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                desa.innerHTML = '<option value="">-- Pilih Desa --</option>';
            });

            kabupaten.addEventListener('change', function () {
                kecamatan.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                desa.innerHTML = '<option value="">-- Pilih Desa --</option>';
            });

            kecamatan.addEventListener('change', function () {
                desa.innerHTML = '<option value="">-- Pilih Desa --</option>';
            });
        }
    });
</script>

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush