@extends('layout.v_template')
@section('title', 'Edit Operational & Cost-POxxxx')
@push('custom-css')
<!-- Toastr -->
<link rel="stylesheet" href="{{asset('assets/')}}/plugins/toastr/toastr.min.css">
@endpush
@section('content')
<div class="container">
    <div class="col-md">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">@yield('title')</h3>
            </div>
            <!-- /.card-header -->
            <form role="form" action="/operationals/{{$id}}"
                onsubmit="return confirm('Are you sure you want to Submit?')" method="post">
                @method('patch')
                @csrf
                <div class="card-body">
                    <div class="form">
                        <div class="d-flex justify-content-center">
                            <table class="table table-bordered" id="refresh-after-ajax">
                                <tr>
                                    <th class="text-center">Operational & Progress</th>
                                    <th class="text-center">Progress</th>
                                    <th class="text-center">Invoicing</th>
                                </tr>
                                <tr>
                                    @foreach($progress_items as $progress_item)
                                    <td>
                                        <div class="d-flex justify-content-around">
                                            <div class="form-group col-4">
                                                <p class="font-weight-bolder">
                                                    {{$progress_item->name_progress}}</p>
                                            </div>
                                            <div class="form-group col-4">

                                                <div class="input-group">
                                                    <a type="button" class="btn btn-primary"
                                                        value="/operationals/{{$progress_item->id}}" data-toggle="modal"
                                                        data-target="#exampleModal" data-id="{{$progress_item->id}}"
                                                        data-whatever="{{$progress_item->name_progress}}">Upload</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if(!$progress_item->status_id)
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <a data-name="status" data-id="{{$progress_item->id}}" data-on="Completed"
                                            data-off="inProgress" class="btn btn-primary changeStatus">inProgress</a>
                                        @else
                                        <i class="nav-icon fas fa-check text-success"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (!$progress_item->status_id)
                                        <a class="btn btn-secondary alertNotSet">in Progress</a>
                                        @else
                                        @if (!$progress_item->invoice_status_id)
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <a data-name="invoice_status" data-id="{{$progress_item->id}}" data-on="Completed"
                                            data-off="inProgress" class="btn btn-primary changeStatus">inProgress</a>
                                        @else
                                        <i class="nav-icon fas fa-check text-success"></i>
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <table class="table d-flex justify-content-center" id="refresh-after-ajax">
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">File Name</th>
                            </tr>
                            @foreach($progress_docs as $progress_doc)
                            <tr>
                                <td>{{$progress_doc->name_progress}}</td>
                                <td>
                                    @foreach($progress_doc->doc as $doc)
                                    <div class="d-flex justify-content-around">
                                        <div class="form-group col-12">
                                            <a href="{{ asset('progress_docs') }}/{{$doc->filename}}"
                                                class="form-group col">
                                                {{$doc->filename}}
                                            </a>
                                        </div>
                                        <div class="form-group col">
                                            <div class="input-group">
                                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                                <a type="button" data-id="{{ $doc->id }}" class="removedoc"><i
                                                        class="nav-icon fas fa-trash" style="color:#dc3545;"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        <div class=" card-header mt-4 d-flex justify-content-center">
                            <h3 class=" card-title font-weight-bold">Costing</h3>
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
                                <input type="hidden" name="cost_id[]" value="{{old('cost_id[]', $cost->id)}}">
                                <td><input type="text" name="name_cost[]"
                                        value="{{old('name_cost[]', $cost->name_cost)}}" placeholder="Enter name"
                                        class="form-control" />
                                </td>
                                <td><input type="text" name="desc[]" value="{{old('desc[]', $cost->desc)}}"
                                        placeholder="Enter desc" class="form-control" />
                                </td>
                                <td><input type="number" name="total_cost[]"
                                        value="{{old('total_cost[]', $cost->total_cost)}}" placeholder="Total cost"
                                        class="form-control" />
                                </td>
                            </tr>
                            @endforeach
                            @foreach(old('name_cost', []) as $dataCost)
                            <tr>
                                <input type="hidden" name="cost_id[]" value="{{old('cost_id')[$loop->index]}}">
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
                <!-- /.card-body -->
                <div class="card-footer mt-2">
                    <div class="text-center">
                        <a href="/operationals" type="submit" class="btn btn-danger">Back</a>
                        <button type="submit" class="btn btn-primary">Submit Cost</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('progress_doc') }}" id="upload_modal_form" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="progress_id" id="progress_id">
                        <label></label>
                        <input type="file" class="form-control @error('filename') is-invalid @enderror" id="filename"
                            name="filename[]" multiple>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" onclick="$('#upload_modal_form').submit();"
                        class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('custom-js')
