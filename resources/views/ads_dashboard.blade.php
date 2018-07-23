<!DOCTYPE html>
    <!--
    This is a starter template page. Use this page to start your new project from
    scratch. This page gets rid of all links and provides the needed markup only.
    -->
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Kodsana Report</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <script type="text/javascript">
            var api_url = "{{ env('API_URL') }}";
        </script>
        
        <script src="{{ mix('/js/app.js') }}" defer></script>
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
        
    </head>
    <body class="skin-blue">
    <div id="app" class="wrapper">

        <!-- Header -->
        @include('header')

        <!-- Sidebar -->
        @include('sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    {{ $page_title or "Ads Dashboard" }}
                    <small>{{ $page_description or null }}</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="{{ route('ads.dashboard') }}"><i class="fa fa-line-chart"></i> Ads Dashboard </a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                @yield('content')
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <!-- Footer -->
        @include('footer')

    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 3.3.1 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    </body>
</html>