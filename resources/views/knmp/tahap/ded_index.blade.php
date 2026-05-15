@include('knmp.tahap._stage_index', [
    'title'       => 'Tahap DED',
    'stageName'   => 'DED',
    'icon'        => 'mdi-drawing',
    'lucideIcon'  => 'drafting-compass',
    'color'       => '#10b981',
    'colorEnd'    => '#059669',
    'colorShadow' => 'rgba(16, 185, 129, 0.3)',
    'showRoute'   => 'ded.show',
    'importRoute' => route('usulan.import'),
    'knmps'       => $knmps,
    'templateSection' => 'ded-knmp',
    'columns'     => [
        ['label' => 'Lokasi KNMP', 'key' => 'nama', 'type' => 'lokasi'],
        ['label' => 'Status', 'key' => 'status', 'type' => 'badge_status'],
    ]
])
