<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Progres KNMP Tahap {{ $tahapLabel }}</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://kampungnelayanmerahputih.kkp.go.id/img/favicon.ico">
    <style>
        @font-face {
            font-family: 'Lexend';
            font-style: normal;
            font-weight: 300;
            src: url('{{ storage_path("fonts/lexend/Lexend-Light.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Lexend';
            font-style: normal;
            font-weight: 400;
            src: url('{{ storage_path("fonts/lexend/Lexend-Regular.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Lexend';
            font-style: normal;
            font-weight: 500;
            src: url('{{ storage_path("fonts/lexend/Lexend-Medium.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Lexend';
            font-style: normal;
            font-weight: 600;
            src: url('{{ storage_path("fonts/lexend/Lexend-SemiBold.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Lexend';
            font-style: normal;
            font-weight: 700;
            src: url('{{ storage_path("fonts/lexend/Lexend-Bold.ttf") }}') format('truetype');
        }

        @page {
            margin: 40px 50px;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Lexend', Arial, sans-serif;
            font-size: 10px;
            color: #1e293b;
            line-height: 1.5;
        }

        .header-formal {
            text-align: center;
            margin-bottom: 20px;
            padding-top: 10px;
        }
        .header-formal h3 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
            color: #000;
        }
        .header-formal h1 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #000;
        }
        .header-formal .subtitle {
            font-size: 12px;
            color: #000;
        }
        .header-formal .date {
            font-size: 10px;
            margin-top: 5px;
            color: #000;
        }
        .header-formal hr.thick {
            border: 0;
            border-bottom: 3px solid #000;
            margin-top: 15px;
        }
        .header-formal hr.thin {
            border: 0;
            border-bottom: 1px solid #000;
            margin-top: 2px;
        }

        .content { padding: 0; }

        .section {
            margin-bottom: 18px;
        }
        .section-title {
            font-size: 11px;
            font-weight: 700;
            color: #000;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            text-align: left;
            font-size: 9px;
        }
        th {
            background: #e2e8f0;
            color: #000;
            font-weight: 600;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: 700; }



        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: 600;
        }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-primary { background: #dbeafe; color: #1e40af; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-gray { background: #f1f5f9; color: #475569; }

        .page-break { page-break-before: always; }

        .photo-island-title {
            font-size: 12px;
            font-weight: 700;
            color: #000;
            border-left: 4px solid #000;
            padding-left: 10px;
            margin-bottom: 12px;
            margin-top: 6px;
        }
        .photo-grid {
            width: 100%;
            margin-bottom: 15px;
        }
        .photo-card {
            width: 23%;
            display: inline-block;
            vertical-align: top;
            margin: 0 1% 10px 0;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
            page-break-inside: avoid;
            text-align: center;
        }
        .photo-card-header {
            background: #f1f5f9;
            padding: 4px;
            border-bottom: 1px solid #e2e8f0;
            height: 35px;
        }
        .photo-card-header h4 {
            font-size: 8px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            line-height: 1.2;
        }
        .photo-card-header small {
            font-size: 6px;
            color: #64748b;
        }
        .photo-card-body {
            padding: 4px;
        }
        .photo-card-body img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 2px;
        }

        .footer {
            position: fixed;
            bottom: -40px;
            left: 0;
            right: 0;
            padding: 8px 0;
            font-size: 7px;
            color: #94a3b8;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            background: #fff;
        }
    </style>
</head>
<body>
    {{-- HEADER FORMAL --}}
    <div class="header-formal">
        <h3>KEMENTERIAN KELAUTAN DAN PERIKANAN REPUBLIK INDONESIA</h3>
        <h1>LAPORAN PROGRES PEMBANGUNAN KAMPUNG NELAYAN MERAH PUTIH (KNMP)</h1>
        <div class="subtitle">TAHAP {{ strtoupper($tahapLabel) }}</div>
        <div class="date">Tanggal Laporan: {{ $exportDate }}</div>
        <hr class="thick">
        <hr class="thin">
    </div>

    <div class="content">
        {{-- DATA TABLE --}}
        <div class="section">
            <div class="section-title">Data Progres Pembangunan KNMP</div>

            @if($selectedProgresDate)
                <p style="font-size: 8px; color: #64748b; margin-bottom: 8px;">
                    Data per tanggal: <strong>{{ \Carbon\Carbon::parse($selectedProgresDate)->format('d F Y') }}</strong>
                </p>
            @endif

            <table>
                <thead>
                    <tr>
                        <th style="width: 30px;" class="text-center">No</th>
                        <th style="width: 140px;">Lokasi</th>
                        <th>Nama Penyedia</th>
                        <th style="width: 100px;" class="text-center">% Progres Fisik</th>
                        <th style="width: 80px;" class="text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tableData as $index => $row)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold" style="font-size: 9px; color: #000; margin-bottom: 2px;">{{ $row['lokasi_1'] }}</div>
                                <div style="font-size: 7px; color: #64748b;">{{ $row['lokasi_2'] }}</div>
                            </td>
                            <td class="text-center" style="color: #94a3b8; font-style: italic;">
                                {{ $row['nama_penyedia'] ?: '-' }}
                            </td>
                            <td class="text-center">
                                <span class="fw-bold">{{ number_format($row['progres'], 2) }}%</span>
                            </td>
                            <td class="text-center" style="color: #94a3b8; font-style: italic;">
                                {{ $row['keterangan'] ?: '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center" style="padding: 20px; color: #94a3b8;">Belum ada data progres.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PHOTO ATTACHMENTS --}}
        @if(count($photosByIsland) > 0)
            <div class="page-break"></div>
            <div class="section">
                <div class="section-title">Lampiran Foto Pembangunan KNMP</div>
                <p style="font-size: 8px; color: #64748b; margin-bottom: 12px;">
                    Dokumentasi foto dikelompokkan berdasarkan wilayah pulau.
                </p>

                @foreach($photosByIsland as $island => $knmpPhotos)
                    <div class="photo-island-title">{{ $island }}</div>

                    <div class="photo-grid">
                        @foreach($knmpPhotos as $knmpPhoto)
                            <div class="photo-card">
                                <div class="photo-card-header">
                                    <h4>{{ $knmpPhoto['nama'] }}</h4>
                                    <small>{{ $knmpPhoto['lokasi'] }}</small>
                                </div>
                                <div class="photo-card-body">
                                    @foreach($knmpPhoto['photos'] as $photo)
                                        @php
                                            $imagePath = storage_path('app/public/' . $photo->path_file);
                                            $src = '';
                                            if (file_exists($imagePath)) {
                                                $type = pathinfo($imagePath, PATHINFO_EXTENSION);
                                                $data = file_get_contents($imagePath);
                                                $src = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                            }
                                        @endphp
                                        @if($src)
                                            <img src="{{ $src }}" alt="{{ $photo->nama_file }}">
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="footer">
        Laporan Progres KNMP Tahap {{ $tahapLabel }} &mdash; Biro Perencanaan, Kementerian Kelautan dan Perikanan &copy; {{ date('Y') }} &mdash; Dicetak: {{ $exportDate }}
    </div>
</body>
</html>