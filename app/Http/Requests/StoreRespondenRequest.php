<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRespondenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Adjust if authorization logic is needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_responden' => 'required|string|max:255',
            'nik' => 'required|string|size:16|regex:/^[0-9]+$/',
            'nomor_kusuka' => 'required|string|max:30',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'umur' => 'required|integer|min:0',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'suku_bangsa' => 'required|string|max:255',
            'pendidikan_terakhir' => 'required|string|max:255',
            'wpp' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp_responden' => 'required|string|max:20',
            'jumlah_anggota_rumah' => 'required|integer|min:0',
            'jumlah_anggota_perempuan_rumah' => 'required|integer|min:0',
            'jumlah_anggota_bekerja' => 'required|integer|min:0',
            'jumlah_anggota_perempuan_bekerja' => 'required|integer|min:0',
            'jumlah_abk' => 'required|integer|min:0',
            'pengalaman_usaha' => 'required|integer|min:0',
            'province_id' => 'required|integer',
            'regency_id' => 'required|integer',
            'district_id' => 'required|integer',
            'village_id' => 'required|integer',
            'tanggal_wawancara' => 'required|date',
            'nama_enumerator' => 'required|string|max:255',
            'jenis_kelamin_enumerator' => 'required|in:Laki-laki,Perempuan',
            'no_hp_enumerator' => 'required|string|max:20',
        ];
    }
}
