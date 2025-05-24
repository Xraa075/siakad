    <div class="container mt-4">
        <h3 class="mb-4">Tambah Departemen Baru</h3>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.departemen.store') }}" method="POST">
                    @csrf
                    @include('admin.departemen.partials.form', ['submitButtonText' => 'Simpan'])
                </form>
            </div>
        </div>
    </div>
