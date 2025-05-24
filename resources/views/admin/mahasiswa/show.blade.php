<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Detail Mahasiswa: <span class="fw-normal">{{ $mahasiswa->nama }}</span></h3>
        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-outline-secondary">&larr; Kembali ke Daftar
            Mahasiswa</a>
    </div>

    <div class="card">
        <div class="card-header">
            Informasi Umum
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <strong>NRP:</strong> {{ $mahasiswa->nrp }}
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Nama Lengkap:</strong> {{ $mahasiswa->nama }}
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Email Login:</strong> {{ $mahasiswa->user->email ?? '-' }}
                </div>
                <div class="col-md-6 mb-2">
                    <strong>No. Telepon:</strong> {{ $mahasiswa->no_telp ?? '-' }}
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Kelas:</strong> {{ $mahasiswa->kelas->nama_kelas ?? '-' }}
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Jurusan:</strong> {{ $mahasiswa->kelas->jurusan->nama_jurusan ?? '-' }}
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Semester:</strong> {{ $mahasiswa->semester }}
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Akun Dibuat:</strong> {{ $mahasiswa->user->created_at->format('d M Y, H:i') ?? '-' }}
                </div>
            </div>
            <hr>
            <a href="{{ route('admin.mahasiswa.edit', $mahasiswa->nrp) }}" class="btn btn-warning">Edit Data
                Mahasiswa</a>
        </div>
    </div>

    {{-- Anda bisa menambahkan bagian untuk FRS, Nilai, dll di sini --}}
    {{-- Contoh:
    <div class="card mt-4">
        <div class="card-header">
            Histori FRS
        </div>
        <div class="card-body">
            @if ($mahasiswa->frs && $mahasiswa->frs->count() > 0)
                <ul>
                @foreach ($mahasiswa->frs as $frsItem)
                    <li>{{ $frsItem->matakuliah->nama_matakuliah ?? 'N/A' }} - Semester {{ $frsItem->semester }} (Status: {{ $frsItem->status }})</li>
                @endforeach
                </ul>
            @else
                <p>Belum ada data FRS.</p>
            @endif
        </div>
    </div>
    --}}
</div>
