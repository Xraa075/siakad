@extends('layouts.admin')
@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Mata Kuliah</h3>

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


        <a href="{{ route('admin.matakuliah.create') }}" class="btn btn-success mb-3">Tambah Mata Kuliah</a>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Mata Kuliah</th>
                        <th>Dosen PJMK</th>
                        <th>Jurusan</th>
                        <th>SKS</th>
                        <th>Semester</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($matakuliahs as $mk)
                        <tr>
                            <td>{{ $mk->nama_matakuliah }}</td>
                            <td>{{ $mk->dosenPJMK->nama ?? '-' }}</td>
                            <td>{{ $mk->jurusan->nama_jurusan ?? '-' }}</td>
                            <td>{{ $mk->sks }}</td>
                            <td>{{ $mk->semester }}</td>
                            <td>
                                <a href="{{ route('admin.matakuliah.edit', $mk->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.matakuliah.destroy', $mk->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data mata kuliah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($matakuliahs->hasPages())
            <div class="mt-4">
                {{ $matakuliahs->links() }}
            </div>
        @endif
    </div>
@endsection
