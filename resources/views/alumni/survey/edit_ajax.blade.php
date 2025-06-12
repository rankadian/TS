<form id="editSurveyForm" onsubmit="submitEditSurvey(event)">
    @csrf

    <div class="modal-header">
        <h5 class="modal-title">Edit Survey Tracer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body row">
        <div class="col-md-6">
            <x-form.input label="Student ID Number (NIM)" name="nim" value="{{ $survey->alumni->nim }}" required />

            <x-form.select label="Teamwork" name="teamwork" required>
                <option value="">-- Select --</option>
                @for($i = 1; $i <= 4; $i++)
                    <option value="{{ $i }}" {{ $survey->teamwork == $i ? 'selected' : '' }}>
                        {{ $i }} - {{ ['Poor', 'Fair', 'Good', 'Excellent'][$i - 1] }}
                    </option>
                @endfor
            </x-form.select>

            <x-form.select label="IT Skills" name="it_skills" required>
                <option value="">-- Select --</option>
                @for($i = 1; $i <= 4; $i++)
                    <option value="{{ $i }}" {{ $survey->it_skills == $i ? 'selected' : '' }}>
                        {{ $i }} - {{ ['Poor', 'Fair', 'Good', 'Excellent'][$i - 1] }}
                    </option>
                @endfor
            </x-form.select>

            <x-form.select label="Foreign Language Proficiency" name="foreign_language" required>
                <option value="">-- Select --</option>
                @for($i = 1; $i <= 4; $i++)
                    <option value="{{ $i }}" {{ $survey->foreign_language == $i ? 'selected' : '' }}>
                        {{ $i }} - {{ ['Poor', 'Fair', 'Good', 'Excellent'][$i - 1] }}
                    </option>
                @endfor
            </x-form.select>

            <x-form.select label="Communication Skills" name="communication" required>
                <option value="">-- Select --</option>
                @for($i = 1; $i <= 4; $i++)
                    <option value="{{ $i }}" {{ $survey->communication == $i ? 'selected' : '' }}>
                        {{ $i }} - {{ ['Poor', 'Fair', 'Good', 'Excellent'][$i - 1] }}
                    </option>
                @endfor
            </x-form.select>
        </div>

        <div class="col-md-6">
            <x-form.select label="Self Development" name="self_development" required>
                <option value="">-- Select --</option>
                @for($i = 1; $i <= 4; $i++)
                    <option value="{{ $i }}" {{ $survey->self_development == $i ? 'selected' : '' }}>
                        {{ $i }} - {{ ['Poor', 'Fair', 'Good', 'Excellent'][$i - 1] }}
                    </option>
                @endfor
            </x-form.select>

            <x-form.select label="Leadership" name="leadership" required>
                <option value="">-- Select --</option>
                @for($i = 1; $i <= 4; $i++)
                    <option value="{{ $i }}" {{ $survey->leadership == $i ? 'selected' : '' }}>
                        {{ $i }} - {{ ['Poor', 'Fair', 'Good', 'Excellent'][$i - 1] }}
                    </option>
                @endfor
            </x-form.select>

            <x-form.select label="Work Ethic" name="work_ethic" required>
                <option value="">-- Select --</option>
                @for($i = 1; $i <= 4; $i++)
                    <option value="{{ $i }}" {{ $survey->work_ethic == $i ? 'selected' : '' }}>
                        {{ $i }} - {{ ['Poor', 'Fair', 'Good', 'Excellent'][$i - 1] }}
                    </option>
                @endfor
            </x-form.select>

            <x-form.textarea label="Unmet Competencies" name="unmet_competencies" rows="3">{{ $survey->unmet_competencies }}</x-form.textarea>

            <x-form.textarea label="Suggestions for Curriculum" name="curriculum_suggestions" rows="3">{{ $survey->curriculum_suggestions }}</x-form.textarea>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Save Changes
        </button>
    </div>
</form>

<script>
    function submitEditSurvey(e) {
        e.preventDefault();

        const form = $('#editSurveyForm');
        const formData = new FormData(form[0]);
        const url = `/alumni/tracer/update-ajax/{{ $survey->id }}`;

        $.ajax({
            url: url,
            type: 'POST',
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
                        title: 'Success',
                        text: res.message
                    }).then(() => {
                        $('#editModal').modal('hide');
                        $('#editModalContent').html('');
                        $('#dataSurveyTable').load(window.location.href + ' #dataSurveyTable > *');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: res.message || 'Failed to save changes'
                    });
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let msg = Object.values(errors).map(e => `- ${e[0]}`).join('\n');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation Error',
                        text: msg
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'An error occurred on the server.'
                    });
                }
            }
        });
    }
</script>
