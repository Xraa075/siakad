<input type="hidden" name="departemen_id" value="{{ $departemenDipilih->id ?? $jurusan->departemen_id }}">

<div class="mb-3">
    <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
    <input type="text" name="nama_jurusan" id="nama_jurusan"
        class="form-control @error('nama_jurusan') is-invalid @enderror"
        value="{{ old('nama_jurusan', $jurusan->nama_jurusan ?? '') }}" required>
    @error('nama_jurusan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit"
    class="btn btn-primary">{{ $submitButtonText ?? (isset($jurusan) ? 'Update Jurusan' : 'Simpan Jurusan') }}</button>
<a href="{{ route('admin.jurusan.index', ['departemen_id' => $departemenDipilih->id ?? $jurusan->departemen_id]) }}"
    class="btn btn-secondary">Kembali</a>
