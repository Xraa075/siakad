<div class="container mt-4">
    @if ($departemen)
        <h3 class="mb-2">Manajemen Jurusan untuk Departemen: <span
                class="fw-normal">{{ $departemen->nama_departemen }}</span></h3>
        <a href="{{ route('admin.departemen.index') }}" class="btn btn-sm btn-outline-secondary mb-3">&larr; Kembali ke
            Daftar Departemen</a>
    @else
        <h3 class="mb-4">Manajemen Jurusan (Pilih Departemen Terlebih Dahulu)</h3>
    @endif

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

    @if ($departemen)
        <a href="{{ route('admin.jurusan.create', ['departemen_id' => $departemen->id]) }}"
            class="btn btn-success mb-3">
            Tambah Jurusan (untuk {{ $departemen->nama_departemen }})
        </a>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama Jurusan</th>
                    <th style="width: 200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jurusans as $jur)
                    <tr>
                        <td>{{ $jur->nama_jurusan }}</td>
                        <td>
                            <a href="{{ route('admin.kelas.index', ['jurusan_id' => $jur->id]) }}"
                                class="btn btn-success btn-sm">Lihat Kelas</a>
                            <a href="{{ route('admin.jurusan.edit', $jur->id) }}"
                                class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.jurusan.destroy', $jur->id) }}" method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurusan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">Belum ada data jurusan untuk departemen ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($jurusans->hasPages())
            <div class="mt-4">
                {{ $jurusans->appends(['departemen_id' => $departemen->id])->links() }}
            </div>
        @endif
    @else
        <div class="alert alert-warning">
            Tidak ada departemen yang dipilih atau departemen tidak ditemukan. Silakan kembali dan pilih departemen.
        </div>
    @endif
</div>
