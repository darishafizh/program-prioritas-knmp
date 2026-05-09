<?php

namespace App\Imports;

use App\Models\Knmp;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
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

    private function findOrCreateProvince(string $name): Province
    {
        $name = strtoupper(trim($name));
        
        $province = Province::where('nama', 'LIKE', '%' . $name . '%')->first();
        
        if (!$province) {
            $province = Province::create(['nama' => $name]);
        }
        
        return $province;
    }

    private function findOrCreateRegency(string $name, $provinceId): Regency
    {
        $name = strtoupper(trim($name));
        
        $regency = Regency::where('provinsi_id', $provinceId)
            ->where('nama', 'LIKE', '%' . $name . '%')
            ->first();
        
        if (!$regency) {
            $regency = Regency::create([
                'provinsi_id' => $provinceId,
                'nama' => $name
            ]);
        }
        
        return $regency;
    }

    private function findOrCreateDistrict(string $name, $regencyId): District
    {
        $name = strtoupper(trim($name));
        
        $district = District::where('kabupaten_kota_id', $regencyId)
            ->where('nama', 'LIKE', '%' . $name . '%')
            ->first();
        
        if (!$district) {
            $district = District::create([
                'kabupaten_kota_id' => $regencyId,
                'nama' => $name
            ]);
        }
        
        return $district;
    }

    private function findOrCreateVillage(string $name, $districtId): Village
    {
        $name = strtoupper(trim($name));
        
        $village = Village::where('kecamatan_id', $districtId)
            ->where('nama', 'LIKE', '%' . $name . '%')
            ->first();
        
        if (!$village) {
            $village = Village::create([
                'kecamatan_id' => $districtId,
                'nama' => $name
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
            ->where('desa_kelurahan', $village->id)
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
            'provinsi' => $province->id,
            'kabupaten_kota' => $regency->id,
            'kecamatan' => $district->id,
            'desa_kelurahan' => $village->id,
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
