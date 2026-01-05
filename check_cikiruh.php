<?php
use App\Models\Knmp;
use Illuminate\Support\Facades\DB;

$k = Knmp::with(['province','regency','district','village'])->where('nama', 'like', '%Cikiruh%')->first();

if ($k) {
    echo "KNMP: " . $k->nama . "\n";
    echo "Province ID: " . $k->province_id . " - " . ($k->province->name ?? 'NULL') . "\n";
    echo "Regency ID: " . $k->regency_id . " - " . ($k->regency->name ?? 'NULL') . "\n";
    echo "District ID: " . $k->district_id . " - " . ($k->district->name ?? 'NULL') . "\n";
    echo "Village ID: " . $k->village_id . " - " . ($k->village->name ?? 'NULL') . "\n";
} else {
    echo "KNMP Cikiruh not found\n";
}
