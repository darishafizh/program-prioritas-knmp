@include('knmp.tahap._stage_index', [
    'title'       => 'Tahap Konstruksi',
    'stageName'   => 'Konstruksi',
    'icon'        => 'mdi-office-building',
    'lucideIcon'  => 'building-2',
    'color'       => '#ef4444',
    'colorEnd'    => '#dc2626',
    'colorShadow' => 'rgba(239, 68, 68, 0.3)',
    'showRoute'   => 'konstruksi.show',
    'importRoute' => route('dashboard.import_progres_nasional'),
    'knmps'       => $knmps,
    'availableTahap' => $availableTahap,
    'templateSection' => 'progres-knmp-nasional',
    'columns'     => [
        ['label' => 'Lokasi KNMP', 'key' => 'nama', 'type' => 'lokasi'],
        ['label' => 'Penyedia Jasa Konstruksi', 'key' => 'penyedia', 'type' => 'raw',
         'render' => function($k) { return '<span class="text-dark fw-medium" style="font-size: 0.8rem;">'.($k->konstruksiKnmp->penyediaJasa->nama ?? '-').'</span>'; }],
        ['label' => 'Progres', 'key' => 'progres', 'type' => 'progres_bar'],
        ['label' => 'Keterangan', 'key' => 'keterangan', 'type' => 'raw',
         'render' => function($k) { return '<div class="text-muted text-truncate" style="max-width: 200px; font-size: 0.75rem;" title="'.($k->latestProgresNasional->keterangan ?? '-').'">'.($k->latestProgresNasional->keterangan ?? '-').'</div>'; }],
    ]
])
