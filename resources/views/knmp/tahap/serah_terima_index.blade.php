@include('knmp.tahap._stage_index', [
    'title'       => 'Tahap Serah Terima',
    'stageName'   => 'Serah Terima',
    'icon'        => 'mdi-handshake',
    'lucideIcon'  => 'handshake',
    'color'       => '#8b5cf6',
    'colorEnd'    => '#6d28d9',
    'colorShadow' => 'rgba(139, 92, 246, 0.3)',
    'showRoute'   => 'serah_terima.show',
    'importRoute' => route('usulan.import'),
    'knmps'       => $knmps,
    'templateSection' => 'serah-terima-knmp',
    'columns'     => [
        ['label' => 'Lokasi KNMP', 'key' => 'nama', 'type' => 'lokasi'],
        ['label' => 'Status', 'key' => 'status', 'type' => 'badge_status'],
    ]
])
