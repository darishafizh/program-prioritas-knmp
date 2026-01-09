<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard KNMP - Laporan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }

        .header {
            background: linear-gradient(135deg, #1e3a5f 0%, #0891b2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 11px;
            opacity: 0.9;
        }

        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .section-title {
            background: #f1f5f9;
            padding: 8px 15px;
            font-size: 13px;
            font-weight: bold;
            color: #1e3a5f;
            border-left: 4px solid #0891b2;
            margin-bottom: 10px;
        }

        .stats-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .stat-card {
            display: table-cell;
            width: 33.33%;
            padding: 10px;
            text-align: center;
            border: 1px solid #e5e7eb;
        }

        .stat-value {
            font-size: 22px;
            font-weight: bold;
            color: #0891b2;
        }

        .stat-label {
            font-size: 10px;
            color: #6b7280;
            margin-top: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f8fafc;
            font-weight: bold;
            color: #374151;
        }

        .progress-bar {
            background: #e5e7eb;
            border-radius: 4px;
            height: 12px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #0891b2;
        }

        .rank-1 {
            color: #f59e0b;
            font-weight: bold;
        }

        .rank-2 {
            color: #6b7280;
            font-weight: bold;
        }

        .rank-3 {
            color: #b45309;
            font-weight: bold;
        }

        .text-success {
            color: #10b981;
        }

        .text-danger {
            color: #ef4444;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px 20px;
            font-size: 9px;
            color: #9ca3af;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>📊 Dashboard Monitoring KNMP</h1>
        <p>Kementerian Kelautan dan Perikanan Republik Indonesia</p>
        <p style="margin-top: 5px;">Periode: {{ $periodLabel }} | Diekspor: {{ $exportDate }}</p>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="section">
        <div class="section-title">Ringkasan Statistik Nasional</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ number_format(count($desa_knmp)) }}</div>
                <div class="stat-label">Total Lokasi KNMP</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ number_format($totalSurveyTerisi) }}</div>
                <div class="stat-label">Survey Terisi</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ number_format($tingkatKelengkapanData, 1) }}%</div>
                <div class="stat-label">Kelengkapan Data</div>
            </div>
        </div>
        <div class="stats-grid" style="margin-top: 5px;">
            <div class="stat-card">
                <div class="stat-value">{{ number_format($capaianIndikator, 1) }}%</div>
                <div class="stat-label">Capaian Indikator</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ number_format($rataRataKebahagiaan, 2) }}</div>
                <div class="stat-label">Indeks Kebahagiaan</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ number_format($totalTenagaKerja) }}</div>
                <div class="stat-label">Tenaga Kerja Terserap</div>
            </div>
        </div>
    </div>

    <!-- Progress Nasional -->
    <div class="section">
        <div class="section-title">Progress Pembangunan Nasional</div>
        <table>
            <tr>
                <td style="width: 40%;">Target KNMP Nasional</td>
                <td>{{ $targetKnmp }} lokasi</td>
            </tr>
            <tr>
                <td>KNMP Terimplementasi</td>
                <td>{{ $totalKnmpNasional }} lokasi</td>
            </tr>
            <tr>
                <td>Persentase Tercapai</td>
                <td>
                    <div class="progress-bar" style="display: inline-block; width: 200px; vertical-align: middle;">
                        <div class="progress-fill" style="width: {{ $progressNasional }}%;"></div>
                    </div>
                    <strong>{{ $progressNasional }}%</strong>
                </td>
            </tr>
        </table>
    </div>

    <!-- Top 5 Provinsi -->
    <div class="section">
        <div class="section-title">🏆 Top 5 Provinsi Terbaik</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">Rank</th>
                    <th>Provinsi</th>
                    <th style="width: 80px;">KNMP</th>
                    <th style="width: 120px;">Capaian</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topProvinsi as $index => $prov)
                    <tr>
                        <td class="rank-{{ $index + 1 }}">{{ $index + 1 }}</td>
                        <td>{{ $prov->province_name }}</td>
                        <td>{{ $prov->total_knmp }}</td>
                        <td class="text-success">{{ number_format($prov->avg_capaian, 1) }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Provinsi Perlu Perhatian -->
    <div class="section">
        <div class="section-title">⚠️ Provinsi Perlu Perhatian</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Provinsi</th>
                    <th style="width: 80px;">KNMP</th>
                    <th style="width: 120px;">Capaian</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bottomProvinsi as $index => $prov)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $prov->province_name }}</td>
                        <td>{{ $prov->total_knmp }}</td>
                        <td class="text-danger">{{ number_format($prov->avg_capaian, 1) }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Semua provinsi berkinerja baik!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Capaian per KNMP -->
    <div class="section">
        <div class="section-title">📈 Capaian per KNMP</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama KNMP</th>
                    <th style="width: 150px;">Capaian</th>
                </tr>
            </thead>
            <tbody>
                @forelse($capaianPerKnmpData as $index => $knmp)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $knmp->nama }}</td>
                        <td>
                            <div class="progress-bar" style="display: inline-block; width: 80px; vertical-align: middle;">
                                <div class="progress-fill" style="width: {{ min($knmp->avg_persen, 100) }}%;"></div>
                            </div>
                            {{ number_format($knmp->avg_persen, 1) }}%
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center;">Belum ada data KNMP</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        Dashboard KNMP - Kementerian Kelautan dan Perikanan © {{ date('Y') }} | Diekspor pada {{ $exportDate }}
    </div>
</body>

</html>