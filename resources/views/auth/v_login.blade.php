@extends('auth.layoutLogin.tempL')

@section('titleH','Login')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>Tracking</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="{{ route('loginui') }}" method="post">
        {{ csrf_field() }}

        <div class="input-group mb-3">
          <input type="text" name="username"
          class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
          placeholder="Username" value="{{ old('username') }}" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
          @if($errors->has('username'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('username') }}</strong>
                </div>
            @endif
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password"
            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
            value="{{ old('password') }}" placeholder="Password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
            @if($errors->has('password'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
            @endif
        </div>

        <div class="row">

          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-custome btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- /.social-auth-links -->

      {{-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> --}}
    </div>
    <!-- /.card-body -->
  </div>
@endsection
