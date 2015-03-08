<head>
	<meta charset="utf-6">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>@yield('title')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<!-- Open Sans font from Google CDN -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">

	<!-- Pixel Admin's stylesheets -->
    @section('styles')
	<link href="{{ elixir('css/backend.css') }}" rel="stylesheet">
    @show
	<!--[if lt IE 9]>
		<script src="assets/javascripts/ie.min.js"></script>
	<![endif]-->
</head>
<body class="theme-default main-menu-animated">
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
                                    <span>John Doe</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!--<li><a href="#"><span class="label label-warning pull-right">New</span>Profile</a></li>
                                    <li><a href="#"><span class="badge badge-primary pull-right">New</span>Account</a></li>
                                    <li><a href="#"><i class="dropdown-icon fa fa-cog"></i>&nbsp;&nbsp;Settings</a></li>
                                    <li class="divider"></li>-->
                                    <li><a href=""><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;{{ Lang::get('backend.logout') }}</a></li>
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
                    <a href=""><i class="menu-icon fa fa-dashboard"></i><span class="mm-text">{{ Lang::get('backend.dashboard') }}</span></a>
				</li>
			</ul> <!-- / .navigation -->
		</div> <!-- / #main-menu-inner -->
	</div> <!-- / #main-menu -->

    @yield('container')

	<div id="main-menu-bg"></div>
</div> <!-- / #main-wrapper -->

@section('scripts')
<script src="js/backend/jquery.min.js"></script>
<script src="js/backend/bootstrap.min.js"></script>
<script src="js/backend/pixel-admin.min.js"></script>
<script type="text/javascript">
	init.push(function () {
		// Javascript code here
	})
	window.PixelAdmin.start(init);
</script>
@show

</body>
</html>

