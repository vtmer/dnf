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
            <form id="form_group" action="{{ $formUrl }}" method="post" class="panel form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $data->id or '' }}">
                <div class="panel-heading">
                    <span class="panel-title">{{ Lang::get('backend.acl-set')}}</span>
                </div>
                @include('backend.widgets.acl')
            </form>

        </div>
    </div>

</div> <!-- / #content-wrapper -->
@stop

@section('scripts')
@parent
<script type="text/javascript">
    init.push(function () {
    });
    window.PixelAdmin.start(init);
</script>
@stop

