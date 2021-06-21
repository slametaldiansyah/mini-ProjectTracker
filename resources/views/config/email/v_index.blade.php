@extends('layout.v_template')
@section('title', 'List Config Email')
@push('custom-css')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('assets/')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<!-- Dropdown-item -->
<link rel="stylesheet" href="{{asset('assets/')}}/dist/css/custom/dropdowncustom.css">

<link href="{{asset('assets/')}}/costume/tablecostume.css" rel="stylesheet">
<link href="{{asset('assets/')}}/costume/switchcostume.css" rel="stylesheet">
<!-- RadioButton -->
<link href="{{asset('assets/')}}/costume/radiobuttoncostume.css" rel="stylesheet">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('assets/')}}/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="{{asset('assets/')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

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
            {{-- <div class="card-header text-right"> --}}
                {{-- <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#email-create">Create config Email</button> --}}
                {{-- <a href="email_configuration/show">cek</a> --}}
             {{-- </div> --}}
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th class="text-center">Frequency</th>
                            <th class="text-center">Duration</th>
                            <th class="text-center">Emails</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ec as $e)
                        <tr>
                            <th class="text-center" width="30px">{{$loop->iteration}}</th>
                            <td class="text-center">{{$e->frequency->name}}</td>
                            {{-- @if ($e->frequency->name == 'Day')
                            <td class="text-center">{{$e->duration}}:00</td>
                            @endif --}}
                            @if ($e->frequency->name == 'Day')
                            <td class="text-center">{{$e->duration}}:00</td>
                            @elseif($e->frequency->name == 'Month')
                            <td class="text-center">{{$e->duration}}th</td>
                            @elseif($e->frequency->name == 'Week')
                            <td class="text-center">Day {{$e->duration}}</td>
                            @endif
                            <td class="text-center">
                                {{-- {{$e->email}} --}}
                                <div class="btn-group">
                                    <button id="typeEdit" class="btn btn-warning btn-sm dropdown-hover"
                                    data-toggle="modal" data-target="#show-email"
                                    data-id="{{$e->id}}"
                                    onclick="emailShow(this)">
                                        <i class="nav-icon fas fa-eye"></i>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item">Cek Email</a>
                                        </div>
                                    </button>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button id="typeEdit" class="btn btn-primary btn-sm dropdown-hover"
                                    data-toggle="modal" data-target="#email-edit"
                                    data-id="{{$e->id}}"
                                    data-freq-id="{{$e->frequency->id}}"
                                    data-duration="{{$e->duration}}"
                                    data-email-id="{{$e->email}}"
                                    onclick="editData(this)">
                                        <i class="nav-icon fas fa-pen"></i>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item">Edit</a>
                                        </div>
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <form action="/email_configuration/{{$e->id}}"
                                        onsubmit="return confirm('Are you sure you want to delete?')" method="post"
                                        class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm dropdown-hover">
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
                            <th width="30px">No</th>
                            <th class="text-center">Frequency</th>
                            <th class="text-center">Duration</th>
                            <th class="text-center">Emails</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- @include('config.email.modal.m_create') --}}
@include('config.email.modal.m_edit')
@include('config.email.modal.m_show_email')
{{-- @include('config.typecontract.modal.m_edit') --}}
@endsection
@push('custom-js')
<!-- DataTables -->
<script src="{{asset('assets/')}}/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{asset('assets/')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- Select2 -->
<script src="{{asset('assets/')}}/plugins/select2/js/select2.full.min.js"></script>
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
    function editData(e) {
        var id = $(e).data("id");
        var freqId = $(e).data("freq-id");
        var duration = $(e).data("duration");
        var emails = $(e).data("email-id");
        if (e != 0) {
        document.getElementById("id").value = id;
        var emailList = emails;
        var listEmail = [];
        emailList.forEach(myFunction);
        function myFunction(item, index) {
            listEmail.push(item.email);
        }
        if (freqId == 2) {
            document.getElementById("2").checked = true;
            document.getElementById("monthInput").style.display = "none";
            document.getElementById("weekInput").style.display = "none";
            document.getElementById("dayInput").style.display = "block";
            document.getElementById("day").value = duration;
            $(".select2bs4").select2().val(listEmail).trigger("change");
        } else if(freqId == 3) {
            document.getElementById("3").checked = true;
            document.getElementById("monthInput").style.display = "none";
            document.getElementById("dayInput").style.display = "none";
            document.getElementById("weekInput").style.display = "block";
            document.getElementById("week").value = duration;
            $(".select2bs4").select2().val(listEmail).trigger("change");
        } else if(freqId == 4){
            document.getElementById("4").checked = true;
            document.getElementById("dayInput").style.display = "none";
            document.getElementById("weekInput").style.display = "none";
            document.getElementById("monthInput").style.display = "block";
            document.getElementById("month").value = duration;
            $(".select2bs4").select2().val(listEmail).trigger("change");
        }else{
            alert('error');
        }
    }else{
    alert("error");
    }
    }
    //button submit
    $('#myFormIdEdit').submit(function() {
        $("#myButtonID", this)
            .html("Please Wait...")
            .attr('disabled', 'disabled');
        return true;
    });
    //Create
    $('#myFormIdCreate').submit(function() {
        $("#myButtonIDCreate", this)
            .html("Please Wait...")
            .attr('disabled', 'disabled');
        return true;
    });
