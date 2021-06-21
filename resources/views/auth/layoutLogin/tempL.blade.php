<!DOCTYPE html>
<html lang="en">

@extends('auth.layoutLogin.headerL')

<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->

  @include('sweetalert::alert')
  @yield('content')

  <!-- /.card -->
</div>
<!-- /.login-box -->

@extends('auth.layoutLogin.footerL')
</body>
</html>
