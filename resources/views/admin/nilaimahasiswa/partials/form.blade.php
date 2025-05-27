<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="matakuliah_id_select" class="form-label">Mata Kuliah (sesuai Jadwal Kelas Mahasiswa) <span
                    class="text-danger">*</span></label>
            <select name="matakuliah_id" id="matakuliah_id_select"
                class="form-select @error('matakuliah_id') is-invalid @enderror" required
                {{ isset($nilaimahasiswa) ? 'disabled' : '' }}>
                <option value="">-- Pilih Mata Kuliah --</option>
                @foreach ($matakuliahOptions as $mk)
                    @if ($mk)
                        <option value="{{ $mk->id }}" data-dosenpjmk_nip="{{ $mk->dosen_nip }}"
                            data-namadosenpjmk="{{ $mk->dosenPJMK->nama ?? 'N/A' }}"
                            {{ old('matakuliah_id', $nilaimahasiswa->matakuliah_id ?? '') == $mk->id ? 'selected' : '' }}>
                            {{ $mk->nama_matakuliah }} (SKS: {{ $mk->sks }})
                        </option>
                    @endif
                @endforeach
            </select>
            @if (isset($nilaimahasiswa))
                <input type="hidden" name="matakuliah_id" value="{{ $nilaimahasiswa->matakuliah_id }}">
                <small class="form-text text-muted">Mata Kuliah tidak dapat diubah saat edit.</small>
            @endif
            @error('matakuliah_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="semester_display" class="form-label">Semester Pengambilan (Otomatis)</label>
            <input type="text" id="semester_display" class="form-control"
                value="{{ $selectedMahasiswa->semester ?? ($nilaimahasiswa->semester ?? '') }}" readonly>
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="dosen_display" class="form-label">Dosen PJMK (Otomatis dari Mata Kuliah)</label>
    <input type="text" id="dosen_display" class="form-control"
        value="{{ $nilaimahasiswa->dosen->nama ?? ($nilaimahasiswa->matakuliah->dosenPJMK->nama ?? '') }}" readonly
        placeholder="Akan terisi setelah memilih mata kuliah">
</div>

<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <label for="nilai_uts" class="form-label">Nilai UTS <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="nilai_uts" id="nilai_uts"
                class="form-control @error('nilai_uts') is-invalid @enderror"
                value="{{ old('nilai_uts', $nilaimahasiswa->nilai_uts ?? '') }}" required min="0"
                max="100">
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
                value="{{ old('nilai_uas', $nilaimahasiswa->nilai_uas ?? '') }}" required min="0"
                max="100">
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
                value="{{ old('nilai_tugas', $nilaimahasiswa->nilai_tugas ?? '') }}" required min="0"
                max="100">
            @error('nilai_tugas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

@if (isset($nilaimahasiswa) && $nilaimahasiswa->nilai_akhir !== null)
@endif

<button type="submit"
    class="btn btn-primary">{{ $submitButtonText ?? (isset($nilaimahasiswa) ? 'Update Nilai' : 'Simpan Nilai') }}</button>
<a href="{{ route('admin.nilaimahasiswa.index') }}" class="btn btn-secondary">Kembali</a>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mahasiswaSelect = document.getElementById('mahasiswa_nrp_select_filter');
            const matakuliahSelectForLogic = document.getElementById('matakuliah_id_select');
            const semesterDisplay = document.getElementById('semester_display');
            const dosenDisplay = document.getElementById('dosen_display');

            function updateDosenPjmkDisplay() {
                if (matakuliahSelectForLogic && matakuliahSelectForLogic.value !== "") {
                    const selectedOption = matakuliahSelectForLogic.options[matakuliahSelectForLogic.selectedIndex];
                    dosenDisplay.value = selectedOption.dataset.namadosenpjmk || 'N/A';
                } else {
                    dosenDisplay.value = '{{ $nilaimahasiswa->dosen->nama ?? '' }}';
                }
            }

            if (matakuliahSelectForLogic) {
                matakuliahSelectForLogic.addEventListener('change', updateDosenPjmkDisplay);
                if (matakuliahSelectForLogic.value) {
                    updateDosenPjmkDisplay();
                }
            }
        });
    </script>
@endpush
