@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>

            <div class="card-tools">
                <button onclick="modalAction('{{ url('/barang/import') }}')" class="btn btn-warning">Import Barang</button>
                <a href="{{ url('/barang/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i>Export
                    Barang</a>
                <a href="{{ url('/barang/export_pdf') }}" class="btn btn-secondary"><i class="fa fa-file-pdf"></i> Export
                    Barang</a>
                <button onclick="modalAction('{{ url('user/create_ajax') }}')" class="btn btn-success">Add
                    Admin</button>
            </div>

        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_admin">
                <thead>
                    <tr>
                        <th>Admin ID</th>
                        <th>Name</th>
                        <th>Email</th>
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
            var dataAdmin
            $(document).ready(function () {
                dataAdmin = $('#table_admin').DataTable({
                    serverSide: true,
                    ajax: {
                        "url": "{{ url('admin/list') }}",
                        "dataType": "json",
                        "type": "POST",
                    },
                    columns: [
                        {
                            data: "DT_RowIndex",
                            className: "text-center",
                            orderable: false,
                            searchable: false
                        }, {
                            data: "name",
                            className: "",
                            orderable: false,
                            searchable: false
                        }, {
                            data: "email",
                            className: "",
                            orderable: false,
                            searchable: false
                        }, {
                            data: "aksi",
                            className: "",
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
                $('#admin_id').on('change', function () {
                    dataAdmin.ajax.reload();
                });
            }); 
        </script>
    @endpush