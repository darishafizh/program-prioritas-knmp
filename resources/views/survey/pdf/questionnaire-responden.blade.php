<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuesioner {{ $responden->nama_responden }}</title>
    <style>
        @page {
            margin: 18mm 16mm 18mm 16mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
            color: #2d3748;
            background: #ffffff;
            font-size: 10px;
        }

        .page {
            page-break-after: always;
            padding: 5px;
        }

        .page:last-child {
            page-break-after: avoid;
        }

        /* ================================ */
        /* HEADER */
        /* ================================ */
        .header {
            width: 100%;
            border-bottom: 2px solid #2b579a;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }

        .header-table {
            width: 100%;
            border: none;
            border-collapse: collapse;
        }

        .header-table td {
            border: none;
            vertical-align: middle;
            padding: 0;
        }

        .header-logo {
            width: 65px;
            text-align: left;
        }

        .header-logo img {
            width: 55px;
            height: auto;
        }

        .header-text {
            text-align: center;
            padding: 0 15px;
        }

        .header-title {
            font-size: 15px;
            font-weight: bold;
            color: #2b579a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .header-subtitle {
            font-size: 11px;
            font-weight: bold;
            color: #444444;
            margin-bottom: 3px;
        }

        .header-ministry {
            font-size: 9px;
            color: #777777;
        }

        /* ================================ */
        /* KNMP INFO BOX */
        /* ================================ */
        .knmp-box {
            width: 100%;
            background-color: #f8fafc;
            border: 1px solid #cbd5e0;
            border-radius: 4px;
            padding: 14px 18px;
            margin-bottom: 18px;
            text-align: center;
        }

        .knmp-name {
            font-size: 12px;
            font-weight: bold;
            color: #2b579a;
            margin-bottom: 6px;
        }

        .knmp-location {
            font-size: 10px;
            color: #4a5568;
            line-height: 1.5;
        }

        /* ================================ */
        /* SECTION TITLE */
        /* ================================ */
        .section-title {
            background-color: #2b579a;
            color: #ffffff;
            padding: 10px 16px;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 0.3px;
            margin-bottom: 14px;
            border-radius: 3px;
        }

        .sub-section-title {
            font-size: 10px;
            font-weight: bold;
            color: #2b579a;
            padding: 6px 0;
            margin: 14px 0 10px 0;
            border-bottom: 1px solid #cbd5e0;
        }

        /* ================================ */
        /* INFO BOX */
        /* ================================ */
        .info-box {
            width: 100%;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 3px solid #2b579a;
            border-radius: 0 4px 4px 0;
            padding: 14px 18px;
            margin-bottom: 14px;
        }

        .info-table {
            width: 100%;
            border: none;
            border-collapse: collapse;
        }

        .info-table td {
            border: none;
            padding: 6px 0;
            vertical-align: top;
        }

        .info-label {
            width: 38%;
            font-weight: bold;
            color: #4a5568;
            font-size: 10px;
        }

        .info-value {
            width: 62%;
            color: #1a202c;
            font-size: 10px;
        }

        /* ================================ */
        /* TABLE */
        /* ================================ */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 9px;
        }

        .data-table th {
            background-color: #2b579a;
            color: #ffffff;
            padding: 9px 12px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
            border: 1px solid #2b579a;
        }

        .data-table td {
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
            background-color: #ffffff;
        }

        .data-table tr:nth-child(even) td {
            background-color: #f7fafc;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* ================================ */
        /* BADGE */
        /* ================================ */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            font-size: 8px;
            font-weight: bold;
            border-radius: 3px;
        }

        .badge-success {
            background-color: #c6f6d5;
            color: #22543d;
            border: 1px solid #9ae6b4;
        }

        .badge-warning {
            background-color: #fefcbf;
            color: #744210;
            border: 1px solid #f6e05e;
        }

        .badge-info {
            background-color: #bee3f8;
            color: #2a4365;
            border: 1px solid #90cdf4;
        }

        /* ================================ */
        /* DIVIDER */
        /* ================================ */
        .divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 16px 0;
        }

        /* ================================ */
        /* IMAGE GALLERY */
        /* ================================ */
        .image-item {
            display: inline-block;
            width: 30%;
            margin: 1%;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            vertical-align: top;
        }

        .image-item img {
            width: 100%;
            height: auto;
            max-height: 130px;
        }

        .image-caption {
            padding: 6px 8px;
            font-size: 8px;
            background-color: #f7fafc;
            border-top: 1px solid #e2e8f0;
        }

        /* ================================ */
        /* COVER PAGE */
        /* ================================ */
        .cover-center {
            text-align: center;
            padding: 35px 0;
        }

        .cover-title {
            font-size: 17px;
            font-weight: bold;
            color: #2b579a;
            margin: 18px 0 8px 0;
        }

        .cover-subtitle {
            font-size: 10px;
            color: #718096;
            margin-bottom: 25px;
        }

        .cover-info {
            width: 75%;
            margin: 0 auto;
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 18px 22px;
        }

        .cover-info-table {
            width: 100%;
            border: none;
            border-collapse: collapse;
        }

        .cover-info-table td {
            border: none;
            padding: 7px 12px;
            font-size: 10px;
        }

        /* ================================ */
        /* NOTE BOX */
        /* ================================ */
        .note-box {
            background-color: #ebf8ff;
            border-left: 3px solid #4299e1;
            border-radius: 0 4px 4px 0;
            padding: 12px 16px;
            margin: 16px 0;
            font-size: 9px;
            color: #2c5282;
            line-height: 1.5;
        }

        /* ================================ */
        /* SECTION WRAPPER */
        /* ================================ */
        .section {
            margin-bottom: 16px;
        }
    </style>
