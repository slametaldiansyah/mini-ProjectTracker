@extends('layout.v_template')
@section('title', 'List Contract')
@push('custom-css')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('assets/')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<!-- Dropdown-item -->
<link rel="stylesheet" href="{{asset('assets/')}}/dist/css/custom/dropdowncustom.css">
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
                <a href="/contracts/create" class="btn btn-sm btn-primary">Create Contract</a>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Cont. Number</th>
                            <th>Cont. Name</th>
                            <th>Client</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contracts as $index => $contract)
                        <tr>
                            <th class="text-center">{{$loop->iteration}}</th>
                            <td>{{$contract->cont_num}}</td>
                            <td>{{$contract->name}}</td>
                            <td>{{$contract->client->name}}</td>
                            <td class="text-center">
                            <div class="btn-group">
                                <form action="/contracts/{{$contract->id}}"
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
                                <form action="/contracts/{{$contract->id}}/edit"
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
                                <form action="/contracts/{{$contract->id}}/ammend"
                                    method="get"
                                    class="d-inline">
                                <button class="btn btn-sm btn-success dropdown-hover">
                                    <i class="nav-icon fas fa-clone"></i>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item">Ammend</a>
                                    </div>
                                </button>
                                </form>
                            </div>
                            <div class="btn-group">
                                <form action="/contracts/{{$contract->id}}"
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
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Cont. Number</th>
                            <th>Cont. Name</th>
                            <th>Client</th>
                            <th>Action</th>
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
