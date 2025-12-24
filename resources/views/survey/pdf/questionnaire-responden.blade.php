<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuesioner {{ $responden->nama_responden }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: white;
        }

        .page {
            page-break-after: always;
            padding: 40px;
        }

        .page:last-child {
            page-break-after: avoid;
        }

        /* Header Styles */
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
        }

        .header-logo {
            width: 80px;
            height: 80px;
            margin-right: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .header-logo img {
            max-width: 100%;
            max-height: 100%;
        }

        .header-content {
            flex: 1;
            text-align: center;
        }

        .header-content h1 {
            color: #667eea;
            font-size: 22px;
            margin-bottom: 3px;
        }

        .header-content p {
            color: #666;
            font-size: 12px;
            margin: 2px 0;
        }

        .header .knmp-info {
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 15px;
            font-size: 11px;
            text-align: center;
        }

        /* Section Styles */
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .section-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 15px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10px;
        }

        table th {
            background: #e9ecef;
            color: #333;
            padding: 8px;
            text-align: left;
            font-weight: 600;
            border: 1px solid #dee2e6;
        }

        table td {
            padding: 6px 8px;
            border: 1px solid #dee2e6;
        }

        table tr:nth-child(even) {
            background: #f8f9fa;
        }

        /* Info Box */
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 12px 15px;
            margin-bottom: 15px;
            border-radius: 3px;
            font-size: 11px;
        }

        .info-box-row {
            display: flex;
            margin-bottom: 6px;
        }

        .info-box-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            color: #667eea;
            width: 35%;
            min-width: 120px;
        }

        .info-value {
            color: #333;
            flex: 1;
        }

        /* Divider */
        .divider {
            border: 0;
            border-top: 2px dashed #dee2e6;
            margin: 20px 0;
        }

        /* Text Alignment */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* Empty Message */
        .empty-message {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 10px 12px;
            border-radius: 3px;
            font-size: 11px;
            color: #856404;
        }

        /* Image Gallery */
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 15px;
        }

        .image-item {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            overflow: hidden;
            text-align: center;
            background: #f8f9fa;
        }

        .image-item img {
            width: 100%;
            height: auto;
            max-height: 200px;
            object-fit: contain;
            display: block;
        }

        .image-item-info {
            padding: 8px;
            font-size: 9px;
            border-top: 1px solid #dee2e6;
        }

        /* Responsive */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .page {
                page-break-before: avoid;
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
        <div class="header">
            <div class="header-logo">
                <div style="text-align: center; font-size: 24px;">⚓</div>
            </div>
            <div class="header-content">
                <h1>KUESIONER SURVEI KNMP</h1>
                <p>Kampung Nelayan Merah Putih</p>
                <p style="font-size: 10px; color: #999;">Kementerian Kelautan dan Perikanan</p>
                <div class="knmp-info">
                    <div style="font-weight: 700;">{{ $knmp->nama_knmp ?? 'N/A' }}</div>
                    <div>{{ $knmp->village->name ?? 'N/A' }}, {{ $knmp->district->name ?? 'N/A' }}, {{ $knmp->regency->name ?? 'N/A' }}, {{ $knmp->province->name ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <hr class="divider">

        <div class="section">
            <p style="font-size: 11px; color: #666; margin-bottom: 10px;">Informasi lengkap responden terdapat pada halaman Section E.</p>
        </div>
    </div>

    {{-- ============================= --}}
    {{-- A. PROFIL KNMP --}}
    {{-- ============================= --}}
    @if($profileKnmp)
        <div class="page">
            <div class="section-title">A. PROFIL KNMP</div>

            <div class="section">
                <div class="info-box">
                    <div class="info-box-row">
                        <span class="info-label">Jumlah Penduduk</span>
                        <span class="info-value">{{ number_format($profileKnmp->jml_penduduk_des ?? 0, 0, ',', '.') }} jiwa</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Jumlah Nelayan</span>
                        <span class="info-value">{{ number_format($profileKnmp->jml_nelayan ?? 0, 0, ',', '.') }} orang</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Pendapatan Rata-rata Nelayan</span>
                        <span class="info-value">Rp {{ number_format($profileKnmp->pendapatan_rata_rata_nelayan ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Volume Produksi</span>
                        <span class="info-value">{{ number_format($profileKnmp->volume_produksi_ton ?? 0, 2, ',', '.') }} ton/tahun</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Nilai Produksi</span>
                        <span class="info-value">Rp {{ number_format($profileKnmp->nilai_produksi ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Komoditas Utama 1</span>
                        <span class="info-value">{{ $profileKnmp->komoditas_utama_1 ?? '-' }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Komoditas Utama 2</span>
                        <span class="info-value">{{ $profileKnmp->komoditas_utama_2 ?? '-' }}</span>
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
                            <span class="info-value">Rp {{ number_format($progres->anggaran_konstruksi ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-box-row">
                            <span class="info-label">Anggaran Sarpras</span>
                            <span class="info-value">Rp {{ number_format($progres->anggaran_sarpras ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-box-row">
                            <span class="info-label">Tenaga Kerja Total</span>
                            <span class="info-value">{{ $progres->tk_total ?? 0 }} orang (L: {{ $progres->tk_laki ?? 0 }}, P: {{ $progres->tk_perempuan ?? 0 }})</span>
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
                        <span class="info-value">{{ $tanggapanMasyarakat->kesesuaian_kebutuhan ? '✓ Ya, Sesuai' : '✗ Tidak Sesuai' }}</span>
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
                    <h4 style="color: #667eea; margin-bottom: 10px; font-size: 11px;">{{ ucfirst(str_replace('_', ' ', $kategori)) }}</h4>
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
                                    <td>{{ $tingkatKebahagiaan_pertanyaan[$soal->kategori][$soal->nomor_soal] ?? 'Soal ' . $soal->nomor_soal }}</td>
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
                        <span class="info-value">{{ \Carbon\Carbon::parse($responden->tanggal_lahir)->format('d/m/Y') }}</span>
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
                        <span class="info-value">{{ \Carbon\Carbon::parse($responden->tanggal_wawancara)->format('d/m/Y') }}</span>
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
                            <span class="info-value">Rp {{ number_format($usaha->penjualan_rp_per_trip ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-box-row">
                            <span class="info-label">Total Biaya Operasional</span>
                            <span class="info-value">Rp {{ number_format($usaha->total_biaya_operasional ?? 0, 0, ',', '.') }}</span>
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
                                <td style="text-align: center;">{{ number_format($informasiPemasaran->detail_pemasaran->eceran_kg ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Koperasi</td>
                                <td style="text-align: center;">{{ number_format($informasiPemasaran->detail_pemasaran->koperasi_kg ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Tengkulak</td>
                                <td style="text-align: center;">{{ number_format($informasiPemasaran->detail_pemasaran->tengkulak_kg ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Pengepul</td>
                                <td style="text-align: center;">{{ number_format($informasiPemasaran->detail_pemasaran->pengepul_kg ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Pedagang Besar</td>
                                <td style="text-align: center;">{{ number_format($informasiPemasaran->detail_pemasaran->pedagang_besar_kg ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Lainnya</td>
                                <td style="text-align: center;">{{ number_format($informasiPemasaran->detail_pemasaran->lainnya_kg ?? 0, 2) }}</td>
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
                        <span class="info-value">Rp {{ number_format($pendapatanRt->pendapatan_perikanan ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Pendapatan Non-Perikanan</span>
                        <span class="info-value">Rp {{ number_format($pendapatanRt->pendapatan_non_perikanan ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-label">Pendapatan Total</span>
                        <span class="info-value"><strong>Rp {{ number_format($pendapatanRt->pendapatan_total ?? 0, 0, ',', '.') }}</strong></span>
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
                    <h4 style="color: #667eea; margin-bottom: 10px; font-size: 11px;">Foto Dokumentasi</h4>
                    <div class="image-gallery">
                        @foreach($gambarFiles as $file)
                            <div class="image-item">
                                <img src="{{ public_path('storage/'.$file->path_file) }}" alt="{{ $file->nama_file }}">
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
        <div style="text-align: center; padding: 100px 0;">
            <div style="font-size: 40px; margin-bottom: 20px;">✓</div>
            <h3 style="color: #667eea; margin-bottom: 20px;">Dokumen Kuesioner Selesai</h3>
            <p style="color: #666; margin-bottom: 10px;">Laporan ini dibuat otomatis oleh Sistem Kuesioner KNMP</p>
            <p style="color: #999; font-size: 10px; margin-top: 30px;">
                Tanggal Cetak: {{ now()->format('d Maret Y H:i:s') }}<br>
                Responden: {{ $responden->nama_responden }}<br>
                KNMP: {{ $knmp->nama_knmp }}
            </p>
        </div>
    </div>
</body>
</html>
