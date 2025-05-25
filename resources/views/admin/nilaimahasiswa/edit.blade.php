@extends('layouts.admin')
@section('content')
    <div class="container mt-4">
        <h3 class="mb-3">Edit Nilai Mahasiswa</h3>
        <p>
            <strong>Mahasiswa:</strong> {{ $nilaimahasiswa->mahasiswa->nama ?? 'N/A' }}
            ({{ $nilaimahasiswa->mahasiswa_nrp }}) <br>
            <strong>Mata Kuliah:</strong> {{ $nilaimahasiswa->matakuliah->nama_matakuliah ?? 'N/A' }}
        </p>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.nilaimahasiswa.update', $nilaimahasiswa->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('admin.nilaimahasiswa.partials.form', [
                        'submitButtonText' => 'Update Nilai',
                        'nilaimahasiswa' => $nilaimahasiswa,
                        'mahasiswas' => $mahasiswas,
                        'matakuliahs' => $matakuliahs,
                        'dosens' => $dosens,
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection
