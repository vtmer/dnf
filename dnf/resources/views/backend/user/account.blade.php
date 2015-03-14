@extends('backend.layouts.dashboard')

@section('title')
{{ Lang::get('backend.title.acl.add') }}
@stop

@section('container')
<div id="content-wrapper">
    <div class="row">
        <div class="col-sm-12">

            <form id="form_account" action="{{ $formUrl }}" method="post" class="panel form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $data->id}}">
                <input type="hidden" name="group_id" value="{{ $data->group->id}}">
                <div class="panel-heading">
                    <span class="panel-title">{{ Lang::get('backend.edit-self')}}</span>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">{{ Lang::get('backend.form.user')}}</label>
                        <div class="col-sm-5">
                            <div class="has-feedback">
                                <input type="text" class="form-control" name="name" id="name" value="{{ $data->name or old('name') }}">
                                <i class="fa fa-asterisk form-control-feedback"></i>
                            </div>
                        </div>
                    </div> <!-- / .form-group -->
                    <div class="form-group">
                        <label for="realname" class="col-sm-2 control-label">{{ Lang::get('backend.form.realname')}}</label>
                        <div class="col-sm-5">
                            <div class="has-feedback">
                                <input type="text" name="realname" class="form-control" id="realname" value="{{ $data->realname or old('realname') }}">
                                <i class="fa fa-asterisk form-control-feedback"></i>
                            </div>
                        </div>
                    </div> <!-- / .form-group -->
                    <div class="form-group">
                        <label for="mobile" class="col-sm-2 control-label">{{ Lang::get('backend.form.mobile')}}</label>
                        <div class="col-sm-5">
                            <div class="has-feedback">
                                <input type="text" name="mobile" class="form-control" id="mobile" value="{{ $data->mobile or old('mobile') }}">
                                <i class="fa fa-asterisk form-control-feedback"></i>
                            </div>
                        </div>
                    </div> <!-- / .form-group -->
                    <div class="form-group">
                        <label for="old-password" class="col-sm-2 control-label">{{ Lang::get('backend.form.old-password')}}</label>
                        <div class="col-sm-5">
                            <div class="has-feedback">
                                <input type="password" name="old_password" class="form-control" id="old-password" value="">
                            </div>
                        </div>
                    </div> <!-- / .form-group -->
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">{{ Lang::get('backend.form.password')}}</label>
                        <div class="col-sm-5">
                            <div class="has-feedback">
                                <input type="password" name="password" class="form-control" id="password" value="">
                            </div>
                        </div>
                    </div> <!-- / .form-group -->
                    <div class="form-group">
                        <label for="password-confirmation" class="col-sm-2 control-label">{{ Lang::get('backend.form.password-confirmation')}}</label>
                        <div class="col-sm-5">
                            <div class="has-feedback">
                                <input type="password" name="password_confirmation" class="form-control" id="password-confirmation" value="">
                            </div>
                        </div>
                    </div> <!-- / .form-group -->
                    <div class="form-group" style="margin-bottom: 0;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">{{ Lang::get('backend.save') }}</button>
                            <button class="btn " onclick="javascript:history.go(-1);" type="button">{{ Lang::get('backend.return') }}</button>
                        </div>
                    </div> <!-- / .form-group -->
                </div>
            </form>

        </div>
    </div>

</div> <!-- / #content-wrapper -->
@stop

@section('scripts')
@parent
<script type="text/javascript">
    init.push(function () {
        // 表单验证
        $("#form_account").validate({ focusInvalid: true, errorPlacement: function () {} });
        $("#name").rules("add", { required: true });
        $("#realname").rules("add", { required: true });
        $("#mobile").rules("add", { required: true, number: true });
        $("#old-password").rules("add", {
            minlength: 6,
            maxlength: 20
        });
        $("#password").rules("add", {
            minlength: 6,
            maxlength: 20
        });
        $("#password-confirmation").rules("add", {
            equalTo: "#password"
        });
    });
    window.PixelAdmin.start(init);
</script>
@stop

