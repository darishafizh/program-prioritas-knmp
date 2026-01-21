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
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = $this->parseQueryException($e);
            \Log::error('Import Responden DB Error', ['message' => $e->getMessage()]);
            return back()->with('error', $errorMessage);
        } catch (\Exception $e) {
            \Log::error('Import Responden Error', ['message' => $e->getMessage()]);
            return back()->with('error', 'Gagal import data: ' . $this->simplifyErrorMessage($e->getMessage()));
        }
    }

    /**
     * Parse QueryException to user-friendly message
     */
    private function parseQueryException(\Illuminate\Database\QueryException $e): string
    {
        $message = $e->getMessage();
        
        // Incorrect integer value
        if (str_contains($message, 'Incorrect integer value')) {
            preg_match("/Incorrect integer value: '(.+?)' for column '(.+?)'/", $message, $matches);
            if (count($matches) >= 3) {
                $value = $matches[1];
                $column = $matches[2];
                return "Error: Nilai '{$value}' tidak valid untuk kolom '{$column}'. Pastikan kolom berisi angka/ID yang benar.";
            }
        }
        
        // Duplicate entry
        if (str_contains($message, 'Duplicate entry')) {
            preg_match("/Duplicate entry '(.+?)' for key/", $message, $matches);
            if (count($matches) >= 2) {
                return "Error: Data '{$matches[1]}' sudah ada di database (duplikat).";
            }
        }
        
        // Data too long
        if (str_contains($message, 'Data too long')) {
            preg_match("/Data too long for column '(.+?)'/", $message, $matches);
            if (count($matches) >= 2) {
                return "Error: Data terlalu panjang untuk kolom '{$matches[1]}'. Kurangi jumlah karakter.";
            }
        }
        
        // Cannot be null
        if (str_contains($message, 'cannot be null')) {
            preg_match("/Column '(.+?)' cannot be null/", $message, $matches);
            if (count($matches) >= 2) {
                return "Error: Kolom '{$matches[1]}' wajib diisi (tidak boleh kosong).";
            }
        }
        
        // Foreign key constraint
        if (str_contains($message, 'foreign key constraint')) {
            return "Error: Referensi data tidak valid. Pastikan ID yang dimasukkan sudah ada di database.";
        }
        
        return "Error Database: " . $this->simplifyErrorMessage($message);
    }

    /**
     * Simplify long error messages
     */
    private function simplifyErrorMessage(string $message): string
    {
        // Remove SQL query from message
        if (str_contains($message, 'SQL:')) {
            $message = preg_replace('/\(SQL:.*\)/s', '', $message);
        }
        
        // Truncate if too long
        if (strlen($message) > 200) {
            $message = substr($message, 0, 200) . '...';
        }
        
        return trim($message);
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
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            \Log::error('Import Profile KNMP Validation Error', ['errors' => $errorMessages]);
            return back()->with('error', 'Gagal import: ' . implode('; ', array_slice($errorMessages, 0, 3)));
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = $this->parseQueryException($e);
            \Log::error('Import Profile KNMP DB Error', ['message' => $e->getMessage()]);
            return back()->with('error', $errorMessage);
        } catch (\Exception $e) {
            \Log::error('Import Profile KNMP Error', ['message' => $e->getMessage()]);
            return back()->with('error', 'Gagal import data: ' . $this->simplifyErrorMessage($e->getMessage()));
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
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            \Log::error('Import Progres KNMP Validation Error', ['errors' => $errorMessages]);
            return back()->with('error', 'Gagal import: ' . implode('; ', array_slice($errorMessages, 0, 3)));
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = $this->parseQueryException($e);
            \Log::error('Import Progres KNMP DB Error', ['message' => $e->getMessage()]);
            return back()->with('error', $errorMessage);
        } catch (\Exception $e) {
            \Log::error('Import Progres KNMP Error', ['message' => $e->getMessage()]);
            return back()->with('error', 'Gagal import data: ' . $this->simplifyErrorMessage($e->getMessage()));
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
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = $this->parseQueryException($e);
            \Log::error('Import Tanggapan DB Error', ['message' => $e->getMessage()]);
            return back()->with('error', $errorMessage);
        } catch (\Exception $e) {
            \Log::error('Import Tanggapan Error', ['message' => $e->getMessage()]);
            return back()->with('error', 'Gagal import data: ' . $this->simplifyErrorMessage($e->getMessage()));
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
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = $this->parseQueryException($e);
            \Log::error('Import Tingkat Kebahagiaan DB Error', ['message' => $e->getMessage()]);
            return back()->with('error', $errorMessage);
        } catch (\Exception $e) {
            \Log::error('Import Tingkat Kebahagiaan Error', ['message' => $e->getMessage()]);
            return back()->with('error', 'Gagal import data: ' . $this->simplifyErrorMessage($e->getMessage()));
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
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = $this->parseQueryException($e);
            \Log::error('Import Informasi Usaha DB Error', ['message' => $e->getMessage()]);
            return back()->with('error', $errorMessage);
        } catch (\Exception $e) {
            \Log::error('Import Informasi Usaha Error', ['message' => $e->getMessage()]);
            return back()->with('error', 'Gagal import data: ' . $this->simplifyErrorMessage($e->getMessage()));
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
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = $this->parseQueryException($e);
            \Log::error('Import Informasi Pemasaran DB Error', ['message' => $e->getMessage()]);
            return back()->with('error', $errorMessage);
        } catch (\Exception $e) {
            \Log::error('Import Informasi Pemasaran Error', ['message' => $e->getMessage()]);
            return back()->with('error', 'Gagal import data: ' . $this->simplifyErrorMessage($e->getMessage()));
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
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = $this->parseQueryException($e);
            \Log::error('Import Pendapatan RT DB Error', ['message' => $e->getMessage()]);
            return back()->with('error', $errorMessage);
        } catch (\Exception $e) {
            \Log::error('Import Pendapatan RT Error', ['message' => $e->getMessage()]);
            return back()->with('error', 'Gagal import data: ' . $this->simplifyErrorMessage($e->getMessage()));
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
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = $this->parseQueryException($e);
            \Log::error('Import Sosial Kelembagaan DB Error', ['message' => $e->getMessage()]);
            return back()->with('error', $errorMessage);
        } catch (\Exception $e) {
            \Log::error('Import Sosial Kelembagaan Error', ['message' => $e->getMessage()]);
            return back()->with('error', 'Gagal import data: ' . $this->simplifyErrorMessage($e->getMessage()));
        }
    }

    /**
     * Download template Excel for a specific section
     */
    public function downloadTemplate(Request $request, $section)
    {
        $templates = [
            'responden' => ['export' => RespondenTemplateExport::class, 'filename' => 'template-informasi-responden.xlsx', 'needs_responden' => false],
            'profile-knmp' => ['export' => ProfileKnmpTemplateExport::class, 'filename' => 'template-profile-knmp.xlsx', 'needs_responden' => false],
            'progres-knmp' => ['export' => ProgresKnmpTemplateExport::class, 'filename' => 'template-progres-knmp.xlsx', 'needs_responden' => false],
            'tanggapan-masyarakat' => ['export' => TanggapanMasyarakatTemplateExport::class, 'filename' => 'template-tanggapan-masyarakat.xlsx', 'needs_responden' => true],
            'tingkat-kebahagiaan' => ['export' => TingkatKebahagiaanTemplateExport::class, 'filename' => 'template-tingkat-kebahagiaan.xlsx', 'needs_responden' => true],
            'informasi-usaha' => ['export' => InformasiUsahaTemplateExport::class, 'filename' => 'template-informasi-usaha.xlsx', 'needs_responden' => true],
            'informasi-pemasaran' => ['export' => InformasiPemasaranTemplateExport::class, 'filename' => 'template-informasi-pemasaran.xlsx', 'needs_responden' => true],
            'pendapatan-rt' => ['export' => InformasiPendapatanRtTemplateExport::class, 'filename' => 'template-pendapatan-rumah-tangga.xlsx', 'needs_responden' => true],
            'sosial-kelembagaan' => ['export' => SosialKelembagaanTemplateExport::class, 'filename' => 'template-sosial-kelembagaan.xlsx', 'needs_responden' => true],
        ];

        if (!isset($templates[$section])) {
            abort(404, 'Template tidak ditemukan');
        }

        $template = $templates[$section];
        $respondenIds = $request->input('responden_ids', []);

        // For sections that need responden, pass the IDs to the export class
        if ($template['needs_responden'] && !empty($respondenIds)) {
            $exportInstance = new $template['export']($respondenIds);
        } else {
            $exportInstance = new $template['export']();
        }

        return Excel::download($exportInstance, $template['filename']);
    }
}
