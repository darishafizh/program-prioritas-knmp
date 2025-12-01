<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\InformasiUmum;
use App\Models\KeteranganEnumerator;
use App\Models\TargetRealisasi;

class FormsController extends Controller
{
    // ==============================
    // MENU FORMS (MAIN)
    // ==============================
    public function index()
    {
        $informasiUmum = $this->fetchInformasiUmum();
        $keteranganEnumerator = $this->fetchKeteranganEnumerator();
        $targets = $this->fetchTargetRealisasi();

        return view('forms.index', compact('informasiUmum', 'keteranganEnumerator', 'targets'));
    }

    // ==============================
    // INFORMASI UMUM – LIST
    // ==============================
    public function informasiUmum()
    {
        $informasiUmum = $this->fetchInformasiUmum();
        return view('forms.informasi-umum.index', compact('informasiUmum'));
    }

    // ==============================
    // INFORMASI UMUM – CREATE
    // ==============================
    public function informasiUmumCreate()
    {
        return view('forms.informasi-umum.create');
    }

    public function informasiUmumStore(Request $request)
    {
        $validated = $request->validate([
            'nama_responden'     => 'required|string|max:255',
            'provinsi'           => 'required|string|max:255',
            'kabupaten'          => 'required|string|max:255',
            'kecamatan'          => 'required|string|max:255',
            'desa_kelurahan'     => 'required|string|max:255',
            'pekerjaan_jabatan'  => 'required|string|max:255',
            'jenis_program'      => 'required|string|max:255',
        ]);

        $data = [
            'nama_responden'   => $validated['nama_responden'],
            'provinsi'         => $validated['provinsi'],
            'kabupaten'        => $validated['kabupaten'],
            'kecamatan'        => $validated['kecamatan'],
            'desa'             => $validated['desa_kelurahan'],
            'status_responden' => $validated['pekerjaan_jabatan'],
            'jenis_program'    => $validated['jenis_program'],
        ];

        try {
            if (Schema::hasTable((new InformasiUmum())->getTable())) {
                InformasiUmum::create($data);
            } else {
                DB::table('informasi_umum')->insert(array_merge($data, [
                    'created_at' => now(),
                    'updated_at' => now()
                ]));
            }
        } catch (\Throwable $e) {
            return back()->withErrors(['exception' => $e->getMessage()]);
        }

        return redirect()->route('forms.informasi_umum')->with('success', 'Data berhasil disimpan');
    }

    public function informasiUmumEdit($id)
    {
        $informasiUmum = $this->fetchInformasiUmum();
        $item = $informasiUmum->firstWhere('id', (int)$id);

        if (!$item) abort(404, 'Data tidak ditemukan.');

        return view('forms.informasi-umum.edit', compact('item'));
    }

