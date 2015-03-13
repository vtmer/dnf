@extends('backend.layouts.dashboard')

@section('title')
{{ Lang::get('backend.title.acl.add') }}
@stop

@section('container')
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">{{ Lang::get('backend.where') }} :</div>
        <li class="active"><a href="#">系统管理</a></li>
    </ul>
    <div class="row">
        <div class="col-sm-12">

            <form id="form_user" action="{{ $formUrl }}" method="post" class="panel form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $data->id or '' }}">
                <div class="panel-heading">
                    <span class="panel-title">{{ Lang::get('backend.add-user')}}</span>
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
                        <label for="password" class="col-sm-2 control-label">{{ Lang::get('backend.form.password')}}</label>
                        <div class="col-sm-5">
                            <div class="has-feedback">
                                <input type="password" name="password" class="form-control" id="password" value="">
                                @if(!isset($data))<i class="fa fa-asterisk form-control-feedback"></i>@endif
                            </div>
                        </div>
                    </div> <!-- / .form-group -->
                    <div class="form-group">
                        <label for="password-confirmation" class="col-sm-2 control-label">{{ Lang::get('backend.form.password-confirmation')}}</label>
                        <div class="col-sm-5">
                            <div class="has-feedback">
                                <input type="password" name="password_confirmation" class="form-control" id="password-confirmation" value="">
                                @if(!isset($data))<i class="fa fa-asterisk form-control-feedback"></i>@endif
                            </div>
                        </div>
                    </div> <!-- / .form-group -->
                    <div class="form-group">
                        <label for="group" class="col-sm-2 control-label">{{ Lang::get('backend.form.group') }}</label>
                        <div class="col-sm-5">
                            <div class="has-feedback">
                                <select id="group" name="group_id" class="form-control">
                                    <option></option>
                                    @foreach($groups as $group)
                                    <option value="{{{ $group->id }}}" @if(isset($data) && $group->id == $data->group->id) selected @endif>{{{ $group->name }}}</option>
                                    @endforeach
                                </select>
                                <i class="fa fa-asterisk form-control-feedback"></i>
                            </div>
                        </div>
                    </div> <!-- / .form-group -->
                    <div class="form-group">
                    <div class="form-group" style="margin-bottom: 0;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">{{ Lang::get('backend.save') }}</button>
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
        // Single select
        $("#group").select2({
            allowClear: true,
            placeholder: "<?php echo Lang::get('backend.messages.select-group'); ?>"
        });

        // 表单验证
        $("#form_user").validate({ focusInvalid: true, errorPlacement: function () {} });
        $("#name").rules("add", { required: true });
        $("#realname").rules("add", { required: true });
        $("#mobile").rules("add", { required: true, number: true });
        $("#group").rules("add", { required: true });
        $("#password").rules("add", {
            minlength: 6,
            maxlength: 20
        });
        $("#password-confirmation").rules("add", {
            equalTo: "#password"
        });
        <?php if (!isset($data)): ?>
        $("#password").rules("add", {
            required: true,
        });
        $("#password-confirmation").rules("add", {
            required: true,
        });
        <?php endif; ?>
    });
    window.PixelAdmin.start(init);
</script>
@stop

