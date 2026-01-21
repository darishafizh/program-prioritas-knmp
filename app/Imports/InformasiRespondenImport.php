<?php

namespace App\Imports;

use App\Models\InformasiResponden;
use App\Models\KnmpProvinces;
use App\Models\KnmpRegencies;
use App\Models\KnmpDistricts;
use App\Models\KnmpVillages;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Collection;

class InformasiRespondenImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected $knmpId;
    protected $errors = [];

    public function __construct($knmpId)
    {
        $this->knmpId = $knmpId;
    }

    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Lookup location IDs from names
        $provinceId = $this->lookupProvinceId($row['province_id'] ?? $row['provinsi'] ?? null);
        $regencyId = $this->lookupRegencyId($row['regency_id'] ?? $row['kabupaten'] ?? null, $provinceId);
        $districtId = $this->lookupDistrictId($row['district_id'] ?? $row['kecamatan'] ?? null, $regencyId);
        $villageId = $this->lookupVillageId($row['village_id'] ?? $row['desa'] ?? null, $districtId);

        return new InformasiResponden([
            'knmp_id' => $this->knmpId,
            'nama_responden' => $row['nama_responden'] ?? null,
            'nik' => $row['nik'] ?? null,
            'nomor_kusuka' => $row['nomor_kusuka'] ?? null,
            'tempat_lahir' => $row['tempat_lahir'] ?? null,
            'tanggal_lahir' => $this->parseDate($row['tanggal_lahir'] ?? null),
            'umur' => $row['umur'] ?? null,
            'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
            'suku_bangsa' => $row['suku_bangsa'] ?? null,
            'pendidikan_terakhir' => $row['pendidikan_terakhir'] ?? null,
            'wpp' => $row['wpp'] ?? null,
            'alamat' => $row['alamat'] ?? null,
            'no_hp_responden' => $row['no_hp_responden'] ?? null,
            'jumlah_anggota_rumah' => $row['jumlah_anggota_rumah'] ?? null,
            'jumlah_anggota_perempuan_rumah' => $row['jumlah_anggota_perempuan_rumah'] ?? null,
            'jumlah_anggota_bekerja' => $row['jumlah_anggota_bekerja'] ?? null,
            'jumlah_anggota_perempuan_bekerja' => $row['jumlah_anggota_perempuan_bekerja'] ?? null,
            'jumlah_abk' => $row['jumlah_abk'] ?? null,
            'pengalaman_usaha' => $row['pengalaman_usaha'] ?? null,
            'province_id' => $provinceId,
            'regency_id' => $regencyId,
            'district_id' => $districtId,
            'village_id' => $villageId,
            'tanggal_wawancara' => $this->parseDate($row['tanggal_wawancara'] ?? null),
            'nama_enumerator' => $row['nama_enumerator'] ?? null,
            'jenis_kelamin_enumerator' => $row['jenis_kelamin_enumerator'] ?? null,
            'no_hp_enumerator' => $row['no_hp_enumerator'] ?? null,
        ]);
    }

    /**
     * Lookup province ID from name or return as-is if already numeric
     */
    protected function lookupProvinceId($value)
    {
        if (empty($value)) return null;
        if (is_numeric($value)) return (int) $value;
        
        $province = KnmpProvinces::where('name', 'LIKE', '%' . trim($value) . '%')->first();
        return $province ? $province->id : null;
    }

    /**
     * Lookup regency ID from name or return as-is if already numeric
     */
    protected function lookupRegencyId($value, $provinceId = null)
    {
        if (empty($value)) return null;
        if (is_numeric($value)) return (int) $value;
        
        $query = KnmpRegencies::where('name', 'LIKE', '%' . trim($value) . '%');
        if ($provinceId) {
            $query->where('knmp_province_id', $provinceId);
        }
        $regency = $query->first();
        return $regency ? $regency->id : null;
    }

    /**
     * Lookup district ID from name or return as-is if already numeric
     */
    protected function lookupDistrictId($value, $regencyId = null)
    {
        if (empty($value)) return null;
        if (is_numeric($value)) return (int) $value;
        
        $query = KnmpDistricts::where('name', 'LIKE', '%' . trim($value) . '%');
        if ($regencyId) {
            $query->where('knmp_regency_id', $regencyId);
        }
        $district = $query->first();
        return $district ? $district->id : null;
    }

    /**
     * Lookup village ID from name or return as-is if already numeric
     */
    protected function lookupVillageId($value, $districtId = null)
    {
        if (empty($value)) return null;
        if (is_numeric($value)) return (int) $value;
        
        $query = KnmpVillages::where('name', 'LIKE', '%' . trim($value) . '%');
        if ($districtId) {
            $query->where('knmp_district_id', $districtId);
        }
        $village = $query->first();
        return $village ? $village->id : null;
    }

    /**
     * Parse date from Excel format
     */
    protected function parseDate($value)
    {
        if (empty($value)) {
            return null;
        }

        // Handle Excel serial date
        if (is_numeric($value)) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        // Handle string date
        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'nama_responden' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages()
    {
        return [
            'nama_responden.required' => 'Kolom "nama_responden" wajib diisi pada baris :attribute',
            'nama_responden.string' => 'Kolom "nama_responden" harus berupa teks pada baris :attribute',
            'nik.string' => 'Kolom "nik" harus berupa teks pada baris :attribute',
        ];
    }
}
