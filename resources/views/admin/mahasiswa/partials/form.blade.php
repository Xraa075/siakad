{{-- File: resources/views/admin/mahasiswa/partials/form.blade.php --}}

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="nrp" class="form-label">NRP <span class="text-danger">*</span></label>
            <input type="text" name="nrp" id="nrp"
                   class="form-control @error('nrp') is-invalid @enderror"
                   value="{{ old('nrp', $mahasiswa->nrp ?? '') }}" required
                   {{ isset($mahasiswa) ? 'readonly' : '' }}
                   title="{{ isset($mahasiswa) ? 'NRP tidak dapat diubah' : '' }}">
            @error('nrp')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="nama" id="nama"
                   class="form-control @error('nama') is-invalid @enderror"
                   value="{{ old('nama', $mahasiswa->nama ?? ($mahasiswa->user->name ?? '') ) }}" required>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    {{-- Email Login tidak diinput manual, akan digenerate --}}
    <div class="col-md-6">
        <div class="mb-3">
            <label for="email_kontak" class="form-label">Email Kontak (Pribadi)</label>
            <input type="email" name="email_kontak" id="email_kontak"
                   class="form-control @error('email_kontak') is-invalid @enderror"
                   value="{{ old('email_kontak', $mahasiswa->email_kontak ?? '') }}">
            @error('email_kontak')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="no_telp" class="form-label">No. Telepon</label>
            <input type="text" name="no_telp" id="no_telp"
                   class="form-control @error('no_telp') is-invalid @enderror"
                   value="{{ old('no_telp', $mahasiswa->no_telp ?? '') }}">
            @error('no_telp')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="password" class="form-label">Password Akun <span class="text-danger">*</span> {{ isset($mahasiswa) ? '(Kosongkan jika tidak ingin diubah)' : '' }}</label>
            <input type="password" name="password" id="password"
                   class="form-control @error('password') is-invalid @enderror"
                   {{ !isset($mahasiswa) ? 'required' : '' }}>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span> {{ isset($mahasiswa) ? '' : '' }}</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="form-control" {{ !isset($mahasiswa) ? 'required' : '' }}>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="kelas_id" class="form-label">Kelas <span class="text-danger">*</span></label>
            <select name="kelas_id" id="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach ($kelasList as $kelas)
                    <option value="{{ $kelas->id }}"
                            {{ old('kelas_id', isset($mahasiswa) ? $mahasiswa->kelas_id : '') == $kelas->id ? 'selected' : '' }}>
                        {{ $kelas->nama_kelas }} ({{ $kelas->jurusan->nama_jurusan ?? 'N/A' }}) - Sem: {{ $kelas->semester }}
                    </option>
                @endforeach
            </select>
            @error('kelas_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="semester" class="form-label">Semester Saat Ini <span class="text-danger">*</span></label>
            <input type="number" name="semester" id="semester"
                   class="form-control @error('semester') is-invalid @enderror"
                   value="{{ old('semester', $mahasiswa->semester ?? '') }}" required min="1" max="14">
            @error('semester')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">{{ $submitButtonText ?? (isset($mahasiswa) ? 'Update Mahasiswa' : 'Simpan Mahasiswa') }}</button>
<a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
