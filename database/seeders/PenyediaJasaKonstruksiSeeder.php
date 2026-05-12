<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenyediaJasaKonstruksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'PT. Viola Cipta Mahakarya'],
            ['nama' => 'PT. Toleransi Aceh'],
            ['nama' => 'PT. Karsa Prabala'],
            ['nama' => 'PT. Naurah Dinamika Nusantara'],
            ['nama' => 'PT. Adhi Karya (Persero) Tbk.'],
            ['nama' => 'PT. Indopenta Bumi Permai'],
            ['nama' => 'PT. Tirtha Wandhira Utama'],
            ['nama' => 'PT. Wirakarsa Konstruksi'],
            ['nama' => 'PT. Bumi Delta Hatten'],
            ['nama' => 'PT. Rukun Jaya Madura Group'],
            ['nama' => 'PT. Tirai Megah Utama'],
            ['nama' => 'CV. Cendana Indah'],
            ['nama' => 'CV. Clara Benefecia'],
            ['nama' => 'PT. Duta Tunggal Jaya'],
            ['nama' => 'PT. Aisha Bangun Raya'],
            ['nama' => 'PT. Nila Nasra Nina'],
            ['nama' => 'PT. Wirabaya Nusantara Permai Im'],
            ['nama' => 'PT. Wirabaya Nusantara Permai'],
            ['nama' => 'PT. Artamakmur Permai'],
            ['nama' => 'PT. Kreasindo Bangun Persada'],
            ['nama' => 'CV. Putra Diwa Adyatama'],
            ['nama' => 'PT. Bina Mandiri Mukti'],
            ['nama' => 'CV. Cahaya Lima Mandiri'],
            ['nama' => 'CV. Tiga Dara Indah'],
            ['nama' => 'PT. Sinar Habib Agung Putra'],
            ['nama' => 'PT. Aset Prima Konstruksi'],
            ['nama' => 'PT. Nara Tunas Karya'],
            ['nama' => 'PT. Lesindo Bersinar'],
            ['nama' => 'PT. Tolping Jaya'],
            ['nama' => 'PT. Aulia Berlian Konstruksi'],
            ['nama' => 'PT. Berkah Rizki Jaya'],
            ['nama' => 'PT. Dewata Teknik'],
            ['nama' => 'PT. Sembada Tiga Abadi'],
            ['nama' => 'PT. Zegar Inti Papua'],
            ['nama' => 'CV. Sonta Abadi'],
            ['nama' => 'CV. Galung Lombok Indah'],
            ['nama' => 'CV. Cakra Mas'],
            ['nama' => 'PT. Gunung Landoli Jaya'],
            ['nama' => 'PT. Tiga Surya Katulistiwa'],
            ['nama' => 'CV. Surya Utama'],
            ['nama' => 'PT. Bumi Permata Kendari'],
            ['nama' => 'CV. Barlia Citra Mandiri'],
            ['nama' => 'PT Mitra Agung Indonesia CV Baladwipa KSO'],
        ];

        DB::table('penyedia_jasa_konstruksi')->insert($data);
    }
}
