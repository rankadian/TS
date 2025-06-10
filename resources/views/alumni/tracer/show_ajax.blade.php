<div class="modal-header">
    <h5 class="modal-title">Detail Tracer Study</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <p><strong>Program Studi:</strong><br>{{ $data->program_studi }}</p>
            <p><strong>Tahun Lulus:</strong><br>{{ $data->tahun_lulus }}</p>
            <p><strong>Nama:</strong><br>{{ $data->nama }}</p>
            <p><strong>No HP:</strong><br>{{ $data->no_hp }}</p>
            <p><strong>Email:</strong><br>{{ $data->email }}</p>
            <p><strong>Tanggal Pertama Kerja:</strong><br>{{ $data->tgl_pertama_kerja }}</p>
            <p><strong>Tanggal Mulai Kerja Saat Ini:</strong><br>{{ $data->tgl_mulai_instansi }}</p>
            <p><strong>Jenis Instansi:</strong><br>{{ $data->jenis_instansi }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>Nama Instansi:</strong><br>{{ $data->nama_instansi }}</p>
            <p><strong>Skala:</strong><br>{{ $data->skala }}</p>
            <p><strong>Lokasi Instansi:</strong><br>{{ $data->lokasi_instansi }}</p>
            <p><strong>Kategori Profesi:</strong><br>{{ $data->kategori_profesi }}</p>
            <p><strong>Profesi:</strong><br>{{ $data->profesi }}</p>
            <p><strong>Nama Atasan:</strong><br>{{ $data->nama_atasan }}</p>
            <p><strong>Jabatan Atasan:</strong><br>{{ $data->jabatan_atasan }}</p>
            <p><strong>No HP Atasan:</strong><br>{{ $data->no_hp_atasan }}</p>
            <p><strong>Email Atasan:</strong><br>{{ $data->email_atasan }}</p>
        </div>
    </div>
</div>
