<div class="container mt-4">
    <h3 class="mb-4">Manajemen Departemen</h3>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="{{ route('admin.departemen.create') }}" class="btn btn-success mb-3">Tambah Departemen Baru</a>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>Nama Departemen</th>
                <th style="width: 250px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($departemens as $dept)
                <tr>
                    <td>{{ $dept->nama_departemen }}</td>
                    <td>
                        <a href="{{ route('admin.jurusan.index', ['departemen_id' => $dept->id]) }}"
                            class="btn btn-info btn-sm">Lihat Jurusan</a>
                        <a href="{{ route('admin.departemen.edit', $dept->id) }}"
                            class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.departemen.destroy', $dept->id) }}" method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus departemen ini? Semua jurusan yang terkait akan terhapus juga.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">Belum ada data departemen.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($departemens->hasPages())
        <div class="mt-4">
            {{ $departemens->links() }}
        </div>
    @endif
</div>
