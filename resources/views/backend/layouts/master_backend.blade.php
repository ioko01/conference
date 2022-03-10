<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | DASHBOARD</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet"
        href="{{ asset('vendor/plugins/fontawesome-free/css/all.min.css', env('REDIRECT_HTTPS')) }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
        href="{{ asset('vendor/plugins/overlayScrollbars/css/OverlayScrollbars.min.css', env('REDIRECT_HTTPS')) }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/dist/css/adminlte.min.css', env('REDIRECT_HTTPS')) }}">
</head>

<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        @include('backend.includes.topbar')
        @include('backend.includes.leftbar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">แผงควบคุม</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('section')
                </div>
                <!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        @include('backend.includes.rightbar')
        @include('backend.includes.footer')

        @include('backend.includes.script')


    </div>
    <!-- ./wrapper -->
</body>

</html>
