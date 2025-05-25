@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-3">
            Edit Detail Jadwal Mata Kuliah
        </h3>
        <p class="mb-3">Untuk Jadwal Umum: <span class="fw-semibold">{{ $jadwalKuliahContext->nama_jadwal }}</span></p>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.jadwalmatakuliah.update', $jadwalmatakuliah->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('admin.jadwalmatakuliah.partials.form', [
                        'submitButtonText' => 'Update Detail Jadwal',
                        'jadwalmatakuliah' => $jadwalmatakuliah,
                        'jadwalKuliahContext' => $jadwalKuliahContext,
                        'matakuliahs' => $matakuliahs,
                        'dosens' => $dosens,
                        'hariOptions' => $hariOptions
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection
