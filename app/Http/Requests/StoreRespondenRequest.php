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

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nama_responden.required' => 'Nama Responden wajib diisi.',
            'nama_responden.string' => 'Nama Responden harus berupa teks.',
            'nama_responden.max' => 'Nama Responden maksimal 255 karakter.',

            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus terdiri dari 16 digit.',
            'nik.regex' => 'NIK harus berupa angka saja.',

            'nomor_kusuka.required' => 'Nomor KUSUKA wajib diisi.',
            'nomor_kusuka.max' => 'Nomor KUSUKA maksimal 30 karakter.',

            'tempat_lahir.required' => 'Tempat Lahir wajib diisi.',
            'tempat_lahir.max' => 'Tempat Lahir maksimal 255 karakter.',

            'tanggal_lahir.required' => 'Tanggal Lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format Tanggal Lahir tidak valid.',

            'umur.required' => 'Umur wajib diisi.',
            'umur.integer' => 'Umur harus berupa angka.',
            'umur.min' => 'Umur tidak boleh negatif.',

            'jenis_kelamin.required' => 'Jenis Kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis Kelamin harus Laki-laki atau Perempuan.',

            'suku_bangsa.required' => 'Suku Bangsa wajib diisi.',
            'suku_bangsa.max' => 'Suku Bangsa maksimal 255 karakter.',

            'pendidikan_terakhir.required' => 'Pendidikan Terakhir wajib diisi.',
            'pendidikan_terakhir.max' => 'Pendidikan Terakhir maksimal 255 karakter.',

            'wpp.required' => 'Wilayah Pengelolaan Perikanan (WPP) wajib diisi.',
            'wpp.max' => 'WPP maksimal 255 karakter.',

            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',

            'no_hp_responden.required' => 'No. HP Responden wajib diisi.',
            'no_hp_responden.max' => 'No. HP Responden maksimal 20 karakter.',

            'jumlah_anggota_rumah.required' => 'Jumlah Anggota Rumah Tangga wajib diisi.',
            'jumlah_anggota_rumah.integer' => 'Jumlah Anggota Rumah Tangga harus berupa angka.',
            'jumlah_anggota_rumah.min' => 'Jumlah Anggota Rumah Tangga tidak boleh negatif.',

            'jumlah_anggota_perempuan_rumah.required' => 'Jumlah Anggota Perempuan wajib diisi.',
            'jumlah_anggota_perempuan_rumah.integer' => 'Jumlah Anggota Perempuan harus berupa angka.',
            'jumlah_anggota_perempuan_rumah.min' => 'Jumlah Anggota Perempuan tidak boleh negatif.',

            'jumlah_anggota_bekerja.required' => 'Jumlah Anggota Bekerja wajib diisi.',
            'jumlah_anggota_bekerja.integer' => 'Jumlah Anggota Bekerja harus berupa angka.',
            'jumlah_anggota_bekerja.min' => 'Jumlah Anggota Bekerja tidak boleh negatif.',

            'jumlah_anggota_perempuan_bekerja.required' => 'Jumlah Anggota Perempuan Bekerja wajib diisi.',
            'jumlah_anggota_perempuan_bekerja.integer' => 'Jumlah Anggota Perempuan Bekerja harus berupa angka.',
            'jumlah_anggota_perempuan_bekerja.min' => 'Jumlah Anggota Perempuan Bekerja tidak boleh negatif.',

            'jumlah_abk.required' => 'Jumlah ABK wajib diisi.',
            'jumlah_abk.integer' => 'Jumlah ABK harus berupa angka.',
            'jumlah_abk.min' => 'Jumlah ABK tidak boleh negatif.',

            'pengalaman_usaha.required' => 'Pengalaman Usaha (tahun) wajib diisi.',
            'pengalaman_usaha.integer' => 'Pengalaman Usaha harus berupa angka.',
            'pengalaman_usaha.min' => 'Pengalaman Usaha tidak boleh negatif.',

            'province_id.required' => 'Provinsi wajib dipilih.',
            'province_id.integer' => 'Data Provinsi tidak valid.',

            'regency_id.required' => 'Kabupaten/Kota wajib dipilih.',
            'regency_id.integer' => 'Data Kabupaten/Kota tidak valid.',

            'district_id.required' => 'Kecamatan wajib dipilih.',
            'district_id.integer' => 'Data Kecamatan tidak valid.',

            'village_id.required' => 'Desa/Kelurahan wajib dipilih.',
            'village_id.integer' => 'Data Desa/Kelurahan tidak valid.',

            'tanggal_wawancara.required' => 'Tanggal Wawancara wajib diisi.',
            'tanggal_wawancara.date' => 'Format Tanggal Wawancara tidak valid.',

            'nama_enumerator.required' => 'Nama Enumerator wajib diisi.',
            'nama_enumerator.max' => 'Nama Enumerator maksimal 255 karakter.',

            'jenis_kelamin_enumerator.required' => 'Jenis Kelamin Enumerator wajib dipilih.',
            'jenis_kelamin_enumerator.in' => 'Jenis Kelamin Enumerator harus Laki-laki atau Perempuan.',

            'no_hp_enumerator.required' => 'No. HP Enumerator wajib diisi.',
            'no_hp_enumerator.max' => 'No. HP Enumerator maksimal 20 karakter.',
        ];
    }
}
