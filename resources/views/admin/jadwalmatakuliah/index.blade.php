@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-2">Jadwal Umum: <span class="fw-semibold">{{ $jadwalKuliahContext->nama_jadwal }}</span></h3>
        <a href="{{ route('admin.jadwalkuliah.index') }}" class="btn btn-sm btn-outline-secondary mb-3">Kembali ke Daftar
            Jadwal Kuliah</a>

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

        @if ($jadwalKuliahContext)
            <a href="{{ route('admin.jadwalmatakuliah.create', ['jadwal_kuliah_id' => $jadwalKuliahContext->id]) }}"
                class="btn btn-success mb-3">
                Tambah Jadwal Matakuliah
            </a>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Dosen 1</th>
                            <th>Dosen 2</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Ruangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jadwalMatakuliahs as $detail)
                            <tr>
                                <td>{{ $detail->matakuliah->nama_matakuliah ?? '-' }}</td>
                                <td>{{ $detail->matakuliah->sks ?? '-' }}</td>
                                <td>{{ $detail->semester }}</td>
                                <td>{{ $detail->dosenPengajar1->nama ?? '-' }}</td>
                                <td>{{ $detail->dosenPengajar2->nama ?? '-' }}</td>
                                <td>{{ $detail->hari }}</td>
                                <td>{{ \Carbon\Carbon::parse($detail->jam_mulai)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($detail->jam_selesai)->format('H:i') }}</td>
                                <td>{{ $detail->ruangan }}</td>
                                <td>
                                    <a href="{{ route('admin.jadwalmatakuliah.edit', $detail->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.jadwalmatakuliah.destroy', $detail->id) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus detail jadwal ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada detail jadwal mata kuliah untuk Jadwal
                                    Kuliah ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($jadwalMatakuliahs->hasPages())
                <div class="mt-4">
                    {{ $jadwalMatakuliahs->appends(['jadwal_kuliah_id' => $jadwalKuliahContext->id])->links() }}
                </div>
            @endif
        @elseif(!$jadwalKuliahContext && request()->query('jadwal_kuliah_id'))
            <div class="alert alert-warning">Jadwal Kuliah dengan ID tersebut tidak ditemukan.</div>
        @endif
    </div>
@endsection
