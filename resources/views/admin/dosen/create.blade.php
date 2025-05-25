@extends('layouts.admin')
@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Tambah Dosen Baru</h3>
        <div class="card">
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form action="{{ route('admin.dosen.store') }}" method="POST">
                    @csrf
                    @include('admin.dosen.partials.form', [
                        'submitButtonText' => 'Simpan Dosen',
                        'jurusans' => $jurusans,
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection
