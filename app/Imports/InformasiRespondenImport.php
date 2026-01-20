<?php

namespace App\Imports;

use App\Models\InformasiResponden;
use App\Models\Knmp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class InformasiRespondenImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected $knmpId;
    protected $knmp;

    public function __construct($knmpId)
    {
        $this->knmpId = $knmpId;
        // Fetch KNMP data to get location information
        $this->knmp = Knmp::find($knmpId);
    }

    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
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
            // Get location IDs from KNMP address instead of Excel
            'province_id' => $this->knmp->province_id ?? null,
            'regency_id' => $this->knmp->regency_id ?? null,
            'district_id' => $this->knmp->district_id ?? null,
            'village_id' => $this->knmp->village_id ?? null,
            'tanggal_wawancara' => $this->parseDate($row['tanggal_wawancara'] ?? null),
            'nama_enumerator' => $row['nama_enumerator'] ?? null,
            'jenis_kelamin_enumerator' => $row['jenis_kelamin_enumerator'] ?? null,
            'no_hp_enumerator' => $row['no_hp_enumerator'] ?? null,
        ]);
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
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
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
}
