<div class="mb-3">
    <label for="nama_jadwal" class="form-label">Nama Jadwal Kuliah <span class="text-danger">*</span></label>
    <input type="text" name="nama_jadwal" id="nama_jadwal"
           class="form-control @error('nama_jadwal') is-invalid @enderror"
           value="{{ old('nama_jadwal', $jadwalkuliah->nama_jadwal ?? '') }}" required>
    @error('nama_jadwal')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary">{{ $submitButtonText ?? (isset($jadwalkuliah) ? 'Update Jadwal' : 'Simpan Jadwal') }}</button>
<a href="{{ route('admin.jadwalkuliah.index') }}" class="btn btn-secondary">Kembali</a>
