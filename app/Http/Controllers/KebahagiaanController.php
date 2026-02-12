<?php

namespace App\Http\Controllers;

use App\Models\TingkatKebahagiaanNelayan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KebahagiaanController extends Controller
{
    /**
     * Store Tingkat Kebahagiaan Nelayan
     */
    public function store(Request $request)
    {
        // Define base validation rules
        $rules = [
            'knmp_id' => 'required|exists:knmp,id',
            'responden_id' => 'required|exists:informasi_responden,id',
        ];

        // Define categories and question numbers
        $categories = [
            'kepuasan_hidup_personal' => range(1, 8),
            'kepuasan_hidup_sosial' => range(9, 18),
            'perasaan' => range(19, 24),
            'makna_hidup' => range(25, 36),
        ];

        // Add validation rules for each question
        foreach ($categories as $prefix => $numbers) {
            foreach ($numbers as $num) {
                $rules["{$prefix}_{$num}"] = 'required|string';
            }
        }

        // Custom attributes for error messages
        $customAttributes = [];
        foreach ($categories as $prefix => $numbers) {
            foreach ($numbers as $num) {
                $customAttributes["{$prefix}_{$num}"] = "Soal No. {$num}";
            }
        }

        $request->validate($rules, [], $customAttributes);

        $knmp_id = (int) $request->knmp_id;
        $responden_id = (int) $request->responden_id;

        $skorMap = [
            'Sangat Tidak Setuju' => 1,
            'Tidak Setuju' => 2,
            'Netral' => 3,
            'Setuju' => 4,
            'Sangat Setuju' => 5,
        ];

        DB::beginTransaction();

        try {
            foreach ($request->all() as $key => $value) {
                if (
                    !preg_match(
                        '/^(kepuasan_hidup_personal|kepuasan_hidup_sosial|perasaan|makna_hidup)_(\d+)$/',
                        $key,
                        $m
                    )
                ) {
                    continue;
                }

                if (!isset($skorMap[$value])) {
                    continue;
                }

                TingkatKebahagiaanNelayan::updateOrCreate(
                    [
                        'knmp_id' => $knmp_id,
                        'responden_id' => $responden_id,
                        'nomor_soal' => (int) $m[2],
                    ],
                    [
                        'kategori' => $m[1],
                        'jawaban_teks' => $value,
                        'skor_nilai' => $skorMap[$value],
                    ]
                );
            }

            DB::commit();

            return back()->with(
                'success',
                'Tingkat Kebahagiaan Nelayan berhasil disimpan.'
            );
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withInput()->with(
                'error',
                'Gagal menyimpan data: ' . $e->getMessage()
            );
        }
    }
}
