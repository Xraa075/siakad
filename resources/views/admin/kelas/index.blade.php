@extends('layouts.admin')
@section('content')
    <div class="container mt-4">
        @if ($jurusanContext)
            <h3 class="mb-2">
                {{ $pageTitle ?? 'Manajemen Kelas' }}
                (<span class="fw-normal">{{ $jurusanContext->departemen->nama_departemen }}</span>)
            </h3>
            <a href="{{ route('admin.jurusan.index', ['departemen_id' => $jurusanContext->departemen_id]) }}"
                class="btn btn-sm btn-outline-secondary mb-3">Kembali ke Daftar Jurusan</a>
        @else
            <h3 class="mb-4">{{ $pageTitle ?? 'Manajemen Kelas (Pilih Jurusan Terlebih Dahulu)' }}</h3>
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
        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($jurusanContext)
            <a href="{{ route('admin.kelas.create', ['jurusan_id' => $jurusanContext->id]) }}" class="btn btn-success mb-3">
                Tambah Kelas
            </a>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Kelas</th>
                            <th>Semester Kelas</th>
                            <th>Dosen Wali</th>
                            <th>Jadwal Kuliah Umum</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kelasList as $item)
                            <tr>
                                <td>{{ $item->nama_kelas }}</td>
                                <td>{{ $item->semester }}</td>
                                <td>{{ $item->dosenWali->nama ?? '-' }}</td>
                                <td>{{ $item->jadwalKuliah->nama_jadwal ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.kelas.edit', $item->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.kelas.destroy', $item->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data kelas untuk jurusan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($kelasList->hasPages())
                <div class="mt-4">
                    {{ $kelasList->appends(['jurusan_id' => $jurusanContext->id])->links() }}
                </div>
            @endif
        @elseif(!$jurusanContext && request()->query('jurusan_id'))
            <div class="alert alert-warning">Jurusan dengan ID tersebut tidak ditemukan.</div>
        @endif
    </div>
@endsection
