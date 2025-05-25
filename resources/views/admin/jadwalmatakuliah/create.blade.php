@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">
            Tambah Detail Jadwal Mata Kuliah untuk: <span class="fw-normal">{{ $jadwalKuliahContext->nama_jadwal }}</span>
        </h3>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.jadwalmatakuliah.store') }}" method="POST">
                    @csrf
                    @include('admin.jadwalmatakuliah.partials.form', [
                        'submitButtonText' => 'Simpan Detail Jadwal',
                        'jadwalKuliahContext' => $jadwalKuliahContext,
                        'matakuliahs' => $matakuliahs,
                        'dosens' => $dosens,
                        'hariOptions' => $hariOptions,
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection
