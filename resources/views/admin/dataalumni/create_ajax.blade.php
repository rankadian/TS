<form action="{{ url('/admin/data-alumni/ajax') }}" method="POST" id="form-tambah-alumni">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Alumni Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Program Studi --}}
                <div class="form-group">
                    <label>Program Studi</label>
                    <input type="text" name="program_study" id="program_study" class="form-control" required>
                    <small id="error-program_study" class="error-text form-text text-danger"></small>
                </div>
                {{-- Tanggal Lulus --}}
                <div class="form-group">
                    <label>Tanggal Lulus</label>
                    <input type="date" name="year_graduated" id="year_graduated" class="form-control" required>
                    <small id="error-year_graduated" class="error-text form-text text-danger"></small>
                </div>
                {{-- Nama --}}
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                    <small id="error-name" class="error-text form-text text-danger"></small>
                </div>
                {{-- No Telpon --}}
                <div class="form-group">
                    <label>No Telpon</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" required>
                    <small id="error-no_hp" class="error-text form-text text-danger"></small>
                </div>
                {{-- Email --}}
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    <small id="error-email" class="error-text form-text text-danger"></small>
                </div>
                {{-- NIM --}}
                <div class="form-group">
                    <label>NIM</label>
                    <input type="text" name="nim" id="nim" class="form-control" required>
                    <small id="error-nim" class="error-text form-text text-danger"></small>
                </div>
                {{-- Password --}}
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
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

<script>
$(document).ready(function () {
    $("#form-tambah-alumni").validate({
        rules: {
            program_study: { required: true, minlength: 3 },
            year_graduated: { required: true, date: true },
            name: { required: true, minlength: 3 },
            no_hp: { required: true, minlength: 9 },
            email: { required: true, email: true, maxlength: 100 },
            nim: { required: true, minlength: 3 },
            password: { required: true, minlength: 5 }
        },
        messages: {
            program_study: {
                required: "Program studi wajib diisi",
                minlength: "Minimal 3 karakter"
            },
            year_graduated: {
                required: "Tanggal lulus wajib diisi",
                date: "Format tanggal tidak valid"
            },
            name: {
                required: "Nama wajib diisi",
                minlength: "Minimal 3 karakter"
            },
            no_hp: {
                required: "No telpon wajib diisi",
                minlength: "Minimal 9 digit"
            },
            email: {
                required: "Email wajib diisi",
                email: "Format email tidak valid",
                maxlength: "Maksimal 100 karakter"
            },
            nim: {
                required: "NIM wajib diisi",
                minlength: "Minimal 3 karakter"
            },
            password: {
                required: "Password wajib diisi",
                minlength: "Minimal 5 karakter"
            }
        },
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function (response) {
                    if (response.status) {
                        $('#modal-master').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        });
                        if(typeof dataAlumni !== 'undefined'){
                            dataAlumni.ajax.reload();
                        }
                    } else {
                        $('.error-text').text('');
                        $.each(response.msgField, function (prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: response.message
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Terjadi kesalahan saat menyimpan data.'
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
