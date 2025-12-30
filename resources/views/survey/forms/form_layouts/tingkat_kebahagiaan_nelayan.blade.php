<form method="POST" action="{{ route('survey.forms.store_tingkat_kebahagiaan', ['knmp' => $knmp->id]) }}">
    @csrf

    <input type="hidden" name="knmp_id" value="{{ $knmp->id }}">
    <input type="hidden" name="active_section" value="collapseFour">


    {{-- ========================= --}}
    {{-- PILIH RESPONDEN --}}
    {{-- ========================= --}}
    <div class="mb-4">
        <label class="form-label fw-bold">
            Responden
        </label>

        <select name="responden_id" class="form-select @error('responden_id') is-invalid @enderror" required>
            <option value="">-- Pilih Responden --</option>
            @foreach ($respondenList as $r)
                @php
                    $tingkatKebahagiaanData = isset($selectedRespondenData['tingkat_kebahagiaan']) ? $selectedRespondenData['tingkat_kebahagiaan'] : null;
                    $tingkatKebahagiaanFirst = $tingkatKebahagiaanData && $tingkatKebahagiaanData->count() > 0 ? $tingkatKebahagiaanData->first() : null;
                    $isSelected = old('responden_id') == $r->id ||
                        ($selectedRespondenId && $selectedRespondenId == $r->id && !old('responden_id')) ||
                        ($tingkatKebahagiaanFirst && $tingkatKebahagiaanFirst->responden_id == $r->id && !old('responden_id'));
                @endphp
                <option value="{{ $r->id }}" {{ $isSelected ? 'selected' : '' }}>
                    {{ $r->nama_responden }} ({{ $r->nik }})
                </option>
            @endforeach
        </select>

        @error('responden_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    @php
        $pilihan = ['Sangat Tidak Setuju', 'Tidak Setuju', 'Netral', 'Setuju', 'Sangat Setuju'];

        $kepuasanHidupPersonal = [
            1 => 'Saya memiliki pendidikan/keterampilan yang memadai untuk menunjang pekerjaan nelayan saya.',
            2 => 'Pelatihan/penyuluhan yang saya ikuti bermanfaat bagi peningkatan hasil tangkapan.',
            3 => 'Pekerjaan/usaha utama saya saat ini memberikan penghasilan yang layak bagi keluarga.',
            4 => 'Saya merasa pekerjaan/usaha utama saya stabil dan berkelanjutan.',
            5 => 'Kesehatan saya dalam satu bulan terakhir cukup baik untuk bekerja di laut.',
            6 => 'Saya mudah mengakses layanan kesehatan saat dibutuhkan.',
            7 => 'Kondisi rumah dan fasilitas dasar (air, listrik, sanitasi) di rumah saya memadai.',
            8 => 'Saya merasa nyaman dan aman tinggal di rumah saya saat ini.',
        ];

        $kepuasanHidupSosial = [
            9 => 'Hubungan dalam keluarga saya harmonis.',
            10 => 'Kami dapat menyelesaikan masalah keluarga dengan baik.',
            11 => 'Saya memiliki waktu luang yang cukup untuk beristirahat atau berkumpul dengan keluarga.',
            12 => 'Keseimbangan antara bekerja dan waktu untuk keluarga terjaga.',
            13 => 'Saya memiliki hubungan sosial yang baik dengan sesama nelayan dan tetangga.',
            14 => 'Saya aktif dalam kegiatan sosial/komunitas di kampung.',
            15 => 'Lingkungan kampung/pelabuhan terasa bersih dan tertata.',
            16 => 'Fasilitas umum di lingkungan saya cukup memadai.',
            17 => 'Saya merasa aman dari tindak kriminal/konflik di lingkungan saya.',
            18 => 'Pengaturan keamanan/pengawasan di pelabuhan/dermaga berjalan baik.',
        ];

        $perasaan = [
            19 => 'Dalam dua minggu terakhir, saya sering merasa senang/gembira setelah melaut.',
            20 => 'Saya bersemangat menjalani kegiatan sehari-hari sebagai nelayan.',
            21 => 'Saya merasa cemas/khawatir terhadap masa depan pekerjaan saya.',
            22 => 'Saya sering merasa was-was terhadap ketersediaan BBM/es atau harga ikan.',
            23 => 'Saya merasa tertekan dengan beban kerja atau tekanan sosial di pelabuhan.',
            24 => 'Saya sering merasa lelah batin atau putus asa.',
        ];

        $maknaHidup = [
            25 => 'Saya mampu mengambil keputusan penting dalam hidup dan pekerjaan saya secara mandiri.',
            26 => 'Saya bertanggung jawab terhadap pilihan-pilihan saya.',
            27 => 'Saya mampu mengelola lingkungan kerja (kapal, alat, tim) dengan baik.',
            28 => 'Saya dapat menyesuaikan diri dengan perubahan kondisi laut/pasar.',
            29 => 'Saya terus belajar untuk meningkatkan diri (keterampilan, teknologi, praktik pascapanen).',
            30 => 'Saya memiliki rencana pengembangan diri untuk 1–3 tahun ke depan.',
            31 => 'Saya memiliki hubungan positif dan saling mendukung dengan orang lain di komunitas.',
            32 => 'Saya merasa menjadi bagian penting di koperasi/komunitas nelayan.',
            33 => 'Saya memiliki tujuan hidup yang jelas untuk keluarga dan pekerjaan.',
            34 => 'Saya melihat masa depan yang ingin saya capai dan saya mengetahuinya.',
            35 => 'Saya menerima kekuatan dan keterbatasan diri saya.',
            36 => 'Saya merasa hidup ini hampa dan tidak bermakna.',
        ];
    @endphp

    <div class="accordion" id="accordionKebahagiaan">

        @php
            function renderQuestions($questions, $prefix, $pilihan)
            {
                foreach ($questions as $no => $text) {
                    echo '<div class="mb-3">';
                    echo '<label class="form-label"><strong>' . $no . '.</strong> ' . $text . '</label>';
                    echo '<div>';
                    foreach ($pilihan as $value) {
                        $fieldName = $prefix . '_' . $no;
                        $id = $prefix . '_' . $no . '_' . \Illuminate\Support\Str::slug($value);
                        $checked = old($fieldName) == $value ? 'checked' : '';
                        echo '<div class="form-check form-check-inline">';
                        echo '<input class="form-check-input" type="radio" name="' .
                            $fieldName .
                            '" id="' .
                            $id .
                            '" value="' .
                            $value .
                            '" ' .
                            $checked .
                            '>';

                        echo '<label class="form-check-label" for="' . $id . '">' . $value . '</label>';
                        echo '</div>';
                    }
                    echo '</div>
                </div>';
                }
            }
        @endphp <!-- Kepuasan Hidup Personal -->
        <div id="sectionKebahagiaan">

            {{-- Kategori: A.1 Kepuasan Hidup Personal --}}
            <div class="mb-3">
                <h5 class="mt-3 mb-3 fw-bold text-primary">A.1 Kepuasan Hidup Personal</h5>
                @php renderQuestions($kepuasanHidupPersonal, 'kepuasan_hidup_personal', $pilihan); @endphp
            </div>

            {{-- Kategori: A.2 Kepuasan Hidup Sosial --}}
            <hr>
            <div class="mb-3">
                <h5 class="mt-3 mb-3 fw-bold text-primary">A.2 Kepuasan Hidup Sosial</h5>
                @php renderQuestions($kepuasanHidupSosial, 'kepuasan_hidup_sosial', $pilihan); @endphp
            </div>

            {{-- Kategori: B. Perasaan --}}
            <hr>
            <div class="mb-3">
                <h5 class="mt-3 mb-3 fw-bold text-primary">B. Perasaan</h5>
                @php renderQuestions($perasaan, 'perasaan', $pilihan); @endphp
            </div>

            {{-- Kategori: C. Makna Hidup --}}
            <hr>
            <div class="mb-3">
                <h5 class="mt-3 mb-3 fw-bold text-primary">C. Makna Hidup</h5>
                @php renderQuestions($maknaHidup, 'makna_hidup', $pilihan); @endphp
            </div>

        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>