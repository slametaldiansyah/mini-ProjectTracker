@extends('layout.v_template')
@section('title', 'List Project Status')
@push('custom-css')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('assets/')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
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
            {{-- <div class="card-header text-right">
                <a href="/projects_status/create" class="btn btn-primary">Create Project</a>
            </div> --}}
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th class="text-center">PO Name</th>
                            <th class="text-center">PO Number</th>
                            <th class="text-center">Progress Status</th>
                            <th class="text-center">Invoicing Status</th>
                            {{-- <th class="text-center">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects_status as $status)
                        <tr>
                            <th class="text-center" width="30px">{{$loop->iteration}}</th>
                            <td>{{$status->name}}</td>
                            <td class="text-right">{{$status->no_po}}</td>
                            <td class="text-center text-bold {{$status->status <= 30 ? 'text-red' :
                            ($status->status <= 99 ? 'text-blue' : 'text-green') }}" style="font-size: 130%"> {{$status->status}}%</td>
                            <td class="text-center text-bold {{$status->invoice_status <= 30 ? 'text-red' :
                            ($status->status <= 99 ? 'text-blue' : 'text-green') }}" style="font-size: 130%"> {{$status->invoice_status}}%</td>
                           
                            {{-- <td class="text-center">
                                <a href="/progress_status/{{$status->id}}" class="btn btn-warning">
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
                                </form>
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th width="30px">No</th>
                            <th class="text-center">PO Name</th>
                            <th class="text-center">PO Number</th>
                            <th class="text-center">Progress Status</th>
                            <th class="text-center">Invoicing Status</th>
                            {{-- <th class="text-center"> Action</th> --}}
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
