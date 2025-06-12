@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        <h4>Profile Information</h4>
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Study Program</th>
                <td>{{ $user->program_study }}</td>
            </tr>
            <tr>
                <th>Student ID (NIM)</th>
                <td>{{ $user->nim }}</td>
            </tr>
            <tr>
                <th>Graduation Date</th>
                <td>{{ \Carbon\Carbon::parse($user->year_graduated)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td>{{ $user->no_hp }}</td>
            </tr>
        </table>
    </div>
    <div class="card-footer">
        <button class="btn btn-warning" onclick="editProfile('{{ $user->id }}')">
            <i class="fas fa-edit"></i> Edit Profile
        </button>
    </div>
</div>

{{-- Modal placeholder --}}
<div id="modal-container"></div>
@endsection

@push('js')
<script>
    function editProfile(id) {
        $.ajax({
            url: '/alumni/' + id + '/edit_ajax',
            type: 'GET',
            success: function (res) {
                $('#modal-container').html(res);
                $('#modal-master').modal('show');
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Failed to load edit form.'
                });
            }
        });
    }
</script>
@endpush
