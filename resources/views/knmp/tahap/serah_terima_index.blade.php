@include('knmp.tahap._stage_index', [
    'title'       => 'Tahap Serah Terima',
    'stageName'   => 'Serah Terima',
    'icon'        => 'mdi-handshake',
    'color'       => '#8b5cf6',
    'colorEnd'    => '#6d28d9',
    'colorShadow' => 'rgba(139, 92, 246, 0.3)',
    'showRoute'   => 'serah_terima.show',
    'knmps'       => $knmps,
])
