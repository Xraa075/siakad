<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
            <input type="text" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror"
                value="{{ old('nip', $dosen->nip ?? '') }}" required {{ isset($dosen) ? 'readonly' : '' }}
                title="{{ isset($dosen) ? 'NIP tidak dapat diubah' : '' }}">
            @error('nip')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                value="{{ old('nama', $dosen->nama ?? ($dosen->user->name ?? '')) }}" required>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="email_kontak" class="form-label">Email Kontak (Pribadi)</label>
            <input type="email" name="email_kontak" id="email_kontak"
                class="form-control @error('email_kontak') is-invalid @enderror"
                value="{{ old('email_kontak', $dosen->email_kontak ?? '') }}">
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
                value="{{ old('no_telp', $dosen->no_telp ?? '') }}">
            @error('no_telp')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="password" class="form-label">Password Akun <span class="text-danger">*</span>
                {{ isset($dosen) ? '(Kosongkan jika tidak ingin diubah)' : '' }}</label>
            <input type="password" name="password" id="password"
                class="form-control @error('password') is-invalid @enderror" {{ !isset($dosen) ? 'required' : '' }}>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span>
                {{ isset($dosen) ? '' : '' }}</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                {{ !isset($dosen) ? 'required' : '' }}>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="jurusan_id" class="form-label">Jurusan <span class="text-danger">*</span></label>
            <select name="jurusan_id" id="jurusan_id" class="form-select @error('jurusan_id') is-invalid @enderror"
                required>
                <option value="">-- Pilih Jurusan --</option>
                @foreach ($jurusans as $jurusan)
                    <option value="{{ $jurusan->id }}"
                        {{ old('jurusan_id', isset($dosen) ? $dosen->jurusan_id : '') == $jurusan->id ? 'selected' : '' }}>
                        {{ $jurusan->nama_jurusan }}
                    </option>
                @endforeach
            </select>
            @error('jurusan_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Status Dosen Wali</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="isDosenWali" id="isDosenWali_ya" value="1"
                        {{ old('isDosenWali', isset($dosen) ? $dosen->isDosenWali : 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="isDosenWali_ya">Ya</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="isDosenWali" id="isDosenWali_tidak"
                        value="0"
                        {{ old('isDosenWali', isset($dosen) ? $dosen->isDosenWali : 0) == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="isDosenWali_tidak">Tidak</label>
                </div>
            </div>
            @error('isDosenWali')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<button type="submit"
    class="btn btn-primary">{{ $submitButtonText ?? (isset($dosen) ? 'Update Dosen' : 'Simpan Dosen') }}</button>
<a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary">Kembali</a>
