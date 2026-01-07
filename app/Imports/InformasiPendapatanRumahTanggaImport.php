<?php

namespace App\Imports;

use App\Models\InformasiPendapatanRumahTangga;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class InformasiPendapatanRumahTanggaImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected $knmpId;

    public function __construct($knmpId)
    {
        $this->knmpId = $knmpId;
    }

    public function model(array $row)
    {
        return new InformasiPendapatanRumahTangga([
            'knmp_id' => $this->knmpId,
            'responden_id' => $row['responden_id'] ?? null,
            'pendapatan_perikanan' => $row['pendapatan_perikanan'] ?? null,
            'pendapatan_non_perikanan' => $row['pendapatan_non_perikanan'] ?? null,
            'pendapatan_total' => $row['pendapatan_total'] ?? null,
            'kontribusi_nelayan_persen' => $row['kontribusi_nelayan_persen'] ?? null,
            'jumlah_sumber_penghasilan' => $row['jumlah_sumber_penghasilan'] ?? null,
            'ketergantungan_perikanan' => $row['ketergantungan_perikanan'] ?? null,
            'stabilitas_pendapatan' => $row['stabilitas_pendapatan'] ?? null,
            'keterlibatan_perempuan' => $row['keterlibatan_perempuan'] ?? null,
            'kontribusi_perempuan_persen' => $row['kontribusi_perempuan_persen'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'responden_id' => 'required|exists:informasi_responden,id',
        ];
    }
}
