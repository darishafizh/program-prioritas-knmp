@include('knmp.tahap._stage_index', [
    'title'       => 'Tahap DED',
    'stageName'   => 'DED',
    'icon'        => 'mdi-drawing',
    'color'       => '#10b981',
    'colorEnd'    => '#059669',
    'colorShadow' => 'rgba(16, 185, 129, 0.3)',
    'showRoute'   => 'ded.show',
    'knmps'       => $knmps,
])
