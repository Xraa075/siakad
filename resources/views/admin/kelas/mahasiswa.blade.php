@extends('layouts.admin')

@section('title', 'Daftar Mahasiswa')

@section('content')
    <div class="container mt-4">
        <h4>Daftar Mahasiswa untuk Kelas: <span class="fw-normal">{{ $kelas->nama_kelas }}</span></h4>
        <a href="{{ route('admin.kelas.index', ['jurusan_id' => $kelas->jurusan_id]) }}" class="btn btn-outline-secondary mb-3">Kembali</a>

        @if($mahasiswas->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>NRP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Semester</th>
                        <th>No. Telepon</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahasiswas as $mhs)
                        <tr>
                            <td>{{ $mhs->nrp }}</td>
                            <td>{{ $mhs->nama }}</td>
                            <td>{{ $mhs->email_kontak }}</td>
                            <td>{{ $mhs->semester }}</td>
                            <td>{{ $mhs->no_telp }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">Belum ada mahasiswa di kelas ini.</div>
        @endif
    </div>
@endsection
