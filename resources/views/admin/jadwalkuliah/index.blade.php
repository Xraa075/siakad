@extends('layouts.admin')
@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Jadwal Kuliah</h3>

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

        <a href="{{ route('admin.jadwalkuliah.create') }}" class="btn btn-success mb-3">Tambah Jadwal Kuliah</a>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Jadwal Kuliah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwalkuliahs as $jadwal)
                        <tr>
                            <td>{{ $jadwal->nama_jadwal }}</td>
                            <td>
                                <a href="{{ route('admin.jadwalmatakuliah.index', ['jadwal_kuliah_id' => $jadwal->id]) }}"
                                    class="btn btn-info btn-sm">Lihat Detail Jadwal</a>
                                <a href="{{ route('admin.jadwalkuliah.edit', $jadwal->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.jadwalkuliah.destroy', $jadwal->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal kuliah ini? Semua jadwal mata kuliah di dalamnya juga akan terpengaruh jika tidak di-handle dengan benar.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada data jadwal kuliah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($jadwalkuliahs->hasPages())
            <div class="mt-4">
                {{ $jadwalkuliahs->links() }}
            </div>
        @endif
    </div>
@endsection
