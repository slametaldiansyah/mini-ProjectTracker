@extends('layout.v_template')
@section('title', 'Detail Operational & Cost-POxxxx')
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
            <form role="form">
                <div class="card-body">
                    <div class="form">
                        <div class="d-flex justify-content-center">
                            <table class="table table-bordered" id="refresh-after-ajax">
                                <tr>
                                    <th class="text-center">Operational & Progress</th>
                                    <th class="text-center">Progress</th>
                                    <th class="text-center">Payment</th>
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
                                                        data-whatever="{{$progress_item->name_progress}}"
                                                        disabled>Upload</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if(!$progress_item->status_id)
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <a name="status" data-id="{{$progress_item->id}}" data-on="Completed"
                                            data-off="inProgress" class="btn btn-primary changeStatus"
                                            disabled>inProgress</a>
                                        @else
                                        <i class="nav-icon fas fa-check text-success"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (!$progress_item->invoice_status_id)
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <a data-name="invoice_status" data-id="{{$progress_item->id}}" data-on="Completed"
                                            data-off="inProgress" class="btn btn-primary changeStatus">inProgress</a>
                                        @else
                                        <i class="nav-icon fas fa-check text-success"></i>
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
                                    </div>
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        <div class=" card-header mt-4 d-flex justify-content-center">
                            <h3 class=" card-title font-weight-bold">Costing</h3>
                        </div>
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
                                        class="form-control" disabled />
                                </td>
                                <td><input type="text" name="desc[]" value="{{old('desc[]', $cost->desc)}}"
                                        placeholder="Enter desc" class="form-control" disabled />
                                </td>
                                <td><input type="number" name="total_cost[]"
                                        value="{{old('total_cost[]', $cost->total_cost)}}" placeholder="Total cost"
                                        class="form-control" disabled />
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
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection