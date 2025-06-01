@empty($alumni)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Error</h5>
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
<form action="{{ url('/admin/data-alumni/' . $alumni->id . '/delete_ajax') }}" method="POST" id="form-delete-alumni">
    @csrf
    @method('DELETE')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Alumni Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Confirmation !!!</h5>
                    Do you want to delete the data as below?
                </div>
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right col-3">Name :</th>
                        <td class="col-9">{{ $alumni->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Program Studi :</th>
                        <td class="col-9">{{ $alumni->program_study }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Year Graduated :</th>
                        <td class="col-9">{{ $alumni->year_graduated }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Email :</th>
                        <td class="col-9">{{ $alumni->email }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Cancel</button>
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function () {
    $("#form-delete-alumni").validate({
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: 'DELETE',
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
                        text: 'Something went wrong when deleting the data.'
                    });
                }
            });
            return false;
        }
    });
});
</script>
@endempty
