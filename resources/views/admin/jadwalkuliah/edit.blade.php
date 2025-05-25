@extends('layouts.admin')
@section('content')
    <div class="container mt-4">
        <h3 class="mb-3">Edit Jadwal Kuliah: <span class="fw-normal">{{ $jadwalkuliah->nama_jadwal }}</span></h3>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.jadwalkuliah.update', $jadwalkuliah->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('admin.jadwalkuliah.partials.form', [
                        'submitButtonText' => 'Update Jadwal',
                        'jadwalkuliah' => $jadwalkuliah,
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection
