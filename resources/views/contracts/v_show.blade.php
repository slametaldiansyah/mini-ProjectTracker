@extends('layout.v_template')
@section('title', 'Detail Contract')
@section('content')
<div class="container">
    <div class="col-md">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Detail Contract</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form">
                <div class="card-body">
                    <div class="form">
                        <div class="d-flex justify-content-around">
                            <div class="form-group col-4">
                                <label for="name">Contract Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{old('name', $contract->name)}}" placeholder="Enter name"
                                    disabled="disabled">
                            </div>
                            <div class="form-group col-4">
                                <label>Client</label>
                                <select name="client_id" class="form-control" disabled="disabled">
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
                                    value="{{old('cont_num', $contract->cont_num)}}" placeholder="Enter No. Contract"
                                    disabled="disabled">
                            </div>
                            <div class="form-group col-4">
                                <label>Contract Sign Date</label>
                                <div class="input-group date" id="signdate" data-target-input="nearest">
                                    <input type="text"
                                        class="form-control  @error('sign_date') is-invalid @enderror datetimepicker-input"
                                        data-target="#signdate" name="sign_date" id="sign_date"
                                        value="{{old('sign_date', $contract->sign_date)}}" placeholder="dd/mm/yyyy"
                                        disabled="disabled" />
                                    <div class="input-group-append" data-target="#signdate"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="form-group col-4">
                                <label for="volume">Volume</label>
                                <input type="number" class="form-control" id="volume" name="volume"
                                    value="{{old('volume', $contract->volume)}}" placeholder="Enter volume"
                                    disabled="disabled">
                            </div>
                            <div class="form-group col-2">
                                <label for="unit">Unit</label>
                                <input type="text" class="form-control" id="unit" name="unit"
                                    value="{{old('unit', $contract->unit)}}" placeholder="ex: Mandays..."
                                    disabled="disabled">
                            </div>
                            <div class="form-group col-4">
                                <label for="paire">Price</label>
                                <input type="number" class="form-control" id="price" name="price" placeholder="Rp."
                                    value="{{old('price', $contract->price)}}" disabled="disabled">
                            </div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <div class="form-group col-4">
                                <label>Start Date</label>
                                <div class="input-group date" id="startdate" data-target-input="nearest">
                                    <input type="text" class="form-control" data-target="#startdate" name="start_date"
                                        placeholder="YYYY-MM-DD" value="{{old('start_date', $contract->start_date)}}"
                                        disabled="disabled" />
                                    <div class="input-group-append" data-target="#startdate"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label>End Date</label>
                                <div class="input-group date" id="enddate" data-target-input="nearest">
                                    <input type="text" class="form-control" data-target="#enddate" name="end_date"
                                        placeholder="YYYY-MM-DD" value="{{old('end_date', $contract->end_date)}}"
                                        disabled="disabled" />
                                    <div class=" input-group-append" data-target="#enddate"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <div class="form-group col-4">
                                <label for="exampleInputFile">Upload Doc</label>
                                <div class="input-group">
                                    <div class="custom-file">

                                        <input type="file" class="form-control @error('filename') is-invalid @enderror"
                                            id="filename" name="filename[]" multiple disabled="disabled">
                                        @error('filename')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
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
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('custom-js')
<!-- DataTables -->
<script src="{{asset('assets/')}}/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{asset('assets/')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endpush