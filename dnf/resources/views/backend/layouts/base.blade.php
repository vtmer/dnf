<html class="gt-ie8 gt-ie9 not-ie pxajs">
<head>
	<meta charset="utf-6">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>@yield('title')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<!-- Open Sans font from Google CDN -->

	<!-- Pixel Admin's stylesheets -->
    @section('styles')
    <script src="{{ asset('packages/ckfinder/ckfinder.js') }}"></script>
	<link href="{{ elixir('css/backend.css') }}" rel="stylesheet">
    @show
	<!--[if lt IE 9]>
		<script src="assets/javascripts/ie.min.js"></script>
	<![endif]-->
</head>
<body @section('body-class') class="theme-default main-menu-animated" @show>
@yield('body')

@section('scripts')
    <script src="{{ asset('asset/js/backend/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/js/backend/bootstrap.min.js') }}"></script>
    <script src="{{ asset('asset/js/backend/pixel-admin.min.js') }}"></script>
    <script src="{{ asset('asset/js/backend/common.js') }}"></script>
    @if(Session::has('error'))
        <script>
        bootbox.alert({
            message: "<?php echo Session::get('error'); ?>",
            className: "bootbox-sm"
        });
        </script>
    @elseif($errors->any())
        <script>
        var error = "";
        @foreach($errors->all() as $error)
            error += "<?php echo $error; ?>" + "<br>";
        @endforeach
        bootbox.alert({
            message: error,
            className: "bootbox-sm"
        });
        </script>
    @endif
@show
</body>
</html>

