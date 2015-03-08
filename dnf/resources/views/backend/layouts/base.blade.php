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
<body @section('body-class') class="theme-default main-menu-animated" @show>
@yield('body')

@section('scripts')
<script src="/js/backend/jquery.min.js"></script>
<script src="/js/backend/bootstrap.min.js"></script>
<script src="/js/backend/pixel-admin.min.js"></script>
@show
</body>
</html>

