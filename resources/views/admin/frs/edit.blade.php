@extends('layouts.admin')

@section('title', 'Edit FRS')

@section('content')
    <div class="container">
        <h3>Edit FRS Mahasiswa</h3>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.frs-mahasiswa.update', $frs_mahasiswa->id) }}"
            method="POST"onsubmit="console.log('form dikirim')">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="mahasiswa_nrp" class="form-label">Mahasiswa</label>
                <select name="mahasiswa_nrp" id="mahasiswa_nrp" class="form-select" required>
                    <option value="">-- Pilih Mahasiswa --</option>
                    @foreach ($mahasiswas as $mhs)
                        <option value="{{ $mhs->nrp }}" data-semester="{{ $mhs->semester }}"
                            {{ old('mahasiswa_nrp', $frs_mahasiswa->mahasiswa_nrp) == $mhs->nrp ? 'selected' : '' }}>
                            {{ $mhs->nama }} ({{ $mhs->nrp }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="matakuliah_id" class="form-label">Mata Kuliah</label>
                <select name="matakuliah_id" id="matakuliah_id" class="form-select" required>
                    @foreach ($matakuliahs as $mk)
                        <option value="{{ $mk->id }}"
                            {{ old('matakuliah_id', $frs_mahasiswa->matakuliah_id) == $mk->id ? 'selected' : '' }}>
                            {{ $mk->nama_matakuliah }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <input type="number" name="semester" id="semester" class="form-control"
                    value="{{ old('semester', $frs_mahasiswa->semester) }}" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="acc" {{ old('status', $frs_mahasiswa->status) == 'acc' ? 'selected' : '' }}>ACC
                    </option>
                    <option value="belum acc" {{ old('status', $frs_mahasiswa->status) == 'belum acc' ? 'selected' : '' }}>
                        Belum ACC</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                <input type="date" name="tanggal_pengajuan" class="form-control"
                    value="{{ old('tanggal_pengajuan', $frs_mahasiswa->tanggal_pengajuan) }}" required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="available" id="available" class="form-check-input"
                    {{ old('available', isset($frs_mahasiswa) ? $frs_mahasiswa->available : true) ? 'checked' : '' }}>
                <label for="available" class="form-check-label">Tersedia untuk diambil mahasiswa</label>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('admin.frs-mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mahasiswaSelect = document.getElementById('mahasiswa_nrp');
            const semesterInput = document.getElementById('semester');

            mahasiswaSelect.addEventListener('change', function() {
                const semester = this.options[this.selectedIndex].getAttribute('data-semester');
                semesterInput.value = semester ?? '';
            });

            mahasiswaSelect.dispatchEvent(new Event('change'));
        });
    </script>
@endsection
