<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <label for="mahasiswa_nrp" class="form-label">Mahasiswa <span class="text-danger">*</span></label>
            <select name="mahasiswa_nrp" id="mahasiswa_nrp" class="form-select @error('mahasiswa_nrp') is-invalid @enderror" required {{ isset($nilaimahasiswa) ? 'disabled' : '' }}>
                <option value="">-- Pilih Mahasiswa --</option>
                @foreach ($mahasiswas as $mhs)
                    <option value="{{ $mhs->nrp }}"
                            {{ old('mahasiswa_nrp', $nilaimahasiswa->mahasiswa_nrp ?? '') == $mhs->nrp ? 'selected' : '' }}>
                        {{ $mhs->nama }} ({{ $mhs->nrp }})
                    </option>
                @endforeach
            </select>
            @if(isset($nilaimahasiswa))
                <input type="hidden" name="mahasiswa_nrp" value="{{ $nilaimahasiswa->mahasiswa_nrp }}">
                 <small class="form-text text-muted">Mahasiswa tidak dapat diubah saat edit.</small>
            @endif
            @error('mahasiswa_nrp')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-5">
        <div class="mb-3">
            <label for="matakuliah_id" class="form-label">Mata Kuliah <span class="text-danger">*</span></label>
            <select name="matakuliah_id" id="matakuliah_id" class="form-select @error('matakuliah_id') is-invalid @enderror" required {{ isset($nilaimahasiswa) ? 'disabled' : '' }}>
                <option value="">-- Pilih Mata Kuliah --</option>
                @foreach ($matakuliahs as $mk)
                    <option value="{{ $mk->id }}"
                            {{ old('matakuliah_id', $nilaimahasiswa->matakuliah_id ?? '') == $mk->id ? 'selected' : '' }}>
                        {{ $mk->nama_matakuliah }} (SKS: {{ $mk->sks }})
                    </option>
                @endforeach
            </select>
            @if(isset($nilaimahasiswa))
                <input type="hidden" name="matakuliah_id" value="{{ $nilaimahasiswa->matakuliah_id }}">
                <small class="form-text text-muted">Mata Kuliah tidak dapat diubah saat edit.</small>
            @endif
            @error('matakuliah_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label for="semester" class="form-label">Semester Pengambilan <span class="text-danger">*</span></label>
            <input type="number" name="semester" id="semester"
                   class="form-control @error('semester') is-invalid @enderror"
                   value="{{ old('semester', $nilaimahasiswa->semester ?? '') }}" required min="1">
            @error('semester')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <label for="nilai_uts" class="form-label">Nilai UTS <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="nilai_uts" id="nilai_uts"
                   class="form-control @error('nilai_uts') is-invalid @enderror"
                   value="{{ old('nilai_uts', $nilaimahasiswa->nilai_uts ?? '') }}" required min="0" max="100">
            @error('nilai_uts')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="nilai_uas" class="form-label">Nilai UAS <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="nilai_uas" id="nilai_uas"
                   class="form-control @error('nilai_uas') is-invalid @enderror"
                   value="{{ old('nilai_uas', $nilaimahasiswa->nilai_uas ?? '') }}" required min="0" max="100">
            @error('nilai_uas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="nilai_tugas" class="form-label">Nilai Tugas <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="nilai_tugas" id="nilai_tugas"
                   class="form-control @error('nilai_tugas') is-invalid @enderror"
                   value="{{ old('nilai_tugas', $nilaimahasiswa->nilai_tugas ?? '') }}" required min="0" max="100">
            @error('nilai_tugas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="dosen_nip" class="form-label">Dosen Pengampu <span class="text-danger">*</span></label>
    <select name="dosen_nip" id="dosen_nip" class="form-select @error('dosen_nip') is-invalid @enderror" required>
        <option value="">-- Pilih Dosen --</option>
        @foreach ($dosens as $dosen)
            <option value="{{ $dosen->nip }}"
                    {{ old('dosen_nip', $nilaimahasiswa->dosen_nip ?? (Auth::user()->dosen->nip ?? '') ) == $dosen->nip ? 'selected' : '' }}>
                {{ $dosen->nama }}
            </option>
        @endforeach
    </select>
    @error('dosen_nip')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@if(isset($nilaimahasiswa) && $nilaimahasiswa->nilai_akhir !== null)
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Nilai Akhir (Otomatis)</label>
            <input type="text" class="form-control" value="{{ number_format($nilaimahasiswa->nilai_akhir, 2) }}" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Grade (Otomatis)</label>
            <input type="text" class="form-control" value="{{ $nilaimahasiswa->grade }}" readonly>
        </div>
    </div>
</div>
@endif


<button type="submit" class="btn btn-primary">{{ $submitButtonText ?? (isset($nilaimahasiswa) ? 'Update Nilai' : 'Simpan Nilai') }}</button>
<a href="{{ route('admin.nilaimahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
