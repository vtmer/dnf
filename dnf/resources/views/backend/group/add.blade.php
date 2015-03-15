@extends('backend.layouts.dashboard')

@section('title')
{{ Lang::get('backend.title.acl.add') }}
@stop

@section('container')
<div id="content-wrapper">
    <div class="row">
        <div class="col-sm-12">

            <form id="form_group" action="{{ $formUrl }}" method="post" class="panel form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $data->id or '' }}">
                <div class="panel-heading">
                    <span class="panel-title">{{ Lang::get('backend.add-group')}}</span>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">{{ Lang::get('backend.form.group')}}</label>
                        <div class="col-sm-5">
                            <div class="has-feedback">
                                <input type="text" class="form-control" name="name" id="name" value="{{ $data->name or old('name') }}">
                                <i class="fa fa-asterisk form-control-feedback"></i>
                            </div>
                        </div>
                    </div> <!-- / .form-group -->
                    <div class="form-group">
                        <label for="level" class="col-sm-2 control-label">{{ Lang::get('backend.form.group-level')}}</label>
                        <div class="col-sm-5">
                            <div class="has-feedback">
                                <input type="number" name="level" class="form-control" id="level" value="{{ $data->level or old('level') }}">
                                <i class="fa fa-asterisk form-control-feedback"></i>
                            </div>
                        </div>
                    </div> <!-- / .form-group -->
                    <div class="form-group">
                        <label for="mark" class="col-sm-2 control-label">{{ Lang::get('backend.form.mark') }}</label>
                        <div class="col-sm-7">
                            <textarea id="mark" class="form-control" name="mark" >{{{ $data->mark or old('mark') }}}</textarea>
                            <div id="mark-limit-label" class="limiter-label">{{ Lang::get('backend.character-left') }} : <span class="limiter-count"></span></div>
                        </div>
                    </div> <!-- / .form-group -->
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
        $("#parent-function").select2({
            allowClear: true,
        });

        // 表单验证
        $("#form_group").validate({ focusInvalid: true, errorPlacement: function () {} });
        // Validate username
        $("#name").rules("add", { required: true });
        // Validate class
        $("#level").rules("add", { required: true });

        // 备注长度限制
        $("#mark").limiter(100, { label: '#mark-limit-label' });
    })
    window.PixelAdmin.start(init);
</script>
@stop