</head>

<body>
    {{-- ============================= --}}
    {{-- HALAMAN 1: COVER & INFO --}}
    {{-- ============================= --}}
    <div class="page">
        <div class="header">
            <table class="header-table">
                <tr>
                    <td class="header-logo">
                        @php
                            $path = public_path('assets/images/logo-kkp.png');
                            $logoExists = file_exists($path);
                        @endphp
                        @if($logoExists)
                            <img src="{{ $path }}" alt="Logo KKP">
                        @endif
                    </td>
                    <td class="header-text">
                        <div class="header-title">Kuesioner Survei KNMP</div>
                        <div class="header-subtitle">Kampung Nelayan Merah Putih</div>
                        <div class="header-ministry">Kementerian Kelautan dan Perikanan Republik Indonesia</div>
                    </td>
                    <td style="width: 70px;"></td>
                </tr>
            </table>
        </div>

        <div class="knmp-box">
            <div class="knmp-name">{{ $knmp->nama ?? 'Kampung Nelayan' }}</div>
            <div class="knmp-location">
                Desa {{ $knmp->desa_kelurahan ?? 'N/A' }}, Kec. {{ $knmp->kecamatan ?? 'N/A' }},
                Kab. {{ $knmp->kabupaten_kota ?? 'N/A' }}, Prov. {{ $knmp->provinsi ?? 'N/A' }}
            </div>
        </div>

        <hr class="divider">

        <div class="info-box">
            <table class="info-table">
                <tr>
                    <td class="info-label">Nama Responden</td>
                    <td class="info-value"><strong
                            style="color: #1a202c; font-size: 11px;">{{ $responden->nama_responden }}</strong></td>
                </tr>
                <tr>
                    <td class="info-label">NIK</td>
                    <td class="info-value" style="color: #2d3748;">{{ $responden->nik }}</td>
                </tr>
                <tr>
                    <td class="info-label">Tanggal Wawancara</td>
                    <td class="info-value" style="color: #2d3748;">
                        {{ \Carbon\Carbon::parse($responden->tanggal_wawancara)->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="info-label">Enumerator</td>
                    <td class="info-value" style="color: #2d3748;">{{ $responden->nama_enumerator }}</td>
                </tr>
            </table>
        </div>

        <div class="note-box">
            Dokumen ini berisi hasil kuesioner lengkap yang telah diisi oleh responden.
            Informasi detail responden terdapat pada Section E.
        </div>
    </div>

    {{-- ============================= --}}
    {{-- A. PROFIL KNMP --}}
    {{-- ============================= --}}
    @if($profileKnmp)
        <div class="page">
            <div class="section-title">A. Profil KNMP</div>

            <div class="section">
                <div class="info-box">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Jumlah Penduduk</td>
                            <td class="info-value">{{ number_format($profileKnmp->jml_penduduk_des ?? 0, 0, ',', '.') }}
                                jiwa</td>
                        </tr>
                        <tr>
                            <td class="info-label">Jumlah Nelayan</td>
                            <td class="info-value">{{ number_format($profileKnmp->jml_nelayan ?? 0, 0, ',', '.') }} orang
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label">Pendapatan Rata-rata</td>
                            <td class="info-value">Rp
                                {{ number_format($profileKnmp->pendapatan_rata_rata_nelayan ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Volume Produksi</td>
                            <td class="info-value">{{ number_format($profileKnmp->volume_produksi_ton ?? 0, 2, ',', '.') }}
                                ton/tahun</td>
                        </tr>
                        <tr>
                            <td class="info-label">Nilai Produksi</td>
                            <td class="info-value">Rp {{ number_format($profileKnmp->nilai_produksi ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label">Komoditas Utama</td>
                            <td class="info-value">
                                {{ $profileKnmp->komoditas_utama_1 ?? '-' }}{{ $profileKnmp->komoditas_utama_2 ? ', ' . $profileKnmp->komoditas_utama_2 : '' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- ============================= --}}
    {{-- B. PROSES PEMBANGUNAN KNMP --}}
    {{-- ============================= --}}
    @if($progresKnmp->count() > 0)
        <div class="page">
            <div class="section-title">B. Proses Pembangunan KNMP</div>

            @foreach($progresKnmp as $progres)
                <div class="section">
                    <div class="sub-section-title">Anggaran & Tenaga Kerja</div>
                    <div class="info-box">
                        <table class="info-table">
                            <tr>
                                <td class="info-label">Anggaran Total</td>
                                <td class="info-value">Rp {{ number_format($progres->anggaran_total ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Anggaran Konstruksi</td>
                                <td class="info-value">Rp {{ number_format($progres->anggaran_konstruksi ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="info-label">Anggaran Sarpras</td>
                                <td class="info-value">Rp {{ number_format($progres->anggaran_sarpras ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Tenaga Kerja Total</td>
                                <td class="info-value">{{ $progres->tk_total ?? 0 }} orang (L: {{ $progres->tk_laki ?? 0 }}, P:
                                    {{ $progres->tk_perempuan ?? 0 }})</td>
                            </tr>
                            <tr>
                                <td class="info-label">Tenaga Kerja Lokal</td>
                                <td class="info-value">{{ $progres->tk_lokal ?? 0 }} orang</td>
                            </tr>
                            <tr>
                                <td class="info-label">Tenaga Kerja Luar</td>
                                <td class="info-value">{{ $progres->tk_luar ?? 0 }} orang</td>
                            </tr>
                        </table>
                    </div>

                    @if($progres->details->count() > 0)
                        <div class="sub-section-title">Detail Progres</div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th style="width: 40%;">Komponen</th>
                                    <th style="width: 15%;" class="text-center">Target</th>
                                    <th style="width: 15%;" class="text-center">Progress (%)</th>
                                    <th style="width: 30%;">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($progres->details as $detail)
                                    <tr>
                                        <td>{{ $detail->komponen }}</td>
                                        <td class="text-center">{{ $detail->target ?? '-' }}</td>
                                        <td class="text-center">{{ $detail->persen ?? 0 }}%</td>
                                        <td>{{ $detail->keterangan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- ============================= --}}
    {{-- C. TANGGAPAN MASYARAKAT --}}
    {{-- ============================= --}}
    @if($tanggapanMasyarakat)
        <div class="page">
            <div class="section-title">C. Tanggapan Masyarakat Terkait Pembangunan KNMP</div>

            <div class="section">
                <div class="info-box">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Kesesuaian Kebutuhan</td>
                            <td class="info-value">
                                @if($tanggapanMasyarakat->kesesuaian_kebutuhan)
                                    <span class="badge badge-success">Ya, Sesuai</span>
                                @else
                                    <span class="badge badge-warning">Tidak Sesuai</span>
                                @endif
                            </td>
                        </tr>
                        @if(!$tanggapanMasyarakat->kesesuaian_kebutuhan && $tanggapanMasyarakat->item_tidak_sesuai)
                            <tr>
                                <td class="info-label">Item Tidak Sesuai</td>
                                <td class="info-value">{{ $tanggapanMasyarakat->item_tidak_sesuai }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="info-label">Tingkat Kesenangan</td>
                            <td class="info-value">{{ $tanggapanMasyarakat->tingkat_kesenangan }}</td>
                        </tr>
                        @if($tanggapanMasyarakat->alasan_tidak_senang)
                            <tr>
                                <td class="info-label">Alasan Tidak Senang</td>
                                <td class="info-value">{{ $tanggapanMasyarakat->alasan_tidak_senang }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="info-label">Harapan Masyarakat</td>
                            <td class="info-value">{{ $tanggapanMasyarakat->harapan_masyarakat }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Masukan & Saran</td>
                            <td class="info-value">{{ $tanggapanMasyarakat->masukan_saran_perbaikan }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- ============================= --}}
    {{-- D. TINGKAT KEBAHAGIAAN NELAYAN --}}
    {{-- ============================= --}}
    @if($tingkatKebahagiaan->count() > 0)
        <div class="page">
            <div class="section-title">D. Tingkat Kebahagiaan Nelayan</div>

            @foreach($tingkatKebahagiaan as $kategori => $soals)
                <div class="section">
                    <div class="sub-section-title">{{ ucfirst(str_replace('_', ' ', $kategori)) }}</div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width: 5%;" class="text-center">No</th>
                                <th style="width: 50%;">Pertanyaan</th>
                                <th style="width: 30%;">Jawaban</th>
                                <th style="width: 15%;" class="text-center">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($soals as $soal)
                                <tr>
                                    <td class="text-center">{{ $soal->nomor_soal }}</td>
                                    <td>{{ $tingkatKebahagiaan_pertanyaan[$soal->kategori][$soal->nomor_soal] ?? 'Soal ' . $soal->nomor_soal }}
                                    </td>
                                    <td>{{ $soal->jawaban_teks }}</td>
                                    <td class="text-center">{{ $soal->skor_nilai }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    @endif

    {{-- ============================= --}}
    {{-- E. INFORMASI RESPONDEN --}}
    {{-- ============================= --}}
    @if($responden)
        <div class="page">
            <div class="section-title">E. Informasi Responden</div>

            <div class="section">
                <div class="info-box">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Nama Responden</td>
                            <td class="info-value"><strong>{{ $responden->nama_responden }}</strong></td>
                        </tr>
                        <tr>
                            <td class="info-label">NIK</td>
                            <td class="info-value">{{ $responden->nik }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Jenis Kelamin</td>
                            <td class="info-value">{{ $responden->jenis_kelamin }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Tanggal Lahir</td>
                            <td class="info-value">{{ \Carbon\Carbon::parse($responden->tanggal_lahir)->format('d/m/Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label">Umur</td>
                            <td class="info-value">{{ $responden->umur }} tahun</td>
                        </tr>
                        <tr>
                            <td class="info-label">Alamat</td>
                            <td class="info-value">{{ $responden->alamat }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">No. HP</td>
                            <td class="info-value">{{ $responden->no_hp_responden }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Pendidikan</td>
                            <td class="info-value">{{ $responden->pendidikan_terakhir }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Tanggal Wawancara</td>
                            <td class="info-value">
                                {{ \Carbon\Carbon::parse($responden->tanggal_wawancara)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Enumerator</td>
                            <td class="info-value">{{ $responden->nama_enumerator }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- ============================= --}}
    {{-- F. INFORMASI USAHA --}}
    {{-- ============================= --}}
    @if($informasiUsaha->count() > 0)
        <div class="page">
            <div class="section-title">F. Informasi Usaha (Kondisi Existing)</div>

            @foreach($informasiUsaha as $usaha)
                <div class="section">
                    <div class="sub-section-title">Data Usaha Perikanan</div>
                    <div class="info-box">
                        <table class="info-table">
                            <tr>
                                <td class="info-label">Nama Kapal</td>
                                <td class="info-value">{{ $usaha->nama_kapal }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Tahun Pembuatan</td>
                                <td class="info-value">{{ $usaha->tahun_pembuatan }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Ukuran (GT)</td>
                                <td class="info-value">{{ $usaha->ukuran_gt ?? '-' }} GT</td>
                            </tr>
                            <tr>
                                <td class="info-label">Jenis Alat Tangkap</td>
                                <td class="info-value">{{ $usaha->jenis_alat_tangkap }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Hari per Trip</td>
                                <td class="info-value">{{ $usaha->hari_per_trip ?? '-' }} hari</td>
                            </tr>
                            <tr>
                                <td class="info-label">Trip per Bulan</td>
                                <td class="info-value">{{ $usaha->jml_trip_per_bulan ?? '-' }} kali</td>
                            </tr>
                            <tr>
                                <td class="info-label">Produksi per Trip</td>
                                <td class="info-value">{{ number_format($usaha->produksi_kg_per_trip ?? 0, 2) }} kg</td>
                            </tr>
                            <tr>
                                <td class="info-label">Penjualan per Trip</td>
                                <td class="info-value">Rp {{ number_format($usaha->penjualan_rp_per_trip ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="info-label">Total Biaya Operasional</td>
                                <td class="info-value">Rp {{ number_format($usaha->total_biaya_operasional ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    @if($usaha->ikan->count() > 0)
                        <div class="sub-section-title">Jenis Ikan Hasil Tangkapan Utama</div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th style="width: 40%;">Jenis Ikan</th>
                                    <th style="width: 30%;" class="text-center">kg/trip</th>
                                    <th style="width: 30%;" class="text-center">Persentase (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usaha->ikan as $ikan)
                                    <tr>
                                        <td>{{ $ikan->jenis }}</td>
                                        <td class="text-center">{{ number_format($ikan->kg_trip, 2) }}</td>
                                        <td class="text-center">{{ $ikan->persen }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- ============================= --}}
    {{-- G. INFORMASI PEMASARAN --}}
    {{-- ============================= --}}
    @if($informasiPemasaran)
        <div class="page">
            <div class="section-title">G. Informasi Pemasaran Hasil Perikanan</div>

            <div class="section">
                <div class="info-box">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Kendala Pemasaran</td>
                            <td class="info-value">{{ $informasiPemasaran->kendala_pemasaran_text }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Cara Penanganan Ikan</td>
                            <td class="info-value">{{ $informasiPemasaran->cara_penanganan_ikan }}</td>
                        </tr>
                    </table>
                </div>

                @if($informasiPemasaran->detail_pemasaran)
                    <div class="sub-section-title">Distribusi Saluran Pemasaran</div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width: 50%;">Saluran Pemasaran</th>
                                <th style="width: 50%;" class="text-center">Kuantitas (kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Eceran</td>
                                <td class="text-center">
                                    {{ number_format($informasiPemasaran->detail_pemasaran->eceran_kg ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Koperasi</td>
                                <td class="text-center">
                                    {{ number_format($informasiPemasaran->detail_pemasaran->koperasi_kg ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Tengkulak</td>
                                <td class="text-center">
                                    {{ number_format($informasiPemasaran->detail_pemasaran->tengkulak_kg ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Pengepul</td>
                                <td class="text-center">
                                    {{ number_format($informasiPemasaran->detail_pemasaran->pengepul_kg ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Pedagang Besar</td>
                                <td class="text-center">
                                    {{ number_format($informasiPemasaran->detail_pemasaran->pedagang_besar_kg ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Lainnya</td>
                                <td class="text-center">
                                    {{ number_format($informasiPemasaran->detail_pemasaran->lainnya_kg ?? 0, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    @endif

    {{-- ============================= --}}
    {{-- H. PENDAPATAN RUMAH TANGGA --}}
    {{-- ============================= --}}
    @if($pendapatanRt)
        <div class="page">
            <div class="section-title">H. Informasi Pendapatan Rumah Tangga</div>

            <div class="section">
                <div class="info-box">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Pendapatan Perikanan</td>
                            <td class="info-value">Rp
                                {{ number_format($pendapatanRt->pendapatan_perikanan ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Pendapatan Non-Perikanan</td>
                            <td class="info-value">Rp
                                {{ number_format($pendapatanRt->pendapatan_non_perikanan ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Pendapatan Total</td>
                            <td class="info-value"><strong>Rp
                                    {{ number_format($pendapatanRt->pendapatan_total ?? 0, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <td class="info-label">Kontribusi Nelayan</td>
                            <td class="info-value">{{ $pendapatanRt->kontribusi_nelayan_persen }}%</td>
                        </tr>
                        <tr>
                            <td class="info-label">Ketergantungan Perikanan</td>
                            <td class="info-value">{{ $pendapatanRt->ketergantungan_perikanan }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Stabilitas Pendapatan</td>
                            <td class="info-value">{{ $pendapatanRt->stabilitas_pendapatan }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Keterlibatan Perempuan</td>
                            <td class="info-value">{{ $pendapatanRt->keterlibatan_perempuan }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Kontribusi Perempuan</td>
                            <td class="info-value">{{ $pendapatanRt->kontribusi_perempuan_persen }}%</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- ============================= --}}
    {{-- I. SOSIAL & KELEMBAGAAN --}}
    {{-- ============================= --}}
    @if($sosialKelembagaan)
        <div class="page">
            <div class="section-title">I. Sosial dan Kelembagaan</div>

            <div class="section">
                <div class="info-box">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Anggota Kelompok</td>
                            <td class="info-value">{{ $sosialKelembagaan->anggota_kelompok ?? '-' }}</td>
                        </tr>
                        @if($sosialKelembagaan->manfaat_kelompok)
                            <tr>
                                <td class="info-label">Manfaat Kelompok</td>
                                <td class="info-value">{{ $sosialKelembagaan->manfaat_kelompok }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="info-label">Anggota Koperasi</td>
                            <td class="info-value">{{ $sosialKelembagaan->anggota_koperasi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Tertarik Koperasi</td>
                            <td class="info-value">{{ $sosialKelembagaan->tertarik_koperasi ?? '-' }}</td>
                        </tr>
                        @if($sosialKelembagaan->manfaat_koperasi)
                            <tr>
                                <td class="info-label">Manfaat Koperasi</td>
                                <td class="info-value">{{ $sosialKelembagaan->manfaat_koperasi }}</td>
                            </tr>
                        @endif
                    </table>
                </div>

                <div class="sub-section-title">Penilaian Kelembagaan Koperasi</div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 50%;">Aspek Penilaian</th>
                            <th style="width: 50%;" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Rapat Tahunan Dilakukan</td>
                            <td class="text-center">{{ $sosialKelembagaan->koperasi_rapat_tahunan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Partisipasi Aktif Anggota</td>
                            <td class="text-center">{{ $sosialKelembagaan->koperasi_partisipasi_aktif ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Pengurus Kompeten</td>
                            <td class="text-center">{{ $sosialKelembagaan->koperasi_pengurus_kompeten ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Manajemen Transparan</td>
                            <td class="text-center">{{ $sosialKelembagaan->koperasi_transparan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Keuangan Sehat</td>
                            <td class="text-center">{{ $sosialKelembagaan->koperasi_keuangan_sehat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Jaringan Pasar Luas</td>
                            <td class="text-center">{{ $sosialKelembagaan->koperasi_jaringan_pasar ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Kepercayaan Usaha Tinggi</td>
                            <td class="text-center">{{ $sosialKelembagaan->koperasi_kepercayaan_usaha ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- ============================= --}}
    {{-- J. BUKTI PENDUKUNG --}}
    {{-- ============================= --}}
    @if($buktiPendukung->count() > 0)
        <div class="page">
            <div class="section-title">J. Bukti Pendukung</div>

            <div class="section">
                <div class="note-box">
                    Dokumen dan foto bukti pendukung yang telah diunggah untuk KNMP {{ $knmp->nama_knmp }}
                </div>

                @php
                    $gambarFiles = $buktiPendukung->filter(fn($f) => strpos($f->tipe_file, 'image') !== false);
                    $dokumenFiles = $buktiPendukung->filter(fn($f) => strpos($f->tipe_file, 'image') === false);
                @endphp

                {{-- Gambar Gallery --}}
                @if($gambarFiles->count() > 0)
                    <div class="sub-section-title">Foto Dokumentasi</div>
                    <table style="width: 100%; border: none; border-collapse: collapse; margin-bottom: 15px;">
                        @php
                            $gambarArray = $gambarFiles->values();
                            $totalGambar = $gambarArray->count();
                            $rows = ceil($totalGambar / 3);
                        @endphp
                        @for($row = 0; $row < $rows; $row++)
                            <tr>
                                @for($col = 0; $col < 3; $col++)
                                    @php
                                        $index = ($row * 3) + $col;
                                        $file = $gambarArray->get($index);
                                    @endphp
                                    <td style="width: 33%; padding: 5px; vertical-align: top; border: none;">
                                        @if($file)
                                            @php
                                                $imagePath = public_path('storage/' . $file->path_file);
                                                $displaySrc = $imagePath;

                                                // Jika file ada, konversi ke base64 untuk DomPDF
                                                if (file_exists($imagePath)) {
                                                    try {
                                                        $extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
                                                        $mimeType = 'image/jpeg';
                                                        if ($extension == 'png')
                                                            $mimeType = 'image/png';
                                                        elseif ($extension == 'gif')
                                                            $mimeType = 'image/gif';

                                                        $imageData = file_get_contents($imagePath);
                                                        $displaySrc = 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
                                                    } catch (\Exception $e) {
                                                        $displaySrc = $imagePath;
                                                    }
                                                }
                                            @endphp
                                            <div
                                                style="border: 1px solid #e2e8f0; border-radius: 4px; overflow: hidden; background: #f8fafc;">
                                                <div style="text-align: center; padding: 5px; background: #ffffff;">
                                                    <img src="{{ $displaySrc }}" alt="{{ $file->nama_file }}"
                                                        style="max-width: 100%; max-height: 120px; height: auto;">
                                                </div>
                                                <div
                                                    style="padding: 8px; background: #f7fafc; border-top: 1px solid #e2e8f0; font-size: 8px;">
                                                    <strong
                                                        style="color: #2d3748;">{{ Illuminate\Support\Str::limit($file->nama_file, 18) }}</strong><br>
                                                    <span style="color: #718096;">{{ number_format($file->ukuran_file / 1024, 1) }}
                                                        KB</span>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @endfor
                    </table>
                @endif

                {{-- Dokumen Lainnya --}}
                @if($dokumenFiles->count() > 0)
                    <div class="sub-section-title">Dokumen Pendukung</div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width: 10%;" class="text-center">No</th>
                                <th style="width: 60%;">Nama File</th>
                                <th style="width: 20%;" class="text-center">Jenis</th>
                                <th style="width: 10%;" class="text-right">Ukuran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dokumenFiles as $index => $file)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $file->nama_file }}</td>
                                    <td class="text-center">
                                        @if(strpos($file->tipe_file, 'pdf') !== false)
                                            PDF
                                        @else
                                            File
                                        @endif
                                    </td>
                                    <td class="text-right">{{ number_format($file->ukuran_file / 1024, 1) }} KB</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    @endif

    {{-- ============================= --}}
    {{-- HALAMAN PENUTUP --}}
    {{-- ============================= --}}
    <div class="page">
        <div class="cover-center">
            @php
                $path = public_path('assets/images/logo-kkp.png');
                $logoExists = file_exists($path);
            @endphp
            @if($logoExists)
                <img src="{{ $path }}" style="width: 80px; height: auto;" alt="Logo KKP">
            @endif

            <div class="cover-title">Dokumen Kuesioner Selesai</div>
            <p class="cover-subtitle">Laporan ini dibuat otomatis oleh Sistem Kuesioner KNMP</p>

            <div class="cover-info">
                <table class="cover-info-table">
                    <tr>
                        <td style="text-align: right; width: 40%; color: #666666;">Tanggal Cetak:</td>
                        <td style="text-align: left;">{{ now()->format('d F Y, H:i') }} WIB</td>
                    </tr>
                    <tr>
                        <td style="text-align: right; color: #666666;">Responden:</td>
                        <td style="text-align: left;"><strong>{{ $responden->nama_responden }}</strong></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; color: #666666;">NIK:</td>
                        <td style="text-align: left;">{{ $responden->nik }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right; color: #666666;">KNMP:</td>
                        <td style="text-align: left;">{{ $knmp->nama_knmp }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</body>

</html>