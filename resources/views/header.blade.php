<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    @if (Auth::user()->hasRole('admin'))
        <a href="{{ route('admin.dashboard') }}" class="logo"><b>AdWords</b>Report</a>
    @else
        <a href="{{ route('ads.dashboard') }}" class="logo"><b>AdWords</b>Report</a>
    @endif

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <aside class="control-sidebar control-sidebar-light">
            <!-- Content of the sidebar goes here -->
        </aside>
        <div class="control-sidebar-bg"></div>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ Auth::user()->email }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>