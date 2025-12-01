<div class="table-responsive">
    <table class="table table-bordered table-sm mb-4">
        <thead class="table-light">
            <tr>
                <th style="width:40px">No</th>
                <th>Nama Enumerator</th>
                <th>Tanggal Wawancara</th>
                <th>Tanggal Editing</th>
                <th>Nama Pemvalidasi</th>
                <th style="width:120px">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @php
            $enumerators = $enumerators ?? collect();
            @endphp

            @forelse ($enumerators as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->nama_enumerator }}</td>
                <td>{{ $item->tanggal_wawancara ?? '-' }}</td>
                <td>{{ $item->tanggal_editing ?? '-' }}</td>
                <td>{{ $item->nama_pemvalidasi ?? '-' }}</td>
                <td class="text-center">

                    {{-- Edit --}}
                    <a href="{{ route('forms.keterangan-enumerator.edit', $item->id) }}"
                        class="btn btn-sm btn-outline-primary" title="Edit">
                        ✏️
                    </a>

                    {{-- Delete --}}
                    <form action="{{ route('forms.keterangan-enumerator.destroy', $item->id) }}"
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
                <td colspan="6" class="text-center text-muted">Belum ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>