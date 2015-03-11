@extends('backend.layouts.base')

@section('body')
<script>var init = [];</script>
<div id="main-wrapper">
    <div id="main-navbar" class="navbar navbar-inverse" role="navigation">
        <!-- Main menu toggle -->
        <button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span></button>
        <div class="navbar-inner">
            <!-- Main navbar header -->
            <div class="navbar-header">
                <!-- Logo -->
                <a href="index.html" class="navbar-brand">
                    Vtmer Studio
                </a>
                <!-- Main navbar toggle -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>
            </div> <!-- / .navbar-header -->
            <div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse">
                <div>
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#">{{ Lang::get('backend')['dnf'] }}</a>
                        </li>
                    </ul> <!-- / .navbar-nav -->
                    <div class="right clearfix">
                        <ul class="nav navbar-nav pull-right right-navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle user-menu" data-toggle="dropdown">
                                    <span>{{ Auth::user()->realname }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!--<li><a href="#"><span class="label label-warning pull-right">New</span>Profile</a></li>
                                    <li><a href="#"><span class="badge badge-primary pull-right">New</span>Account</a></li>
                                    <li><a href="#"><i class="dropdown-icon fa fa-cog"></i>&nbsp;&nbsp;Settings</a></li>
                                    <li class="divider"></li>-->
                                    <li><a href="{{ route('backend_auth_auth_logout')}}"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;{{ Lang::get('backend.logout') }}</a></li>
                                </ul>
                            </li>
                        </ul> <!-- / .navbar-nav -->
                    </div> <!-- / .right -->
                </div>
            </div> <!-- / #main-navbar-collapse -->
        </div> <!-- / .navbar-inner -->
    </div> <!-- / #main-navbar -->

	<div id="main-menu" role="navigation">
		<div id="main-menu-inner">
			<ul class="navigation">
				<li>
                    <a href="{{ route('backend_dashboard_index') }}"><i class="menu-icon fa fa-dashboard"></i><span class="mm-text">{{ Lang::get('backend.dashboard') }}</span></a>
				</li>
                {!! App\Widgets\Backend\MenuWidget::menu() !!}
			</ul> <!-- / .navigation -->
		</div> <!-- / #main-menu-inner -->
	</div> <!-- / #main-menu -->

    @yield('container')

	<div id="main-menu-bg"></div>
</div> <!-- / #main-wrapper -->
@stop
