@empty($alumni)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Error!!!</h5>
                    The data you are looking for was not found
                </div>
                <a href="{{ url('/admin/data-alumni') }}" class="btn btn-warning">Back</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/admin/data-alumni/' . $alumni->id . '/update_ajax') }}" method="POST" id="form-edit-alumni">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Alumni Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Study Program</label>
                        <input type="text" name="program_study" id="program_study" class="form-control"
                            value="{{ $alumni->program_study }}" required>
                        <small id="error-program_study" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Date Passed</label>
                        <input type="date" name="year_graduated" id="year_graduated" class="form-control"
                            value="{{ $alumni->year_graduated }}" required>
                        <small id="error-year_graduated" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $alumni->name }}" required>
                        <small id="error-name" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ $alumni->no_hp }}">
                        <small id="error-no_hp" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $alumni->email }}"
                            required>
                        <small id="error-email" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>NIM</label>
                        <input type="text" name="nim" id="nim" class="form-control" value="{{ $alumni->nim }}" required>
                        <small id="error-nim" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                        <small class="form-text text-muted">Ignore if you don't want to change the password</small>
                        <small id="error-password" class="error-text form-text text-danger"></small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
@endempty

<script>
    $(document).ready(function () {
        $("#form-edit-alumni").validate({
            rules: {
                program_study: { required: true, minlength: 3 },
                year_graduated: { required: true, date: true },
                name: { required: true, minlength: 3 },
                no_hp: { minlength: 9 },
                email: { required: true, email: true, maxlength: 100 },
                nim: { required: true, minlength: 3 },
                password: { minlength: 5 }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            });
                            dataAlumni.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Error occurred',
                                text: response.message
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'An error occurred while saving data.'
                        });
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>