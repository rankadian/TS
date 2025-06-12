<div class="modal-header bg-primary text-white">
    <h5 class="modal-title" id="editModalLabel">
        <i class="fas fa-edit me-2"></i> Edit Survey Data
    </h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <form id="editSurveyForm" method="POST" action="{{ route('alumni.survey.update_ajax', $survey->id) }}">
        @csrf
        @method('PUT')

        <!-- Alumni Data -->
        <div class="mb-4">
            <h6 class="fw-bold text-primary mb-3">Alumni Data</h6>
            <div class="mb-3">
                <label class="form-label">NIM <span class="text-danger">*</span></label>
                <select class="form-select select2-nim" name="nim" required style="width: 100%">
                    <option value="">Select NIM</option>
                    @foreach($alumniList as $alumni)
                        <option value="{{ $alumni->nim }}" 
                            @if($alumni->id == $survey->alumni_id) selected @endif
                            data-name="{{ $alumni->name }}"
                            data-program-studi="{{ $alumni->program_study }}"
                            data-year_graduated="{{ $alumni->year_graduated }}"
                            data-email="{{ $alumni->email }}">
                            {{ $alumni->nim }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Competency Assessment -->
        <div class="mb-4">
            <h6 class="fw-bold text-primary mb-3">Competency Assessment</h6>
            
            <div class="row g-3">
                <!-- Teamwork -->
                <div class="col-md-6">
                    <label class="form-label">Teamwork <span class="text-danger">*</span></label>
                    <select class="form-select" name="teamwork" required>
                        @foreach([1 => 'Poor', 2 => 'Fair', 3 => 'Good', 4 => 'Excellent'] as $value => $label)
                            <option value="{{ $value }}" @if($survey->teamwork == $value) selected @endif>
                                {{ $value }} - {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- IT Skills -->
                <div class="col-md-6">
                    <label class="form-label">IT Skills <span class="text-danger">*</span></label>
                    <select class="form-select" name="it_skills" required>
                        @foreach([1 => 'Poor', 2 => 'Fair', 3 => 'Good', 4 => 'Excellent'] as $value => $label)
                            <option value="{{ $value }}" @if($survey->it_skills == $value) selected @endif>
                                {{ $value }} - {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Foreign Language -->
                <div class="col-md-6">
                    <label class="form-label">Foreign Language <span class="text-danger">*</span></label>
                    <select class="form-select" name="foreign_language" required>
                        @foreach([1 => 'Poor', 2 => 'Fair', 3 => 'Good', 4 => 'Excellent'] as $value => $label)
                            <option value="{{ $value }}" @if($survey->foreign_language == $value) selected @endif>
                                {{ $value }} - {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Communication -->
                <div class="col-md-6">
                    <label class="form-label">Communication <span class="text-danger">*</span></label>
                    <select class="form-select" name="communication" required>
                        @foreach([1 => 'Poor', 2 => 'Fair', 3 => 'Good', 4 => 'Excellent'] as $value => $label)
                            <option value="{{ $value }}" @if($survey->communication == $value) selected @endif>
                                {{ $value }} - {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Self Development -->
                <div class="col-md-6">
                    <label class="form-label">Self Development <span class="text-danger">*</span></label>
                    <select class="form-select" name="self_development" required>
                        @foreach([1 => 'Poor', 2 => 'Fair', 3 => 'Good', 4 => 'Excellent'] as $value => $label)
                            <option value="{{ $value }}" @if($survey->self_development == $value) selected @endif>
                                {{ $value }} - {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Leadership -->
                <div class="col-md-6">
                    <label class="form-label">Leadership <span class="text-danger">*</span></label>
                    <select class="form-select" name="leadership" required>
                        @foreach([1 => 'Poor', 2 => 'Fair', 3 => 'Good', 4 => 'Excellent'] as $value => $label)
                            <option value="{{ $value }}" @if($survey->leadership == $value) selected @endif>
                                {{ $value }} - {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Work Ethic -->
                <div class="col-md-6">
                    <label class="form-label">Work Ethic <span class="text-danger">*</span></label>
                    <select class="form-select" name="work_ethic" required>
                        @foreach([1 => 'Poor', 2 => 'Fair', 3 => 'Good', 4 => 'Excellent'] as $value => $label)
                            <option value="{{ $value }}" @if($survey->work_ethic == $value) selected @endif>
                                {{ $value }} - {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Text Inputs -->
        <div class="mb-3">
            <label class="form-label">Unmet Competencies</label>
            <textarea class="form-control" name="unmet_competencies" rows="3">{{ $survey->unmet_competencies }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Curriculum Suggestions</label>
            <textarea class="form-control" name="curriculum_suggestions" rows="3">{{ $survey->curriculum_suggestions }}</textarea>
        </div>
    </form>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
        <i class="fas fa-times me-2"></i> Cancel
    </button>
    <button type="submit" form="editSurveyForm" class="btn btn-primary">
        <i class="fas fa-save me-2"></i> Save Changes
    </button>
</div>

<script>
$(document).ready(function() {
    // Initialize Select2 for NIM dropdown
    $('.select2-nim').select2({
        placeholder: "Select NIM",
        dropdownParent: $('#editModal')
    });

    // Handle form submission
    $('#editSurveyForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const formData = new FormData(this);

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message
                    }).then(() => {
                        $('#editModal').modal('hide');
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let message = '';
                    for (let field in errors) {
                        message += errors[field].join('<br>') + '<br>';
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update data. Please try again.'
                    });
                }
            }
        });
    });
});
</script>