@extends('layouts.dosen')

@section('title', 'FRS Mahasiswa')

@section('content')
<div class="container">
    <h4>FRS Mahasiswa dari Kelas Wali Anda</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($frsList->count())
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
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada FRS dari mahasiswa yang Anda wali-i.</p>
    @endif
</div>
@endsection
