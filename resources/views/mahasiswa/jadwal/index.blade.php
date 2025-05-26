@extends('layouts.mahasiswa')

@section('title', 'Jadwal Mata Kuliah')

@section('content')
<div class="container">
    <h4>Jadwal Mata Kuliah</h4>

    @if($jadwalMatakuliah->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Mata Kuliah</th>
                    <th>Ruangan</th>
                    <th>Dosen 1</th>
                    <th>Dosen 2</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalMatakuliah as $jadwal)
                    <tr>
                        <td>{{ $jadwal->hari }}</td>
                        <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                        <td>{{ $jadwal->matakuliah->nama_matakuliah }}</td>
                        <td>{{ $jadwal->ruangan }}</td>
                        <td>{{ $jadwal->dosenPengajar1->nama ?? '-' }}</td>
                        <td>{{ $jadwal->dosenPengajar2->nama ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada jadwal kuliah.</p>
    @endif
</div>
@endsection
