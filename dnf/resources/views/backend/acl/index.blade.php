@extends('backend.layouts.dashboard')

@section('title')
{{ Lang::get('backend.title.acl.index') }}
@stop

@section('container')
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div id="content-wrapper">
    <div class="page-header">
        <div class="row">
            <!-- Page header, center on small screens -->
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;{{ Lang::get('backend.menu-management')}}</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">
                    <hr class="visible-xs no-grid-gutter-h">
                    <!-- "Create project" button, width=auto on desktops -->
                    <div class="pull-right col-xs-12 col-sm-auto">{!! AclWidget::add(route('backend_system_acl_add'), 'system', 'acl', 'add', Lang::get('backend.add-menu')) !!}</div>
                    <div class="visible-xs clearfix form-group-margin"></div>
                </div>
            </div>
        </div>
    </div> <!-- / .page-header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="table-primary">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="aclList">
                            <thead>
                                <tr>
                                    <th>{{ Lang::get('backend.form.menu') }}</th>
                                    <th>{{ Lang::get('backend.form.module') }}</th>
                                    <th>{{ Lang::get('backend.form.class') }}</th>
                                    <th>{{ Lang::get('backend.form.function') }}</th>
                                    <th>{{ Lang::get('backend.form.mark') }}</th>
                                    <th>{{ Lang::get('backend.create-time') }}</th>
                                    <th>{{ Lang::get('backend.update-time') }}</th>
                                    <th>{{ Lang::get('backend.operate') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                <tr id="aclList-data-id-{{ $data->id }}">
                                    <td class="center">{{{ $data->name }}}</td>
                                    <td class="center">{{{ $data->module }}}</td>
                                    <td class="center">{{{ $data->class }}}</td>
                                    <td class="center">{{{ $data->function }}}</td>
                                    <td class="center">{{{ $data->mark }}}</td>
                                    <td class="center">{{{ $data->created_at }}}</td>
                                    <td class="center">{{{ $data->updated_at }}}</td>
                                    <td class="center">
                                        {!! AclWidget::edit(route('backend_system_acl_edit', ['id' => $data->id]), 'system', 'acl', 'edit', null) !!}
                                        {!! AclWidget::delete(route('backend_system_acl_delete', false), 'system', 'acl', 'delete', 'aclList',  $data->id ) !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div> <!-- / #content-wrapper -->

@stop

@section('scripts')
    @parent
    <script type="text/javascript">
        init.push(function () {
            $('#aclList').dataTable();
            $('#aclList_wrapper .table-caption').text('Some header text');
            $('#aclList_wrapper .dataTables_filter input').attr('placeholder', 'Search...');
            $('#aclList_wrapper .dataTables_empty').text('No data !');
        });
        window.PixelAdmin.start(init);
    </script>
@stop

