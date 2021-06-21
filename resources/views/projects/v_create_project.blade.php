@extends('layout.v_template')
@section('title', 'Create Project')
@push('custom-css')
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet"
    href="{{asset('assets/')}}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
@endpush
@section('content')
<!-- Main content -->
<div class="container">
    <div class="col-md">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create Project</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="myFormId" role="form" action="/projects" method="post">
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
                                        <option id="op" value="{{$contract->id}}" data-name="{{$contract->name}}"
                                            data-cont_num="{{$contract->cont_num}}"
                                            data-client_id="{{$contract->client_id}}"
                                            data-volume="{{$contract->volume}}" data-unit="{{$contract->unit}}"
                                            data-price="{{$contract->price}}" data-sign_date="{{$contract->sign_date}}"
                                            data-start_date="{{$contract->start_date}}"
                                            data-end_date="{{$contract->end_date}}"
                                            data-type_id="{{$contract->type_id}}" data-type_display="{{$contract->type->display}}"
                                            @if (old('contract_id')==$contract->id)
                                            selected="selected" @endif >
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
                                        <div class="d-flex justify-content-center">
                                            <div class="form-group col-4">
                                                <label for="cont_num">No. Contract</label>
                                                <input type="number" class="form-control" id="cont_num" name="cont_num"
                                                    value="" disabled="disabled">
                                            </div>
                                            <div class="form-group col-3">
                                                <label>Type</label>
                                                <select id="type_id" name="type_id" class="form-control @error('type_id') is-invalid @enderror"
                                                disabled="disabled">
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
                                            <div class="form-group col-3">
                                                <label>Contract Sign Date</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" name="sign_date"
                                                        id="sign_date" value="no data" disabled="disabled" />
                                                    <div class="input-group-append">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <div class="row col-6">
                                                <div id="IsVolumeUnit" class="row col-12" style="display:{{$typecek->type->display}}">
                                                    <div class="form-group col-8">
                                                        <label for="volume">Volume</label>
                                                        <input type="text" class="form-control" id="volume" name="volume"
                                                            value="no data" disabled="disabled">
                                                    </div>
                                                    <div class="form-group col-4">
                                                        <label for="unit">Unit</label>
                                                        <input type="text" class="form-control" id="unit" name="unit"
                                                            value="no data" disabled="disabled">
                                                    </div>
                                                </div>
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
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" name="start_date" value=""
                                                        id="start_date" disabled="disabled" />
                                                    <div class="input-group-append">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-4">
                                                <label>End Date</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" name="end_date" value=""
                                                        id="end_date" disabled="disabled" />
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

                        <div class="d-flex justify-content-around mt-5">
                            <div class="form-group col-4">
                                <label for="name">Project Name</label><label style="color:#dc3545;">*</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{old('name')}}" name="name" placeholder="Enter project name">
                                @error('name')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for=no_po>No. PO</label>
                                <input type="number" class="form-control @error('no_po') is-invalid @enderror"
                                    name="no_po" id="no_po" value="{{old('no_po')}}" placeholder="Enter no. po">
                                @error('no_po')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <div class="form-group col-4">
                                <label for="po_sign_date">Project Sign Date</label>
                                <div class="input-group date" id="po_sign_date" data-target-input="nearest">
                                    <input type="text" class="form-control @error('po_sign_date') is-invalid @enderror datetimepicker-input"
                                        data-target="#po_sign_date" name="po_sign_date" placeholder="dd/mm/yyyy"
                                        value="{{old('po_sign_date')}}" />
                                    <div class="input-group-append" data-target="#po_sign_date"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    @error('po_sign_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" name="price" id="price"
                                    value="{{old('price')}}" placeholder="Rp." onchange="math()">
                            </div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <div class="form-group col-4">
                                <label for="po_start_date">Start Date</label>
                                <div class="input-group date" id="po_start_date" data-target-input="nearest">
                                    <input type="text" class="form-control @error('po_start_date') is-invalid @enderror datetimepicker-input"
                                        data-target="#po_start_date" name="po_start_date"
                                        value="{{old('po_start_date')}}" placeholder="dd/mm/yyyy" />
                                    <div class="input-group-append" data-target="#po_start_date"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    @error('po_start_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label for="po_end_date">End Date</label>
                                <div class="input-group date" id="po_end_date" data-target-input="nearest">
                                    <input type="text" name="po_end_date" class="form-control @error('po_end_date') is-invalid @enderror datetimepicker-input"
                                        data-target="#po_end_date" value="{{old('po_end_date')}}"
                                        placeholder="dd/mm/yyyy" />
                                    <div class="input-group-append" data-target="#po_end_date"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    @error('po_end_date')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <div class="form-group col-4" style="
                                    visibility:hidden" id=hiddvolume>
                                <label for="volume_use">Volume Use</label>
                                <input id="volume_use" type="number"
                                    class="form-control @error('volume_use') is-invalid @enderror" name="volume_use"
                                    placeholder="Enter volume use.." value="{{old('volume_use')}}" onchange="math()">
                                @error('volume_use')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="total_price">Total Price</label>
                                <input type="number" name="total_price" class="form-control"
                                    value="{{old('total_price')}}" id="total_price" placeholder="Rp." onchange="math()">
                            </div>
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
                                <th><a type="button" name="add" id="add-btn" class="btn btn-success">+</a></th>
                            </tr>
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
                            @if(!old('name_progress'))
                            <tr>
                                <td>
                                    <input type="text" name="name_progress[]" placeholder="Enter name" value=""
                                        class="form-control" />
                                </td>
                                <td><input type="number" name="payment_percentage[]" value=""
                                        placeholder="Enter % invoice" class="form-control" />
                                </td>
                                <td><a type="button" class="btn btn-danger remove-tr">-</a></td>
                            </tr>
                            @endif
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
                            @if(!old('name_cost'))
                            <tr>
                                <td><input type="text" name="name_cost[]" value="" placeholder="Enter name"
                                        class="form-control" />
                                </td>
                                <td><input type="text" name="desc[]" value="" placeholder="Enter desc"
                                        class="form-control" />
                                </td>
                                <td><input type="number" name="total_cost[]" value="" placeholder="Total cost"
                                        class="form-control" />
                                </td>
                                <td><a type="button" class="btn btn-danger removeCost-tr">-</a>
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
                <div class="card-footer mt-5 text-center">
                    <a href="/projects" type="submit" class="btn btn-danger">Back</a>
                    <button id="myButtonID" type="submit" class="btn btn-primary">Submit</button>
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
        //disabled: true,
        format: 'YYYY-MM-DD',
    });
    //startdate
    $('#po_start_date').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD'
    });
    //enddate
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
        '</tr>';
    $("#dynamicProgress").append(tr);
});
$(document).on('click', '.remove-tr', function() {
    $(this).parents('tr').remove();
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
    var type_id = op.options[op.selectedIndex].getAttribute('data-type_id');
    var type_display = op.options[op.selectedIndex].getAttribute('data-type_display');
    console.log(op.options[op.selectedIndex].getAttribute('data-type_display'))
    if (x != 0) {
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
        document.getElementById('type_id').value = type_id;
        document.getElementById("IsVolumeUnit").style.display = type_display;
        if (type_display == "block") {
            document.getElementById("hiddvolume").style.visibility = "visible";
        }else{
            document.getElementById("hiddvolume").style.visibility = "hidden";
        }
    } else {
        document.getElementById("nocontract").style.display = "block";
        document.getElementById("Iscontract").style.display = "none";
        document.getElementById("volume_use").value = "";
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
