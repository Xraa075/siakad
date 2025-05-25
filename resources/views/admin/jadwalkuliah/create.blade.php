@extends('layouts.admin')
@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Tambah Jadwal Kuliah Baru</h3>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.jadwalkuliah.store') }}" method="POST">
                    @csrf
                    @include('admin.jadwalkuliah.partials.form', [
                        'submitButtonText' => 'Simpan Jadwal',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection
