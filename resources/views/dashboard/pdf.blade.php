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
            margin: 35px 45px;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', Arial, sans-serif;
            font-size: 10px;
            color: #1f2937;
            line-height: 1.45;
        }

        /* HEADER */
        .header-formal {
            text-align: center;
            margin-bottom: 18px;
        }
        .header-formal .line {
            font-weight: 700;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .header-formal .line-1 { font-size: 14px; }
        .header-formal .line-2 { font-size: 12px; margin-top: 2px; }
        .header-formal .line-3 { font-size: 13px; margin-top: 2px; }
        .header-formal hr.thick {
            border: 0;
            border-bottom: 3px solid #000;
            margin: 8px 0 0 0;
        }

        /* BODY TITLE */
        .doc-title {
            text-align: center;
            font-size: 13px;
            font-weight: 700;
            color: #000;
            text-transform: uppercase;
            margin: 14px 0 4px 0;
            letter-spacing: 0.3px;
        }
        .doc-subtitle {
            text-align: center;
            font-size: 10px;
            font-weight: 500;
            color: #1f2937;
            margin: 0 0 12px 0;
        }

        /* TABLE */
        table.progres-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }
        table.progres-table th,
        table.progres-table td {
            border: 1px solid #94a3b8;
            padding: 6px 7px;
            font-size: 9px;
            vertical-align: middle;
        }
        table.progres-table thead th {
            background: #e5e7eb;
            color: #000;
            font-weight: 600;
            text-align: center;
            text-transform: uppercase;
            font-size: 8.5px;
            letter-spacing: 0.3px;
        }
        table.progres-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        .text-center { text-align: center; }
        .text-right  { text-align: right; }
        .fw-bold     { font-weight: 700; }
        .fw-semibold { font-weight: 600; }
        .muted       { color: #6b7280; font-style: italic; }

        .lokasi-name {
            font-size: 9px;
            font-weight: 600;
            color: #000;
            margin-bottom: 1px;
        }
        .lokasi-detail {
            font-size: 8px;
            color: #4b5563;
        }

        /* DOCUMENTATION */
        .doc-section-title {
            font-size: 12px;
            font-weight: 700;
            color: #000;
            text-transform: uppercase;
            text-align: center;
            margin: 6px 0 12px 0;
            padding: 6px 0;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            letter-spacing: 0.4px;
        }
        .province-title {
            font-size: 11px;
            font-weight: 700;
            color: #000;
            background: #e5e7eb;
            padding: 5px 10px;
            margin: 10px 0 8px 0;
            border-left: 4px solid #000;
        }
        .photo-grid {
            width: 100%;
            margin-bottom: 6px;
        }
        .photo-card {
            width: 31%;
            display: inline-block;
            vertical-align: top;
            margin: 0 1.5% 12px 0;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            overflow: hidden;
            page-break-inside: avoid;
            text-align: center;
            background: #ffffff;
        }
        .photo-card-body {
            padding: 4px;
            background: #f8fafc;
        }
        .photo-card-body img {
            width: 100%;
            height: 110px;
            object-fit: cover;
            border-radius: 2px;
            display: block;
        }
        .photo-card-caption {
            padding: 6px 6px 8px 6px;
            text-align: center;
        }
        .photo-card-caption .nama {
            font-size: 8.5px;
            font-weight: 600;
            color: #000;
            margin: 0 0 2px 0;
            line-height: 1.25;
        }
        .photo-card-caption .lokasi {
            font-size: 7.5px;
            color: #4b5563;
            margin: 0;
            line-height: 1.25;
        }
        .photo-empty {
            padding: 30px 10px;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
            font-style: italic;
            border: 1px dashed #cbd5e1;
            background: #f8fafc;
        }

        .page-break { page-break-before: always; }

        /* FOOTER */
        .footer {
            position: fixed;
            bottom: -25px;
            left: 0;
            right: 0;
            padding: 6px 0;
            font-size: 7.5px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>
<body>
    {{-- HEADER FORMAL --}}
    <div class="header-formal">
        <div class="line line-1">Biro Perencanaan</div>
        <div class="line line-2">Sekretariat Jenderal</div>
        <div class="line line-3">Kementerian Kelautan dan Perikanan</div>
        <hr class="thick">
    </div>

    {{-- BODY TITLE --}}
    <div class="doc-title">
        Progres Pembangunan KNMP Tahap {{ $tahapLabel }}
    </div>
    <div class="doc-subtitle">
        @if($selectedProgresDate)
            Data per tanggal: {{ \Carbon\Carbon::parse($selectedProgresDate)->translatedFormat('d F Y') }}
        @else
            Data per tanggal: {{ $exportDate }}
        @endif
    </div>

    {{-- TABLE --}}
    <table class="progres-table">
        <thead>
            <tr>
                <th style="width: 28px;">No</th>
                <th>Nama KNMP dan Lokasi</th>
                <th style="width: 130px;">Penyedia Jasa Konstruksi</th>
                <th style="width: 70px;">% Progres Fisik</th>
                <th style="width: 110px;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tableData as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <div class="lokasi-name">{{ $row['lokasi_1'] }}</div>
                        <div class="lokasi-detail">{{ $row['lokasi_2'] }}</div>
                    </td>
                    <td class="text-center {{ $row['nama_penyedia'] ? '' : 'muted' }}">
                        {{ $row['nama_penyedia'] ?: '-' }}
                    </td>
                    <td class="text-center fw-semibold">
                        {{ number_format($row['progres'], 2, ',', '.') }}%
                    </td>
                    <td class="text-center {{ $row['keterangan'] ? '' : 'muted' }}">
                        {{ $row['keterangan'] ?: '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center muted" style="padding: 18px;">
                        Belum ada data progres.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- DOCUMENTATION SECTION --}}
    <div class="doc-section-title">
        Dokumentasi Progres Pembangunan KNMP
    </div>

    @if(count($photosByProvince) > 0)
        @foreach($photosByProvince as $province => $items)
            <div class="province-title">{{ $province }}</div>
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
                                    <div style="height: 110px; line-height: 110px; color: #9ca3af; font-size: 8px;">
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

    <div class="footer">
        Biro Perencanaan &mdash; Sekretariat Jenderal &mdash; Kementerian Kelautan dan Perikanan &middot; Dicetak: {{ $exportDate }}
    </div>
</body>
</html>
