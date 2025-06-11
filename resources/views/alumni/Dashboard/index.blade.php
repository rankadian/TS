@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
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
                        <th>No.</th>
                        <th>Name</th>
                        <th>Study Program</th>
                        <th>NIM</th>
                        <th>Date Passed</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    </div>
@endsection

@push('css')
    <!-- DataTables CSS jika belum di-include -->
@endpush

@push('js')
    <script>
        // Setup CSRF Token untuk semua AJAX request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        var dataAlumni;
        $(document).ready(function () {
            dataAlumni = $('#table_alumni').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ url('alumni/list') }}",
                    type: "POST",
                    dataType: "json",
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "name", className: "", orderable: false, searchable: true },
                    { data: "program_study", className: "", orderable: false, searchable: false },
                    { data: "nim", className: "", orderable: false, searchable: true },
                    { data: "year_graduated", className: "", orderable: false, searchable: false },
                    { data: "email", className: "", orderable: false, searchable: false },
                    { data: "no_hp", className: "", orderable: false, searchable: false },
                    { data: "aksi", className: "text-center", orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush
