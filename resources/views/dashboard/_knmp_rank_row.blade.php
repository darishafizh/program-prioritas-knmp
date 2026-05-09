@php
    /** @var \App\Models\ProgresKnmpNasional $item */
    /** @var string $context  'top' | 'bottom' */
    $namaKnmp     = $item->knmp->nama ?? ('KNMP #'.$item->knmp_id);
    $deviasiValue = isset($item->deviasi) ? round((float) $item->deviasi, 2) : 0;
    $progresValue = (float) $item->progres;
    $isComplete   = !empty($item->is_complete);
    $isStagnan    = !empty($item->is_stagnan);

    $progresClass = $isStagnan
        ? 'text-danger'
        : ($isComplete
            ? 'text-success'
            : ($context === 'top' ? 'text-success' : 'text-danger'));

    $rowClass = $isStagnan ? 'knmp-rank-row knmp-rank-row--alert' : 'knmp-rank-row';

    $tooltipHtml = '';
    if ($isStagnan) {
        $past   = $item->past_progres !== null ? round((float) $item->past_progres, 2) : null;
        $tglRaw = $item->past_progres_date ?? null;
        $tgl    = $tglRaw ? \Carbon\Carbon::parse($tglRaw)->translatedFormat('d M Y') : null;

        $tooltipHtml  = '<div class="knmp-tt">';
        $tooltipHtml .= '<div class="knmp-tt__title"><i class="mdi mdi-alert-circle-outline"></i> Progres Stagnan</div>';
        $tooltipHtml .= '<div class="knmp-tt__name">' . e($namaKnmp) . '</div>';
        $tooltipHtml .= '<div class="knmp-tt__rows">';
        $tooltipHtml .= '<div class="knmp-tt__row"><span>Progres Saat ini</span><strong>' . number_format($progresValue, 2, ',', '.') . '%</strong></div>';
        $tooltipHtml .= '<div class="knmp-tt__row"><span>Deviasi</span><strong>' . ($deviasiValue > 0 ? '+' : '') . number_format($deviasiValue, 2, ',', '.') . '%</strong></div>';
        if ($past !== null) {
            $tooltipHtml .= '<div class="knmp-tt__row"><span>5 hari lalu' . ($tgl ? ' ('.$tgl.')' : '') . '</span><strong>' . number_format($past, 2, ',', '.') . '%</strong></div>';
            $tooltipHtml .= '<div class="knmp-tt__row knmp-tt__row--delta"><span>Selisih</span><strong>0,00%</strong></div>';
        }
        $tooltipHtml .= '</div>';
        $tooltipHtml .= '<div class="knmp-tt__hint">Tidak ada perubahan progres dalam 5 hari terakhir.</div>';
        $tooltipHtml .= '</div>';
    } elseif ($isComplete) {
        $tooltipHtml  = '<div class="knmp-tt knmp-tt--ok">';
        $tooltipHtml .= '<div class="knmp-tt__title"><i class="mdi mdi-check-circle-outline"></i> Pembangunan Selesai</div>';
        $tooltipHtml .= '<div class="knmp-tt__name">' . e($namaKnmp) . '</div>';
        $tooltipHtml .= '<div class="knmp-tt__hint">Progres mencapai 100%.</div>';
        $tooltipHtml .= '</div>';
    } else {
        $tooltipHtml = '<div class="knmp-tt knmp-tt--plain">' . e($namaKnmp) . '<br><span class="text-muted" style="font-size: 0.7rem;">Progres: ' . number_format($progresValue, 2, ',', '.') . '%</span></div>';
    }
@endphp

<tr class="{{ $rowClass }}">
    <td class="ps-4 align-middle" style="font-size: 0.8rem;">
        <div class="d-flex align-items-center"
             data-bs-toggle="tooltip"
             data-bs-html="true"
             data-bs-placement="right"
             data-bs-custom-class="knmp-rank-tooltip{{ $isStagnan ? ' knmp-rank-tooltip--alert' : ($isComplete ? ' knmp-rank-tooltip--ok' : '') }}"
             data-bs-title="{{ $tooltipHtml }}">
            @if($isStagnan)
                <span class="knmp-rank-row__alert" aria-label="Progres stagnan 5 hari">
                    <i class="mdi mdi-alert-octagram-outline"></i>
                </span>
            @elseif($isComplete)
                <span class="knmp-rank-row__check" aria-label="Pembangunan selesai">
                    <i class="mdi mdi-check-decagram"></i>
                </span>
            @endif
            <span class="fw-medium text-truncate d-inline-block {{ $isStagnan ? 'text-danger' : 'text-dark' }}" style="max-width: 140px;">
                {{ $namaKnmp }}
            </span>
        </div>
    </td>
    <td class="text-end fw-bold pe-4 align-middle {{ $progresClass }}" style="font-size: 0.8rem;">
        {{ $deviasiValue > 0 ? '+' : '' }}{{ number_format($deviasiValue, 2, ',', '.') }}%
    </td>
</tr>
