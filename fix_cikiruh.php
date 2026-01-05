<?php
use Illuminate\Support\Facades\DB;

// Get Banten province ID
$bantenId = DB::table('knmp_provinces')->where('name', 'Banten')->value('id');
echo "Banten Province ID: $bantenId\n";

// Add Pandeglang regency if not exists
$pandeglangId = DB::table('knmp_regencies')->where('name', 'Pandeglang')->value('id');
if (!$pandeglangId) {
    DB::table('knmp_regencies')->insert([
        'name' => 'Pandeglang',
        'province_id' => $bantenId,
        'created_at' => now(),
        'updated_at' => now()
    ]);
    $pandeglangId = DB::table('knmp_regencies')->where('name', 'Pandeglang')->value('id');
    echo "Created Pandeglang regency with ID: $pandeglangId\n";
} else {
    echo "Pandeglang already exists with ID: $pandeglangId\n";
}

// Add Cibitung district if not exists
$cibitungId = DB::table('knmp_districts')->where('name', 'Cibitung')->where('regency_id', $pandeglangId)->value('id');
if (!$cibitungId) {
    DB::table('knmp_districts')->insert([
        'name' => 'Cibitung',
        'regency_id' => $pandeglangId,
        'created_at' => now(),
        'updated_at' => now()
    ]);
    $cibitungId = DB::table('knmp_districts')->where('name', 'Cibitung')->value('id');
    echo "Created Cibitung district with ID: $cibitungId\n";
} else {
    echo "Cibitung already exists with ID: $cibitungId\n";
}

// Add Cikiruh Wetan village if not exists
$cikiruhId = DB::table('knmp_villages')->where('name', 'Cikiruh Wetan')->where('district_id', $cibitungId)->value('id');
if (!$cikiruhId) {
    DB::table('knmp_villages')->insert([
        'name' => 'Cikiruh Wetan',
        'district_id' => $cibitungId,
        'created_at' => now(),
        'updated_at' => now()
    ]);
    $cikiruhId = DB::table('knmp_villages')->where('name', 'Cikiruh Wetan')->value('id');
    echo "Created Cikiruh Wetan village with ID: $cikiruhId\n";
} else {
    echo "Cikiruh Wetan already exists with ID: $cikiruhId\n";
}

// Update KNMP Cikiruh Wetan
$updated = DB::table('knmp')->where('nama', 'like', '%Cikiruh%')->update([
    'province_id' => $bantenId,
    'regency_id' => $pandeglangId,
    'district_id' => $cibitungId,
    'village_id' => $cikiruhId
]);

echo "\nUpdated $updated KNMP record(s)\n";
echo "Done!\n";
