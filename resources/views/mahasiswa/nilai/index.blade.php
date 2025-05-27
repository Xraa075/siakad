@extends('layouts.mahasiswa')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Transkrip Nilai Sementara - {{ $mahasiswa->nama }} ({{ $mahasiswa->nrp }})</h3>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($nilais->isEmpty())
            <div class="alert alert-info mt-3">
                Belum ada data nilai yang tercatat untuk Anda.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Kode MK</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Nilai UTS</th>
                            <th>Nilai UAS</th>
                            <th>Nilai Tugas</th>
                            <th>Nilai Akhir</th>
                            <th>Grade</th>
                            <th>Dosen Pengampu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $nomor = 1;
                        @endphp
                        @foreach ($nilais as $nilai)
                            <tr>
                                <td>{{ $nomor++ }}</td>
                                <td>{{ $nilai->matakuliah->id ?? '-' }}</td>
                                <td>{{ $nilai->matakuliah->nama_matakuliah ?? 'Mata Kuliah Tidak Ditemukan' }}</td>
                                <td>{{ $nilai->matakuliah->sks ?? '-' }}</td>
                                <td>{{ $nilai->semester }}</td>
                                <td>{{ number_format($nilai->nilai_uts, 2) }}</td>
                                <td>{{ number_format($nilai->nilai_uas, 2) }}</td>
                                <td>{{ number_format($nilai->nilai_tugas, 2) }}</td>
                                <td>{{ $nilai->nilai_akhir !== null ? number_format($nilai->nilai_akhir, 2) : '-' }}</td>
                                <td>{{ $nilai->grade ?? '-' }}</td>
                                <td>{{ $nilai->dosen->nama ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