<!-- Toastr -->
<script src="{{asset('assets/')}}/plugins/toastr/toastr.min.js"></script>
<script src="{{asset('assets/')}}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
@endpush
@push('custom-script')
<script>
$('#exampleModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var recipient = button.data('whatever')
    var progress_id = button.data('id')
    var modal = $(this)
    modal.find('.modal-title').text('Upload ' + recipient)
    modal.find('#progress_id').val(progress_id)
});
</script>
@if (session('errorUpload'))
<script>
toastr.error("{{session('errorUpload')}}");
</script>
@endif
@if (session('status'))
<script>
toastr.success('Upload success!');
</script>
@endif
@if (session('null'))
<script>
toastr.warning('No files uploaded!');
</script>
@endif
<script>
$("#exampleModal").on("hidden.bs.modal", function() {
    $("#filename").val("");
});

$('.alertNotSet').click(function () {
    // alert()->error('Title','Lorem Lorem Lorem');
    alert('Your progress not runing !!!');
});
</script>
<!-- <script>
i = 1;

function myStatus() {

    var status = "complete";
    document.getElementById("status" + i).value = status;
    i++;
}
</script> -->
<script type="text/javascript">
$("#add-btnCost").click(function() {
    var tr = '<tr>' +
        '<input type="hidden" name="cost_id[]" value="{{old(' + cost_id + ')}}">' +
        '<td>' +
        '<input type="text" name="name_cost[]" value="{{old(' + name_cost +
        ')}}" placeholder="Enter name" class="form-control" /></td>' +
        '<td><input type="text" name="desc[]" value="{{old(' + desc +
        ')}}" placeholder="Enter desc" class="form-control" />' +
        '</td>' +
        '<td><input type="number" name="total_cost[]" value="{{old(' + total_cost +
        ')}}" placeholder="Total cost" class="form-control" /></td>' +
        '<td><a type="button" class="btn btn-danger removeCost-tr">-</a></td>' +
        '</tr>';
    $("#dynamicCosting").append(tr);
});
$(document).on('click', '.removeCost-tr', function() {
    $(this).parents('tr').remove();
});
</script>
<!-- <script>
$(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 'Completed' : 'inProgress';
        var progress_id = $(this).data('id');
        var changed = confirm("Want to delete?");
        var token = $("meta[name='csrf-token']").attr("content");
        var checked = $(this).is(':checked');
        var tes = $(this).prop('checked', false);
        if (!changed) {
            location.reload();
        } else {
            if (status == "Completed") {
                $(this).prop("disabled", true);
            }
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/changestatus',
                data: {
                    'status': status,
                    'progress_id': progress_id,
                    "_token": token,
                },
                success: function(data) {
                    console.log(data.success)
                    location.reload();
                }
            });
        }
    });

})
</script> -->
<script>
$(".changeStatus").click(function() {
    var id = $(this).data("id");
    var name = $(this).data("name");
    var dataOn = $(this).data("on");
    var dataOff = $(this).data("off");
    var token = $("meta[name='csrf-token']").attr("content");
    var result = confirm("Want to change status?");
    if (result) {
        $.ajax({
            url: "/changestatus/" + id,
            type: 'get',
            data: {
                "name": name,
                "id": id,
                "dataOn": dataOn,
                "_token": token,
            },
            success: function(data) {
                console.log(data.success);
                location.reload();
            },
            error: function(xhr, data, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(data);
            }
        });
    }
});
</script>
<script>
$(".removedoc").click(function() {
    var id = $(this).data("id");
    var token = $("meta[name='csrf-token']").attr("content");
    var result = confirm("Want to delete?");
    if (result) {
        $.ajax({
            url: "/progress_doc/" + id,
            type: 'get',
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
@endpush
