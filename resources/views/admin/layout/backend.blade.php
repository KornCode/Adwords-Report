<!DOCTYPE html>
    <!--
    This is a starter template page. Use this page to start your new project from
    scratch. This page gets rid of all links and provides the needed markup only.
    -->
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Admin</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <script type="text/javascript">
            var api_url = "{{ env('API_URL') }}";
        </script>

        {{-- <script src="{{ mix('/js/app.js') }}" defer></script> --}}
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
        
    </head>
    <body class="skin-blue">
    <div id="app" class="wrapper">

        <!-- Header -->
        @include('header')

        <!-- Sidebar -->
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar Menu -->
                <ul class="sidebar-menu">
                    <li class="header">MENU</li>
                    <li class="treeview">
                        <a href="{{ route('admin.members.index') }}"><i class="fa fa-users"></i> <span>Members</span></a>
                    </li>
                    <li class="treeview">
                        <a href="{{ route('admin.roles.index') }}"><i class="fa fa-link"></i> <span>Roles</span></a>
                    </li>
                    <li class="treeview">
                        <a href="{{ route('admin.permissions.index') }}"><i class="fa fa-lock"></i> <span>Permissions</span></a>
                    </li>
                    <li class="treeview">
                        <a href="{{ route('admin.widgets.index') }}"><i class="fa fa-th"></i> <span>Widgets</span></a>
                    </li>
                    <li class="treeview">
                        <a href="{{ route('admin.dashboard') }}"><i class="fa fa-user"></i> <span>Dashboard</span></a>
                    </li>
                    <li class="treeview">
                        <a href="{{ route('ads.dashboard') }}"><i class="fa fa-line-chart"></i> <span>Ads Dashboard</span></a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i class="fa fa-arrow-circle-o-left"></i> <span>Logout</span></a>
                    </li>
                </ul><!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
            {{-- for logout --}}
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    {{ $page_title or "Admin Dashboard" }}
                    <small>{{ $page_description or null }}</small>
                </h1>
                <ol class="breadcrumb">
                @if (URL::current() == 'http://localhost:8000/admin/members')
                    <li><a href="{{ route('admin.members.index') }}"><i class="fa fa-users"></i>  Member Dashboard </a></li>
                @elseif (URL::current() == 'http://localhost:8000/admin/members/create')
                    <li><a href="{{ route('admin.members.index') }}"><i class="fa fa-users"></i>  Member Dashboard </a></li>
                    <li><a href="{{ URL::current() }}">Create</a></li>
                @elseif (strpos(URL::current(), 'http://localhost:8000/admin/members/edit') !== false)
                    <li><a href="{{ route('admin.members.index') }}"><i class="fa fa-users"></i>  Member Dashboard </a></li>
                    <li><a href="{{ URL::current() }}">Edit</a></li>
                @elseif (URL::current() == 'http://localhost:8000/admin/roles')
                    <li><a href="{{ route('admin.roles.index') }}"><i class="fa fa-link"></i>  Roles Dashboard </a></li>
                @elseif (URL::current() == 'http://localhost:8000/admin/roles/create')
                    <li><a href="{{ route('admin.roles.index') }}"><i class="fa fa-link"></i>  Roles Dashboard </a></li>
                    <li><a href="{{ URL::current() }}">Create</a></li>
                @elseif (strpos(URL::current(), 'http://localhost:8000/admin/roles/edit') !== false)
                    <li><a href="{{ route('admin.roles.index') }}"><i class="fa fa-link"></i>  Roles Dashboard </a></li>
                    <li><a href="{{ URL::current() }}">Edit </a></li>
                @elseif (URL::current() == 'http://localhost:8000/admin/permissions')
                    <li><a href="{{ route('admin.permissions.index') }}"><i class="fa fa-lock"></i>  Permissions Dashboard </a></li>
                @elseif (URL::current() == 'http://localhost:8000/admin/permissions/create')
                    <li><a href="{{ route('admin.permissions.index') }}"><i class="fa fa-lock"></i>  Permissions Dashboard </a></li>
                    <li><a href="{{ URL::current() }}">Create</a></li>
                @elseif (strpos(URL::current(), 'http://localhost:8000/admin/permissions/edit') !== false)
                    <li><a href="{{ route('admin.permissions.index') }}"><i class="fa fa-lock"></i>  Permissions Dashboard </a></li>
                    <li><a href="{{ URL::current() }}">Edit </a></li>

                @elseif (URL::current() == 'http://localhost:8000/admin/widgets')
                    <li><a href="{{ route('admin.widgets.index') }}"><i class="fa fa-th"></i>  Widgets Dashboard </a></li>
                @elseif (URL::current() == 'http://localhost:8000/admin/widgets/create_widget')
                    <li><a href="{{ route('admin.widgets.index') }}"><i class="fa fa-th"></i>  Widgets Dashboard </a></li>
                    <li><a href="{{ URL::current() }}">Create</a></li>
                @elseif (URL::current() == 'http://localhost:8000/admin/widgets/create_comp')
                    <li><a href="{{ route('admin.widgets.index') }}"><i class="fa fa-th"></i>  Widgets Dashboard </a></li>
                    <li><a href="{{ URL::current() }}">Create</a></li>
                @elseif (URL::current() == 'http://localhost:8000/admin/widgets/create_wc')
                    <li><a href="{{ route('admin.widgets.index') }}"><i class="fa fa-th"></i>  Widgets Dashboard </a></li>
                    <li><a href="{{ URL::current() }}">Create</a></li>
                @elseif (strpos(URL::current(), 'http://localhost:8000/admin/widgets/edit_widget') !== false)
                    <li><a href="{{ route('admin.widgets.index') }}"><i class="fa fa-th"></i>  Widgets Dashboard </a></li>
                    <li><a href="{{ URL::current() }}">Edit </a></li>
                @elseif (strpos(URL::current(), 'http://localhost:8000/admin/widgets/edit_comp') !== false)
                    <li><a href="{{ route('admin.widgets.index') }}"><i class="fa fa-th"></i>  Widgets Dashboard </a></li>
                    <li><a href="{{ URL::current() }}">Edit </a></li>
                @elseif (strpos(URL::current(), 'http://localhost:8000/admin/widgets/edit_wc') !== false)
                    <li><a href="{{ route('admin.widgets.index') }}"><i class="fa fa-th"></i>  Widgets Dashboard </a></li>
                    <li><a href="{{ URL::current() }}">Edit </a></li>
                @endif
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
    <script src="{{ mix('/js/app.js') }}" defer></script>

    <!-- jQuery 3.3.1 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $('.bs-colorpicker').colorpicker();
        });
    </script>
    </body>
</html>
