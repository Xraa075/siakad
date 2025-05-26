@extends('layouts.mahasiswa')

@section('content')
<div class="container">
    <h4>FRS yang Tersedia</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($frsTersedia->count())
        <table class="table">
            <thead>
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Semester</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($frsTersedia as $frs)
                    <tr>
                        <td>{{ $frs->matakuliah->nama_matakuliah }}</td>
                        <td>{{ $frs->semester }}</td>
                        <td>
                            <form action="{{ route('mahasiswa.frs.ambil', $frs->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">Ambil</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada FRS yang tersedia saat ini.</p>
    @endif

    <hr>
    <h4>FRS yang Sudah Diambil</h4>
    @if($frsTerambil->count())
        <table class="table">
            <thead>
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Semester</th>
                    <th>Status</th>
                    <th>Tanggal Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($frsTerambil as $frs)
                    <tr>
                        <td>{{ $frs->matakuliah->nama_matakuliah }}</td>
                        <td>{{ $frs->semester }}</td>
                        <td>{{ $frs->status }}</td>
                        <td>{{ $frs->tanggal_pengajuan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada FRS yang Anda ambil.</p>
    @endif
</div>
@endsection
