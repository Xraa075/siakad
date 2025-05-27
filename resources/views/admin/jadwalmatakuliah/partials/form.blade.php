<input type="hidden" name="jadwal_kuliah_id" value="{{ $jadwalKuliahContext->id }}">

<div class="mb-3">
    <label class="form-label">Untuk Jadwal Kuliah Umum</label>
    <input type="text" class="form-control" value="{{ $jadwalKuliahContext->nama_jadwal }}" readonly>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="matakuliah_id" class="form-label">Mata Kuliah <span class="text-danger">*</span></label>
            <select name="matakuliah_id" id="matakuliah_id"
                class="form-select @error('matakuliah_id') is-invalid @enderror" required>
                <option value="">-- Pilih Mata Kuliah --</option>
                @foreach ($matakuliahs as $mk)
                    <option value="{{ $mk->id }}" data-semester="{{ $mk->semester }}"
                        data-dosen-nip="{{ $mk->dosen_nip }}"
                        {{ old('matakuliah_id', $jadwalmatakuliah->matakuliah_id ?? '') == $mk->id ? 'selected' : '' }}>
                        {{ $mk->nama_matakuliah }} (Semester {{ $mk->semester }})
                    </option>
                @endforeach
            </select>
            @error('matakuliah_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Semester Pelaksanaan</label>
            <input type="number" id="semester" class="form-control"
                value="{{ old('semester', $jadwalmatakuliah->semester ?? '') }}" readonly disabled>
            <input type="hidden" name="semester" id="semester_hidden"
                value="{{ old('semester', $jadwalmatakuliah->semester ?? '') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Dosen Pengajar 1 (Otomatis dari Mata Kuliah)</label>
            <input type="text" id="dosen_nama" class="form-control"
                value="{{ $jadwalmatakuliah->matakuliah->dosen->nama ?? '-' }}" readonly>
            <input type="hidden" name="dosen_nip" id="dosen_nip"
                value="{{ old('dosen_nip', $jadwalmatakuliah->matakuliah->dosen_nip ?? '') }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="dosen_pengajar2_nip" class="form-label">Dosen Pengajar 2 (Opsional)</label>
            <select name="dosen_pengajar2_nip" id="dosen_pengajar2_nip"
                class="form-select @error('dosen_pengajar2_nip') is-invalid @enderror">
                <option value="">-- Tidak Ada / Pilih Dosen --</option>
                @foreach ($dosens as $dosen)
                    <option value="{{ $dosen->nip }}"
                        {{ old('dosen_pengajar2_nip', $jadwalmatakuliah->dosen_pengajar2_nip ?? '') == $dosen->nip ? 'selected' : '' }}>
                        {{ $dosen->nama }}
                    </option>
                @endforeach
            </select>
            @error('dosen_pengajar2_nip')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="mb-3">
            <label for="hari" class="form-label">Hari <span class="text-danger">*</span></label>
            <select name="hari" id="hari" class="form-select @error('hari') is-invalid @enderror" required>
                <option value="">-- Pilih Hari --</option>
                @foreach ($hariOptions as $hari)
                    <option value="{{ $hari }}"
                        {{ old('hari', $jadwalmatakuliah->hari ?? '') == $hari ? 'selected' : '' }}>
                        {{ $hari }}</option>
                @endforeach
            </select>
            @error('hari')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="mb-3">
            <label for="jam_mulai" class="form-label">Jam Mulai <span class="text-danger">*</span></label>
            <input type="time" name="jam_mulai" id="jam_mulai"
                class="form-control @error('jam_mulai') is-invalid @enderror"
                value="{{ old('jam_mulai', $jadwalmatakuliah->jam_mulai ?? '') }}" required>
            @error('jam_mulai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="mb-3">
            <label for="jam_selesai" class="form-label">Jam Selesai <span class="text-danger">*</span></label>
            <input type="time" name="jam_selesai" id="jam_selesai"
                class="form-control @error('jam_selesai') is-invalid @enderror"
                value="{{ old('jam_selesai', $jadwalmatakuliah->jam_selesai ?? '') }}" required>
            @error('jam_selesai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="mb-3">
            <label for="ruangan" class="form-label">Ruangan <span class="text-danger">*</span></label>
            <input type="text" name="ruangan" id="ruangan"
                class="form-control @error('ruangan') is-invalid @enderror"
                value="{{ old('ruangan', $jadwalmatakuliah->ruangan ?? '') }}" required>
            @error('ruangan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<button type="submit"
    class="btn btn-primary">{{ $submitButtonText ?? (isset($jadwalmatakuliah) ? 'Update Detail Jadwal' : 'Simpan Detail Jadwal') }}</button>
<a href="{{ route('admin.jadwalmatakuliah.index', ['jadwal_kuliah_id' => $jadwalKuliahContext->id]) }}"
    class="btn btn-secondary">Kembali</a>

{{-- JavaScript untuk auto-set semester dan dosen_nip --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectMataKuliah = document.getElementById('matakuliah_id');
        const semesterInput = document.getElementById('semester');
        const semesterHidden = document.getElementById('semester_hidden');
        const dosenNipInput = document.getElementById('dosen_nip');
        const dosenNamaInput = document.getElementById('dosen_nama');

        const matakuliahMap = @json($matakuliahs->keyBy('id'));

        function updateFromMataKuliah(id) {
            const selected = matakuliahMap[id];
            if (selected) {
                semesterInput.value = selected.semester;
                semesterHidden.value = selected.semester;
                dosenNipInput.value = selected.dosen_nip;

                const dosen = @json($dosens->keyBy('nip'));
                dosenNamaInput.value = dosen[selected.dosen_nip]?.nama || '-';
            }
        }

        selectMataKuliah.addEventListener('change', function() {
            updateFromMataKuliah(this.value);
        });

        if (selectMataKuliah.value) {
            updateFromMataKuliah(selectMataKuliah.value);
        }
    });
</script>
