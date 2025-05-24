<div class="mb-3">
    <label for="nama_matakuliah" class="form-label">Nama Mata Kuliah</label>
    <input type="text" name="nama_matakuliah" id="nama_matakuliah"
        class="form-control @error('nama_matakuliah') is-invalid @enderror"
        value="{{ old('nama_matakuliah', $matakuliah->nama_matakuliah ?? '') }}" required>
    @error('nama_matakuliah')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="dosen_nip" class="form-label">Dosen Penanggung Jawab (PJMK)</label>
    <select name="dosen_nip" id="dosen_nip" class="form-select @error('dosen_nip') is-invalid @enderror" required>
        <option value="">-- Pilih Dosen --</option>
        @foreach ($dosens as $dosen)
            <option value="{{ $dosen->nip }}"
                {{ old('dosen_nip', isset($matakuliah) ? $matakuliah->dosen_nip : '') == $dosen->nip ? 'selected' : '' }}>
                {{ $dosen->nama }} ({{ $dosen->nip }})
            </option>
        @endforeach
    </select>
    @error('dosen_nip')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="jurusan_id" class="form-label">Jurusan</label>
    <select name="jurusan_id" id="jurusan_id" class="form-select @error('jurusan_id') is-invalid @enderror" required>
        <option value="">-- Pilih Jurusan --</option>
        @foreach ($jurusans as $jurusan)
            <option value="{{ $jurusan->id }}"
                {{ old('jurusan_id', isset($matakuliah) ? $matakuliah->jurusan_id : '') == $jurusan->id ? 'selected' : '' }}>
                {{ $jurusan->nama_jurusan }}
            </option>
        @endforeach
    </select>
    @error('jurusan_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="sks" class="form-label">SKS</label>
            <input type="number" name="sks" id="sks" class="form-control @error('sks') is-invalid @enderror"
                value="{{ old('sks', $matakuliah->sks ?? '') }}" required min="1" max="6">
            @error('sks')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="semester" class="form-label">Semester</label>
            <input type="number" name="semester" id="semester"
                class="form-control @error('semester') is-invalid @enderror"
                value="{{ old('semester', $matakuliah->semester ?? '') }}" required min="1" max="8">
            @error('semester')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>


<button type="submit"
    class="btn btn-primary">{{ $submitButtonText ?? (isset($matakuliah) ? 'Update Mata Kuliah' : 'Simpan Mata Kuliah') }}</button>
<a href="{{ route('admin.matakuliah.index') }}" class="btn btn-secondary">Kembali</a>
