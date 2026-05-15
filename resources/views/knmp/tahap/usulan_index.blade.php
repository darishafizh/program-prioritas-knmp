@extends('knmp.tahap._stage_index', [
    'title'       => 'Tahap Usulan',
    'stageName'   => 'Usulan',
    'icon'        => 'mdi-clipboard-outline',
    'lucideIcon'  => 'clipboard-list',
    'color'       => '#3b82f6',
    'colorEnd'    => '#1e40af',
    'colorShadow' => 'rgba(59,130,246,.2)',
    'showRoute'   => 'usulan.show',
    'importRoute' => route('usulan.import'),
    'knmps'       => $knmps,
    'templateSection' => 'usulan-knmp',
    'columns'     => [
        ['label' => 'Lokasi KNMP', 'key' => 'nama', 'type' => 'lokasi'],
        ['label' => 'Status', 'key' => 'status', 'type' => 'badge_status'],
    ]
])
