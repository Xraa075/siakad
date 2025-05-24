
    <div class="container mt-4">
        <h3 class="mb-4">
            Tambah Kelas Baru untuk Jurusan: <span class="fw-normal">{{ $jurusanContext->nama_jurusan }}</span>
        </h3>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.kelas.store') }}" method="POST">
                    @include('admin.kelas.partials.form', [
                        'submitButtonText' => 'Simpan Kelas',
                        'jurusanContext' => $jurusanContext,
                        'dosens' => $dosens,
                        'jadwalKuliahs' => $jadwalKuliahs
                    ])
                </form>
            </div>
        </div>
    </div>

