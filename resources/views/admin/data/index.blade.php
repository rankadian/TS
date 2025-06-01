@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title ?? 'Data Alumni' }}</h3>

            <div class="card-tools">
                <button onclick="modalAction('{{ url('admin/alumni/create_ajax') }}')" class="btn btn-success">Add Alumni</button>
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
                        <th>ID</th>
                        <th>Tahun Lulus</th>
                        <th>Name</th>
                        <th>No HP</th>
                        <th>Email</th>
                        <th>Email Verified</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" data-width="75%" aria-hidden="true"></div>
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
    var dataAlumni;
    $(document).ready(function () {
        dataAlumni = $('#table_alumni').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('admin/alumni/list') }}",
                dataType: "json",
                type: "POST",
            },
            columns: [
                {
                    data: "id",
                    className: "text-center",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "tahun_lulus",
                    className: "text-center",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "name",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "no_hp",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "email",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "email_verified_at",
                    className: "text-center",
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return data ? '<span class="badge badge-success">Verified</span>' : '<span class="badge badge-warning">Not Verified</span>';
                    }
                },
                {
                    data: "aksi",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Jika ada filter tertentu, bisa ditambahkan event handler di sini
    });
</script>
@endpush
