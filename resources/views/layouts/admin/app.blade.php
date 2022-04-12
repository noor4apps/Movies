<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', '')</title>

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/main.css') }}" media="all">

    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body class="app sidebar-mini">

@include('layouts.admin._header')

@include('layouts.admin._aside')

<main class="app-content">
    @yield('crumb')
    @yield('content')
</main>

<!-- Essential javascript for application to work-->
<script src="{{ asset('admin_assets/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/popper.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/main.js') }}"></script>

<!-- datatable-->
<script type="text/javascript" src="{{ asset('admin_assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin_assets/js/plugins/dataTables.bootstrap.min.js') }}"></script>

<!-- select2 -->
<script type="text/javascript" src="{{ asset('admin_assets/js/plugins/select2.min.js') }}"></script>

<!-- noty-->
<link rel="stylesheet" href="{{ asset('admin_assets/plugins/noty/noty.css') }}">
<script src="{{ asset('admin_assets/plugins/noty/noty.min.js') }}"></script>
</body>
</html>