</script>
<script type="text/javascript">
    @if (count($errors) > 0)
        $('#type-create').modal('show');
    @endif
</script>
<!-- Selected -->
<script>
$(document).on('change', 'input:radio', function () {
    if (this.value == 1) {
        // alert($(this).data("name"));
        document.getElementById("hourInput").style.display = "block";
        document.getElementById("dayInput").style.display = "none";
        document.getElementById("weekInput").style.display = "none";
        document.getElementById("monthInput").style.display = "none";
        document.getElementById("yearInput").style.display = "none";
    }else if(this.value == 2){
        document.getElementById("hourInput").style.display = "none";
        document.getElementById("dayInput").style.display = "block";
        document.getElementById("weekInput").style.display = "none";
        document.getElementById("monthInput").style.display = "none";
        document.getElementById("yearInput").style.display = "none";
    }else if(this.value == 3){
        document.getElementById("hourInput").style.display = "none";
        document.getElementById("dayInput").style.display = "none";
        document.getElementById("weekInput").style.display = "block";
        document.getElementById("monthInput").style.display = "none";
        document.getElementById("yearInput").style.display = "none";
    }else if(this.value == 4){
        document.getElementById("hourInput").style.display = "none";
        document.getElementById("dayInput").style.display = "none";
        document.getElementById("weekInput").style.display = "none";
        document.getElementById("monthInput").style.display = "block";
        document.getElementById("yearInput").style.display = "none";
    }else if(this.value == 5){
        document.getElementById("hourInput").style.display = "none";
        document.getElementById("dayInput").style.display = "none";
        document.getElementById("weekInput").style.display = "none";
        document.getElementById("monthInput").style.display = "none";
        document.getElementById("yearInput").style.display = "block";
    }else{
        document.getElementById("hourInput").style.display = "none";
        document.getElementById("dayInput").style.display = "none";
        document.getElementById("weekInput").style.display = "none";
        document.getElementById("monthInput").style.display = "none";
        document.getElementById("yearInput").style.display = "none";
    }
    });
    //hour
    $(function(){
    var $select = $(".hourNum");
    var n = ' Hour';
    for (i=0;i<=24;i++){
        $select.append($('<option></option>').val(i).html(i+n))
    }
    });
    //day
    $(function(){
    var $select = $(".dayNum");
    var n = ':00';
    for (i=0;i<=24;i++){
        $select.append($('<option></option>').val(i).html(i+n))
    }
    });
    //week
    $(function(){
    var $select = $(".weekNum");
    var n = 'Day ';
    for (i=0;i<=7;i++){
        $select.append($('<option></option>').val(i).html(n+i))
    }
    });
    //month
    $(function(){
    var $select = $(".monthNum");
    // var n = '';
    for (i=0;i<=31;i++){
        $select.append($('<option></option>').val(i).html(i))
    }
    });
    //year
    $(function(){
    var $select = $(".yearNum");
    var n = ' Year';
    for (i=0;i<=5;i++){
        $select.append($('<option></option>').val(i).html(i+n))
    }
    });

    //Multiple Select
    $(document).ready(function() {
        var value = $(".select2bs4").select2();
        $(".select2bs4").val(value).trigger('change');
    });


    $.ajax({
        type: "GET",
        url: "email_configuration/show",
        cache: "false",
        dataType: "json",
        success: function(data) {
        //   console.log(data.data[0]['email']);
            // Get select
            var select = document.getElementById('select2bs4');
            // Add options
            for (var i in data.data) {
                $(select).append('<option value=' + data.data[i]['email'] + '>' + data.data[i]['email'] + '</option>');
            }
        // Set selected value
        // $(select).val(data[1]);
    }
    });
</script>
<script type="text/javascript">
    @if (count($errors) > 0)
        $('#email-create').modal('show');
    @endif
</script>
<script>
    function emailShow(e) {
        var EmailConfigId = $(e).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        if (e) {
            $('#aldiTable').DataTable({
            processing: true,
            // serverSide: true,
            destroy: true,
            responsive: true,
            ajax: {
            url: "/email/show" + EmailConfigId,
            type: 'get',
            data: {
                "id": EmailConfigId,
                "_token": token,},
                // "dataSrc": "dataPay"
                dataSrc: function(json) {
                    if ( json.dataE === null ) {
                        return [];
                    }
                    // var amount = JSON.parse(json.dataPay);
                    // console.log(json.dataE);
                    return json.dataE;
                    }
            },
            columns: [
                    {data: "id"},
                    {data: "email",  className: "text-center"}
                    ],
            "columnDefs": [
                        {
                        "data": null
                        }

                    ],
            language: {
                search : '<i class="fas fa-search"></i>',
                searchPlaceholder: "Search",
                'paginate': {
                    'previous': '<a>Back <i class="fas fa-hand-point-left"></i></a>',
                    'next': '<a><i class="fas fa-hand-point-right"></i> Next</a>',
                    }}
        });
    }
    }
</script>

@endpush
