<?php

namespace App\Http\Controllers;

use App\Models\Knmp;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InformasiRespondenImport;
use App\Imports\ProfileKnmpImport;
use App\Imports\ProgresKnmpImport;
use App\Imports\TanggapanMasyarakatImport;
use App\Imports\TingkatKebahagiaanNelayanImport;
use App\Imports\InformasiUsahaImport;
use App\Imports\InformasiPemasaranImport;
use App\Imports\InformasiPendapatanRumahTanggaImport;
use App\Imports\SosialKelembagaanImport;
use App\Exports\RespondenTemplateExport;
use App\Exports\ProfileKnmpTemplateExport;
use App\Exports\ProgresKnmpTemplateExport;
use App\Exports\TanggapanMasyarakatTemplateExport;
use App\Exports\TingkatKebahagiaanTemplateExport;
use App\Exports\InformasiUsahaTemplateExport;
use App\Exports\InformasiPemasaranTemplateExport;
use App\Exports\InformasiPendapatanRtTemplateExport;
use App\Exports\SosialKelembagaanTemplateExport;

class ImportController extends Controller
{
    /**
     * Import Informasi Responden (Section C)
     */
    public function importResponden(Request $request, Knmp $knmp)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new InformasiRespondenImport($knmp->id), $request->file('file'));
            return back()->with('success', 'Data Responden berhasil diimport!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            return back()->with('error', 'Gagal import: ' . implode('; ', array_slice($errorMessages, 0, 3)));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Import Profile KNMP (Section A)
     */
    public function importProfileKnmp(Request $request, Knmp $knmp)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new ProfileKnmpImport($knmp->id), $request->file('file'));
            return back()->with('success', 'Data Profile KNMP berhasil diimport!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Import Progres KNMP (Section B)
     */
    public function importProgresKnmp(Request $request, Knmp $knmp)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new ProgresKnmpImport($knmp->id), $request->file('file'));
            return back()->with('success', 'Data Progres KNMP berhasil diimport!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Import Tanggapan Masyarakat (Section D)
     */
    public function importTanggapanMasyarakat(Request $request, Knmp $knmp)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new TanggapanMasyarakatImport($knmp->id), $request->file('file'));
            return back()->with('success', 'Data Tanggapan Masyarakat berhasil diimport!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            return back()->with('error', 'Gagal import: ' . implode('; ', array_slice($errorMessages, 0, 3)));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Import Tingkat Kebahagiaan Nelayan (Section E)
     */
    public function importTingkatKebahagiaan(Request $request, Knmp $knmp)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new TingkatKebahagiaanNelayanImport($knmp->id), $request->file('file'));
            return back()->with('success', 'Data Tingkat Kebahagiaan berhasil diimport!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            return back()->with('error', 'Gagal import: ' . implode('; ', array_slice($errorMessages, 0, 3)));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Import Informasi Usaha (Section F)
     */
    public function importInformasiUsaha(Request $request, Knmp $knmp)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new InformasiUsahaImport($knmp->id), $request->file('file'));
            return back()->with('success', 'Data Informasi Usaha berhasil diimport!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            return back()->with('error', 'Gagal import: ' . implode('; ', array_slice($errorMessages, 0, 3)));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Import Informasi Pemasaran (Section G)
     */
    public function importInformasiPemasaran(Request $request, Knmp $knmp)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new InformasiPemasaranImport($knmp->id), $request->file('file'));
            return back()->with('success', 'Data Informasi Pemasaran berhasil diimport!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            return back()->with('error', 'Gagal import: ' . implode('; ', array_slice($errorMessages, 0, 3)));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Import Pendapatan Rumah Tangga (Section H)
     */
    public function importPendapatanRt(Request $request, Knmp $knmp)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new InformasiPendapatanRumahTanggaImport($knmp->id), $request->file('file'));
            return back()->with('success', 'Data Pendapatan Rumah Tangga berhasil diimport!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            return back()->with('error', 'Gagal import: ' . implode('; ', array_slice($errorMessages, 0, 3)));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Import Sosial Kelembagaan (Section I)
     */
    public function importSosialKelembagaan(Request $request, Knmp $knmp)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new SosialKelembagaanImport($knmp->id), $request->file('file'));
            return back()->with('success', 'Data Sosial Kelembagaan berhasil diimport!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            return back()->with('error', 'Gagal import: ' . implode('; ', array_slice($errorMessages, 0, 3)));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel for a specific section
     */
    public function downloadTemplate($section)
    {
        $templates = [
            'responden' => ['export' => RespondenTemplateExport::class, 'filename' => 'template-informasi-responden.xlsx'],
            'profile-knmp' => ['export' => ProfileKnmpTemplateExport::class, 'filename' => 'template-profile-knmp.xlsx'],
            'progres-knmp' => ['export' => ProgresKnmpTemplateExport::class, 'filename' => 'template-progres-knmp.xlsx'],
            'tanggapan-masyarakat' => ['export' => TanggapanMasyarakatTemplateExport::class, 'filename' => 'template-tanggapan-masyarakat.xlsx'],
            'tingkat-kebahagiaan' => ['export' => TingkatKebahagiaanTemplateExport::class, 'filename' => 'template-tingkat-kebahagiaan.xlsx'],
            'informasi-usaha' => ['export' => InformasiUsahaTemplateExport::class, 'filename' => 'template-informasi-usaha.xlsx'],
            'informasi-pemasaran' => ['export' => InformasiPemasaranTemplateExport::class, 'filename' => 'template-informasi-pemasaran.xlsx'],
            'pendapatan-rt' => ['export' => InformasiPendapatanRtTemplateExport::class, 'filename' => 'template-pendapatan-rumah-tangga.xlsx'],
            'sosial-kelembagaan' => ['export' => SosialKelembagaanTemplateExport::class, 'filename' => 'template-sosial-kelembagaan.xlsx'],
        ];

        if (!isset($templates[$section])) {
            abort(404, 'Template tidak ditemukan');
        }

        $template = $templates[$section];
        return Excel::download(new $template['export'](), $template['filename']);
    }
}
