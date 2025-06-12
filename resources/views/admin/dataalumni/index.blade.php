@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>

        <div class="card-tools">
            <button onclick="modalAction('{{ url('/admin/data-alumni/import') }}')" class="btn btn-success">Import Alumni</button>
        </div>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm" id="table_alumni">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Study Program</th>
                    <th>Graduation Year</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Student ID</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
</div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }

    $(document).ready(function () {
        $('#table_alumni').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('admin/data-alumni/list') }}",
                type: "POST",
                dataType: "json",
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "program_study", className: "text-center" },
                { data: "year_graduated", className: "text-center" },
                { data: "name" },
                { data: "no_hp" },
                { data: "email" },
                { data: "nim" },
                { data: "aksi", className: "text-center", orderable: false, searchable: false },
            ]
        });
    });
</script>
@endpush
