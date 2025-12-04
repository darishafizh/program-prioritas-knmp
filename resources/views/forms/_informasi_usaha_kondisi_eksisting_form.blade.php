<div class="container">
    <h5 class="mb-3">1. Kapal dan Jenis Alat Tangkap</h5>

    <form method="POST" action="{{ $route }}">
        @csrf
        @if($method === 'PUT')
        @method('PUT')
        @endif

        <div class="card mb-4">
            <div class="card-body">

                <!-- 1. Nama Kapal Perikanan -->
                <div class="mb-3">
                    <label class="form-label">Nama Kapal Perikanan</label>
                    <input type="text" name="nama_kapal" class="form-control"
                        value="{{ $data->nama_kapal ?? '' }}">
                </div>

                <!-- 2. Tahun Pembuatan Kapal -->
                <div class="mb-3">
                    <label class="form-label">Tahun Pembuatan Kapal</label>
                    <input type="number" name="tahun_pembuatan" class="form-control"
                        value="{{ $data->tahun_pembuatan ?? '' }}">
                </div>

                <!-- 3. Ukuran Perahu / GT -->
                <div class="mb-3">
                    <label class="form-label">Ukuran Perahu / Tonase Kotor (GT)</label>
                    <input type="text" name="ukuran_gt" class="form-control"
                        value="{{ $data->ukuran_gt ?? '' }}">
                </div>

                <!-- 4. Dimensi Perahu -->
                <div class="mb-3">
                    <label class="form-label">Dimensi Perahu (Panjang x Lebar x Dalam)</label>
                    <input type="text" name="dimensi_perahu" class="form-control"
                        value="{{ $data->dimensi_perahu ?? '' }}">
                </div>

                <!-- 5. Jenis Bahan Baku Kapal -->
                <div class="mb-3">
                    <label class="form-label">Jenis Bahan Baku Kapal</label>
                    <select name="bahan_baku" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Fiber" {{ ($data->bahan_baku ?? '') == 'Fiber' ? 'selected' : '' }}>Fiber</option>
                        <option value="Kayu" {{ ($data->bahan_baku ?? '') == 'Kayu' ? 'selected' : '' }}>Kayu</option>
                        <option value="Besi" {{ ($data->bahan_baku ?? '') == 'Besi' ? 'selected' : '' }}>Besi</option>
                        <option value="Kayu Laminasi" {{ ($data->bahan_baku ?? '') == 'Kayu Laminasi' ? 'selected' : '' }}>Kayu Laminasi</option>
                        <option value="Lainnya" {{ ($data->bahan_baku ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <!-- 6. Jenis Alat Tangkap -->
                <div class="mb-3">
                    <label class="form-label">Jenis Alat Tangkap</label>
                    <select name="alat_tangkap" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Handline/Pancing Ulur">Handline/Pancing Ulur</option>
                        <option value="Rawai Dasar">Rawai Dasar</option>
                        <option value="Pancing Dasar">Pancing Dasar</option>
                        <option value="Gillnet">Jaring Insang / Gillnet</option>
                        <option value="Pole and Line">Pole and Line</option>
                        <option value="Purse Seine">Purse Seine</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- 7. Jenis Mesin Motor -->
                <div class="mb-3">
                    <label class="form-label">Jenis Mesin Motor</label>
                    <select name="mesin_motor" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Motor Tempel Bantuan">Motor Tempel Bantuan</option>
                        <option value="Motor Tempel Pribadi">Motor Tempel Pribadi</option>
                        <option value="Sampan (tanpa motor)">Sampan (tanpa motor)</option>
                    </select>
                </div>

                <!-- 8. Alat Penyimpanan Ikan -->
                <div class="mb-3">
                    <label class="form-label">Jenis Alat Penyimpanan Ikan</label>
                    <select name="alat_penyimpanan" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Palka">Palka</option>
                        <option value="Coolbox">Coolbox</option>
                        <option value="Stereofoam Box">Stereofoam Box</option>
                        <option value="Tong Plastik">Tong Plastik</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

            </div>
        </div>

        <!-- ============================= -->
        <!-- 2. DATA PRODUKSI PERIKANAN -->
        <!-- ============================= -->
        <h5 class="mb-3">2. Data Produksi Perikanan</h5>

        <div class="card mb-4">
            <div class="card-body">

                @php
                $produksi = [
                'hari_per_trip' => 'Jumlah hari per trip (hari/trip)',
                'lama_melaut' => 'Lama waktu melaut (jam/trip)',
                'jarak_daerah' => 'Jarak ke daerah penangkapan (mil)',
                'waktu_tempuh' => 'Waktu tempuh ke daerah penangkapan (jam)',
                'trip_bulanan' => 'Jumlah trip/bulan',
                'bulan_melaut' => 'Jumlah bulan melaut',
                'produksi_trip' => 'Rata-rata Produksi Per Trip (Kg)',
                'penjualan_trip' => 'Rata-rata Penjualan Ikan Per Trip (Rp)',
                'biaya_solar' => 'Biaya Solar Per Trip (Rp)',
                'volume_solar' => 'Volume Solar Per Trip (Liter)',
                'biaya_bensin' => 'Biaya Bensin Per Trip (Rp)',
                'volume_bensin' => 'Volume Bensin Per Trip (Liter)',
                'biaya_es_balok' => 'Biaya Es Balok Pabrik Per Trip (Rp)',
                'volume_es_balok' => 'Volume Es Balok Per Trip (Balok)',
                'biaya_es_kantong' => 'Biaya Es Kantong Per Trip (Rp)',
                'volume_es_kantong' => 'Volume Es Kantong Per Trip (Kantong)',
                'total_operasional' => 'Total Biaya Operasional Per Trip (Rp)',
                ];
                @endphp

                @foreach($produksi as $field => $label)
                <div class="mb-3">
                    <label class="form-label">{{ $label }}</label>
                    <input type="number" step="0.01" name="{{ $field }}" class="form-control"
                        value="{{ $data->$field ?? '' }}">
                </div>
                @endforeach

            </div>
        </div>


        <!-- ============================= -->
        <!-- 3. JENIS IKAN HASIL PRODUKSI -->
        <!-- ============================= -->
        <h5 class="mb-3">3. Jenis Ikan Hasil Produksi</h5>

        <div class="card mb-4">
            <div class="card-body">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Ikan</th>
                            <th>Kondisi Saat Ini</th>
                            <th>% dari Produksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=1; $i<=2; $i++)
                            <tr>
                            <td>{{ $i }}</td>
                            <td><input type="text" class="form-control" name="ikan_jenis_{{ $i }}"
                                    value="{{ $data->{'ikan_jenis_'.$i} ?? '' }}"></td>

                            <td><input type="text" class="form-control" name="ikan_kondisi_{{ $i }}"
                                    value="{{ $data->{'ikan_kondisi_'.$i} ?? '' }}"></td>

                            <td><input type="number" class="form-control" name="ikan_persen_{{ $i }}"
                                    value="{{ $data->{'ikan_persen_'.$i} ?? '' }}"></td>
                            </tr>
                            @endfor
                            <tr>
                                <td colspan="3"><strong>Total</strong></td>
                                <td><strong>100%</strong></td>
                            </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>

    </form>
</div>