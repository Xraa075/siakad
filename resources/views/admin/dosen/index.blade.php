@extends('layouts.admin')
@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Daftar Dosen</h3>
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

        <a href="{{ route('admin.dosen.create') }}" class="btn btn-success mb-3">Tambah Dosen</a>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Email Login</th>
                        <th>Email Kontak</th>
                        <th>Jurusan</th>
                        <th>No Telp</th>
                        <th>Dosen Wali</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dosens as $d)
                        <tr>
                            <td>{{ $d->nip }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->user->email ?? '-' }}</td>
                            <td>{{ $d->email_kontak ?? '-' }}</td>
                            <td>{{ $d->jurusan->nama_jurusan ?? '-' }}</td>
                            <td>{{ $d->no_telp ?? '-' }}</td>
                            <td>{{ $d->isDosenWali ? 'Ya' : 'Tidak' }}</td>
                            <td>
                                <div class="d-flex gap-1"> {{-- Menggunakan gap-1 untuk sedikit spasi --}}
                                    <a href="{{ route('admin.dosen.show', $d->nip) }}"
                                        class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('admin.dosen.edit', $d->nip) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.dosen.destroy', $d->nip) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus dosen ini? Akun user terkait juga akan dihapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data dosen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($dosens->hasPages())
            <div class="mt-4">
                {{ $dosens->links() }}
            </div>
        @endif
    </div>
@endsection
