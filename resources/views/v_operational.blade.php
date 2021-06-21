@extends('layout.v_template')
@section('title', 'Operational & Cost-POxxxx')
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
                            <table class="table table-bordered">
                                <tr>
                                    <th class="text-center">Operational & Progress</th>
                                    <th class="text-center">Progress</th>
                                    <th class="text-center">Invoicing</th>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="InputFileSit">Upload Sit
                                                    ..</label>
                                                <input type="file" class="custom-file-input" id="InputFileSit">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <i class="nav-icon fas fa-check text-success"></i>
                                    </td>
                                    <td class="text-center">
                                        <i class="nav-icon fas fa-check text-success"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="InputFileUat">Upload Uat
                                                    ..</label>
                                                <input type="file" class="custom-file-input" id="InputFileUat">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <i class="nav-icon fas fa-check text-success"></i>
                                    </td>
                                    <td class="text-center">
                                        <i class="nav-icon fas fa-check text-success"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="InputFileVit">Upload Vit
                                                    ..</label>
                                                <input type="file" class="custom-file-input" id="InputFileVit">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center font-italic">
                                        <p>inProgress</p>
                                    </td>
                                    <td class="text-center">
                                        <i class="nav-icon fas fa-times text-danger"></i>
                                    </td>

                                </tr>
                            </table>
                        </div>
                        <div class="card-header mt-4 d-flex justify-content-center">
                            <h3 class="card-title font-weight-bold">Costing</h3>
                        </div>
                        <table class="table table-borderless d-flex justify-content-center" id="dynamicCosting">
                            <tr>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Desc</th>
                                <th class="text-center">Cost</th>
                                <th><a type="button" name="addcost" id="add-btnCost" class="btn btn-success">+</a>
                                </th>
                            </tr>
                            <tr>
                                <td><input type="text" name="moreFields[0][nama_cost]" placeholder="Enter nama"
                                        class="form-control" />
                                </td>
                                <td><input type="text" name="moreFields[0][desc_cost]" placeholder="Enter desc"
                                        class="form-control" />
                                </td>
                                <td><input type="text" name="moreFields[0][cost]" placeholder="Enter cost"
                                        class="form-control" />
                                </td>
                                <td><a type="button" class="btn btn-danger removeCost-tr">-</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer mt-2">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit Cost</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection