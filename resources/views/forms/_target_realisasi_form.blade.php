<div class="table-responsive">
    <table class="table table-bordered table-sm mb-4">
        <thead class="table-light">
            <tr>
                <th style="width:40px">No</th>
                <th>Nama KNMP</th>
                <th>PPK</th>
                <th>Kontraktor Pelaksana</th>
                <th style="width:100px">Target Fisik</th>
                <th style="width:120px">Realisasi Fisik</th>
                <th style="width:120px">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @php
            // Ambil data dari controller atau session
            $targets = $targets ?? session()->get('target_realisasi', []);
            @endphp

            @forelse ($targets as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item['nama_knmp'] }}</td>
                <td>{{ $item['ppk'] }}</td>
                <td>{{ $item['kontraktor'] }}</td>
                <td>{{ $item['target_fisik'] }}</td>
                <td>{{ $item['realisasi_fisik'] }}</td>

                <td class="text-center">
                    <a href="{{ route('forms.target_realisasi.edit', $item['id']) }}"
                        class="btn btn-sm btn-outline-primary"
                        title="Edit">
                        ✏️
                    </a>

                    <form action="{{ route('forms.target_realisasi.delete', $item['id']) }}"
                        method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Hapus data ini?')"
                            title="Delete">
                            🗑️
                        </button>
                    </form>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted">Belum ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>