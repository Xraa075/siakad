@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Input Nilai Mahasiswa Baru</h3>
        <div class="card">
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form method="GET" action="{{ route('admin.nilaimahasiswa.create') }}" class="mb-4"
                    id="selectMahasiswaForm">
                    <div class="row align-items-end">
                        <div class="col-md-8">
                            <label for="mahasiswa_nrp_select_filter" class="form-label">
                                @if ($selectedMahasiswa)
                                    Mahasiswa Terpilih: <span class="fw-bold">{{ $selectedMahasiswa->nama }}
                                        ({{ $selectedMahasiswa->nrp }})</span> - Ganti?
                                @else
                                    Pilih Mahasiswa Terlebih Dahulu <span class="text-danger">*</span>
                                @endif
                            </label>
                            <select name="mahasiswa_nrp_selected" id="mahasiswa_nrp_select_filter"
                                class="form-select @error('mahasiswa_nrp_selected') is-invalid @enderror">
                                <option value="">-- Pilih Mahasiswa --</option>
                                @foreach ($mahasiswas as $mhs)
                                    <option value="{{ $mhs->nrp }}"
                                        {{ ($selectedMahasiswa && $selectedMahasiswa->nrp == $mhs->nrp) || old('mahasiswa_nrp_selected') == $mhs->nrp ? 'selected' : '' }}>
                                        {{ $mhs->nama }} ({{ $mhs->nrp }}) - Semester: {{ $mhs->semester }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mahasiswa_nrp_selected')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-info w-100">
                                {{ $selectedMahasiswa ? 'Ganti Mahasiswa / Muat Ulang Mata Kuliah' : 'Pilih Mahasiswa & Lanjutkan' }}
                            </button>
                        </div>
                    </div>
                </form>

                @if ($selectedMahasiswa)
                    <hr class="my-4">
                    <h4>Input Nilai untuk: <span class="fw-normal">{{ $selectedMahasiswa->nama }} (NRP:
                            {{ $selectedMahasiswa->nrp }})</span></h4>
                    @if ($matakuliahOptions->isEmpty())
                        <div class="alert alert-warning mt-3">
                            Tidak ada mata kuliah yang tersedia untuk diinput nilainya bagi mahasiswa ini pada semester
                            {{ $selectedMahasiswa->semester }} berdasarkan jadwal kelasnya, atau semua mata kuliah yang
                            relevan sudah memiliki nilai.
                        </div>
                    @else
                        <form action="{{ route('admin.nilaimahasiswa.store') }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="mahasiswa_nrp" value="{{ $selectedMahasiswa->nrp }}">

                            @include('admin.nilaimahasiswa.partials.form', [
                                'submitButtonText' => 'Simpan Nilai',
                                'selectedMahasiswa' => $selectedMahasiswa,
                                'matakuliahOptions' => $matakuliahOptions,
                            ])
                        </form>
                    @endif
                @elseif(request()->filled('mahasiswa_nrp_selected'))
                    <div class="alert alert-info mt-3">
                        Mahasiswa dengan NRP tersebut tidak ditemukan atau tidak memiliki jadwal kelas yang valid.
                    </div>
                @else
                    <p class="text-muted mt-3">Silakan pilih mahasiswa di atas untuk menampilkan form input nilai.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
