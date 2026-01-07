<?php

namespace App\Imports;

use App\Models\TanggapanMasyarakat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class TanggapanMasyarakatImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected $knmpId;

    public function __construct($knmpId)
    {
        $this->knmpId = $knmpId;
    }

    public function model(array $row)
    {
        return new TanggapanMasyarakat([
            'knmp_id' => $this->knmpId,
            'responden_id' => $row['responden_id'] ?? null,
            'kesesuaian_kebutuhan' => $this->parseBoolean($row['kesesuaian_kebutuhan'] ?? null),
            'item_tidak_sesuai' => $row['item_tidak_sesuai'] ?? null,
            'tingkat_kesenangan' => $row['tingkat_kesenangan'] ?? null,
            'alasan_tidak_senang' => $row['alasan_tidak_senang'] ?? null,
            'harapan_masyarakat' => $row['harapan_masyarakat'] ?? null,
            'masukan_saran_perbaikan' => $row['masukan_saran_perbaikan'] ?? null,
        ]);
    }

    protected function parseBoolean($value)
    {
        if (is_null($value))
            return null;
        if (is_bool($value))
            return $value;
        $value = strtolower(trim($value));
        return in_array($value, ['ya', 'yes', '1', 'true', 'sesuai']);
    }

    public function rules(): array
    {
        return [
            'responden_id' => 'required|exists:informasi_responden,id',
        ];
    }
}
