@extends('layout.v_template')
@section('title', 'User Profile')
@push('custom-css')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('assets/')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
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
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{asset('assets/')}}/dist/img/user2-160x160.jpg" alt="User profile picture">
              </div>


              @php
              //Request Data
                // dd(session()->get('token'));
                $username = session()->get('token')['user']['fullname'];
                $position = session()->get('token')['user']['position'];
                $dob = session()->get('token')['user']['birth_date'];
                $email = session()->get('token')['user']['email'];
                $join = session()->get('token')['user']['join_date'];

                // dd(session()->get('token')['detail_user'][0]);
              @endphp


              <h3 class="profile-username text-center">{{$username}}</h3>
              <p class="text-muted text-center">{{$position}}</p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Email</b> <a class="float-right">{{$email}}</a>
                </li>
                <li class="list-group-item">
                  <b>Date of birth</b> <a class="float-right">{{date('d M Y', strtotime($dob))}}</a>
                </li>
                <li class="list-group-item">
                  <b>Join</b> <a class="float-right">{{date('d M Y', strtotime($join))}}</a>
                </li>
              </ul>

              <a href="#" class="col-2 float-right btn btn-primary btn-block"><b>Edit</b></a>
            </div>
            <!-- /.card-body -->
          </div>
    </div>
</div>
@endsection
@push('custom-js')
<!-- DataTables -->
<script src="{{asset('assets/')}}/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{asset('assets/')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
@endpush
@push('custom-script')
<script>
$(function() {
    $("#example1").DataTable();
});
</script>
@endpush
