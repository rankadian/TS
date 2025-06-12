<form action="{{ url('/alumni/' . $alumni->id . '/update_ajax') }}" method="POST" id="form-edit-alumni">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- Form Fields --}}
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $alumni->name }}" required>
                        <small id="error-name" class="form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Study Program</label>
                        <input type="text" name="program_study" class="form-control" value="{{ $alumni->program_study }}" required>
                        <small id="error-program_study" class="form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Student ID (NIM)</label>
                        <input type="text" name="nim" class="form-control" value="{{ $alumni->nim }}" required>
                        <small id="error-nim" class="form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Graduation Date</label>
                        <input type="date" name="year_graduated" class="form-control" value="{{ $alumni->year_graduated }}" required>
                        <small id="error-year_graduated" class="form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $alumni->email }}" required>
                        <small id="error-email" class="form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ $alumni->no_hp }}">
                        <small id="error-no_hp" class="form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Password (Leave blank if unchanged)</label>
                        <input type="password" name="password" class="form-control">
                        <small id="error-password" class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $('#form-edit-alumni').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success: function (res) {
                if (res.status) {
                    $('#modal-master').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message
                    }).then(() => location.reload());
                } else {
                    $('.form-text.text-danger').text('');
                    $.each(res.msgField, function (key, value) {
                        $('#error-' + key).text(value[0]);
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while saving data.'
                });
            }
        });
    });
</script>
