@extends('layouts.admin')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Detail Dosen: <span class="fw-normal">{{ $dosen->nama }}</span></h3>
            <a href="{{ route('admin.dosen.index') }}" class="btn btn-outline-secondary">Kembali ke Daftar Dosen</a>
        </div>

        <div class="card">
            <div class="card-header">
                Informasi Umum Dosen
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <strong>NIP:</strong> {{ $dosen->nip }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Nama Lengkap:</strong> {{ $dosen->nama }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Email Login:</strong> {{ $dosen->user->email ?? '-' }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Email Kontak:</strong> {{ $dosen->email_kontak ?? '-' }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>No. Telepon:</strong> {{ $dosen->no_telp ?? '-' }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Jurusan:</strong> {{ $dosen->jurusan->nama_jurusan ?? '-' }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Status Dosen Wali:</strong> {{ $dosen->isDosenWali ? 'Ya' : 'Tidak' }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Akun Dibuat:</strong> {{ $dosen->user->created_at->format('d M Y, H:i') ?? '-' }}
                    </div>
                </div>
                <hr>
                <a href="{{ route('admin.dosen.edit', $dosen->nip) }}" class="btn btn-warning">Edit Data Dosen</a>
            </div>
        </div>

        @if ($dosen->kelasWali && $dosen->kelasWali->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    Kelas yang Diampu sebagai Dosen Wali
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($dosen->kelasWali as $kelas)
                        <li class="list-group-item">{{ $kelas->nama_kelas }} (Semester {{ $kelas->semester }})</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($dosen->matakuliahPJMK && $dosen->matakuliahPJMK->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    Mata Kuliah yang Diampu
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($dosen->matakuliahPJMK as $mk)
                        <li class="list-group-item">{{ $mk->nama_matakuliah }} ({{ $mk->sks }} SKS, Semester
                            {{ $mk->semester }})</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
@endsection
