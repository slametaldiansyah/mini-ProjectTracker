@extends('layout.v_template')
@section('title', 'Edit Contract')
@push('custom-css')
<!-- Toastr -->
<link rel="stylesheet" href="{{asset('assets/')}}/plugins/toastr/toastr.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet"
    href="{{asset('assets/')}}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
@endpush
@section('content')
<div class="container">
    <div class="col-md">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Contract</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="myFormId" role="form" action="/contracts/{{$contract->id}}" method="post"
                enctype="multipart/form-data">
                @method('patch')
                @csrf
                <div class="card-body">
                    <div class="form">
                        <div class="d-flex justify-content-around">
                            <div class="form-group col-4">
                                <label for="name">Contract Name</label>

                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{old('name', $contract->name)}}" placeholder="Enter name"
                                    readonly>
                                @error('name')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror

                            </div>
                            <div class="form-group col-4">
                                <label>Client</label>
                                <select name="client_id" class="form-control @error('client_id') is-invalid @enderror"
                                    {{ $contract['client_id'] ? 'disabled' : '' }}>
                                    <option>--option--</option>
                                    @foreach($clients as $client)
                                    <option value="{{$client->id}}"
                                        {{old('client_id', $contract->client_id) == $client->id ? 'selected': null}}>
                                        {{$client->name}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="form-group col-4">
                                <label for="cont_num">No. Contract</label>
                                <input type="number" class="form-control  @error('cont_num') is-invalid @enderror"
                                    id="cont_num" name="cont_num" value="{{old('cont_num', $contract->cont_num)}}"
                                    placeholder="Enter No. Contract" {{ $contract['cont_num'] ? 'disabled' : '' }}>
                                @error('cont_num')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group col-2">
                                <label>Type</label><label style="color:#dc3545;">*</label>
                                <select id="type" name="type_id" class="form-control @error('type_id') is-invalid @enderror"
                                 onchange="myType()">
                                    <option value="">--option--</option>
                                    @foreach($types as $type)
                                    <option id="op" value="{{$type->id}}" data-name="{{$type->name}}"
                                        data-display="{{$type->display}}"
                                        {{old('type_id', $contract->type_id) == $type->id ? 'selected': null}}>{{$type->name}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label>Contract Sign Date</label>
                                <div class="input-group date" id="signdate" data-target-input="nearest">
                                    <input type="text"
                                        class="form-control  @error('sign_date') is-invalid @enderror datetimepicker-input"
                                        data-target="#signdate" name="sign_date" id="sign_date"
                                        value="{{old('sign_date', $contract->sign_date)}}" placeholder="dd/mm/yyyy"
                                        {{ $contract['sign_date'] ? 'disabled' : '' }} />
                                    <div class="input-group-append" data-target="#signdate"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    @error('sign_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="row col-6">
                                <div id="IsVolumeUnit" class="row col-12" style="display:{{$typecek->type->display}}">
                                    <div class="form-group col-8">
                                        <label for="volume">Volume</label>
                                        <input type="number" class="form-control @error('volume') is-invalid @enderror"
                                            id="volume" name="volume" value="{{old('volume', $contract->volume)}}"
                                            placeholder="Enter volume" {{ $contract['volume'] ? 'disabled' : '' }}>
                                        @error('volume')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="unit">Unit</label>
                                        <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit"
                                            name="unit" value="{{old('unit', $contract->unit)}}" placeholder="ex: Mandays..."
                                            {{ $contract['unit'] ? 'disabled' : '' }}>
                                        @error('unit')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label for="paire">Price</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" placeholder="Rp." value="{{old('price', $contract->price)}}"
                                    {{ $contract['price'] ? 'disabled' : '' }}>
                                @error('price')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <div class="form-group col-4">
                                <label>Start Date</label>
                                <div class="input-group date" id="startdate" data-target-input="nearest">
                                    <input type="text"
                                        class="form-control @error('start_date') is-invalid @enderror datetimepicker-input"
                                        data-target="#startdate" name="start_date" placeholder="YYYY-MM-DD"
                                        value="{{old('start_date', $contract->start_date)}}"
                                        {{ $contract['start_date'] ? 'disabled' : '' }} />
                                    <div class="input-group-append" data-target="#startdate"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    @error('start_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label>End Date</label>
                                <div class="input-group date" id="enddate" data-target-input="nearest">
                                    <input type="text"
                                        class="form-control @error('end_date') is-invalid @enderror datetimepicker-input"
                                        data-target="#enddate" name="end_date" placeholder="YYYY-MM-DD"
                                        value="{{old('end_date', $contract->end_date)}}"
                                        {{ $contract['end_date'] ? 'disabled' : '' }} />
                                    <div class="input-group-append" data-target="#enddate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    @error('end_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="form-group col-4">
                                <label for="filename">Upload Doc</label>
                                <input type="file" class="form-control @error('filename') is-invalid @enderror"
                                    id="filename" name="filename[]" value="{{old('filename')}}" multiple>
                                @error('filename')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-4"></div>
                            <div class="form-group col-2">
                                {{-- <label for="created_by">Created by</label>
                                <input type="number" class="form-control @error('created_by') is-invalid @enderror"
                                    id="created_by" name="created_by"
                                    value="{{old('created_by', $contract->created_by)}}"
                                    {{ $contract['created_by'] ? 'disabled' : '' }}> --}}
                            </div>
                        </div>
                        @foreach($filename as $file)
                        <div class="d-flex justify-content-center" name="refresh-after-ajax" id="refresh-after-ajax">
                            <a href="{{ asset('docs') }}/{{$file->filename}}" class="form-group col-4">
                                {{$file->filename}}
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer mt-2 text-center">
                    <a href="/contracts" type="submit" class="btn btn-danger">Back</a>
                    <button id="myButtonID" type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('custom-js')
<!-- Toastr -->
<script src="{{asset('assets/')}}/plugins/toastr/toastr.min.js"></script>
<!-- DataTables -->
<script src="{{asset('assets/')}}/plugins/datatables/jquery.dataTables.js"></script>
<!-- InputMask -->
<script src="{{asset('assets/')}}/plugins/moment/moment.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('assets/')}}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
@endpush
@push('custom-script')
@if (session('errorUpload'))
<script>
toastr.error("{{session('errorUpload')}}");
</script>
@endif
<script>
$('#myFormId').submit(function() {
    $("#myButtonID", this)
        .html("Please Wait...")
        .attr('disabled', 'disabled');
    return true;
});
</script>
<script>
$(function() {
    $('#signdate').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD',
    });
    $('#startdate').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD'
    });
    $('#enddate').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD'
    });
});
</script>
<script>
    function myType(){
        var x = document.getElementById("type").value;
        var op = document.getElementById("type");
        var name = op.options[op.selectedIndex].getAttribute('data-name');
        var display = op.options[op.selectedIndex].getAttribute('data-display');
        console.log(op.options[op.selectedIndex].getAttribute('data-display'))
        if (x != 0) {
        document.getElementById("IsVolumeUnit").style.display = display;
        }
    }
</script>
@endpush
