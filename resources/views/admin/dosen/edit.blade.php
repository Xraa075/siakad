@extends('layouts.admin')
@section('content')
    <div class="container mt-4">
        <h3 class="mb-3">Edit Data Dosen: <span class="fw-normal">{{ $dosen->nama }} ({{ $dosen->nip }})</span></h3>
        <a href="{{ route('admin.dosen.index') }}" class="btn btn-sm btn-outline-secondary mb-3">Kembali ke Daftar
            Dosen</a>

        <div class="card">
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form action="{{ route('admin.dosen.update', $dosen->nip) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('admin.dosen.partials.form', [
                        'submitButtonText' => 'Update Dosen',
                        'dosen' => $dosen,
                        'jurusans' => $jurusans,
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection
