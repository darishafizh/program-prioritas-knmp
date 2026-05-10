@include('knmp.tahap._stage_index', [
    'title'       => 'Tahap Konstruksi',
    'stageName'   => 'Konstruksi',
    'icon'        => 'mdi-office-building',
    'color'       => '#ef4444',
    'colorEnd'    => '#dc2626',
    'colorShadow' => 'rgba(239, 68, 68, 0.3)',
    'showRoute'   => 'konstruksi.show',
    'knmps'       => $knmps,
])