    public function informasiUmumUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_responden'     => 'required|string|max:255',
            'provinsi'           => 'required|string|max:255',
            'kabupaten'          => 'required|string|max:255',
            'kecamatan'          => 'required|string|max:255',
            'desa_kelurahan'     => 'required|string|max:255',
            'pekerjaan_jabatan'  => 'required|string|max:255',
            'jenis_program'      => 'required|string|max:255',
        ]);

        $data = [
            'nama_responden'   => $validated['nama_responden'],
            'provinsi'         => $validated['provinsi'],
            'kabupaten'        => $validated['kabupaten'],
            'kecamatan'        => $validated['kecamatan'],
            'desa'             => $validated['desa_kelurahan'],
            'status_responden' => $validated['pekerjaan_jabatan'],
            'jenis_program'    => $validated['jenis_program'],
            'updated_at'       => now(),
        ];

        try {
            if (Schema::hasTable((new InformasiUmum())->getTable())) {
                $item = InformasiUmum::findOrFail($id);
                $item->update($data);
            } else {
                DB::table('informasi_umum')->where('id', $id)->update($data);
            }
        } catch (\Throwable $e) {
            return back()->withErrors(['exception' => $e->getMessage()]);
        }

        return redirect()->route('forms.informasi_umum')->with('success', 'Data berhasil diperbarui');
    }

    public function informasiUmumDelete($id)
    {
        try {
            if (Schema::hasTable((new InformasiUmum())->getTable())) {
                $item = InformasiUmum::findOrFail($id);
                $item->delete();
            } else {
                DB::table('informasi_umum')->where('id', $id)->delete();
            }
        } catch (\Throwable $e) {
            return back()->withErrors(['exception' => $e->getMessage()]);
        }

        return redirect()->route('forms.informasi_umum')->with('success', 'Data berhasil dihapus');
    }

    // ==============================
    // KETERANGAN ENUMERATOR – RESOURCE
    // ==============================
    public function keteranganEnumeratorIndex()
    {
        $enumerators = $this->fetchKeteranganEnumerator();
        return view('forms.keterangan-enumerator.index', compact('enumerators'));
    }

    public function create()
    {
        return view('forms.keterangan-enumerator.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_enumerator' => 'required|string|max:255',
            'keterangan'      => 'required|string',
        ]);

        if (class_exists(KeteranganEnumerator::class)) {
            KeteranganEnumerator::create($request->only('nama_enumerator', 'keterangan'));
        } else {
            DB::table('keterangan_enumerator')->insert(array_merge(
                $request->only('nama_enumerator', 'keterangan'),
                ['created_at' => now(), 'updated_at' => now()]
            ));
        }

        return redirect()->route('forms.keterangan-enumerator.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        if (class_exists(KeteranganEnumerator::class)) {
            $enumerator = KeteranganEnumerator::findOrFail($id);
        } else {
            $enumerator = DB::table('keterangan_enumerator')->where('id', $id)->first();
            if (!$enumerator) abort(404);
        }

        return view('forms.keterangan-enumerator.edit', compact('enumerator'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_enumerator' => 'required|string|max:255',
            'keterangan'      => 'required|string',
        ]);

        if (class_exists(KeteranganEnumerator::class)) {
            $enumerator = KeteranganEnumerator::findOrFail($id);
            $enumerator->update($request->only('nama_enumerator', 'keterangan'));
        } else {
            DB::table('keterangan_enumerator')->where('id', $id)->update(array_merge(
                $request->only('nama_enumerator', 'keterangan'),
                ['updated_at' => now()]
            ));
        }

        return redirect()->route('forms.keterangan-enumerator.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        if (class_exists(KeteranganEnumerator::class)) {
            $enumerator = KeteranganEnumerator::findOrFail($id);
            $enumerator->delete();
        } else {
            DB::table('keterangan_enumerator')->where('id', $id)->delete();
        }

        return redirect()->route('forms.keterangan-enumerator.index')
            ->with('success', 'Data berhasil dihapus');
    }

    // ==============================
    // TARGET REALISASI
    // ==============================
    public function targetRealisasiIndex()
    {
        $targets = $this->fetchTargetRealisasi();
        return view('forms.target-realisasi.index', compact('targets'));
    }

    public function targetRealisasiCreate()
    {
        return view('forms.target-realisasi.create');
    }

    public function targetRealisasiStore(Request $request)
    {
        $request->validate([
            'nama_knmp'       => 'required|string|max:255',
            'ppk'             => 'required|string|max:255',
            'kontraktor'      => 'required|string|max:255',
            'target_fisik'    => 'required|numeric',
            'realisasi_fisik' => 'required|numeric',
        ]);

        $data = $request->only(
            'nama_knmp',
            'ppk',
            'kontraktor',
            'target_fisik',
            'realisasi_fisik'
        );

        if (Schema::hasTable('target_realisasi') && class_exists(TargetRealisasi::class)) {
            TargetRealisasi::create($data);
        } elseif (Schema::hasTable('target_realisasi')) {
            DB::table('target_realisasi')->insert(array_merge(
                $data,
                ['created_at' => now(), 'updated_at' => now()]
            ));
        } else {
            // Simpan sementara di session
            $sessionTargets = session()->get('target_realisasi', []);
            $sessionTargets[] = array_merge($data, ['id' => count($sessionTargets) + 1]);
            session()->put('target_realisasi', $sessionTargets);
        }

        return redirect()->route('forms.target_realisasi.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function targetRealisasiEdit($id)
    {
        $targets = session()->get('target_realisasi', []);

        // Cari item berdasarkan ID
        $itemArray = collect($targets)->firstWhere('id', $id);

        if (!$itemArray) {
            return redirect()->route('forms.target_realisasi.index')
                ->with('error', 'Data tidak ditemukan');
        }

        // Convert array menjadi object agar bisa dipakai di Blade
        $item = (object) $itemArray;

        return view('forms.target-realisasi.edit', compact('item'));
    }

    public function targetRealisasiUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_knmp'       => 'required|string|max:255',
            'ppk'             => 'required|string|max:255',
            'kontraktor'      => 'required|string|max:255',
            'target_fisik'    => 'required|numeric',
            'realisasi_fisik' => 'required|numeric',
        ]);

        $data = $request->only(
            'nama_knmp',
            'ppk',
            'kontraktor',
            'target_fisik',
            'realisasi_fisik'
        );
        $data['updated_at'] = now();

        try {
            if (Schema::hasTable('target_realisasi') && class_exists(TargetRealisasi::class)) {
                $item = TargetRealisasi::findOrFail($id);
                $item->update($data);
            } elseif (Schema::hasTable('target_realisasi')) {
                DB::table('target_realisasi')->where('id', $id)->update($data);
            } else {
                return redirect()->route('forms.target_realisasi.index')
                    ->with('info', 'Tabel target_realisasi belum dibuat, data tidak diperbarui.');
            }
        } catch (\Throwable $e) {
            return back()->withErrors(['exception' => $e->getMessage()]);
        }

        return redirect()->route('forms.target_realisasi.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function targetRealisasiDelete($id)  
    {
        try {
            if (Schema::hasTable('target_realisasi') && class_exists(TargetRealisasi::class)) {
                $item = TargetRealisasi::findOrFail($id);
                $item->delete();
            } elseif (Schema::hasTable('target_realisasi')) {
                DB::table('target_realisasi')->where('id', $id)->delete();
            } else {
                return redirect()->route('forms.targetRealisasiIndex')
                    ->with('info', 'Tabel target_realisasi belum dibuat, data tidak dihapus.');
            }
        } catch (\Throwable $e) {
            return back()->withErrors(['exception' => $e->getMessage()]);
        }

        return redirect()->route('forms.target_realisasi.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    // ==============================
    // HELPERS
    // ==============================
    protected function fetchInformasiUmum()
    {
        if (class_exists(InformasiUmum::class)) {
            return InformasiUmum::all();
        }

        if (Schema::hasTable('informasi_umum')) {
            return collect(DB::table('informasi_umum')->get());
        }

        return collect();
    }

    protected function fetchKeteranganEnumerator()
    {
        if (!Schema::hasTable('keterangan_enumerator')) {
            return collect();
        }

        if (class_exists(KeteranganEnumerator::class)) {
            return KeteranganEnumerator::all();
        }

        return collect(DB::table('keterangan_enumerator')->get());
    }

    protected function fetchTargetRealisasi()
    {
        // Cek tabel
        if (Schema::hasTable('target_realisasi')) {
            if (class_exists(TargetRealisasi::class)) {
                return TargetRealisasi::all();
            }
            return collect(DB::table('target_realisasi')->get());
        }

        // Jika tabel belum ada, simpan sementara di session (dummy)
        $sessionTargets = session()->get('target_realisasi', []);
        return collect($sessionTargets);
    }

    // ==============================
    // PAGE LAIN
    // ==============================
    public function progresPerKomponen()
    {
        return view('forms.progres_per_komponen');
    }

    public function progresPerKomponenCreate()
    {
        return view('forms.progres_per_komponen_create');
    }

    public function profilKnmp()
    {
        return view('forms.profil_knmp');
    }

    public function profilKnmpCreate()
    {
        return view('forms.profil_knmp_create');
    }
}
