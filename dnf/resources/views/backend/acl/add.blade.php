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

            <form id="form_acl" action="{{ $formUrl }}" method="post" class="panel form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $data->id or '' }}">
                <div class="panel-heading">
                    <span class="panel-title">{{ Lang::get('backend.add-menu')}}</span>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="menu" class="col-sm-2 control-label">{{ Lang::get('backend.form.menu')}}</label>
                        <div class="col-sm-5">
                            <div class="has-feedback">
                                <input type="text" class="form-control" name="name" id="menu" value="{{ $data->name or old('name') }}">
                                <i class="fa fa-asterisk form-control-feedback"></i>
                            </div>
                        </div>
                    </div> <!-- / .form-group -->
                    <div class="form-group">
                        <label for="module" class="col-sm-2 control-label">{{ Lang::get('backend.form.module')}}</label>
                        <div class="col-sm-5">
                            <div class="has-feedback">
                                <input type="text" name="module" class="form-control" id="module" value="{{ $data->module or old('module') }}">
                                <p class="help-block">{{ Lang::get('backend.messages.about-module') }}</p>
                            </div>
                        </div>
                    </div> <!-- / .form-group -->
                    <div class="form-group">
                        <label for="class" class="col-sm-2 control-label">{{ Lang::get('backend.form.class')}}</label>
                        <div class="col-sm-5">
                            <div class="has-feedback">
                                <input type="text" name="class" class="form-control" id="class" value="{{ $data->class or old('class') }}">
                                <i class="fa fa-asterisk form-control-feedback"></i>
                            </div>
                        </div>
                    </div> <!-- / .form-group -->
                    <div class="form-group">
                        <label for="function" class="col-sm-2 control-label">{{ Lang::get('backend.form.function')}}</label>
                        <div class="col-sm-5">
                            <div class="has-feedback">
                                <input type="text" name="function" class="form-control" id="function" value="{{ $data->function or old('function') }}">
                                <i class="fa fa-asterisk form-control-feedback"></i>
                            </div>
                        </div>
                    </div> <!-- / .form-group -->
                    <div class="form-group">
                        <label for="parent-function" class="col-sm-2 control-label">{{ Lang::get('backend.form.parent-function') }}</label>
                        <div class="col-sm-5">
                            <div class="has-feedback">
                                <select id="parent-function" name="pid" class="form-control">
                                    <option value="0">{{ $menus === false ? Lang::get('backend.messages.cant-change') : Lang::get('backend.messages.select-parent')}}</option>
                                    @if($menus !== false)
                                    @foreach($menus as $menu)
                                    <optgroup label="{{{ $menu->name }}}">
                                        <option value="{{{ $menu->id }}}" @if(isset($data) && $data->pid == $menu->id) selected @endif>{{{ $menu->name }}}</option>
                                        @if(isset($menu['sub']))
                                        @foreach($menu['sub'] as $subMenu)
                                            <option value="{{{ $subMenu->id }}}" @if(isset($data) && $data->pid == $subMenu->id) selected @endif>{{{ $menu->name.'/'.$subMenu->name }}}</option>
                                        @endforeach
                                        @endif
                                    </optgroup>
                                    @endforeach
                                    @endif
                                </select>
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
        $("#form_acl").validate({ focusInvalid: true, errorPlacement: function () {} });
        // Validate username
        $("#menu").rules("add", { required: true });
        // Validate class
        $("#class").rules("add", { required: true });
        // Validate function
        $("#function").rules("add", { required: true });

        // 备注长度限制
        $("#mark").limiter(100, { label: '#mark-limit-label' });
    })
    window.PixelAdmin.start(init);
</script>
@stop

