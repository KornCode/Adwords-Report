<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MENU</li>
            <li class="active">
                <a href="{{ route('ads.dashboard') }}"><span>Ads Dashboard</span></a>
            </li>
            @if (Auth::user()->hasRole('admin'))
                <li>
                    <a href="{{ route('admin.dashboard') }}"><span>Admin Dashboard</span></a>
                </li>
            @endif
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"><span>Logout</span></a>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->

    {{-- for logout --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</aside>

