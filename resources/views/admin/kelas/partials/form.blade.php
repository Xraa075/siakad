@csrf
<input type="hidden" name="jurusan_id" value="{{ $jurusanContext->id }}">

<div class="mb-3">
    <label for="nama_kelas" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
    <input type="text" name="nama_kelas" id="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror"
        value="{{ old('nama_kelas', $kela->nama_kelas ?? '') }}" required>
    @error('nama_kelas')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Jurusan Induk</label>
    <input type="text" class="form-control"
        value="{{ $jurusanContext->nama_jurusan }} ({{ $jurusanContext->departemen->nama_departemen }})" readonly>
</div>

<div class="mb-3">
    <label for="semester" class="form-label">Semester Kelas <span class="text-danger">*</span></label>
    <input type="number" name="semester" id="semester" class="form-control @error('semester') is-invalid @enderror"
        value="{{ old('semester', $kela->semester ?? '') }}" required min="1">
    @error('semester')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="dosen_nip" class="form-label">Dosen Wali <span class="text-danger">*</span></label>
    <select name="dosen_nip" id="dosen_nip" class="form-select @error('dosen_nip') is-invalid @enderror" required>
        <option value="">-- Pilih Dosen Wali --</option>
        @foreach ($dosens as $dosen)
            <option value="{{ $dosen->nip }}"
                {{ old('dosen_nip', isset($kela) ? $kela->dosen_nip : '') == $dosen->nip ? 'selected' : '' }}>
                {{ $dosen->nama }} ({{ $dosen->nip }})
            </option>
        @endforeach
    </select>
    @error('dosen_nip')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="jadwal_kuliah_id" class="form-label">Jadwal Kuliah Umum <span class="text-danger">*</span></label>
    <select name="jadwal_kuliah_id" id="jadwal_kuliah_id"
        class="form-select @error('jadwal_kuliah_id') is-invalid @enderror" required>
        <option value="">-- Pilih Jadwal Kuliah --</option>
        @foreach ($jadwalKuliahs as $jadwal)
            <option value="{{ $jadwal->id }}"
                {{ old('jadwal_kuliah_id', isset($kela) ? $kela->jadwal_kuliah_id : '') == $jadwal->id ? 'selected' : '' }}>
                {{ $jadwal->nama_jadwal }}
            </option>
        @endforeach
    </select>
    @error('jadwal_kuliah_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit"
    class="btn btn-primary">{{ $submitButtonText ?? (isset($kela) ? 'Update Kelas' : 'Simpan Kelas') }}</button>
<a href="{{ route('admin.kelas.index', ['jurusan_id' => $jurusanContext->id]) }}" class="btn btn-secondary">Kembali</a>
