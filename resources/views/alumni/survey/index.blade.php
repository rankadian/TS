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

                    <!-- Alumni Data Section -->
                    <div class="section-box mb-4 p-4 bg-light rounded-3">
                        <h5 class="fw-bold text-primary mb-4">
                            <i class="fas fa-user-graduate me-2"></i> Alumni Data
                        </h5>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">NIM</label>
                            <select class="form-select select2-nim" name="nim" id="nimSelect" required style="width: 100%">
                                <option value="">Select NIM or Type to Search</option>
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

                        <div class="border-top pt-3 mt-3"></div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-12">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control bg-white" id="namaInput" readonly>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Study Program</label>
                                <input type="text" class="form-control bg-white" id="programStudiInput" readonly>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Year Graduated</label>
                                <input type="text" class="form-control bg-white" id="tahunLulusInput" readonly>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control bg-white" id="emailInput" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Data Section -->
                    <div class="section-box mb-4 p-4 bg-light rounded-3">
                        <h5 class="fw-bold text-primary mb-4">
                            <i class="fas fa-briefcase me-2"></i> Employment Data
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Agency Name</label>
                                <input type="text" class="form-control bg-white" id="agencyNameInput" readonly>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Profession</label>
                                <input type="text" class="form-control bg-white" id="professionInput" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Competency Assessment Section -->
                    <div class="section-box mb-4 p-4 bg-light rounded-3">
                        <h5 class="fw-bold text-primary mb-4">
                            <i class="fas fa-star me-2"></i> Competency Assessment
                        </h5>
                        <p class="text-muted mb-4">Please rate the following competencies:</p>

                        <!-- Teamwork -->
                        <div class="question-box bg-white p-4 rounded-3 border mb-4">
                            <label class="form-label fw-bold d-block mb-3">
                                <span class="text-primary">1.</span> Teamwork <span class="text-danger">*</span>
                            </label>
                            <div class="rating-container">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    @foreach([1 => 'Poor', 2 => 'Fair', 3 => 'Good', 4 => 'Excellent'] as $value => $label)
                                        <div class="square-radio">
                                            <input type="radio" class="form-check-input" name="teamwork" 
                                                   id="teamwork{{$value}}" value="{{$value}}" required>
                                            <label for="teamwork{{$value}}" class="square-radio-label">
                                                <span class="rating-value">{{$value}}</span>
                                                <span class="rating-label">{{$label}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="d-flex justify-content-between mt-2 text-muted small">
                                    <span>Poor</span>
                                    <span>Excellent</span>
                                </div>
                            </div>
                        </div>

                        <!-- IT Skills -->
                        <div class="question-box bg-white p-4 rounded-3 border mb-4">
                            <label class="form-label fw-bold d-block mb-3">
                                <span class="text-primary">2.</span> IT Skills <span class="text-danger">*</span>
                            </label>
                            <div class="rating-container">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    @foreach([1 => 'Poor', 2 => 'Fair', 3 => 'Good', 4 => 'Excellent'] as $value => $label)
                                        <div class="square-radio">
                                            <input type="radio" class="form-check-input" name="it_skills" 
                                                   id="it_skills{{$value}}" value="{{$value}}" required>
                                            <label for="it_skills{{$value}}" class="square-radio-label">
                                                <span class="rating-value">{{$value}}</span>
                                                <span class="rating-label">{{$label}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="d-flex justify-content-between mt-2 text-muted small">
                                    <span>Poor</span>
                                    <span>Excellent</span>
                                </div>
                            </div>
                        </div>

                        <!-- Foreign Language -->
                        <div class="question-box bg-white p-4 rounded-3 border mb-4">
                            <label class="form-label fw-bold d-block mb-3">
                                <span class="text-primary">3.</span> Foreign Language <span class="text-danger">*</span>
                            </label>
                            <div class="rating-container">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    @foreach([1 => 'Poor', 2 => 'Fair', 3 => 'Good', 4 => 'Excellent'] as $value => $label)
                                        <div class="square-radio">
                                            <input type="radio" class="form-check-input" name="foreign_language" 
                                                   id="foreign_language{{$value}}" value="{{$value}}" required>
                                            <label for="foreign_language{{$value}}" class="square-radio-label">
                                                <span class="rating-value">{{$value}}</span>
                                                <span class="rating-label">{{$label}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="d-flex justify-content-between mt-2 text-muted small">
                                    <span>Poor</span>
                                    <span>Excellent</span>
                                </div>
                            </div>
                        </div>

                        <!-- Communication -->
                        <div class="question-box bg-white p-4 rounded-3 border mb-4">
                            <label class="form-label fw-bold d-block mb-3">
                                <span class="text-primary">4.</span> Communication <span class="text-danger">*</span>
                            </label>
                            <div class="rating-container">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    @foreach([1 => 'Poor', 2 => 'Fair', 3 => 'Good', 4 => 'Excellent'] as $value => $label)
                                        <div class="square-radio">
                                            <input type="radio" class="form-check-input" name="communication" 
                                                   id="communication{{$value}}" value="{{$value}}" required>
                                            <label for="communication{{$value}}" class="square-radio-label">
                                                <span class="rating-value">{{$value}}</span>
                                                <span class="rating-label">{{$label}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="d-flex justify-content-between mt-2 text-muted small">
                                    <span>Poor</span>
                                    <span>Excellent</span>
                                </div>
                            </div>
                        </div>

                        <!-- Self Development -->
                        <div class="question-box bg-white p-4 rounded-3 border mb-4">
                            <label class="form-label fw-bold d-block mb-3">
                                <span class="text-primary">5.</span> Self Development <span class="text-danger">*</span>
                            </label>
                            <div class="rating-container">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    @foreach([1 => 'Poor', 2 => 'Fair', 3 => 'Good', 4 => 'Excellent'] as $value => $label)
                                        <div class="square-radio">
                                            <input type="radio" class="form-check-input" name="self_development" 
                                                   id="self_development{{$value}}" value="{{$value}}" required>
                                            <label for="self_development{{$value}}" class="square-radio-label">
                                                <span class="rating-value">{{$value}}</span>
                                                <span class="rating-label">{{$label}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="d-flex justify-content-between mt-2 text-muted small">
                                    <span>Poor</span>
                                    <span>Excellent</span>
                                </div>
                            </div>
                        </div>

                        <!-- Leadership -->
                        <div class="question-box bg-white p-4 rounded-3 border mb-4">
                            <label class="form-label fw-bold d-block mb-3">
                                <span class="text-primary">6.</span> Leadership <span class="text-danger">*</span>
                            </label>
                            <div class="rating-container">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    @foreach([1 => 'Poor', 2 => 'Fair', 3 => 'Good', 4 => 'Excellent'] as $value => $label)
                                        <div class="square-radio">
                                            <input type="radio" class="form-check-input" name="leadership" 
                                                   id="leadership{{$value}}" value="{{$value}}" required>
                                            <label for="leadership{{$value}}" class="square-radio-label">
                                                <span class="rating-value">{{$value}}</span>
                                                <span class="rating-label">{{$label}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="d-flex justify-content-between mt-2 text-muted small">
                                    <span>Poor</span>
                                    <span>Excellent</span>
                                </div>
                            </div>
                        </div>

                        <!-- Work Ethic -->
                        <div class="question-box bg-white p-4 rounded-3 border mb-4">
                            <label class="form-label fw-bold d-block mb-3">
                                <span class="text-primary">7.</span> Work Ethic <span class="text-danger">*</span>
                            </label>
                            <div class="rating-container">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    @foreach([1 => 'Poor', 2 => 'Fair', 3 => 'Good', 4 => 'Excellent'] as $value => $label)
                                        <div class="square-radio">
                                            <input type="radio" class="form-check-input" name="work_ethic" 
                                                   id="work_ethic{{$value}}" value="{{$value}}" required>
                                            <label for="work_ethic{{$value}}" class="square-radio-label">
                                                <span class="rating-value">{{$value}}</span>
                                                <span class="rating-label">{{$label}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="d-flex justify-content-between mt-2 text-muted small">
                                    <span>Poor</span>
                                    <span>Excellent</span>
                                </div>
                            </div>
                        </div>

                        <!-- Text Inputs -->
                        <div class="question-box bg-white p-4 rounded-3 border mb-4">
                            <label class="form-label fw-bold d-block mb-3">8. Unmet Competencies</label>
                            <textarea class="form-control" name="unmet_competencies" rows="3" placeholder="Please mention any competencies you feel were not adequately addressed during your studies"></textarea>
                        </div>

                        <div class="question-box bg-white p-4 rounded-3 border">
                            <label class="form-label fw-bold d-block mb-3">9. Curriculum Suggestions</label>
                            <textarea class="form-control" name="curriculum_suggestions" rows="3" placeholder="Please provide any suggestions for curriculum improvement"></textarea>
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
        .container-fluid {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .card {
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.05);
        }

        .card-header {
            border-radius: 0.75rem 0.75rem 0 0 !important;
            padding: 1rem 1.5rem;
        }

        .section-box {
            border-left: 4px solid #0d6efd;
            background-color: #f8f9fa;
            border-radius: 0.75rem;
        }

        .question-box {
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .question-box:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-color: #b8daff;
        }

        .rounded-3 {
            border-radius: 0.75rem !important;
        }

        .form-control[readonly] {
            background-color: #ffffff;
            border: 1px solid #ced4da;
        }

        .border-top {
            border-top: 1px solid #dee2e6 !important;
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

        /* Beautiful Square Radio Buttons */
        .square-radio {
            position: relative;
            flex: 1;
            min-width: 80px;
        }

        .square-radio input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .square-radio-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 0.5rem;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            background-color: white;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
            height: 100%;
        }

        .square-radio input[type="radio"]:checked + .square-radio-label {
            border-color: #0d6efd;
            background-color: #f0f7ff;
            box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.25);
        }

        .square-radio input[type="radio"]:focus + .square-radio-label {
            border-color: #0d6efd;
        }

        .square-radio:hover .square-radio-label {
            border-color: #adb5bd;
        }

        .rating-value {
            font-weight: bold;
            font-size: 1.1rem;
            color: #212529;
        }

        .rating-label {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .square-radio {
                min-width: 70px;
            }
        }
    </style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize Select2 for NIM
        $('.select2-nim').select2({
            placeholder: "Select NIM or Type to Search",
            allowClear: true,
            width: '100%'
        });

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
                $('.select2-nim').select2({
                    placeholder: "Select NIM",
                    allowClear: true,
                    width: '100%'
                });
            });
        }
    });
</script>
@endpush