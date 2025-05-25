@extends('layouts.admin')
@section('content')
    <div class="container mt-4">
        <h3 class="mb-3">Edit Data Mahasiswa: <span class="fw-normal">{{ $mahasiswa->nama }} ({{ $mahasiswa->nrp }})</span>
        </h3>
        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-sm btn-outline-secondary mb-3">Kembali ke Daftar
            Mahasiswa</a>

        <div class="card">
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form action="{{ route('admin.mahasiswa.update', $mahasiswa->nrp) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('admin.mahasiswa.partials.form', [
                        'submitButtonText' => 'Update Mahasiswa',
                        'mahasiswa' => $mahasiswa,
                        'kelasList' => $kelasList,
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection
