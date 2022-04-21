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

    <!-- loader -->
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/loader.css') }}">
    
    <!-- noty-->
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/noty/noty.css') }}">
    <script src="{{ asset('admin_assets/plugins/noty/noty.min.js') }}"></script>

    @stack('styles')
</head>
<body class="app sidebar-mini">

@include('layouts.admin._header')

@include('layouts.admin._aside')

<main class="app-content">
    @include('admin.partials._session')

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

{{--custom--}}
<script src="{{ asset('admin_assets/js/custom/index.js') }}"></script>
<script src="{{ asset('admin_assets/js/custom/roles.js') }}"></script>

<script>
    $(document).ready(function () {

        //delete
        $(document).on('click', '.delete, #bulk-delete', function (e) {

            var that = $(this)

            e.preventDefault();

            var n = new Noty({
                text: "@lang('site.confirm_delete')",
                type: "alert",
                killer: true,
                buttons: [
                    Noty.button("@lang('site.yes')", 'btn btn-success mr-2', function () {
                        let url = that.closest('form').attr('action');
                        let data = new FormData(that.closest('form').get(0));

                        let loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i>';
                        let originalText = that.html();
                        that.html(loadingText);

                        n.close();

                        $.ajax({
                            url: url,
                            data: data,
                            method: 'post',
                            processData: false,
                            contentType: false,
                            cache: false,
                            success: function (response) {

                                $("#record__select-all").prop("checked", false);

                                $('.datatable').DataTable().ajax.reload();

                                new Noty({
                                    layout: 'topRight',
                                    type: 'alert',
                                    text: response,
                                    killer: true,
                                    timeout: 2000,
                                }).show();

                                that.html(originalText);
                            },

                        });//end of ajax call

                    }),

                    Noty.button("@lang('site.no')", 'btn btn-danger mr-2', function () {
                        n.close();
                    })
                ]
            });

            n.show();

        });//end of delete

    });//end of document ready

    {{--CKEDITOR.config.language = "{{ app()->getLocale() }}";--}}

    //select 2
    $('.select2').select2({
        'width': '100%',
    });

</script>

@stack('scripts')
</body>
</html>
