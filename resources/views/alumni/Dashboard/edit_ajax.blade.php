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

                    <div class="alert alert-info">
                        Only phone number and password can be updated.
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" value="{{ $alumni->name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Study Program</label>
                        <input type="text" class="form-control" value="{{ $alumni->program_study }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Student ID (NIM)</label>
                        <input type="text" class="form-control" value="{{ $alumni->nim }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Graduation Date</label>
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($alumni->year_graduated)->format('d/m/Y') }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" value="{{ $alumni->email }}" readonly>
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
