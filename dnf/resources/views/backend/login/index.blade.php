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
<form action="index.html" id="signin-form_id" class="panel">
    <div class="form-group">
        <input type="text" name="username" class="form-control input-lg" placeholder="{{ Lang::get('backend.username') }}">
    </div> <!-- / Username -->

    <div class="form-group signin-password">
        <input type="password" name="password" class="form-control input-lg" placeholder="{{ Lang::get('backend.password') }}">
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
    </script>
@stop

</body>
</html>
