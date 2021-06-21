@extends('layout.v_template')
@section('title', 'Master Client')
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
                <h3 class="card-title">Create Client</h3>
            </div>
            <form method="post" action="/">
                @csrf
                <div class="card-body">
                    <div class="d-flex justify-content-around">
                        <div class="form-group col-4">
                            <label for="name">Client Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" placeholder="Enter name">
                            @error('name')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-2 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
