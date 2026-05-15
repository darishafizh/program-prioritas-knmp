@include('knmp.tahap._stage_index', [
    'title'       => 'Tahap Lelang',
    'stageName'   => 'Lelang',
    'icon'        => 'mdi-gavel',
    'lucideIcon'  => 'gavel',
    'color'       => '#f59e0b',
    'colorEnd'    => '#d97706',
    'colorShadow' => 'rgba(245, 158, 11, 0.3)',
    'showRoute'   => 'lelang.show',
    'importRoute' => route('usulan.import'),
    'knmps'       => $knmps,
    'templateSection' => 'lelang-knmp',
    'columns'     => [
        ['label' => 'Lokasi KNMP', 'key' => 'nama', 'type' => 'lokasi'],
        ['label' => 'Status', 'key' => 'status', 'type' => 'badge_status'],
    ]
])
