<form id="editTracerForm" onsubmit="submitEditTracer(event)">
    @csrf
    @method('PUT')

    <div class="modal-header">
        <h5 class="modal-title">Edit Tracer Alumni</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body row">
        <div class="col-md-6">
            <x-form.input label="Tanggal Pertama Kerja" name="tanggal_pertama_kerja" type="date" value="{{ $data->tanggal_pertama_kerja }}" required />
            <x-form.input label="Tanggal Mulai Instansi" name="tanggal_mulai_instansi" type="date" value="{{ $data->tanggal_mulai_instansi }}" required />
            <x-form.input label="Jenis Instansi" name="jenis_instansi" value="{{ $data->jenis_instansi }}" required />
            <x-form.input label="Nama Instansi" name="nama_instansi" value="{{ $data->nama_instansi }}" required />
            <x-form.input label="Skala" name="skala" value="{{ $data->skala }}" required />
            <x-form.input label="Lokasi Instansi" name="lokasi_instansi" value="{{ $data->lokasi_instansi }}" required />
            <x-form.input label="Kategori Profesi" name="kategori_profesi" value="{{ $data->kategori_profesi }}" required />
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="profesi_id" class="form-label">Profesi (Opsional)</label>
                <select name="profesi_id" id="profesi_id" class="form-select">
                    <option value="">-- Pilih Profesi --</option>
                    @foreach (\App\Models\ProfesiModel::all() as $profesi)
                        <option value="{{ $profesi->id_profesi }}" {{ $data->profesi_id == $profesi->id_profesi ? 'selected' : '' }}>
                            {{ $profesi->nama_profesi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <x-form.input label="Nama Atasan Langsung" name="nama_atasan_langsung" value="{{ $data->nama_atasan_langsung }}" required />
            <x-form.input label="Jabatan Atasan Langsung" name="jabatan_atasan_langsung" value="{{ $data->jabatan_atasan_langsung }}" required />
            <x-form.input label="No HP Atasan" name="no_hp_atasan" value="{{ $data->no_hp_atasan }}" required />
            <x-form.input label="Email Atasan" name="email_atasan" type="email" value="{{ $data->email_atasan }}" required />
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Simpan Perubahan
        </button>
    </div>
</form>

<script>
function submitEditTracer(e) {
    e.preventDefault();
    let form = $('#editTracerForm');
    $.ajax({
        url: `/alumni/tracer/{{ $data->id }}/update-ajax`,
        type: 'POST',
        data: form.serialize(),
        success: function (res) {
            if (res.status) {
                location.reload();
            } else {
                alert(res.message || 'Gagal menyimpan perubahan');
            }
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let msg = Object.values(errors).map(e => `- ${e[0]}`).join('\n');
                alert('Validasi Gagal:\n' + msg);
            } else {
                alert('Terjadi kesalahan.');
            }
        }
    });
}
</script>
