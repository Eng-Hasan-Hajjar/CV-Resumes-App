<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    @yield('style')
    @yield('header')
</head>

<body class="hold-transition sidebar-mini">
        <div class="content" id="app">
                <div class="container-fluid">
                    @yield('content')
                </div>
        </div>

    <!-- jQuery -->
    <script src="{{ asset('/assets/adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Vue -->
    <script src="{{ asset('/js/app.js') }}"></script>

    <!-- Infile Script-->
    @yield('script')
</body>
</html>
