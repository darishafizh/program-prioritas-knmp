<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Progres Pembangunan KNMP Tahap {{ $tahapLabel }}</title>
    <style>
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            src: url('{{ storage_path("fonts/poppins/Poppins-Regular.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Poppins';
            font-style: italic;
            font-weight: 400;
            src: url('{{ storage_path("fonts/poppins/Poppins-Italic.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 500;
            src: url('{{ storage_path("fonts/poppins/Poppins-Medium.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 600;
            src: url('{{ storage_path("fonts/poppins/Poppins-SemiBold.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            src: url('{{ storage_path("fonts/poppins/Poppins-Bold.ttf") }}') format('truetype');
        }

        @page {
            margin: 22mm 16mm 22mm 16mm;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', Arial, sans-serif;
            font-size: 9.5px;
            color: #1f2937;
            line-height: 1.35;
        }

        /* ============ KOP / HEADER ============ */
        .kop {
            text-align: center;
            margin: 0 0 4px 0;
        }
        .kop p {
            margin: 0;
            padding: 0;
            line-height: 1.18;
            color: #000;
            text-transform: uppercase;
        }
        .kop .l1 { font-size: 11px; font-weight: 600; letter-spacing: 0.2px; }
        .kop .l2 { font-size: 12px; font-weight: 600; letter-spacing: 0.2px; }
        .kop .l3 { font-size: 15px; font-weight: 700; letter-spacing: 0.5px; margin-top: 1px; }

        .kop-rule-wrap {
            margin: 6px 0 0 0;
            padding: 0;
            line-height: 0;
        }
        .kop-rule-thick {
            border: 0;
            border-top: 2.4px solid #000;
            margin: 0;
            padding: 0;
        }
        .kop-rule-thin {
            border: 0;
            border-top: 0.6px solid #000;
            margin: 1.6px 0 0 0;
            padding: 0;
        }

        /* ============ DOC TITLE ============ */
        .doc-title-block {
            text-align: center;
            margin: 14px 0 12px 0;
        }
        .doc-title {
            font-size: 13px;
            font-weight: 700;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin: 0 0 2px 0;
            line-height: 1.25;
        }
        .doc-subtitle {
            font-size: 9.5px;
            font-weight: 500;
            color: #374151;
            margin: 0;
            line-height: 1.3;
        }
        .doc-subtitle strong { font-weight: 600; color: #000; }

        /* ============ TABLE ============ */
        table.progres-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 0 14px 0;
        }
        table.progres-table th,
        table.progres-table td {
            border: 0.6px solid #94a3b8;
            padding: 4px 6px;
            font-size: 8.5px;
            line-height: 1.3;
            vertical-align: middle;
        }
        table.progres-table thead th {
            background: #d8dee7;
            color: #000;
            font-weight: 600;
            text-align: center;
            text-transform: uppercase;
            font-size: 8px;
            letter-spacing: 0.4px;
            padding: 6px 6px;
        }
        table.progres-table tbody tr:nth-child(even) td {
            background: #f6f8fb;
        }
        .text-center { text-align: center; }
        .fw-semibold { font-weight: 600; }
        .muted       { color: #94a3b8; }

        td.col-no {
            text-align: center;
            font-weight: 500;
            color: #4b5563;
        }
        td.col-lokasi .nama {
            font-size: 8.5px;
            font-weight: 600;
            color: #0f172a;
            line-height: 1.3;
            margin: 0 0 1px 0;
        }
        td.col-lokasi .alamat {
            font-size: 7.6px;
            font-weight: 400;
            color: #4b5563;
            line-height: 1.3;
            margin: 0;
        }
        td.col-progres {
            text-align: center;
            font-weight: 600;
            color: #0f172a;
            white-space: nowrap;
        }

        /* ============ DOCUMENTATION ============ */
        .doc-section {
            margin-top: 6px;
        }
        .doc-section-title {
            font-size: 11.5px;
            font-weight: 700;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
            margin: 0 0 12px 0;
            padding: 6px 0;
            border-top: 1.6px solid #000;
            border-bottom: 1.6px solid #000;
        }
        .province-title {
            font-size: 10px;
            font-weight: 600;
            color: #0f172a;
            margin: 8px 0 6px 0;
            padding: 3px 0 4px 0;
            border-bottom: 0.6px solid #cbd5e1;
            letter-spacing: 0.2px;
        }
        .province-title .count {
            font-size: 8.5px;
            font-weight: 500;
            color: #6b7280;
            margin-left: 4px;
        }

        .photo-grid {
            width: 100%;
            margin: 0 0 4px 0;
        }
        .photo-card {
            width: 31.5%;
            display: inline-block;
            vertical-align: top;
            margin: 0 1.6% 10px 0;
            border: 0.6px solid #d1d5db;
            border-radius: 3px;
            overflow: hidden;
            page-break-inside: avoid;
            text-align: center;
            background: #ffffff;
        }
        .photo-card-body {
            padding: 0;
            background: #f1f5f9;
        }
        .photo-card-body img {
            width: 100%;
            height: 105px;
            object-fit: cover;
            display: block;
        }
        .photo-card-caption {
            padding: 5px 6px 6px 6px;
            text-align: center;
            border-top: 0.6px solid #e5e7eb;
        }
        .photo-card-caption .nama {
            font-size: 8px;
            font-weight: 600;
            color: #0f172a;
            margin: 0 0 1px 0;
            line-height: 1.25;
        }
        .photo-card-caption .lokasi {
            font-size: 7px;
            color: #6b7280;
            margin: 0;
            line-height: 1.25;
        }
        .photo-empty {
            padding: 28px 12px;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
            font-style: italic;
            border: 1px dashed #cbd5e1;
            background: #f8fafc;
            border-radius: 3px;
        }

        .page-break { page-break-before: always; }

        /* ============ FOOTER ============ */
        .footer {
            position: fixed;
            bottom: -14mm;
            left: 0;
            right: 0;
            padding-top: 4mm;
            font-size: 7px;
            color: #6b7280;
            text-align: center;
            border-top: 0.4px solid #cbd5e1;
        }
        .footer .pn:before {
            content: "Halaman " counter(page) " dari " counter(pages);
        }
    </style>
</head>
<body>
    {{-- KOP / HEADER --}}
    <div class="kop">
        <p class="l1">Biro Perencanaan</p>
        <p class="l2">Sekretariat Jenderal</p>
        <p class="l3">Kementerian Kelautan dan Perikanan</p>
    </div>
    <div class="kop-rule-wrap">
        <hr class="kop-rule-thick">
        <hr class="kop-rule-thin">
    </div>

    {{-- DOC TITLE --}}
    <div class="doc-title-block">
        <p class="doc-title">Progres Pembangunan KNMP Tahap {{ $tahapLabel }}</p>
        <p class="doc-subtitle">
            @if($selectedProgresDate)
                Data per tanggal <strong>{{ \Carbon\Carbon::parse($selectedProgresDate)->translatedFormat('d F Y') }}</strong>
            @else
                Data per tanggal <strong>{{ $exportDate }}</strong>
            @endif
        </p>
    </div>

    {{-- TABLE --}}
    <table class="progres-table">
        <thead>
            <tr>
                <th style="width: 24px;">No</th>
                <th>Nama KNMP dan Lokasi</th>
                <th style="width: 22%;">Penyedia Jasa Konstruksi</th>
                <th style="width: 58px;">Progres Fisik (%)</th>
                <th style="width: 18%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tableData as $index => $row)
                <tr>
                    <td class="col-no">{{ $index + 1 }}</td>
                    <td class="col-lokasi">
                        <p class="nama">{{ $row['lokasi_1'] }}</p>
                        <p class="alamat">{{ $row['lokasi_2'] }}</p>
                    </td>
                    <td class="text-center {{ $row['nama_penyedia'] ? '' : 'muted' }}">
                        {{ $row['nama_penyedia'] ?: '—' }}
                    </td>
                    <td class="col-progres">
                        {{ number_format($row['progres'], 2, ',', '.') }}
                    </td>
                    <td class="text-center {{ $row['keterangan'] ? '' : 'muted' }}">
                        {{ $row['keterangan'] ?: '—' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center muted" style="padding: 18px; font-style: italic;">
                        Belum ada data progres untuk filter yang dipilih.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- DOCUMENTATION SECTION --}}
    <div class="doc-section">
        <p class="doc-section-title">Dokumentasi Progres Pembangunan KNMP</p>

        @if(count($photosByProvince) > 0)
            @foreach($photosByProvince as $province => $items)
                <p class="province-title">
                    {{ $province }}<span class="count">({{ count($items) }} lokasi)</span>
                </p>
                <div class="photo-grid">
                    @foreach($items as $item)
                        <div class="photo-card">
                            <div class="photo-card-body">
                                @foreach($item['photos'] as $photo)
                                    @php
                                        $imagePath = storage_path('app/public/' . $photo->path_file);
                                        $src = '';
                                        if (file_exists($imagePath)) {
                                            $type = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
                                            if ($type === 'jpg') {
                                                $type = 'jpeg';
                                            }
                                            $data = file_get_contents($imagePath);
                                            $src = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                        }
                                    @endphp
                                    @if($src)
                                        <img src="{{ $src }}" alt="{{ $photo->nama_file ?? $item['nama'] }}">
                                    @else
                                        <div style="height: 105px; line-height: 105px; color: #9ca3af; font-size: 8px; background: #f1f5f9;">
                                            (Foto tidak tersedia)
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="photo-card-caption">
                                <p class="nama">{{ $item['nama'] }}</p>
                                @if(!empty($item['lokasi']))
                                    <p class="lokasi">{{ $item['lokasi'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="photo-empty">
                Belum ada dokumentasi foto pembangunan yang tersedia.
            </div>
        @endif
    </div>

    <div class="footer">
        <span>Biro Perencanaan &middot; Sekretariat Jenderal &middot; Kementerian Kelautan dan Perikanan</span>
        &nbsp;&middot;&nbsp;
        <span class="pn"></span>
    </div>
</body>
</html>
