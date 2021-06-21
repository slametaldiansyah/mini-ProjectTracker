<!DOCTYPE html>
<html lang="en">
<style>
.fivedashedblack {
    border: 3px dashed black;
}

/* untuk menghilangkan spinner  */
.spinner {
    display: none;
}
/* hide li*/
.hideli{
  display:none;
}
</style>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tracking | @yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/')}}/plugins/fontawesome-free/css/all.min.css">
      <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('assets/')}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    @stack('custom-css')
    <!-- daterange picker -->
    <!-- <link rel="stylesheet" href="{{asset('assets/')}}/plugins/daterangepicker/daterangepicker.css"> -->

    <!-- Select2 -->
    <!-- <link rel="stylesheet" href="{{asset('assets/')}}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{asset('assets/')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css"> -->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/')}}/dist/css/adminlte.min.css">



</head>

{{-- <body class="hold-transition sidebar-mini text-sm"> --}}
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <!-- Site wrapper -->
    <div class="wrapper bg-light">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="/" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">


                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/" class="brand-link">
                <div class="image">
                    <img src="{{asset('assets/')}}/dist/img/Logoadidata.jpg" class="img-thumbnail" alt="AdminLTE Logo">
                </div>
            </a>
            <!-- <a href="{{asset('assets/')}}/index3.html" class="brand-link">
                <img src="{{asset('assets/')}}/dist/img/Logoadidata.jpg" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">PT. Adidata</span>
            </a> -->

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-4 pb-3 mb-3 d-flex">
                    <div class="image">
                        {{-- <img src="{{asset('assets/')}}/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                            alt="User Image"> --}}
                    </div>
                    <div class="info">
                        {{-- <a href="{{ route('profile')}}" class="d-block">{{$username}}</a> --}}
                    </div>
                </div>
                <div class="user-panel mt-4 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{asset('assets/')}}/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    @php
                    //Request Data
                      $username = session()->get('token')['user']['username'];
                    @endphp
                    <div class="info">
                        <a href="{{ route('profile')}}" class="d-block">{{$username}}</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->

                @include('layout.v_nav')

                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        @include('sweetalert::alert')
                        <div class="col-sm-6">
                            <h1>@yield('title')</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->

            <!-- /.content-wrapper -->


        </div>
        @include('layout.v_foot')
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{asset('assets/')}}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('assets/')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{asset('assets/')}}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    @stack('custom-js')

    <!-- Select2 -->
    <!-- <script src="{{asset('assets/')}}/plugins/select2/js/select2.full.min.js"></script> -->
    <!-- InputMask -->
    <!-- <script src="{{asset('assets/')}}/plugins/inputmask/jquery.inputmask.min.js"></script> -->
    <!-- date-range-picker -->
    <!-- <script src="{{asset('assets/')}}/plugins/daterangepicker/daterangepicker.js"></script> -->

    <!-- bs-custom-file-input -->
    <!-- <script src="{{asset('assets/')}}/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script> -->
    <!-- AdminLTE App -->
    <script src="{{asset('assets/')}}/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="{{asset('assets/')}}/dist/js/demo.js"></script> -->
    <!-- Page specific script -->
    @stack('custom-script')
    <!-- <script>
    $(function() {
        // $("#example1").DataTable();
        //signdate
        $('#signdate').datetimepicker({
            useCurrent: false,
            //disabled: true,
            format: 'YYYY-MM-DD',
        });
        //startdate
        $('#startdate').datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD'
        });
        //enddate
        $('#enddate').datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD'
        });
    });
    </script> -->
    <!-- <script>
    $('#contra').on('change', function() {
        if ($(this).val() === "") {
            $("#nocontract").show()
            $("#msg").val($(this).val())
            $("#Iscontract").hide()
        } else {
            $("#nocontract").hide()
            $("#msg").val($(this).val())
            $("#Iscontract").show()
        }
    });
    </script> -->


</body>

</html>
