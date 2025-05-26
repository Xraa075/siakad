@extends('layouts.admin')

@section('content')
<div class="container">
    <h3>Data FRS Seluruh Mahasiswa</h3>

    <a href="{{ route('admin.frs-mahasiswa.create') }}" class="btn btn-primary my-3">Tambah FRS</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>NRP</th>
                <th>Nama Mahasiswa</th>
                <th>Mata Kuliah</th>
                <th>Semester</th>
                <th>Status</th>
                <th>Tanggal Pengajuan</th>
                <th>Available</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($frs as $item)
                <tr>
                    <td>{{ $item->mahasiswa_nrp }}</td>
                    <td>{{ $item->mahasiswa->nama }}</td>
                    <td>{{ $item->matakuliah->nama_matakuliah }}</td>
                    <td>{{ $item->semester }}</td>
                    <td>{{ $item->status ?? '-' }}</td>
                    <td>{{ $item->tanggal_pengajuan }}</td>
                    <td>{{ $item->available ? 'Ya' : 'Tidak' }}</td>
                    <td>
                        <a href="{{ route('admin.frs-mahasiswa.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.frs-mahasiswa.destroy', $item->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
