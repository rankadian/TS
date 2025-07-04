@extends('layouts.template')

@section('content')
    <div class="container-fluid px-4 py-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center">
        <h4 class="mb-0">
            <i class="fas fa-graduation-cap me-2"></i>
            @if ($data) Data Tracer Study @else Form Tracer Study @endif
        </h4>
    </div>
    @if($data)
        <div>
            <button class="btn btn-light btn-sm" onclick="editTracer({{ $data->id }})">
                <i class="fas fa-edit me-1"></i> Edit
            </button>
        </div>
    @endif
</div>

            <div class="card-body p-4">
                @if ($data)
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        Your tracer study data has been submitted. You can edit the data if needed.
                    </div>

                    <div class="table-responsive-lg">
    <table class="table table-bordered table-hover mb-0">
        <tbody>
            <tr class="table-primary">
                <th colspan="2" class="text-center">ALUMNUS DATA</th>
            </tr>
            <tr>
                <th width="30%">Study Program</th>
                <td>{{ $data->alumni->program_study ?? '-' }}</td>
            </tr>
            <tr>
                <th>Year Graduated</th>
                <td>{{ $data->alumni->year_graduated ?? '-' }}</td>
            </tr>
            <tr>
                <th>Name (NIM)</th>
                <td>{{ $data->alumni->name ?? '-' }} ({{ $data->alumni->nim ?? '-' }})</td>
            </tr>
            <tr>
                <th>No HP</th>
                <td>{{ $data->alumni->no_hp ?? '-' }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $data->alumni->email ?? '-' }}</td>
            </tr>
      


                                <tr class="table-primary">
                                    <th colspan="2" class="text-center">DATA PEKERJAAN</th>
                                </tr>
                                <tr>
                                    <th>First Date of Employment</th>
                                    <td>{{ $data->date_first_work }}</td>
                                </tr>
                                <tr>
                                    <th>Start Date at Agency</th>
                                    <td>{{ $data->agency_start_date }}</td>
                                </tr>
                                <tr>
                                    <th>Type of Agency</th>
                                    <td>{{ $data->type_agency }}</td>
                                </tr>
                                <tr>
                                    <th>Agency Name</th>
                                    <td>{{ $data->agency_name }}</td>
                                </tr>
                                <tr>
                                    <th>Agency Scale</th>
                                    <td>{{ $data->scale }}</td>
                                </tr>
                                <tr>
                                    <th>Agency Location</th>
                                    <td>{{ $data->location_agency }}</td>
                                </tr>
                                <tr>
                                    <th>Profession Category</th>
                                    <td>{{ $data->category_profession }}</td>
                                </tr>
                                <tr>
                                    <th>Profession</th>
                                    <td>{{ $data->profesi->nama_profesi ?? '-' }}</td>
                                </tr>

                                <tr class="table-primary">
                                    <th colspan="2" class="text-center">DATA ATASAN</th>
                                </tr>
                                <tr>
                                    <th>Name of Supervisor</th>
                                    <td>{{ $data->name_direct_superior }}</td>
                                </tr>
                                <tr>
                                    <th>Supervisor Position</th>
                                    <td>{{ $data->position_direct_superior }}</td>
                                </tr>
                                <tr>
                                    <th>Supervisor cell phone number</th>
                                    <td>{{ $data->no_hp_superior }}</td>
                                </tr>
                                <tr>
                                    <th>Supervisor Email</th>
                                    <td>{{ $data->email_superior }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <form id="tracerForm" method="POST" action="{{ route('alumni.tracer.store_ajax') }}">
                        @csrf

                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="section-box mb-4 p-3 bg-light rounded">
                                    <h5 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-user-graduate me-2"></i> Data Alumni
                                    </h5>

                                    <div class="mb-3">
                                        <label class="form-label">NIM <span class="text-danger">*</span></label>
                                        <select class="form-select select2-nim" name="nim" id="nimSelect" required>
                                            <option value="">Choose Your NIM or Look for it</option>
                                            @foreach($alumniList as $alumni)
                                                <option value="{{ $alumni->nim }}" data-nama="{{ $alumni->name }}"
                                                    data-program-studi="{{ $alumni->program_study }}"
                                                    data-year_graduated="{{ $alumni->year_graduated }}"
                                                    data-no_hp="{{ $alumni->no_hp }}" data-email="{{ $alumni->email }}">
                                                    {{ $alumni->nim }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" id="namaInput" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Study Program</label>
                                        <input type="text" class="form-control" name="program_study" id="programStudiInput"
                                            readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Year Graduated</label>
                                        <input type="text" class="form-control" name="year_graduated" id="tahunLulusInput"
                                            readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">No HP<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="no_hp" id="noHpInput" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" id="emailInput" required>
                                    </div>
                                </div>

                                <div class="section-box mb-4 p-3 bg-light rounded">
                                    <h5 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-building me-2"></i> Work Details
                                    </h5>

                                    <div class="mb-3">
                                        <label class="form-label">Agency Location<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="location_agency" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Profession Category<span class="text-danger">*</span></label>
                                        <select class="form-select" name="category_profession" id="kategoriProfesi" required>
    <option value="" disabled selected hidden>-- Select Profession Category --</option>
    @foreach($categories as $category)
        <option value="{{ $category->category_name }}">{{ ucfirst($category->category_name) }}</option>
    @endforeach
</select>

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Profession <span class="text-danger">*</span></label>
                                        <select class="form-select select2-profesi" name="profesi_id" id="profesiSelect"
                                            required>
                                            <option value="">Choose a Profession</option>
                                            @foreach($professions as $profession)
                                                <option value="{{ $profession->id_profesi }}"
                                                    data-category="{{ $profession->category_id }}">
                                                    {{ $profession->nama_profesi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="section-box mb-4 p-3 bg-light rounded">
                                    <h5 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-briefcase me-2"></i> Job Data
                                    </h5>

                                    <div class="mb-3">
                                        <label class="form-label">First Date of Employment<span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="date_first_work" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Start Date at Agency<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="agency_start_date" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Type of Agency<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="type_agency" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Agency Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="agency_name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Agency Scale<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="scale" required>
                                    </div>
                                </div>

                                <div class="section-box mb-4 p-3 bg-light rounded">
                                    <h5 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-user-tie me-2"></i> Supervisor Data
                                    </h5>

                                    <div class="mb-3">
                                        <label class="form-label">Name of Immediate Superior<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name_direct_superior" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Supervisor Position<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="position_direct_superior" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Supervisor cell phone number<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="no_hp_superior" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Supervisor Email<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email_superior" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger mt-4">
                                <h6 class="fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Terdapat kesalahan:</h6>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-paper-plane me-2"></i> Send Data
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="editModalContent">
                <!-- Content loaded via AJAX -->
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <style>
        .container-fluid {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .card {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            border-radius: 0.5rem 0.5rem 0 0 !important;
            padding: 1rem 1.5rem;
        }

        .section-box {
            border-left: 4px solid #1890ff;
            background-color: #f8f9fa;
        }

        .table th {
            width: 35%;
            background-color: #f8f9fa;
        }

        .table tr:not(.table-primary) th {
            font-weight: normal;
        }

        .form-control,
        .form-select {
            border-radius: 0.375rem;
            border: 1px solid #ced4da;
        }

        .form-control[readonly] {
            background-color: #f8f9fa;
            opacity: 1;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .alert {
            border-radius: 0.375rem;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-light {
            background-color: #f8f9fa;
            border-color: #f8f9fa;
        }

        .select2-container {
    width: 100% !important;
    display: block;
}

.select2-container--default .select2-selection--single {
    width: 100%;
    height: 38px;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    padding: 0.375rem 0.75rem;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
    padding-left: 0;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
    right: 8px;
}

.select2-dropdown {
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

/* Ensure all form controls have consistent spacing */
.form-select, .select2-container--default .select2-selection--single {
    margin-top: 0.25rem;
}

.card-header {
    position: relative;
}

.card-header .btn {
    position: absolute;
    top: 50%;
    right: 1rem;
    transform: translateY(-50%);
}

    </style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        // =================== Select2: NIM ===================
        $('.select2-nim').select2({
            placeholder: "Select NIM or Type to Search",
            allowClear: true,
            templateResult: formatNimOption,
            templateSelection: formatNimSelection
        });

        function formatNimOption(option) {
            if (!option.id) return option.text;
            return $('<span>').text(option.text.split(' - ')[0]);
        }

        function formatNimSelection(option) {
            if (!option.id) return option.text;
            return $('<span>').text(option.text.split(' - ')[0]);
        }

        $('#nimSelect').on('change', function () {
            const selectedOption = $(this).find('option:selected');
            $('#namaInput').val(selectedOption.data('nama'));
            $('#programStudiInput').val(selectedOption.data('program-studi'));
            $('#tahunLulusInput').val(selectedOption.data('year_graduated'));
            $('#noHpInput').val(selectedOption.data('no_hp'));
            $('#emailInput').val(selectedOption.data('email'));
        });

        // =================== Select2: Kategori Profesi ===================
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

        // =================== Form Submit via AJAX ===================
        $('#tracerForm').on('submit', function (e) {
            e.preventDefault();

            const form = $(this);
            const url = form.attr('action');
            const formData = new FormData(this);

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message || 'Terjadi kesalahan'
                        });
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let pesan = '';
                        for (let field in errors) {
                            pesan += errors[field].join(', ') + '\n';
                        }
                        Swal.fire({
                            icon: 'warning',
                            title: 'Validasi Gagal',
                            text: pesan
                        });
                    } else if (xhr.status === 403) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Sudah Pernah Submit',
                            text: xhr.responseJSON.message
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal mengirim data. Coba lagi.'
                        });
                    }
                }
            });
        });

        // =================== Modal Edit ===================
        window.editTracer = function (id) {
            $.get(`/alumni/tracer/edit-ajax/${id}`, function (res) {
                $('#editModalContent').html(res);
                $('#editModal').modal('show');

                $('.select2-nim').select2({
                    placeholder: "Select NIM",
                    allowClear: true,
                    templateResult: formatNimOption,
                    templateSelection: formatNimSelection
                });

                $('.select2-profesi').select2();

                $('#kategoriProfesi').on('change', function () {
                    const selectedCategory = $(this).val();
                    const profesiSelect = $('#profesiSelect');

                    profesiSelect.val(null).trigger('change');
                    profesiSelect.find('option').prop('disabled', true).hide();

                    if (selectedCategory === 'infokom') {
                        profesiSelect.find('option[data-category="1"]').prop('disabled', false).show();
                    } else if (selectedCategory === 'non-infokom') {
                        profesiSelect.find('option[data-category="2"]').prop('disabled', false).show();
                    } else {
                        profesiSelect.find('option').prop('disabled', false).show();
                    }

                    profesiSelect.trigger('change.select2');
                }).trigger('change');
            });
        }
    });
</script>
@endpush
