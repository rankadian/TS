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

        <div class="mb-3">
            <label class="form-label">NIM</label>
            <select class="form-select select2-nim" name="nim" required>
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

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Teamwork <span class="text-danger">*</span></label>
                <select class="form-select" name="teamwork" required>
                    <option value="1" @if($survey->teamwork == 1) selected @endif>1 - Poor</option>
                    <option value="2" @if($survey->teamwork == 2) selected @endif>2 - Fair</option>
                    <option value="3" @if($survey->teamwork == 3) selected @endif>3 - Good</option>
                    <option value="4" @if($survey->teamwork == 4) selected @endif>4 - Excellent</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">IT Skills <span class="text-danger">*</span></label>
                <select class="form-select" name="it_skills" required>
                    <option value="1" @if($survey->it_skills == 1) selected @endif>1 - Poor</option>
                    <option value="2" @if($survey->it_skills == 2) selected @endif>2 - Fair</option>
                    <option value="3" @if($survey->it_skills == 3) selected @endif>3 - Good</option>
                    <option value="4" @if($survey->it_skills == 4) selected @endif>4 - Excellent</option>
                </select>
            </div>

            <!-- Add other rating fields similarly -->

            <div class="col-12 mt-3">
                <label class="form-label">Unmet Competencies</label>
                <textarea class="form-control" name="unmet_competencies" rows="3">{{ $survey->unmet_competencies }}</textarea>
            </div>

            <div class="col-12 mt-3">
                <label class="form-label">Curriculum Suggestions</label>
                <textarea class="form-control" name="curriculum_suggestions" rows="3">{{ $survey->curriculum_suggestions }}</textarea>
            </div>
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
    $('#editSurveyForm').on('submit', function(e) {
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
                        text: 'An error occurred. Please try again.'
                    });
                }
            }
        });
    });
});
</script>