@extends('layouts.dosen')

@section('title', 'FRS Mahasiswa')

@section('content')
    <div class="container">
        <h4>FRS dari Mahasiswa</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($frsList->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Mahasiswa</th>
                        <th>Kelas</th>
                        <th>Mata Kuliah</th>
                        <th>Semester</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($frsList as $frs)
                        <tr>
                            <td>{{ $frs->mahasiswa->nama }}</td>
                            <td>{{ $frs->mahasiswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $frs->matakuliah->nama_matakuliah }}</td>
                            <td>{{ $frs->semester }}</td>
                            <td>{{ $frs->tanggal_pengajuan }}</td>
                            <td>
                                <form action="{{ route('dosen.frs.acc', $frs->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                                </form>
                                <form action="{{ route('dosen.frs.destroy', $frs->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus FRS ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada FRS</p>
        @endif
        <h4>FRS yang sudah disetujui</h4>
        @if ($frsDisetujui->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Mahasiswa</th>
                        <th>Kelas</th>
                        <th>Mata Kuliah</th>
                        <th>Semester</th>
                        <th>Tanggal Pengajuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($frsDisetujui as $frs)
                        <tr>
                            <td>{{ $frs->mahasiswa->nama }}</td>
                            <td>{{ $frs->mahasiswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $frs->matakuliah->nama_matakuliah }}</td>
                            <td>{{ $frs->semester }}</td>
                            <td>{{ $frs->tanggal_pengajuan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Belum ada FRS yang disetujui.</p>
        @endif
    </div>
@endsection
