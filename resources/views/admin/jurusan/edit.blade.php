@extends('layouts.admin')
@section('content')
<div class="container mt-4">
    <h3 class="mb-3">
        Edit Jurusan: <span class="fw-normal">{{ $jurusan->nama_jurusan }}</span>
    </h3>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.jurusan.update', $jurusan->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.jurusan.partials.form', [
                    'submitButtonText' => 'Update Jurusan',
                    'jurusan' => $jurusan,
                    'departemenDipilih' => $jurusan->departemen,
                ])
            </form>
        </div>
    </div>
</div>
@endsection
