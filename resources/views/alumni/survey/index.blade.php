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
                    <i class="fas fa-clipboard-check me-2"></i>
                    @if ($survey) Survey Data @else Survey Form @endif
                </h4>
            </div>
            @if($survey)
                <div>
                    <button class="btn btn-light btn-sm" onclick="editSurvey({{ $survey->id }})">
                        <i class="fas fa-edit me-1"></i> Edit
                    </button>
                </div>
            @endif
        </div>

        <div class="card-body p-4">
            @if ($survey)
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>
                    Your survey data has been submitted. You can edit the data if needed.
                </div>

                <div class="table-responsive-lg">
                    <table class="table table-bordered table-hover mb-0">
                        <tbody>
                            <tr class="table-primary">
                                <th colspan="2" class="text-center">ALUMNI DATA</th>
                            </tr>
                            <tr>
                                <th width="30%">Name (NIM)</th>
                                <td>{{ $survey->alumni->name ?? '-' }} ({{ $survey->alumni->nim ?? '-' }})</td>
                            </tr>
                            <tr>
                                <th>Study Program</th>
                                <td>{{ $survey->alumni->program_study ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Year Graduated</th>
                                <td>{{ $survey->alumni->year_graduated ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $survey->alumni->email ?? '-' }}</td>
                            </tr>

                            <tr class="table-primary">
                                <th colspan="2" class="text-center">EMPLOYMENT DATA</th>
                            </tr>
                            <tr>
                                <th>Agency Name</th>
                                <td>{{ $survey->tracer->agency_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Profession</th>
                                <td>{{ $survey->tracer->profesi->nama_profesi ?? '-' }}</td>
                            </tr>

                            <tr class="table-primary">
                                <th colspan="2" class="text-center">SURVEY RESPONSES</th>
                            </tr>
                            <tr>
                                <th>Teamwork</th>
                                <td>{{ $survey->teamwork ? $survey->teamwork.' - '.getRatingText($survey->teamwork) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>IT Skills</th>
                                <td>{{ $survey->it_skills ? $survey->it_skills.' - '.getRatingText($survey->it_skills) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Foreign Language</th>
                                <td>{{ $survey->foreign_language ? $survey->foreign_language.' - '.getRatingText($survey->foreign_language) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Communication</th>
                                <td>{{ $survey->communication ? $survey->communication.' - '.getRatingText($survey->communication) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Self Development</th>
                                <td>{{ $survey->self_development ? $survey->self_development.' - '.getRatingText($survey->self_development) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Leadership</th>
                                <td>{{ $survey->leadership ? $survey->leadership.' - '.getRatingText($survey->leadership) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Work Ethic</th>
                                <td>{{ $survey->work_ethic ? $survey->work_ethic.' - '.getRatingText($survey->work_ethic) : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Unmet Competencies</th>
                                <td>{{ $survey->unmet_competencies ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Curriculum Suggestions</th>
                                <td>{{ $survey->curriculum_suggestions ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <form id="surveyForm" method="POST" action="{{ route('alumni.survey.store_ajax') }}">
                    @csrf

                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="section-box mb-4 p-3 bg-light rounded">
                                <h5 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-user-graduate me-2"></i> Alumni Data
                                </h5>

                                <div class="mb-3">
                                    <label class="form-label">NIM <span class="text-danger">*</span></label>
                                    <select class="form-select select2-nim" name="nim" id="nimSelect" required>
                                        <option value="">Choose Your NIM or Look for it</option>
                                        @foreach($alumniList as $alumni)
                                            <option value="{{ $alumni->nim }}" 
                                                data-name="{{ $alumni->name }}"
                                                data-program-studi="{{ $alumni->program_study }}"
                                                data-year_graduated="{{ $alumni->year_graduated }}"
                                                data-email="{{ $alumni->email }}">
                                                {{ $alumni->nim }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" id="namaInput" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Study Program</label>
                                    <input type="text" class="form-control" id="programStudiInput" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Year Graduated</label>
                                    <input type="text" class="form-control" id="tahunLulusInput" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" id="emailInput" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="section-box mb-4 p-3 bg-light rounded">
                                <h5 class="fw-bold text-primary mb-3">
                                    <i class="fas fa-briefcase me-2"></i> Employment Data
                                </h5>

                                <div class="mb-3">
                                    <label class="form-label">Agency Name</label>
                                    <input type="text" class="form-control" id="agencyNameInput" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Profession</label>
                                    <input type="text" class="form-control" id="professionInput" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-box mb-4 p-3 bg-light rounded">
                        <h5 class="fw-bold text-primary mb-3">
                            <i class="fas fa-star me-2"></i> Competency Assessment
                        </h5>
                        <p class="text-muted">Please rate the following competencies (1 = Poor, 4 = Excellent):</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Teamwork <span class="text-danger">*</span></label>
                                <select class="form-select" name="teamwork" required>
                                    <option value="">Select Rating</option>
                                    <option value="1">1 - Poor</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="3">3 - Good</option>
                                    <option value="4">4 - Excellent</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">IT Skills <span class="text-danger">*</span></label>
                                <select class="form-select" name="it_skills" required>
                                    <option value="">Select Rating</option>
                                    <option value="1">1 - Poor</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="3">3 - Good</option>
                                    <option value="4">4 - Excellent</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Foreign Language <span class="text-danger">*</span></label>
                                <select class="form-select" name="foreign_language" required>
                                    <option value="">Select Rating</option>
                                    <option value="1">1 - Poor</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="3">3 - Good</option>
                                    <option value="4">4 - Excellent</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Communication <span class="text-danger">*</span></label>
                                <select class="form-select" name="communication" required>
                                    <option value="">Select Rating</option>
                                    <option value="1">1 - Poor</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="3">3 - Good</option>
                                    <option value="4">4 - Excellent</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Self Development <span class="text-danger">*</span></label>
                                <select class="form-select" name="self_development" required>
                                    <option value="">Select Rating</option>
                                    <option value="1">1 - Poor</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="3">3 - Good</option>
                                    <option value="4">4 - Excellent</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Leadership <span class="text-danger">*</span></label>
                                <select class="form-select" name="leadership" required>
                                    <option value="">Select Rating</option>
                                    <option value="1">1 - Poor</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="3">3 - Good</option>
                                    <option value="4">4 - Excellent</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Work Ethic <span class="text-danger">*</span></label>
                                <select class="form-select" name="work_ethic" required>
                                    <option value="">Select Rating</option>
                                    <option value="1">1 - Poor</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="3">3 - Good</option>
                                    <option value="4">4 - Excellent</option>
                                </select>
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label">Unmet Competencies</label>
                                <textarea class="form-control" name="unmet_competencies" rows="3" placeholder="Please mention any competencies you feel were not adequately addressed during your studies"></textarea>
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label">Curriculum Suggestions</label>
                                <textarea class="form-control" name="curriculum_suggestions" rows="3" placeholder="Please provide any suggestions for curriculum improvement"></textarea>
                            </div>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger mt-4">
                            <h6 class="fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> There are errors:</h6>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="fas fa-paper-plane me-2"></i> Submit Survey
                        </button>
                    </div>
                </form>
            @endif
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
        /* Same CSS as tracer study */
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
        // Helper function to get rating text
        function getRatingText(rating) {
            const ratings = {
                1: 'Poor',
                2: 'Fair',
                3: 'Good',
                4: 'Excellent'
            };
            return ratings[rating] || '';
        }

        // Initialize Select2 for NIM
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

        // Handle NIM selection change
        $('#nimSelect').on('change', function () {
            const selectedOption = $(this).find('option:selected');
            const nim = $(this).val();
            
            // Fill alumni data
            $('#namaInput').val(selectedOption.data('name'));
            $('#programStudiInput').val(selectedOption.data('program-studi'));
            $('#tahunLulusInput').val(selectedOption.data('year_graduated'));
            $('#emailInput').val(selectedOption.data('email'));

            // Get tracer data via AJAX if NIM is selected
            if (nim) {
                $.get('/alumni/tracer/get-by-nim/' + nim, function(data) {
                    if (data.status && data.tracer) {
                        $('#agencyNameInput').val(data.tracer.agency_name);
                        $('#professionInput').val(data.tracer.profesi ? data.tracer.profesi.nama_profesi : '-');
                    } else {
                        $('#agencyNameInput').val('-');
                        $('#professionInput').val('-');
                    }
                }).fail(function() {
                    $('#agencyNameInput').val('-');
                    $('#professionInput').val('-');
                });
            } else {
                $('#agencyNameInput').val('');
                $('#professionInput').val('');
            }
        });

        // Form submission via AJAX
        $('#surveyForm').on('submit', function (e) {
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
                            title: 'Success',
                            text: res.message
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: res.message || 'An error occurred'
                        });
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let message = '';
                        for (let field in errors) {
                            message += errors[field].join('<br>') + '<br>';
                        }
                        Swal.fire({
                            icon: 'warning',
                            title: 'Validation Error',
                            html: message
                        });
                    } else if (xhr.status === 403) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Already Submitted',
                            text: xhr.responseJSON.message
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to submit data. Please try again.'
                        });
                    }
                }
            });
        });

        // Edit survey modal
        window.editSurvey = function (id) {
            $.get(`/alumni/survey/edit-ajax/${id}`, function (res) {
                $('#editModalContent').html(res);
                $('#editModal').modal('show');

                // Reinitialize Select2 in modal
                $('.select2-nim').select2({
                    placeholder: "Select NIM",
                    allowClear: true,
                    templateResult: formatNimOption,
                    templateSelection: formatNimSelection
                });
            });
        }
    });
</script>
@endpush