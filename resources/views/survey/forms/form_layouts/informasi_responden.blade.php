<form method="POST" action="{{ route('forms.store_informasi_responden', ['knmp' => $knmp->id]) }}">
    @csrf
    {{-- Hidden field untuk knmp_id (asumsi) --}}
    <input type="hidden" name="knmp_id" value="{{ $knmp->id ?? '' }}">

    {{-- ========================= --}}
    {{-- PILIH RESPONDEN --}}
    {{-- ========================= --}}
    <div class="mb-4">
        <label class="form-label fw-bold">
            Responden
        </label>

        <select name="responden_id_select"
            class="form-select @error('responden_id_select') is-invalid @enderror"
            required>
            <option value="">-- Pilih Responden --</option>
            @foreach ($respondenList as $r)
            @php
                $isSelected = old('responden_id_select') == $r->id || 
                             ($selectedRespondenId && $selectedRespondenId == $r->id && !old('responden_id_select')) ||
                             (isset($selectedRespondenData['informasi_responden']) && $selectedRespondenData['informasi_responden'] && $selectedRespondenData['informasi_responden']->id == $r->id && !old('responden_id_select'));
            @endphp
            <option value="{{ $r->id }}" {{ $isSelected ? 'selected' : '' }}>
                {{ $r->nama_responden }} ({{ $r->nik }})
            </option>
            @endforeach
        </select>

        @error('responden_id_select')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

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
                        <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" value="{{ old('tempat_lahir') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
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
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Suku Bangsa</label>
                <input type="text" name="suku_bangsa" class="form-control" value="{{ old('suku_bangsa') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Pendidikan terakhir</label>
                <input type="text" name="pendidikan_terakhir" class="form-control" value="{{ old('pendidikan_terakhir') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">WPP Penangkapan Ikan</label>
                <input type="text" name="wpp" class="form-control" value="{{ old('wpp') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat (Jl/RT/RW)</label>
                <input type="text" name="alamat" class="form-control" placeholder="Jl/RT/RW" value="{{ old('alamat') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah anggota keluarga yang tinggal di rumah</label>
                <input type="number" name="jumlah_anggota_rumah" class="form-control" value="{{ old('jumlah_anggota_rumah') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah anggota keluarga perempuan yg tinggal di rumah</label>
                <input type="number" name="jumlah_anggota_perempuan_rumah" class="form-control" value="{{ old('jumlah_anggota_perempuan_rumah') }}">
            </div>
        </div>

        <div class="col-md-6">

            <div class="mb-3">
                <label class="form-label">Jumlah anggota keluarga yang bekerja</label>
                <input type="number" name="jumlah_anggota_bekerja" class="form-control" value="{{ old('jumlah_anggota_bekerja') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah anggota keluarga perempuan yang bekerja</label>
                <input type="number" name="jumlah_anggota_perempuan_bekerja" class="form-control" value="{{ old('jumlah_anggota_perempuan_bekerja') }}">
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
                <input type="date" name="tanggal_wawancara" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Enumerator</label>
                <input type="text" name="nama_enumerator" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Kelamin Enumerator</label>
                <select name="jenis_kelamin_enumerator" class="form-select">
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">No. HP Enumerator</label>
                <input type="text" name="no_hp_enumerator" class="form-control">
            </div>

        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hitung umur otomatis
        const tanggalLahirInput = document.getElementById('tanggal_lahir');
        const umurInput = document.getElementById('umur');

        // Memanggil fungsi kalkulasi saat DOM dimuat (untuk kasus edit)
        if (tanggalLahirInput.value) {
            hitungUmur();
        }

        tanggalLahirInput.addEventListener('change', hitungUmur);

        function hitungUmur() {
            if (!tanggalLahirInput.value) {
                umurInput.value = '';
                return;
            }
            const today = new Date();
            const birthDate = new Date(tanggalLahirInput.value);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            umurInput.value = age >= 0 ? age : '';
        }

        // Cascading dropdown (diasumsikan fungsi AJAX akan ditambahkan nanti)
        const provinsi = document.getElementById('provinsi');
        const kabupaten = document.getElementById('kabupaten');
        const kecamatan = document.getElementById('kecamatan');
        const desa = document.getElementById('desa');

        provinsi.addEventListener('change', function() {
            kabupaten.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';
            kecamatan.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
            desa.innerHTML = '<option value="">-- Pilih Desa --</option>';
        });

        kabupaten.addEventListener('change', function() {
            kecamatan.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
            desa.innerHTML = '<option value="">-- Pilih Desa --</option>';
        });

        kecamatan.addEventListener('change', function() {
            desa.innerHTML = '<option value="">-- Pilih Desa --</option>';
        });

        // Inisialisasi Select2
        // Pastikan JQuery (jika Select2 membutuhkannya) sudah di-load di layout utama.
        // if (typeof jQuery !== 'undefined') {
        //     $('.select2').select2({
        //         placeholder: 'Pilih...',
        //         allowClear: true,
        //         width: '100%'
        //     });
        // }
    });
</script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>