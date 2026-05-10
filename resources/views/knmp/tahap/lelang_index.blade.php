@include('knmp.tahap._stage_index', [
    'title'       => 'Tahap Lelang',
    'stageName'   => 'Lelang',
    'icon'        => 'mdi-gavel',
    'color'       => '#f59e0b',
    'colorEnd'    => '#d97706',
    'colorShadow' => 'rgba(245, 158, 11, 0.3)',
    'showRoute'   => 'lelang.show',
    'knmps'       => $knmps,
])
