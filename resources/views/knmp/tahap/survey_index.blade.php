@include('knmp.tahap._stage_index', [
    'title'       => 'Tahap Survey',
    'stageName'   => 'Survey',
    'icon'        => 'mdi-clipboard-text-outline',
    'color'       => '#06b6d4',
    'colorEnd'    => '#0891b2',
    'colorShadow' => 'rgba(6, 182, 212, 0.3)',
    'showRoute'   => 'survey_tahap.show',
    'knmps'       => $knmps,
])
