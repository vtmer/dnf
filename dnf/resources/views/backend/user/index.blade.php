@extends('backend.layouts.dashboard')

@section('title')
{{ Lang::get('backend.title.acl.index') }}
@stop

@section('container')
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">{{ Lang::get('backend.where') }} :</div>
        <li class="active"><a href="#">系统管理</a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <!-- Page header, center on small screens -->
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Dashboard</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">
                    <hr class="visible-xs no-grid-gutter-h">
                    <!-- "Create project" button, width=auto on desktops -->
                    <div class="pull-right col-xs-12 col-sm-auto">{!! App\Widgets\Backend\AclWidget::add(route('backend_system_user_add'), 'system', 'user', 'add', Lang::get('backend.add-user')) !!}</div>
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
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="userList">
                            <thead>
                                <tr>
                                    <th>{{ Lang::get('backend.form.user') }}</th>
                                    <th>{{ Lang::get('backend.form.realname') }}</th>
                                    <th>{{ Lang::get('backend.form.mobile') }}</th>
                                    <th>{{ Lang::get('backend.form.status') }}</th>
                                    <th>{{ Lang::get('backend.form.group') }}</th>
                                    <th>{{ Lang::get('backend.create-time') }}</th>
                                    <th>{{ Lang::get('backend.form.last-login-time') }}</th>
                                    <th>{{ Lang::get('backend.operate') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                <tr id="userList-data-id-{{ $data->id }}">
                                    <td class="center">{{{ $data->name }}}</td>
                                    <td class="center">{{{ $data->realname }}}</td>
                                    <td class="center">{{{ $data->mobile }}}</td>
                                    <td class="center">
                                        {!! App\Widgets\Backend\AclWidget::change(route('backend_system_user_change-status'), 'system', 'user', 'change-status', Lang::get('backend.button-status.status.'.$data->status), 'status-id-'.$data->id, $data->id) !!}
                                    </td>
                                    <td class="center">{{{ $data->group->name }}}</td>
                                    <td class="center">{{{ $data->created_at }}}</td>
                                    <td class="center">{{{ App\Component\Helper::mdate($data->last_login_time) }}}</td>
                                    <td class="center">
                                        {!! App\Widgets\Backend\AclWidget::edit(route('backend_system_user_edit', ['id' => $data->id]), 'system', 'user', 'edit', null) !!}
                                        {!! App\Widgets\Backend\AclWidget::button(route('backend_system_user_acl', ['id' => $data->id]), 'system', 'user', 'acl', Lang::get('backend.acl-set')) !!}
                                        {!! App\Widgets\Backend\AclWidget::delete(route('backend_system_user_delete', false), 'system', 'user', 'delete', 'userList',  $data->id ) !!}
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
            $('#userList').dataTable();
            $('#userList_wrapper .table-caption').text('Some header text');
            $('#userList_wrapper .dataTables_filter input').attr('placeholder', 'Search...');
            $('#userList_wrapper .dataTables_empty').text('No data !');
        });
        window.PixelAdmin.start(init);
    </script>
@stop

