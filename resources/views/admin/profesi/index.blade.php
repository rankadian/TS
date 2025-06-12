@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title ?? 'Data Profesi' }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('admin/profesi/create_ajax') }}')" class="btn btn-success">Add
                    Profesi</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_profesi">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Profession Name</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Modal -->
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
            aria-hidden="true"></div>
    </div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function() {
            $('#table_profesi').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.profesi.list') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "nama_profesi",
                        name: "nama_profesi"
                    },
                    {
                        data: "category_name",
                        name: "category_name"
                    },
                    {
                        data: "aksi",
                        name: "aksi",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
