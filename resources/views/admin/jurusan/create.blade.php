<div class="container mt-4">
    <h3 class="mb-4">
        Tambah Jurusan Baru
        @if ($departemenDipilih)
            untuk Departemen: <span class="fw-normal">{{ $departemenDipilih->nama_departemen }}</span>
        @endif
    </h3>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.jurusan.store') }}" method="POST">
                @csrf
                @include('admin.jurusan.partials.form', [
                    'submitButtonText' => 'Simpan Jurusan',
                    'departemenDipilih' => $departemenDipilih,
                ])
            </form>
        </div>
    </div>
</div>
