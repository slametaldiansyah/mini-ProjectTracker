@extends('layout.v_template')
@section('title', 'Ammend Project')
@push('custom-css')
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
                <h3 class="card-title">Ammend Project</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="myFormId" role="form" action="/projects/{{$project->id}}" method="post"
                onsubmit="return confirm('are you sure you want to do ammend?')">
                @method('put')
                @csrf
                <div class="card-body">
                    <div class="form">
                        <div class="d-flex justify-content-center">
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Contract Refference</label>
                                    <select id="contra" name="contract_id"
                                        class="form-control @error('contract_id') is-invalid @enderror"
                                        onchange="myFunction()">
                                        <option value="">No Contract</option>
                                        @foreach($contracts as $contract)
                                        <option value="{{$contract->id}}" data-name="{{$contract->name}}"
                                            data-cont_num="{{$contract->cont_num}}"
                                            data-client_id="{{$contract->client_id}}"
                                            data-volume="{{$contract->volume}}" data-unit="{{$contract->unit}}"
                                            data-price="{{$contract->price}}" data-sign_date="{{$contract->sign_date}}"
                                            data-start_date="{{$contract->start_date}}"
                                            data-end_date="{{$contract->end_date}}"
                                            {{old('contract_id', $project->contract_id) == $contract->id ? 'selected': null}}>
                                            {{$contract->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('contract_id')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="fivedashedblack">
                            <div class="mt-3 d-flex justify-content-center">
                                <div id="nocontract" class="alert alert-danger" style="display:block">
                                    <strong>Info!</strong> Not Found!
                                </div>

                                <div id="Iscontract" class="alert alert-success" style="display:none">
                                    <div class="form">
                                        <div class="d-flex justify-content-around">
                                            <div class="form-group col-4">
                                                <label for="name_contract">Contract Name</label>
                                                <input type="text" class="form-control" id="name_contract"
                                                    name_contract="name_contract" value="" disabled="disabled">
                                            </div>
                                            <div class="form-group col-4">
                                                <label>Client</label>
                                                <select id=client_id name="client_id" class="form-control"
                                                    disabled="disabled">
                                                    <option>--option--</option>
                                                    @foreach($clients as $client)
                                                    <option value="{{$client->id}}"
                                                        {{old('client_id', $contract->client_id) == $client->id ? 'selected': null}}>
                                                        {{$client->name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-around">
                                            <div class="form-group col-4">
                                                <label for="cont_num">No. Contract</label>
                                                <input type="number" class="form-control" id="cont_num" name="cont_num"
                                                    value="" disabled="disabled">
                                            </div>
                                            <div class="form-group col-4">
                                                <label>Contract Sign Date</label>
                                                <div class="input-group date" id="signdate" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#signdate" name="sign_date" id="sign_date"
                                                        value="no data" disabled="disabled" />
                                                    <div class="input-group-append">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <div class="form-group col-4">
                                                <label for="volume">Volume</label>
                                                <input type="text" class="form-control" id="volume" name="volume"
                                                    value="no data" disabled="disabled">
                                            </div>
                                            <div class="form-group col-2">
                                                <label for="unit">Unit</label>
                                                <input type="text" class="form-control" id="unit" name="unit"
                                                    value="no data" disabled="disabled">
                                            </div>
                                            <div class="form-group col-4">
                                                <label for="price_contract">Price</label>
                                                <input type="number" class="form-control" id="price_contract"
                                                    name="price_contract" value="" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-around">
                                            <div class="form-group col-4">
                                                <label>Start Date</label>
                                                <div class="input-group date" id="startdate"
                                                    data-target-input="nearest">
                                                    <input type="text" class="form-control" data-target="#startdate"
                                                        name="start_date" value="" id="start_date"
                                                        disabled="disabled" />
                                                    <div class="input-group-append">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-4">
                                                <label>End Date</label>
                                                <div class="input-group date" id="enddate" data-target-input="nearest">
                                                    <input type="text" class="form-control" data-target="#enddate"
                                                        name="end_date" value="" id="end_date" disabled="disabled" />
                                                    <div class=" input-group-append">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <div class="form-group col-4">
                                <label for="name">Project Name</label><label style="color:#dc3545;">*</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{old('name', $project->name)}}" name="name"
                                    placeholder="Enter project name">
                                @error('name')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for=no_po>No. PO</label>
                                <input type="number" class="form-control @error('no_po') is-invalid @enderror"
                                    name="no_po" id="no_po" value="{{old('no_po', $project->no_po)}}"
                                    placeholder="Enter no. po">
                                @error('no_po')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <div class="form-group col-4">
                                <label>Project Sign Date</label>
                                <div class="input-group date" id="po_sign_date" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input"
                                        data-target="#po_sign_date" name="po_sign_date" placeholder="dd/mm/yyyy"
                                        value="{{old('po_sign_date', $project->po_sign_date)}}" />
                                    <div class="input-group-append" data-target="#po_sign_date"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" name="price" id="price"
                                    value="{{old('price', $project->price)}}" placeholder="Rp." onchange="math()">
                            </div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <div class="form-group col-4">
                                <label>Start Date</label>
                                <div class="input-group date" id="po_start_date" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input"
                                        data-target="#po_start_date" name="po_start_date"
                                        value="{{old('po_start_date', $project->po_start_date)}}"
                                        placeholder="dd/mm/yyyy" />
                                    <div class="input-group-append" data-target="#po_start_date"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label>End Date</label>
                                <div class="input-group date" id="po_end_date" data-target-input="nearest">
                                    <input type="text" name="po_end_date" class="form-control datetimepicker-input"
                                        data-target="#po_end_date" value="{{old('po_end_date', $project->po_end_date)}}"
                                        placeholder="dd/mm/yyyy" />
                                    <div class="input-group-append" data-target="#po_end_date"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <div class="form-group col-4" id="hiddvolume">
                                <label for="volume_use">Volume Use</label>
                                <input id="volume_use" type="number"
                                    class="form-control @error('volume_use') is-invalid @enderror" name="volume_use"
                                    value="{{old('volume_use', $project->volume_use)}}" placeholder="Enter volume use.."
                                    onchange="math()">
                                @error('volume_use')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="total_price">Total Price</label>
                                <input type="number" name="total_price"
                                    value="{{old('total_price', $project->total_price)}}" class="form-control"
                                    id="total_price" placeholder="Rp." onchange="math()">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="form-group col-4"></div>
                       <!--     <div class="form-group col-2">
                                <label for="edit_by">Edit by</label><label style="color:#dc3545;">*</label>
                                <input type="number" class="form-control @error('edit_by') is-invalid @enderror"
                                    id="edit_by" name="edit_by" value="{{old('edit_by')}}">
                                @error('edit_by')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div> -->
                        </div>
                        <div class="card-header mt-4 d-flex justify-content-center">
                            <h3 class="card-title font-weight-bold">Progress</h3>
                        </div>
                        @if (session('statusProgress'))
                        <div class="alert alert-danger  d-flex justify-content-center">
                            {{ session('statusProgress') }}
                        </div>
                        @endif
                        <table class=" table table-borderless d-flex justify-content-center" id="dynamicProgress">
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">% Invoice</th>
                                <th><a type="button" name="add" class="btn btn-success" id="add-btn">+</a></th>
                            </tr>
                            @foreach($progress_item as $progress)
                            <tr>
                                <td>
                                    <input type="text" name="name_progress[]"
                                        value="{{old('name_progress[]', $progress->name_progress)}}"
                                        placeholder="Enter name" class="form-control"
                                        {{ $progress['name_progress'] || $progress['payment_percentage'] ? 'disabled' : '' }}></input>
                                </td>
                                <td>
                                    <input type="number" name="payment_percentage[]"
                                        value="{{old('payment_percentage[]', $progress->payment_percentage)}}"
                                        placeholder="Enter % invoice" class="form-control"
                                        {{ $progress['payment_percentage'] || $progress['name_progress'] ? 'disabled' : '' }}></input>
                                </td>
                                <td>
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <a name="delete" data-id="{{ $progress->id }}" type="button"
                                        class="btn btn-danger removeItem-tr">-</a>
                                </td>
                            </tr>
                            @endforeach
                            @foreach(old('name_progress', []) as $dataProgress)
                            <tr>
                                <td><input type="text" name="name_progress[]"
                                        value="{{old('name_progress')[$loop->index]}}" placeholder="Enter name"
                                        class="form-control" />
                                </td>
                                <td><input type="number" name="payment_percentage[]"
                                        value="{{old('payment_percentage')[$loop->index]}}"
                                        placeholder="Enter % invoice" class="form-control" />
                                </td>
                                <td><a type="button" class="btn btn-danger remove-tr">-</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        <div class="card-header d-flex justify-content-center mt-4">
                            <h3 class="card-title font-weight-bold">Costing</h3>
                        </div>
                        @if (session('statusCost'))
                        <div class="alert alert-danger  d-flex justify-content-center">
                            {{ session('statusCost') }}
                        </div>
                        @endif
                        <table class="table table-borderless d-flex justify-content-center" id="dynamicCosting">
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Desc</th>
                                <th class="text-center">Cost</th>
                                <th><a type="button" name="addcost" id="add-btnCost" class="btn btn-success">+</a>
                                </th>
                            </tr>
                            @foreach($project_cost as $cost)
                            <tr>
                                <td><input type="text" name="name_cost[]"
                                        value="{{old('name_cost[]', $cost->name_cost)}}" placeholder="Enter name"
                                        class="form-control"
                                        {{ $cost['name_cost'] || $cost['desc'] || $cost['total_cost']? 'disabled' : '' }} />
                                </td>
                                <td><input type="text" name="desc[]" value="{{old('desc[]', $cost->desc)}}"
                                        placeholder="Enter desc" class="form-control"
                                        {{ $cost['desc'] || $cost['name_cost'] || $cost['total_cost']? 'disabled' : '' }} />
                                </td>
                                <td><input type="number" name="total_cost[]"
                                        value="{{old('total_cost[]', $cost->total_cost)}}" placeholder="Total cost"
                                        class="form-control"
                                        {{ $cost['total_cost'] || $cost['desc'] || $cost['name_cost'] ? 'disabled' : '' }} />
                                </td>
                                <td>
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <a type="button" data-id="{{ $cost->id }}"
                                        class="btn btn-danger removeCostData-tr">-</a>
                                </td>
                            </tr>
                            @endforeach
                            @foreach(old('name_cost', []) as $dataCost)
                            <tr>
                                <td><input type="text" name="name_cost[]" value="{{old('name_cost')[$loop->index]}}"
                                        placeholder="Enter name" class="form-control" />
                                </td>
                                <td><input type="text" name="desc[]" value="{{old('desc')[$loop->index]}}"
                                        placeholder="Enter desc" class="form-control" />
                                </td>
                                <td><input type="number" name="total_cost[]" value="{{old('total_cost')[$loop->index]}}"
                                        placeholder="Total cost" class="form-control" />
                                </td>
                                <td><a type="button" class="btn btn-danger removeCost-tr">-</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="card-footer mt-5 text-center">
                    <a href="/projects" type="submit" class="btn btn-danger">Back</a>
                    <button id="myButtonID" type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('custom-js')
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
<script>
$(function() {
    $('#po_sign_date').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD',
    });
    $('#po_start_date').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD'
    });
    $('#po_end_date').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD'
    });
});
</script>
<script type="text/javascript">
$("#add-btn").click(function() {
    var tr = '<tr>' +
        '<td>' +
        '<input type="text" name="name_progress[]" value="{{old(' + name_progress +
        ')}}" placeholder="Enter name" class="form-control" /></td>' +
        '<td><input type = "number" name = "payment_percentage[]"  value="{{old(' + payment_percentage +
        ')}}" placeholder = "Enter % invoice" class = "form-control" />' +
        '</td>' +
        '<td><a type="button" class="btn btn-danger remove-tr">-</a></td>' +
        '</tr>';;
    $("#dynamicProgress").append(tr);
});
$(document).on('click', '.remove-tr', function() {
    $(this).parents('tr').remove();
});
$(document).on('click', '.removeItem-tr', function() {
    var id = $(this).data("id");
    var token = $("meta[name='csrf-token']").attr("content");
    var result = confirm("Want to delete Progress?");
    if (result) {
        $.ajax({
            url: "/progress_item/" + id,
            type: 'post',
            data: {
                "id": id,
                "_token": token,
            },
            success: function(data) {
                console.log(data);
                //location.reload();
            }
        });

        $(this).parents('tr').remove();
    }

});
</script>
<script type="text/javascript">
$("#add-btnCost").click(function() {
    var tr = '<tr>' +
        '<td>' +
        '<input type="text" name="name_cost[]" value="{{old(' + name_cost +
        ')}}" placeholder="Enter name" class="form-control" /></td>' +
        '<td><input type="text" name="desc[]" value="{{old(' + desc +
        ')}}" placeholder="Enter desc" class="form-control" />' +
        '</td>' +
        '<td><input type="number" name="total_cost[]" value="{{old(' + total_cost +
        ')}}" placeholder="Total cost" class="form-control" /></td>' +
        '<td><a type="button" class="btn btn-danger remove-tr">-</a></td>' +
        '</tr>';
    $("#dynamicCosting").append(tr);
});
$(document).on('click', '.removeCost-tr', function() {
    $(this).parents('tr').remove();
});
$(document).on('click', '.removeCostData-tr', function() {
    var id = $(this).data("id");
    var token = $("meta[name='csrf-token']").attr("content");
    var result = confirm("Want to delete Cost?");
    if (result) {
        $.ajax({
            url: "/project_cost/" + id,
            type: 'post',
            data: {
                "id": id,
                "_token": token,
            },
            success: function() {
                console.log("it Works");
            }
        });
        $(this).parents('tr').remove();
    }
});
</script>
<script>
function myFunction() {
    var x = document.getElementById("contra").value;
    var op = document.getElementById("contra");
    var name = op.options[op.selectedIndex].getAttribute('data-name');
    var cont_num = op.options[op.selectedIndex].getAttribute('data-cont_num');
    var client_id = op.options[op.selectedIndex].getAttribute('data-client_id');
    var volume = op.options[op.selectedIndex].getAttribute('data-volume');
    var unit = op.options[op.selectedIndex].getAttribute('data-unit');
    var price = op.options[op.selectedIndex].getAttribute('data-price');
    var sign_date = op.options[op.selectedIndex].getAttribute('data-sign_date');
    var start_date = op.options[op.selectedIndex].getAttribute('data-start_date');
    var end_date = op.options[op.selectedIndex].getAttribute('data-end_date');

    console.log(op.options[op.selectedIndex].getAttribute('data-name'))
    if (x) {
        document.getElementById("nocontract").style.display = "none";
        document.getElementById("Iscontract").style.display = "block";
        document.getElementById("name_contract").value = name;
        document.getElementById('client_id').value = client_id;
        document.getElementById("cont_num").value = cont_num;
        document.getElementById("sign_date").value = sign_date;
        document.getElementById("volume").value = volume;
        document.getElementById("unit").value = unit;
        document.getElementById("price_contract").value = price;
        document.getElementById("start_date").value = start_date;
        document.getElementById("end_date").value = end_date;
        document.getElementById("hiddvolume").style.visibility = "visible";
    } else {
        document.getElementById("nocontract").style.display = "block";
        document.getElementById("volume_use").value = "";
        document.getElementById("Iscontract").style.display = "none";
        document.getElementById("hiddvolume").style.visibility = "hidden";
    }
}
myFunction();
</script>
<script>
function math() {
    var a = parseInt(document.getElementById("price").value);
    var b = parseInt(document.getElementById("volume_use").value);
    if (a && b) {
        document.getElementById("total_price").value = a * b;
    }
}
</script>
@endpush