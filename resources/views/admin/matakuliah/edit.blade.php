<div class="container mt-4">
    <h3 class="mb-3">Edit Mata Kuliah: <span class="fw-normal">{{ $matakuliah->nama_matakuliah }}</span></h3>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.matakuliah.update', $matakuliah->id) }}" method="POST">
                @csrf
                @method('PUT')
                {{-- $matakuliah, $dosens, dan $jurusans dikirim dari MatakuliahController@edit --}}
                @include('admin.matakuliah.partials.form', [
                    'submitButtonText' => 'Update Mata Kuliah',
                    'matakuliah' => $matakuliah,
                    'dosens' => $dosens,
                    'jurusans' => $jurusans,
                ])
            </form>
        </div>
    </div>
</div>
