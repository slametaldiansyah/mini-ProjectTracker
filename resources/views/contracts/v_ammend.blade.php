@extends('layout.v_template')
@section('title', 'Ammend Contract')
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
                <h3 class="card-title">Ammend Contract</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="myFormId" role="form" action="/contracts/{{$contract->id}}" enctype="multipart/form-data"
                method="post" onsubmit="return confirm('are you sure you want to do ammend?')">
                @method('put')
                @csrf
                <div class="card-body">
                    <div class="form">
                        <div class="d-flex justify-content-around">
                            <div class="form-group col-4">
                                <label for="name">Contract Name</label><label style="color:#dc3545;">*</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{old('name', $contract->name)}}" placeholder="Enter name">
                                @error('name')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label>Client</label><label style="color:#dc3545;">*</label>
                                <select name="client_id" class="form-control @error('client_id') is-invalid @enderror">
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
                                <label for="cont_num">No. Contract</label><label style="color:#dc3545;">*</label>
                                <input type="number" class="form-control  @error('cont_num') is-invalid @enderror"
                                    id="cont_num" name="cont_num" value="{{old('cont_num', $contract->cont_num)}}"
                                    placeholder="Enter No. Contract">
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
                                        value="{{old('sign_date', $contract->sign_date)}}" placeholder="dd/mm/yyyy" />
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
                                            placeholder="Enter volume">
                                        @error('volume')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="unit">Unit</label>
                                        <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit"
                                            name="unit" value="{{old('unit', $contract->unit)}}" placeholder="ex: Mandays...">
                                        @error('unit')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label for="paire">Price</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" placeholder="Rp."
                                    value="{{old('price', $contract->price)}}">
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
                                        value="{{old('start_date', $contract->start_date)}}" />
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
                                        value="{{old('end_date', $contract->end_date)}}" />
                                    <div class=" input-group-append" data-target="#enddate"
                                        data-toggle="datetimepicker">
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
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-4"></div>
                        </div>
                        @foreach($filename as $file)
                        <div class="d-flex justify-content-center" name="refresh-after-ajax" id="refresh-after-ajax">
                            <a href="{{ asset('docs') }}/{{$file->filename}}" class="form-group col-4">
                                {{$file->filename}}
                            </a>
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <a type="button" name="delete" data-id="{{ $file->id }}" class="deleteRecord">
                                <i class="nav-icon fas fa-trash" style="color:#dc3545;"></i>
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
<script>
$('#myFormId').submit(function() {
    $("#myButtonID", this)
        .html("Please Wait...")
        .attr('disabled', 'disabled');
    return true;
});
</script>
@if (session('errorUpload'))
<script>
toastr.error("{{session('errorUpload')}}");
</script>
@endif
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
$(".deleteRecord").click(function() {
    var id = $(this).data("id");
    var token = $("meta[name='csrf-token']").attr("content");
    var result = confirm("Want to delete?");
    if (result) {
        $.ajax({
            url: "/contract_doc/" + id,
            type: 'post',
            data: {
                "id": id,
                "_token": token,
            },
            success: function(data) {
                console.log(data.success);
                location.reload();
            }
        });

    }

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
