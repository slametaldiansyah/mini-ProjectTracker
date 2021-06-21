@extends('layout.v_template')
@section('title', 'Edit Status')
@section('content')

<div class="container">
    <div class="col-md">
        <!-- general form elements -->
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Status</h3>
            </div>
            <form method="post" action="/progress_status/{{$progress_status->id}}">
                @method('patch')
                @csrf
                <div class="card-body">
                    <div class="d-flex justify-content-around">
                        <div class="form-group col-4">
                            <label for="status">Status</label>
                            <input type="text" name="status" class="form-control @error('status') is-invalid @enderror"
                                id="status" value="{{old('name', $progress_status->status)}}"
                                placeholder="Enter status">
                            @error('status')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-2 text-center">
                    <a href="/progress_status" type="submit" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection