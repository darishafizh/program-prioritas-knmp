<div class="card mb-4">
    <div class="card-body">

        <!-- 1. Penjualan Ikan per Trip -->
        <h5 class="mb-3">1. Penjualan Ikan Hasil Tangkapan per Trip</h5>
        <table class="table table-bordered table-sm">
            <thead class="table-light">
                <tr>
                    <th style="width:30px">No</th>
                    <th>Jenis Pemasaran</th>
                    <th>Total Penjualan (Kg/Trip)</th>
                </tr>
            </thead>
            <tbody>
                @php
                $pemasaranOptions = [
                'langsung_pasar' => 'Langsung ke pasar/pembeli eceran',
                'koperasi' => 'Koperasi',
                'tengkulak' => 'Tengkulak',
                'pengepul' => 'Pengepul',
                'pedagang_besar' => 'Pedagang Besar (PT, CV, BUMD, BUMDES)',
                'lainnya' => 'Lainnya'
                ];
                @endphp

                @foreach($pemasaranOptions as $key => $label)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $label }}</td>
                    <td>
                        <input type="number" step="0.01" min="0"
                            name="penjualan_{{ $key }}"
                            class="form-control"
                            value="{{ old('penjualan_'.$key, $data->{$key} ?? '') }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- 2. Kendala mekanisme pemasaran -->
        <div class="mb-3 mt-4">
            <label class="form-label">2. Apakah terdapat kendala mekanisme pemasaran hasil tangkapan? Jelaskan</label>
            <textarea name="kendala_pemasaran" class="form-control" rows="3">{{ old('kendala_pemasaran', $data->kendala_pemasaran ?? '') }}</textarea>
        </div>

        <!-- 3. Cara penanganan ikan -->
        <div class="mb-3">
            <label class="form-label">3. Bagaimana cara penanganan ikan? Jelaskan</label>
            <textarea name="cara_penanganan_ikan" class="form-control" rows="3">{{ old('cara_penanganan_ikan', $data->cara_penanganan_ikan ?? '') }}</textarea>
        </div>

    </div>
</div>