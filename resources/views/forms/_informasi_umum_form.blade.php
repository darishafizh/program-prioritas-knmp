<div class="table-responsive">
    <table class="table table-bordered table-sm mb-4">
        <thead class="table-light">
            <tr>
                <th style="width:40px">No</th>
                <th>Nama Responden</th>
                <th>Provinsi</th>
                <th>Kabupaten</th>
                <th>Pekerjaan/Jabatan</th>
                <th>Jenis Program</th>
                <th style="width:120px">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($informasiUmum as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->nama_responden }}</td>
                <td>{{ $item->provinsi }}</td>
                <td>{{ $item->kabupaten }}</td>
                <td>{{ $item->status_responden }}</td>
                <td>{{ $item->jenis_program }}</td>

                <td class="text-center">

                    {{-- Edit --}}
                    <a href="{{ route('forms.informasi_umum.edit', $item->id) }}"
                        class="btn btn-sm btn-outline-primary" title="Edit">
                        ✏️
                    </a>

                    {{-- Delete --}}
                    <form action="{{ route('forms.informasi_umum.delete', $item->id) }}"
                        method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Hapus data ini?')" title="Delete">
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