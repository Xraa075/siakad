@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Manajemen Nilai Mahasiswa</h3>

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

        <a href="{{ route('admin.nilaimahasiswa.create') }}" class="btn btn-success mb-3">Input Nilai Baru</a>

        <form method="GET" action="{{ route('admin.nilaimahasiswa.index') }}" class="row g-3 mb-3 align-items-end">
            <div class="col-md-3">
                <label for="filter_mahasiswa_nrp" class="form-label">Filter Mahasiswa</label>
                <select name="mahasiswa_nrp" id="filter_mahasiswa_nrp" class="form-select">
                    <option value="">Semua Mahasiswa</option>
                    @foreach ($mahasiswas as $mhs)
                        <option value="{{ $mhs->nrp }}" {{ request('mahasiswa_nrp') == $mhs->nrp ? 'selected' : '' }}>
                            {{ $mhs->nama }} ({{ $mhs->nrp }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="filter_matakuliah_id" class="form-label">Filter Mata Kuliah</label>
                <select name="matakuliah_id" id="filter_matakuliah_id" class="form-select">
                    <option value="">Semua Mata Kuliah</option>
                    @foreach ($matakuliahs as $mk)
                        <option value="{{ $mk->id }}" {{ request('matakuliah_id') == $mk->id ? 'selected' : '' }}>
                            {{ $mk->nama_matakuliah }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="filter_semester" class="form-label">Filter Semester</label>
                <input type="number" name="semester" id="filter_semester" class="form-control"
                    value="{{ request('semester') }}" placeholder="Cth: 1">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.nilaimahasiswa.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Mahasiswa (NRP)</th>
                        <th>Mata Kuliah</th>
                        <th>Semester</th>
                        <th>UTS</th>
                        <th>UAS</th>
                        <th>Tugas</th>
                        <th>Nilai Akhir</th>
                        <th>Grade</th>
                        <th>Dosen Pengampu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($nilais as $nilai)
                        <tr>
                            <td>{{ $nilai->mahasiswa->nama ?? $nilai->mahasiswa_nrp }} <br> ({{ $nilai->mahasiswa_nrp }})
                            </td>
                            <td>{{ $nilai->matakuliah->nama_matakuliah ?? '-' }}</td>
                            <td>{{ $nilai->semester }}</td>
                            <td>{{ number_format($nilai->nilai_uts, 2) }}</td>
                            <td>{{ number_format($nilai->nilai_uas, 2) }}</td>
                            <td>{{ number_format($nilai->nilai_tugas, 2) }}</td>
                            <td>{{ $nilai->nilai_akhir !== null ? number_format($nilai->nilai_akhir, 2) : '-' }}</td>
                            <td>{{ $nilai->grade ?? '-' }}</td>
                            <td>{{ $nilai->dosen->nama ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.nilaimahasiswa.edit', $nilai->id) }}"
                                    class="btn btn-warning btn-sm mb-1 d-block">Edit</a>
                                <form action="{{ route('admin.nilaimahasiswa.destroy', $nilai->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus nilai ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm d-block w-100">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Belum ada data nilai mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($nilais->hasPages())
            <div class="mt-4">
                {{ $nilais->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
