@extends('backend.layouts.dashboard')

@section('title')
{{ Lang::get('backend.title.index') }}
@stop

@section('container')
<div id="content-wrapper">
    <div class="page-header">
        <div class="row">
            <!-- Page header, center on small screens -->
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;{{ Lang::get('backend.workspace') }}</h1>
        </div>
    </div> <!-- / .page-header -->
    <div class="row">
        <div class="col-sm-8">
            <ul id="uidemo-tabs-default-demo" class="nav nav-tabs">
                <li class="active">
                    <a href="#uidemo-tabs-default-demo-home" data-toggle="tab">{{ Lang::get('backend.newest-action') }}</a>
                </li>
                <!--<li class="">
                    <a href="#uidemo-tabs-default-demo-profile" data-toggle="tab">Profile <span class="badge badge-primary">12</span></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown&nbsp;&nbsp;<i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#uidemo-tabs-default-demo-dropdown1" data-toggle="tab">@fat</a></li>
                        <li><a href="#uidemo-tabs-default-demo-dropdown2" data-toggle="tab">@mdo</a></li>
                    </ul>
                </li>--> <!-- / .dropdown -->
            </ul>

            <div class="tab-content tab-content-bordered">
                <div class="tab-pane fade active in" id="uidemo-tabs-default-demo-home">

                    <div class="widget-comments panel-body tab-pane no-padding fade active in" id="dashboard-recent-comments">
                        <div class="panel-padding no-padding-vr">
                            @foreach ($actions as $action)
                            <div class="comment">
                                <div class="comment-by">
                                    <a>{{ $action->uname }}</a> {{ Lang::get('backend.action.'.$action->type) }} : <a>{{ $action->title }}</a>
                                    <span class="pull-right">{{ Helper::mdate($action->created_at) }}</span>
                                </div>
                                <div class="comment-text">
                                    {{ $action->description }}
                                </div>
                            </div> <!-- / .comment -->
                            @endforeach
                            <div id="pagination">
                            {!! $actions->render() !!}
                            </div>
                        </div>
                    </div>

                </div> <!-- / .tab-pane -->
            </div> <!-- / .tab-content -->
        </div>
        <div class="col-sm-4">
            <div class="panel colourable">
                <div class="panel-body">
                    <img width="100" id="demo-img" src="">
                    <input type="hidden" name="url" id="demo-img-url" value="">
                    <button class="btn btn-primary" type="button" onclick="uploadPic('demo-img');" />上传图片</button>
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
            // Javascript code here
        })
        window.PixelAdmin.start(init);
    </script>
@stop

