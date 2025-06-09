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
                    No alumni data found.
                </div>
                <a href="{{ url('/admin/data-alumni') }}" class="btn btn-warning">Back</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alumni Data Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info-circle"></i> Information</h5>
                    Here are the details of the selected alumni data.
                </div>

                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right col-4">Study Program:</th>
                        <td class="col-8">{{ $alumni->program_study }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-4">Date Passed:</th>
                        <td class="col-8">{{ \Carbon\Carbon::parse($alumni->year_graduated)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-4">Name:</th>
                        <td class="col-8">{{ $alumni->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-4">Phone Number:</th>
                        <td class="col-8">{{ $alumni->no_hp }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-4">Email:</th>
                        <td class="col-8">{{ $alumni->email }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-4">NIM:</th>
                        <td class="col-8">{{ $alumni->nim }}</td>
                    </tr>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
@endempty
