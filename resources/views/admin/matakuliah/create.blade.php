@extends('layouts.admin')
@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Tambah Mata Kuliah Baru</h3>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.matakuliah.store') }}" method="POST">
                    @csrf
                    @include('admin.matakuliah.partials.form', [
                        'submitButtonText' => 'Simpan Mata Kuliah',
                        'dosens' => $dosens,
                        'jurusans' => $jurusans,
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection
