@extends('layouts.dosen')

@section('title', 'Jadwal Kuliah Saya')

@section('content')
<div class="container">
    <h4>Jadwal Kuliah Anda sebagai Pengajar</h4>

    @if($jadwalList->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Ruangan</th>
                    <th>Semester</th>
                    <th>Jenis Pengajar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalList as $jadwal)
                    <tr>
                        <td>{{ $jadwal->matakuliah->nama_matakuliah ?? '-' }}</td>
                        <td>{{ $jadwal->hari }}</td>
                        <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                        <td>{{ $jadwal->ruangan }}</td>
                        <td>{{ $jadwal->semester }}</td>
                        <td>
                            @if ($jadwal->dosen_nip == Auth::user()->username)
                                Pengajar 1
                            @elseif ($jadwal->dosen_pengajar2_nip == Auth::user()->username)
                                Pengajar 2
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Anda belum memiliki jadwal kuliah.</p>
    @endif
</div>
@endsection
