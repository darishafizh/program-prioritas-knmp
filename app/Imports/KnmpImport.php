<?php

namespace App\Imports;

use App\Models\Knmp;
use App\Models\KnmpProvinces;
use App\Models\KnmpRegencies;
use App\Models\KnmpDistricts;
use App\Models\KnmpVillages;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Events\BeforeImport;

class KnmpImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, WithEvents, WithCalculatedFormulas
{
    /**
     * Required columns for this import type
     */
    protected $requiredColumns = [
        'nama',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'desa',
    ];

    /**
     * Register events to validate headers before import
     */
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $worksheet = $event->reader->getActiveSheet();
                $headerRow = $worksheet->getRowIterator(1)->current();

                $actualHeaders = [];
                foreach ($headerRow->getCellIterator() as $cell) {
                    $value = $cell->getValue();
                    if (!empty($value)) {
                        $actualHeaders[] = strtolower(trim($value));
                    }
                }

                $missingColumns = array_diff($this->requiredColumns, $actualHeaders);

                if (!empty($missingColumns)) {
                    throw new \Exception(
                        "File Excel tidak sesuai dengan format Daftar KNMP. " .
                        "Kolom yang diperlukan tidak ditemukan: " . implode(', ', $missingColumns) . ". " .
                        "Pastikan Anda menggunakan template yang benar."
                    );
                }
            },
        ];
    }

    /**
     * Find or create province by name
     */
    private function findOrCreateProvince(string $name): KnmpProvinces
    {
        $name = strtoupper(trim($name));
        
        $province = KnmpProvinces::where('name', 'LIKE', '%' . $name . '%')->first();
        
        if (!$province) {
            $province = KnmpProvinces::create(['name' => $name]);
        }
        
        return $province;
    }

    /**
     * Find or create regency by name within province
     */
    private function findOrCreateRegency(string $name, int $provinceId): KnmpRegencies
    {
        $name = strtoupper(trim($name));
        
        $regency = KnmpRegencies::where('knmp_province_id', $provinceId)
            ->where('name', 'LIKE', '%' . $name . '%')
            ->first();
        
        if (!$regency) {
            $regency = KnmpRegencies::create([
                'knmp_province_id' => $provinceId,
                'name' => $name
            ]);
        }
        
        return $regency;
    }

    /**
     * Find or create district by name within regency
     */
    private function findOrCreateDistrict(string $name, int $regencyId): KnmpDistricts
    {
        $name = strtoupper(trim($name));
        
        $district = KnmpDistricts::where('knmp_regency_id', $regencyId)
            ->where('name', 'LIKE', '%' . $name . '%')
            ->first();
        
        if (!$district) {
            $district = KnmpDistricts::create([
                'knmp_regency_id' => $regencyId,
                'name' => $name
            ]);
        }
        
        return $district;
    }

    /**
     * Find or create village by name within district
     */
    private function findOrCreateVillage(string $name, int $districtId): KnmpVillages
    {
        $name = strtoupper(trim($name));
        
        $village = KnmpVillages::where('knmp_district_id', $districtId)
            ->where('name', 'LIKE', '%' . $name . '%')
            ->first();
        
        if (!$village) {
            $village = KnmpVillages::create([
                'knmp_district_id' => $districtId,
                'name' => $name
            ]);
        }
        
        return $village;
    }

    public function model(array $row)
    {
        // Skip if required fields are empty
        if (empty($row['nama']) || empty($row['provinsi']) || empty($row['kabupaten']) || 
            empty($row['kecamatan']) || empty($row['desa'])) {
            return null;
        }

        // Find or create province
        $province = $this->findOrCreateProvince($row['provinsi']);

        // Find or create regency within province
        $regency = $this->findOrCreateRegency($row['kabupaten'], $province->id);

        // Find or create district within regency
        $district = $this->findOrCreateDistrict($row['kecamatan'], $regency->id);

        // Find or create village within district
        $village = $this->findOrCreateVillage($row['desa'], $district->id);

        // Check if KNMP already exists (by name and village)
        $existingKnmp = Knmp::where('nama', trim($row['nama']))
            ->where('village_id', $village->id)
            ->first();

        if ($existingKnmp) {
            // Update existing KNMP if latitude/longitude provided
            if (!empty($row['latitude']) && !empty($row['longitude'])) {
                $existingKnmp->update([
                    'latitude' => $row['latitude'],
                    'longitude' => $row['longitude'],
                ]);
            }
            return null; // Don't create new, already exists
        }

        return new Knmp([
            'nama' => trim($row['nama']),
            'province_id' => $province->id,
            'regency_id' => $regency->id,
            'district_id' => $district->id,
            'village_id' => $village->id,
            'latitude' => $row['latitude'] ?? null,
            'longitude' => $row['longitude'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'provinsi' => 'required|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'desa' => 'required|string',
        ];
    }
}
