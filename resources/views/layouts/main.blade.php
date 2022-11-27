<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KEUANGAN - SMKS AL MUKHLISIYAH</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/website-icon-transparent-1.jpg') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.style')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <div id="loadings">
            <div class="animation__shake lds-hourglass text-center"></div>
        </div>
    </div>
    <div id="loading">
        <div class="animation__shake lds-hourglass text-center"></div>
    </div>
    @include('layouts.navbar')
    @include('layouts.leftside')
    @yield('content')
    <!-- /.content-wrapper -->
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
@include('layouts.script')

</body>
</html>


