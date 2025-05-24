<div class="container mt-4">
    <h3 class="mb-3">
        Edit Kelas: <span class="fw-normal">{{ $kela->nama_kelas }}</span>
    </h3>
    <p class="mb-3">Jurusan: <span class="fw-semibold">{{ $jurusanContext->nama_jurusan }} (Departemen:
            {{ $jurusanContext->departemen->nama_departemen }})</span></p>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.kelas.update', $kela->id) }}" method="POST">
                @method('PUT')
                @include('admin.kelas.partials.form', [
                    'submitButtonText' => 'Update Kelas',
                    'kela' => $kela,
                    'jurusanContext' => $jurusanContext,
                    'dosens' => $dosens,
                    'jadwalKuliahs' => $jadwalKuliahs,
                ])
            </form>
        </div>
    </div>
</div>
