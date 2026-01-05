<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuesioner {{ $responden->nama_responden }}</title>
    <style>
        @page {
            margin: 20mm 15mm 20mm 15mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.5;
            color: #333;
            background: white;
            font-size: 11px;
        }

        img {
            image-orientation: from-image;
        }

        .page {
            page-break-after: always;
            padding: 15px 0;
        }

        .page:last-child {
            page-break-after: avoid;
        }

        /* Header Styles */
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #2563eb;
            font-size: 18px;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header p {
            color: #666;
            font-size: 11px;
            margin: 3px 0;
        }

        .header .knmp-info {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 15px;
            font-size: 11px;
        }

        .header .knmp-info strong {
            color: #2563eb;
            font-size: 12px;
        }

        /* Section Styles */
        .section {
            margin-bottom: 20px;
        }

        .section-title {
            background: #2563eb;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sub-section-title {
            color: #2563eb;
            font-size: 11px;
            font-weight: 700;
            margin: 15px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #e5e7eb;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10px;
        }

        table th {
            background: #f3f4f6;
            color: #374151;
            padding: 8px 10px;
            text-align: left;
            font-weight: 600;
            border: 1px solid #e5e7eb;
        }

        table td {
            padding: 7px 10px;
            border: 1px solid #e5e7eb;
            vertical-align: top;
        }

        table tr:nth-child(even) {
            background: #f9fafb;
        }

        /* Info Box */
        .info-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-left: 4px solid #2563eb;
            padding: 12px 15px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .info-row,
        .info-box-row {
            display: table;
            width: 100%;
            margin-bottom: 6px;
        }

        .info-row:last-child,
        .info-box-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            display: table-cell;
            font-weight: 600;
            color: #4b5563;
            width: 40%;
            padding-right: 10px;
        }

        .info-value {
            display: table-cell;
            color: #111827;
        }

        /* Divider */
        .divider {
            border: 0;
            border-top: 1px dashed #d1d5db;
            margin: 15px 0;
        }

        /* Text Alignment */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-bold {
            font-weight: 600;
        }

        /* Empty Message */
        .empty-message {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 10px 12px;
            border-radius: 4px;
            color: #92400e;
        }

        /* Status Badge */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: 600;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        /* Image Gallery */
        .image-gallery {
            margin-bottom: 15px;
        }

        .image-item {
            display: inline-block;
            width: 30%;
            margin: 1%;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
            vertical-align: top;
        }

        .image-item img {
            width: 100%;
            height: auto;
            max-height: 150px;
            object-fit: contain;
        }

        .image-item-info {
            padding: 6px;
            font-size: 9px;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
        }

        /* Page Footer */
        .page-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
            padding: 10px 0;
            border-top: 1px solid #e5e7eb;
        }

        /* Cover Page */
        .cover-center {
            text-align: center;
            padding: 60px 0;
        }

        .cover-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .cover-title {
            color: #2563eb;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .cover-subtitle {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 30px;
        }

        /* Print Optimization */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .page {
                page-break-before: avoid;
            }

            .section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    {{-- ============================= --}}
    {{-- HALAMAN 1: COVER & INFO --}}
    {{-- ============================= --}}
    <div class="page">
        <table style="width: 100%; border-bottom: 3px solid #2563eb; margin-bottom: 20px; padding-bottom: 10px;">
            <tr>
                <td style="width: 80px; text-align: center; vertical-align: middle; border: none; padding-right: 15px;">
                    @php
                        $path = public_path('assets/images/logo-kkp.png');
                        $logoExists = file_exists($path);
                    @endphp
                    @if($logoExists)
                        <img src="{{ $path }}" style="width: 70px; height: auto;" alt="Logo KKP">
                    @else
                        <div
                            style="width: 70px; height: 70px; background: #f0f9ff; border: 1px dashed #2563eb; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #2563eb; border-radius: 50%;">
                            Logo
                        </div>
                    @endif
                </td>
                <td style="text-align: center; vertical-align: middle; border: none;">
                    <h1 style="color: #2563eb; font-size: 18px; margin: 0; text-transform: uppercase;">KUESIONER SURVEI
                        KNMP</h1>
                    <p style="margin: 5px 0 0 0; color: #333; font-weight: bold; font-size: 12px;">Kampung Nelayan Merah
                        Putih</p>
                    <p style="margin: 2px 0 0 0; font-size: 10px; color: #6b7280;">Kementerian Kelautan dan Perikanan
                        Republik Indonesia</p>
                </td>
                <td style="width: 80px; border: none;"></td> <!-- Balance for centering -->
            </tr>
        </table>

        <div class="knmp-info" style="text-align: center;">
            <strong>{{ $knmp->nama ?? 'Kampung Nelayan' }}</strong><br>
            Desa {{ $knmp->village->name ?? 'N/A' }}, Kec. {{ $knmp->district->name ?? 'N/A' }}, Kab. {{ $knmp->regency->name ?? 'N/A' }}, Prov. {{ $knmp->province->name ?? 'N/A' }}
        </div>

        <hr class="divider">

        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Nama Responden</span>
                <span class="info-value"><strong>{{ $responden->nama_responden }}</strong></span>
            </div>
            <div class="info-row">
                <span class="info-label">NIK</span>
                <span class="info-value">{{ $responden->nik }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Wawancara</span>
                <span
                    class="info-value">{{ \Carbon\Carbon::parse($responden->tanggal_wawancara)->format('d F Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Enumerator</span>
                <span class="info-value">{{ $responden->nama_enumerator }}</span>
            </div>
        </div>

        <p style="font-size: 10px; color: #6b7280; margin-top: 20px;">
            Dokumen ini berisi hasil kuesioner lengkap yang telah diisi oleh responden.
            Informasi detail responden terdapat pada Section E.
        </p>
    </div>

    {{-- ============================= --}}
    {{-- A. PROFIL KNMP --}}
    {{-- ============================= --}}
    @if($profileKnmp)
        <div class="page">
            <div class="section-title">A. PROFIL KNMP</div>

            <div class="section">
                <div class="info-box">
                    <div class="info-row">
                        <span class="info-label">Jumlah Penduduk</span>
                        <span class="info-value">{{ number_format($profileKnmp->jml_penduduk_des ?? 0, 0, ',', '.') }}
                            jiwa</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jumlah Nelayan</span>
                        <span class="info-value">{{ number_format($profileKnmp->jml_nelayan ?? 0, 0, ',', '.') }}
                            orang</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Pendapatan Rata-rata</span>
                        <span class="info-value">Rp
                            {{ number_format($profileKnmp->pendapatan_rata_rata_nelayan ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Volume Produksi</span>
                        <span class="info-value">{{ number_format($profileKnmp->volume_produksi_ton ?? 0, 2, ',', '.') }}
                            ton/tahun</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nilai Produksi</span>
                        <span class="info-value">Rp
                            {{ number_format($profileKnmp->nilai_produksi ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Komoditas Utama</span>
                        <span
                            class="info-value">{{ $profileKnmp->komoditas_utama_1 ?? '-' }}{{ $profileKnmp->komoditas_utama_2 ? ', ' . $profileKnmp->komoditas_utama_2 : '' }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ============================= --}}
    {{-- B. PROSES PEMBANGUNAN KNMP --}}
    {{-- ============================= --}}
    @if($progresKnmp->count() > 0)
        <div class="page">
            <div class="section-title">B. PROSES PEMBANGUNAN KNMP</div>

            @foreach($progresKnmp as $progres)
                <div class="section">
                    <h4 style="color: #667eea; margin-bottom: 10px; font-size: 11px;">Anggaran & Tenaga Kerja</h4>
                    <div class="info-box">
                        <div class="info-box-row">
                            <span class="info-label">Anggaran Total</span>
                            <span class="info-value">Rp {{ number_format($progres->anggaran_total ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-box-row">
                            <span class="info-label">Anggaran Konstruksi</span>
                            <span class="info-value">Rp
                                {{ number_format($progres->anggaran_konstruksi ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-box-row">
                            <span class="info-label">Anggaran Sarpras</span>
                            <span class="info-value">Rp {{ number_format($progres->anggaran_sarpras ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-box-row">
                            <span class="info-label">Tenaga Kerja Total</span>
                            <span class="info-value">{{ $progres->tk_total ?? 0 }} orang (L: {{ $progres->tk_laki ?? 0 }}, P:
                                {{ $progres->tk_perempuan ?? 0 }})</span>
                        </div>
                        <div class="info-box-row">
                            <span class="info-label">Tenaga Kerja Lokal</span>
                            <span class="info-value">{{ $progres->tk_lokal ?? 0 }} orang</span>
                        </div>
                        <div class="info-box-row">
                            <span class="info-label">Tenaga Kerja Luar</span>
                            <span class="info-value">{{ $progres->tk_luar ?? 0 }} orang</span>
                        </div>
                    </div>

                    @if($progres->details->count() > 0)
                        <h4 style="color: #667eea; margin-bottom: 10px; font-size: 11px;">Detail Progres</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 40%;">Komponen</th>
                                    <th style="width: 15%; text-align: center;">Target</th>
                                    <th style="width: 15%; text-align: center;">Progress (%)</th>
                                    <th style="width: 30%;">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($progres->details as $detail)
                                    <tr>
                                        <td>{{ $detail->komponen }}</td>
                                        <td style="text-align: center;">{{ $detail->target ?? '-' }}</td>
                                        <td style="text-align: center;">{{ $detail->persen ?? 0 }}%</td>
                                        <td>{{ $detail->keterangan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center; color: #999;">Tidak ada data</td>
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
            <div class="section-title">C. TANGGAPAN MASYARAKAT TERKAIT PEMBANGUNAN KNMP</div>

            <div class="section">
                <div class="info-box">
                    <div class="info-box-row">
                        <span class="info-label">Kesesuaian Kebutuhan</span>
                        <span
                            class="info-value">{{ $tanggapanMasyarakat->kesesuaian_kebutuhan ? '✓ Ya, Sesuai' : '✗ Tidak Sesuai' }}</span>
                    </div>
                    @if(!$tanggapanMasyarakat->kesesuaian_kebutuhan && $tanggapanMasyarakat->item_tidak_sesuai)
                        <div class="info-box-row">
                            <span class="info-label">Item Tidak Sesuai</span>
                            <span class="info-value">{{ $tanggapanMasyarakat->item_tidak_sesuai }}</span>
                        </div>
                    @endif
                    <div class="info-box-row">
                        <span class="info-label">Tingkat Kesenangan</span>
                        <span class="info-value">{{ $tanggapanMasyarakat->tingkat_kesenangan }}</span>
                    </div>
                    @if($tanggapanMasyarakat->alasan_tidak_senang)
                        <div class="info-box-row">
                            <span class="info-label">Alasan Tidak Senang</span>
                            <span class="info-value">{{ $tanggapanMasyarakat->alasan_tidak_senang }}</span>
                        </div>
                    @endif
                    <div class="info-box-row">
                        <span class="info-label">Harapan Masyarakat</span>
                        <span class="info-value">{{ $tanggapanMasyarakat->harapan_masyarakat }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Masukan & Saran</span>
                        <span class="info-value">{{ $tanggapanMasyarakat->masukan_saran_perbaikan }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ============================= --}}
    {{-- D. TINGKAT KEBAHAGIAAN NELAYAN --}}
    {{-- ============================= --}}
    @if($tingkatKebahagiaan->count() > 0)
        <div class="page">
            <div class="section-title">D. TINGKAT KEBAHAGIAAN NELAYAN</div>

            @foreach($tingkatKebahagiaan as $kategori => $soals)
                <div class="section">
                    <h4 style="color: #667eea; margin-bottom: 10px; font-size: 11px;">
                        {{ ucfirst(str_replace('_', ' ', $kategori)) }}</h4>
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align: center;">No</th>
                                <th style="width: 50%;">Pertanyaan</th>
                                <th style="width: 30%;">Jawaban</th>
                                <th style="width: 15%; text-align: center;">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($soals as $soal)
                                <tr>
                                    <td style="text-align: center;">{{ $soal->nomor_soal }}</td>
                                    <td>{{ $tingkatKebahagiaan_pertanyaan[$soal->kategori][$soal->nomor_soal] ?? 'Soal ' . $soal->nomor_soal }}
                                    </td>
                                    <td>{{ $soal->jawaban_teks }}</td>
                                    <td style="text-align: center;">{{ $soal->skor_nilai }}</td>
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
            <div class="section-title">E. INFORMASI RESPONDEN</div>

            <div class="section">
                <div class="info-box">
                    <div class="info-box-row">
                        <span class="info-label">Nama Responden</span>
                        <span class="info-value"><strong>{{ $responden->nama_responden }}</strong></span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">NIK</span>
                        <span class="info-value">{{ $responden->nik }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Jenis Kelamin</span>
                        <span class="info-value">{{ $responden->jenis_kelamin }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Tanggal Lahir</span>
                        <span
                            class="info-value">{{ \Carbon\Carbon::parse($responden->tanggal_lahir)->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Umur</span>
                        <span class="info-value">{{ $responden->umur }} tahun</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Alamat</span>
                        <span class="info-value">{{ $responden->alamat }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">No. HP</span>
                        <span class="info-value">{{ $responden->no_hp_responden }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Pendidikan</span>
                        <span class="info-value">{{ $responden->pendidikan_terakhir }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Tanggal Wawancara</span>
                        <span
                            class="info-value">{{ \Carbon\Carbon::parse($responden->tanggal_wawancara)->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Enumerator</span>
                        <span class="info-value">{{ $responden->nama_enumerator }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ============================= --}}
    {{-- F. INFORMASI USAHA --}}
    {{-- ============================= --}}
    @if($informasiUsaha->count() > 0)
        <div class="page">
            <div class="section-title">F. INFORMASI USAHA (KONDISI EXISTING)</div>

            @foreach($informasiUsaha as $usaha)
                <div class="section">
                    <h4 style="color: #667eea; margin-bottom: 10px; font-size: 11px;">Data Usaha Perikanan</h4>
                    <div class="info-box">
                        <div class="info-box-row">
                            <span class="info-label">Nama Kapal</span>
                            <span class="info-value">{{ $usaha->nama_kapal }}</span>
                        </div>
                        <div class="info-box-row">
                            <span class="info-label">Tahun Pembuatan</span>
                            <span class="info-value">{{ $usaha->tahun_pembuatan }}</span>
                        </div>
                        <div class="info-box-row">
                            <span class="info-label">Ukuran (GT)</span>
                            <span class="info-value">{{ $usaha->ukuran_gt ?? '-' }} GT</span>
                        </div>
                        <div class="info-box-row">
                            <span class="info-label">Jenis Alat Tangkap</span>
                            <span class="info-value">{{ $usaha->jenis_alat_tangkap }}</span>
                        </div>
                        <div class="info-box-row">
                            <span class="info-label">Hari per Trip</span>
                            <span class="info-value">{{ $usaha->hari_per_trip ?? '-' }} hari</span>
                        </div>
                        <div class="info-box-row">
                            <span class="info-label">Trip per Bulan</span>
                            <span class="info-value">{{ $usaha->jml_trip_per_bulan ?? '-' }} kali</span>
                        </div>
                        <div class="info-box-row">
                            <span class="info-label">Produksi per Trip</span>
                            <span class="info-value">{{ number_format($usaha->produksi_kg_per_trip ?? 0, 2) }} kg</span>
                        </div>
                        <div class="info-box-row">
                            <span class="info-label">Penjualan per Trip</span>
                            <span class="info-value">Rp
                                {{ number_format($usaha->penjualan_rp_per_trip ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-box-row">
                            <span class="info-label">Total Biaya Operasional</span>
                            <span class="info-value">Rp
                                {{ number_format($usaha->total_biaya_operasional ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($usaha->ikan->count() > 0)
                        <h4 style="color: #667eea; margin-bottom: 10px; font-size: 11px;">Jenis Ikan Hasil Tangkapan Utama</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 40%;">Jenis Ikan</th>
                                    <th style="width: 30%; text-align: center;">kg/trip</th>
                                    <th style="width: 30%; text-align: center;">Persentase (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usaha->ikan as $ikan)
                                    <tr>
                                        <td>{{ $ikan->jenis }}</td>
                                        <td style="text-align: center;">{{ number_format($ikan->kg_trip, 2) }}</td>
                                        <td style="text-align: center;">{{ $ikan->persen }}%</td>
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
            <div class="section-title">G. INFORMASI PEMASARAN HASIL PERIKANAN</div>

            <div class="section">
                <div class="info-box">
                    <div class="info-box-row">
                        <span class="info-label">Kendala Pemasaran</span>
                        <span class="info-value">{{ $informasiPemasaran->kendala_pemasaran_text }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Cara Penanganan Ikan</span>
                        <span class="info-value">{{ $informasiPemasaran->cara_penanganan_ikan }}</span>
                    </div>
                </div>

                @if($informasiPemasaran->detail_pemasaran)
                    <h4 style="color: #667eea; margin-bottom: 10px; font-size: 11px;">Distribusi Saluran Pemasaran</h4>
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 50%;">Saluran Pemasaran</th>
                                <th style="width: 50%; text-align: center;">Kuantitas (kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Eceran</td>
                                <td style="text-align: center;">
                                    {{ number_format($informasiPemasaran->detail_pemasaran->eceran_kg ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Koperasi</td>
                                <td style="text-align: center;">
                                    {{ number_format($informasiPemasaran->detail_pemasaran->koperasi_kg ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Tengkulak</td>
                                <td style="text-align: center;">
                                    {{ number_format($informasiPemasaran->detail_pemasaran->tengkulak_kg ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Pengepul</td>
                                <td style="text-align: center;">
                                    {{ number_format($informasiPemasaran->detail_pemasaran->pengepul_kg ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Pedagang Besar</td>
                                <td style="text-align: center;">
                                    {{ number_format($informasiPemasaran->detail_pemasaran->pedagang_besar_kg ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Lainnya</td>
                                <td style="text-align: center;">
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
            <div class="section-title">H. INFORMASI PENDAPATAN RUMAH TANGGA</div>

            <div class="section">
                <div class="info-box">
                    <div class="info-box-row">
                        <span class="info-label">Pendapatan Perikanan</span>
                        <span class="info-value">Rp
                            {{ number_format($pendapatanRt->pendapatan_perikanan ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Pendapatan Non-Perikanan</span>
                        <span class="info-value">Rp
                            {{ number_format($pendapatanRt->pendapatan_non_perikanan ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Pendapatan Total</span>
                        <span class="info-value"><strong>Rp
                                {{ number_format($pendapatanRt->pendapatan_total ?? 0, 0, ',', '.') }}</strong></span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Kontribusi Nelayan</span>
                        <span class="info-value">{{ $pendapatanRt->kontribusi_nelayan_persen }}%</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Ketergantungan Perikanan</span>
                        <span class="info-value">{{ $pendapatanRt->ketergantungan_perikanan }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Stabilitas Pendapatan</span>
                        <span class="info-value">{{ $pendapatanRt->stabilitas_pendapatan }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Keterlibatan Perempuan</span>
                        <span class="info-value">{{ $pendapatanRt->keterlibatan_perempuan }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Kontribusi Perempuan</span>
                        <span class="info-value">{{ $pendapatanRt->kontribusi_perempuan_persen }}%</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ============================= --}}
    {{-- I. SOSIAL & KELEMBAGAAN --}}
    {{-- ============================= --}}
    @if($sosialKelembagaan)
        <div class="page">
            <div class="section-title">I. SOSIAL DAN KELEMBAGAAN</div>

            <div class="section">
                <div class="info-box">
                    <div class="info-box-row">
                        <span class="info-label">Anggota Kelompok</span>
                        <span class="info-value">{{ $sosialKelembagaan->anggota_kelompok ?? '-' }}</span>
                    </div>
                    @if($sosialKelembagaan->manfaat_kelompok)
                        <div class="info-box-row">
                            <span class="info-label">Manfaat Kelompok</span>
                            <span class="info-value">{{ $sosialKelembagaan->manfaat_kelompok }}</span>
                        </div>
                    @endif
                    <div class="info-box-row">
                        <span class="info-label">Anggota Koperasi</span>
                        <span class="info-value">{{ $sosialKelembagaan->anggota_koperasi ?? '-' }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Tertarik Koperasi</span>
                        <span class="info-value">{{ $sosialKelembagaan->tertarik_koperasi ?? '-' }}</span>
                    </div>
                    @if($sosialKelembagaan->manfaat_koperasi)
                        <div class="info-box-row">
                            <span class="info-label">Manfaat Koperasi</span>
                            <span class="info-value">{{ $sosialKelembagaan->manfaat_koperasi }}</span>
                        </div>
                    @endif
                </div>

                <h4 style="color: #667eea; margin-bottom: 10px; font-size: 11px;">Penilaian Kelembagaan Koperasi</h4>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50%;">Aspek Penilaian</th>
                            <th style="width: 50%; text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Rapat Tahunan Dilakukan</td>
                            <td style="text-align: center;">{{ $sosialKelembagaan->koperasi_rapat_tahunan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Partisipasi Aktif Anggota</td>
                            <td style="text-align: center;">{{ $sosialKelembagaan->koperasi_partisipasi_aktif ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Pengurus Kompeten</td>
                            <td style="text-align: center;">{{ $sosialKelembagaan->koperasi_pengurus_kompeten ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Manajemen Transparan</td>
                            <td style="text-align: center;">{{ $sosialKelembagaan->koperasi_transparan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Keuangan Sehat</td>
                            <td style="text-align: center;">{{ $sosialKelembagaan->koperasi_keuangan_sehat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Jaringan Pasar Luas</td>
                            <td style="text-align: center;">{{ $sosialKelembagaan->koperasi_jaringan_pasar ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Kepercayaan Usaha Tinggi</td>
                            <td style="text-align: center;">{{ $sosialKelembagaan->koperasi_kepercayaan_usaha ?? '-' }}</td>
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
            <div class="section-title">J. BUKTI PENDUKUNG</div>

            <div class="section">
                <p style="font-size: 11px; color: #666; margin-bottom: 15px;">
                    Dokumen dan foto bukti pendukung yang telah diunggah untuk KNMP {{ $knmp->nama_knmp }}:
                </p>

                @php
                    $gambarFiles = $buktiPendukung->filter(fn($f) => strpos($f->tipe_file, 'image') !== false);
                    $dokumenFiles = $buktiPendukung->filter(fn($f) => strpos($f->tipe_file, 'image') === false);
                @endphp

                {{-- Gambar Gallery --}}
                @if($gambarFiles->count() > 0)
                    <h4 style="color: #2563eb; margin-bottom: 10px; font-size: 11px;">Foto Dokumentasi</h4>
                    <div class="image-gallery">
                        @foreach($gambarFiles as $file)
                            @php
                                $imagePath = public_path('storage/'.$file->path_file);
                                $displaySrc = $imagePath;
                                
                                // Logic Rotasi Gambar (Manual Fix untuk DomPDF)
                                try {
                                    if (file_exists($imagePath) && function_exists('exif_read_data')) {
                                        $extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
                                        if (in_array($extension, ['jpg', 'jpeg'])) {
                                            $exif = @exif_read_data($imagePath);
                                            if (!empty($exif['Orientation']) && in_array($exif['Orientation'], [3, 6, 8])) {
                                                $source = @imagecreatefromjpeg($imagePath);
                                                if ($source) {
                                                    $rotate = null;
                                                    switch ($exif['Orientation']) {
                                                        case 3: $rotate = imagerotate($source, 180, 0); break;
                                                        case 6: $rotate = imagerotate($source, -90, 0); break;
                                                        case 8: $rotate = imagerotate($source, 90, 0); break;
                                                    }
                                                    
                                                    if ($rotate) {
                                                        ob_start();
                                                        imagejpeg($rotate);
                                                        $imageData = ob_get_clean();
                                                        $displaySrc = 'data:image/jpeg;base64,' . base64_encode($imageData);
                                                        imagedestroy($rotate);
                                                    }
                                                    imagedestroy($source);
                                                }
                                            }
                                        }
                                    }
                                } catch (\Exception $e) {
                                    // Fallback to original path if processing fails
                                    $displaySrc = $imagePath;
                                }
                            @endphp
                            <div class="image-item">
                                <img src="{{ $displaySrc }}" alt="{{ $file->nama_file }}">
                                <div class="image-item-info">
                                    <strong>{{ Illuminate\Support\Str::limit($file->nama_file, 20) }}</strong>
                                    <div style="color: #999; margin-top: 2px;">{{ number_format($file->ukuran_file / 1024, 1) }} KB</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Dokumen Lainnya --}}
                @if($dokumenFiles->count() > 0)
                    <h4 style="color: #667eea; margin-bottom: 10px; font-size: 11px; margin-top: 20px;">Dokumen Pendukung</h4>
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 10%; text-align: center;">No</th>
                                <th style="width: 60%;">Nama File</th>
                                <th style="width: 20%; text-align: center;">Jenis</th>
                                <th style="width: 10%; text-align: right;">Ukuran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dokumenFiles as $index => $file)
                                <tr>
                                    <td style="text-align: center;">{{ $index + 1 }}</td>
                                    <td>{{ $file->nama_file }}</td>
                                    <td style="text-align: center;">
                                        @if(strpos($file->tipe_file, 'pdf') !== false)
                                            PDF
                                        @else
                                            File
                                        @endif
                                    </td>
                                    <td style="text-align: right;">{{ number_format($file->ukuran_file / 1024, 1) }} KB</td>
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
            <div class="cover-icon">
                @php
                    $path = public_path('assets/images/logo-kkp.png');
                    $logoExists = file_exists($path);
                @endphp
                @if($logoExists)
                    <img src="{{ $path }}" style="width: 100px; height: auto;" alt="Logo KKP">
                @else
                    <div style="font-size: 64px;">⚓</div>
                @endif
            </div>
            <h3 class="cover-title">Dokumen Kuesioner Selesai</h3>
            <p class="cover-subtitle">Laporan ini dibuat otomatis oleh Sistem Kuesioner KNMP</p>

            <div style="margin-top: 40px; padding: 20px; background: #f9fafb; border-radius: 8px;">
                <table style="width: 80%; margin: 0 auto; border: none;">
                    <tr style="background: transparent;">
                        <td style="border: none; text-align: right; padding: 5px 10px; color: #6b7280;">Tanggal Cetak:
                        </td>
                        <td style="border: none; text-align: left; padding: 5px 10px;">{{ now()->format('d F Y, H:i') }}
                            WIB</td>
                    </tr>
                    <tr style="background: transparent;">
                        <td style="border: none; text-align: right; padding: 5px 10px; color: #6b7280;">Responden:</td>
                        <td style="border: none; text-align: left; padding: 5px 10px;">
                            <strong>{{ $responden->nama_responden }}</strong></td>
                    </tr>
                    <tr style="background: transparent;">
                        <td style="border: none; text-align: right; padding: 5px 10px; color: #6b7280;">NIK:</td>
                        <td style="border: none; text-align: left; padding: 5px 10px;">{{ $responden->nik }}</td>
                    </tr>
                    <tr style="background: transparent;">
                        <td style="border: none; text-align: right; padding: 5px 10px; color: #6b7280;">KNMP:</td>
                        <td style="border: none; text-align: left; padding: 5px 10px;">{{ $knmp->nama_knmp }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>