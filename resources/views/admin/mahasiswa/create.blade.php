@extends('layouts.admin')
@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Tambah Mahasiswa Baru</h3>
        <div class="card">
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
                    @csrf
                    @include('admin.mahasiswa.partials.form', [
                        'submitButtonText' => 'Simpan Mahasiswa',
                        'kelasList' => $kelasList,
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection
