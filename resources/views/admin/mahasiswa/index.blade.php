@extends('layouts.admin')
@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Daftar Mahasiswa</h3>

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

        <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-success mb-3">Tambah Mahasiswa</a>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>NRP</th>
                        <th>Nama Mahasiswa</th>
                        <th>Email Login</th>
                        <th>Email Pribadi</th>
                        <th>Kelas</th>
                        <th>Semester</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswas as $mhs)
                        <tr>
                            <td>{{ $mhs->nrp }}</td>
                            <td>{{ $mhs->nama }}</td>
                            <td>{{ $mhs->user->email ?? '-' }}</td>
                            <td>{{ $mhs->email_kontak ?? '-' }}</td>
                            <td>{{ $mhs->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $mhs->semester }}</td>
                            <td>{{ $mhs->kelas->jurusan->nama_jurusan }}</td>
                            <td>
                                <a href="{{ route('admin.mahasiswa.show', $mhs->nrp) }}"
                                    class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('admin.mahasiswa.edit', $mhs->nrp) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.mahasiswa.destroy', $mhs->nrp) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini? Akun user terkait juga akan dihapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($mahasiswas->hasPages())
            <div class="mt-4">
                {{ $mahasiswas->links() }}
            </div>
        @endif
    </div>
@endsection
