@extends('layout.v_template')
@section('title', 'List Progress Status')
@push('custom-css')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('assets/')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<!-- Dropdown-item -->
<link rel="stylesheet" href="{{asset('assets/')}}/dist/css/custom/dropdowncustom.css">
<!-- Table custome -->
<link href="{{asset('assets/')}}/costume/tablecostume.css" rel="stylesheet">

@endpush
@section('content')
<div class="container">
    <div class="col-md">
        <!-- general form elements -->
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="card">
            <div class="card-header text-right">
                <a href="/progress_status/create" class="btn btn-sm btn-primary">Create Status</a>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th class="text-center">ID Number</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($progress_status as $status)
                        <tr>
                            <th class="text-center" width="30px">{{$loop->iteration}}</th>
                            <td class="text-center">{{$status->id}}</td>
                            <td>{{$status->status}}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <form action="/progress_status/{{$status->id}}"
                                        method="get"
                                        class="d-inline">
                                            <button class="btn btn-sm btn-warning dropdown-hover">
                                                <i class="nav-icon fas fa-eye"></i>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item">Show</a>
                                                </div>
                                            </button>
                                    </form>
                                </div>
                                <div class="btn-group">
                                    <form action="/progress_status/{{$status->id}}/edit"
                                        method="get"
                                        class="d-inline">
                                            <button class="btn btn-sm btn-primary dropdown-hover">
                                                <i class="nav-icon fas fa-pen"></i>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item">Edit</a>
                                                </div>
                                            </button>
                                    </form>
                                </div>
                                <div class="btn-group">
                                    <form action="/progress_status/{{$status->id}}"
                                        onsubmit="return confirm('Are you sure you want to delete?')" method="post"
                                        class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger dropdown-hover">
                                            <i class="nav-icon fas fa-trash"></i>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item">Delete</a>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                                {{-- <a href="/progress_status/{{$status->id}}" class="btn btn-warning">
                                    <i class="nav-icon fas fa-eye"></i>
                                </a>
                                <a href="/progress_status/{{$status->id}}/edit" class="btn btn-primary">
                                    <i class="nav-icon fas fa-pen"></i>
                                </a>
                                <form action="/progress_status/{{$status->id}}"
                                    onsubmit="return confirm('Are you sure you want to delete?')" method="post"
                                    class=" d-inline">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="nav-icon fas fa-trash"></i>
                                    </button>
                                </form> --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th width="30px">No</th>
                            <th class="text-center">PO Number</th>
                            <th class="text-center">Status</th>
                            <th class="text-center"> Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('custom-js')
<!-- DataTables -->
<script src="{{asset('assets/')}}/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{asset('assets/')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endpush
@push('custom-script')
<script>
    $(function() {
        $("#example1").DataTable({
            // processing: true,
            // serverSide: true,
            language: {
                searchPlaceholder: "Search",
                search : '<i class="fas fa-search"></i>',
                'paginate': {
                    'previous': '<a>Back <i class="fas fa-hand-point-left"></i></a>',
                    'next': '<a><i class="fas fa-hand-point-right"></i> Next</a>',
                    }}
        });
    });
</script>
@endpush
