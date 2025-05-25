@extends('layouts.admin')
@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Input Nilai Mahasiswa Baru</h3>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.nilaimahasiswa.store') }}" method="POST">
                    @csrf
                    @include('admin.nilaimahasiswa.partials.form', [
                        'submitButtonText' => 'Simpan Nilai',
                        'mahasiswas' => $mahasiswas,
                        'matakuliahs' => $matakuliahs,
                        'dosens' => $dosens,
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection
