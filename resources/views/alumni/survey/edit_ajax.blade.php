<form id="editTracerForm" onsubmit="submitEditTracer(event)">
    @csrf
    @method('PUT')

    <div class="modal-header">
        <h5 class="modal-title">Edit Alumni Tracer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body row">
        <div class="col-md-6">
            <x-form.input label="First Work Date" name="date_first_work" type="date" value="{{ $data->date_first_work }}" required />
            <x-form.input label="Agency Start Date" name="agency_start_date" type="date" value="{{ $data->agency_start_date }}" required />
            <x-form.input label="Type of Agency" name="type_agency" value="{{ $data->type_agency }}" required />
            <x-form.input label="Agency Name" name="agency_name" value="{{ $data->agency_name }}" required />
            <x-form.input label="Scale" name="scale" value="{{ $data->scale }}" required />
            <x-form.input label="Agency Location" name="location_agency" value="{{ $data->location_agency }}" required />

            <div class="mb-3">
                <label class="form-label">Profession Category <span class="text-danger">*</span></label>
                <select class="form-select" name="category_profession" id="kategoriProfesi" required>
                    <option value="" disabled hidden>-- Select Profession Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category_name }}"
                            {{ $data->category_profession === $category->category_name ? 'selected' : '' }}>
                            {{ ucfirst($category->category_name) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Profession <span class="text-danger">*</span></label>
                <select class="form-select select2-profesi" name="profesi_id" id="profesiSelect" required>
                    <option value="">Choose a Profession</option>
                    @foreach($professions as $profession)
                        <option value="{{ $profession->id_profesi }}"
                            data-category="{{ $profession->category_id }}"
                            {{ $data->profesi_id == $profession->id_profesi ? 'selected' : '' }}>
                            {{ $profession->nama_profesi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <x-form.input label="Direct Supervisor's Name" name="name_direct_superior" value="{{ $data->name_direct_superior }}" required />
            <x-form.input label="Direct Supervisor's Position" name="position_direct_superior" value="{{ $data->position_direct_superior }}" required />
            <x-form.input label="Supervisor's Phone Number" name="no_hp_superior" value="{{ $data->no_hp_superior }}" required />
            <x-form.input label="Supervisor's Email" name="email_superior" type="email" value="{{ $data->email_superior }}" required />
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Save Changes
        </button>
    </div>
</form>

<script>
    // Initialize Select2
    $('#kategoriProfesi').select2({
        placeholder: "Choose the Profession Category",
        allowClear: true
    });

    $('.select2-profesi').select2({
        placeholder: "Choose a Profession",
        allowClear: true
    });

    const originalProfesiOptions = $('#profesiSelect').html();

    $('#kategoriProfesi').on('change', function () {
        const selectedCategory = $(this).val();
        const profesiSelect = $('#profesiSelect');
        profesiSelect.html(originalProfesiOptions);

        if (!selectedCategory) {
            profesiSelect.val(null).trigger('change');
            return;
        }

        const categoryId = selectedCategory === 'infokom' ? 1 : 2;

        profesiSelect.find('option').each(function () {
            if ($(this).data('category') != categoryId && $(this).val() !== '') {
                $(this).remove();
            }
        });

        profesiSelect.trigger('change.select2');
    }).trigger('change');

    function submitEditTracer(e) {
        e.preventDefault();
        const form = $('#editTracerForm');
        const url = `/alumni/tracer/update-ajax/{{ $data->id }}`;
        const formData = new FormData(form[0]);
 
         formData.append('_method', 'PUT');

    $.ajax({
        url: url,
        type: 'POST', // Tetap POST karena kita override pakai _method
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            success: function (res) {
                if (res.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Update Berhasil',
                        text: res.message
                    }).then(() => {
                        $('#editModal').modal('hide');
                        $('#editModalContent').html('');
                        $('#dataTracerTable').load(window.location.href + ' #dataTracerTable > *');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message || 'Gagal menyimpan perubahan'
                    });
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let msg = Object.values(errors).map(e => `- ${e[0]}`).join('\n');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validasi Gagal',
                        text: msg
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan pada server.'
                    });
                }
            }
        });
    }
</script>
