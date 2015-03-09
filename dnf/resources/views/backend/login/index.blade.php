@extends('backend.layouts.base')

@section('title')
{{ Lang::get('backend.title.login') }}
@stop

@section('body-class')
class="theme-default page-signin-alt"
@stop

@section('body')
<div class="signin-header">
    <a href="/" class="logo">
        <strong>Vtmer</strong>Studio
    </a> <!-- / .logo -->
</div> <!-- / .header -->

<h1 class="form-header">{{ Lang::get('backend.signin') }}</h1>

<!-- Form -->
<form action="{{ route('backend_auth_auth_login') }}" method="post" id="signin-form_id" class="panel">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <input type="text" id="username_id" name="username" class="form-control input-lg" placeholder="{{ Lang::get('backend.username') }}">
    </div> <!-- / Username -->

    <div class="form-group signin-password">
        <input type="password" id="password_id" name="password" class="form-control input-lg" placeholder="{{ Lang::get('backend.password') }}">
    </div> <!-- / Password -->

    <div class="form-actions">
        <input type="submit" value="{{ Lang::get('backend.signin')}}" class="btn btn-primary btn-block btn-lg">
    </div> <!-- / .form-actions -->
</form>
<!-- / Form -->
@stop

@section('scripts')
    @parent
    <script type="text/javascript">
        window.PixelAdmin.start([
            function () {
                $("#signin-form_id").validate({ focusInvalid: true, errorPlacement: function () {} });

                // Validate username
                $("#username_id").rules("add", {
                    required: true,
                    minlength: 4
                });

                // Validate password
                $("#password_id").rules("add", {
                    required: true,
                    minlength: 4
                });
            }
        ]);
    </script>
@stop

</body>
</html>
