@extends('backend.layouts.dashboard')

@section('title')
{{ Lang::get('backend.title.course.article') }}
@stop

@section('container')
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div id="content-wrapper">
    <div class="page-header">
        <div class="row">
            <!-- Page header, center on small screens -->
            <h1 class="col-xs-12 col-sm-10 text-center text-left-sm"><i class="fa fa-pencil page-header-icon"></i>&nbsp;&nbsp;{{ Lang::get('backend.courseArticle-management') }}</h1>
            <div class="col-xs-12 col-sm-2">
                <div class="row">
                    <hr class="visible-xs no-grid-gutter-h">

                    <!-- "Create project" button, width=auto on desktops -->
                        <div class="pull-right col-xs-12 col-sm-auto">{!! AclWidget::add(route('backend_course_articles_create'), 'course', 'articles', '_create', Lang::get('backend.createCourse')) !!}</div>
                        <div class="visible-xs clearfix form-group-margin"></div>
                      </div>

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
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="articleList">
                            <thead>
                                <tr>
                                    <th>{{ Lang::get('backend.form.course.title') }}</th>
                                    <th>{{ Lang::get('backend.form.course.course-belong') }}</th>
                                    <th>{{ Lang::get('backend.form.course.author') }}</th>
                                    <th>{{ Lang::get('backend.create-time') }}</th>
                                    <th>{{ Lang::get('backend.form.status') }}</th>
                                    <th>{{ Lang::get('backend.form.course.updater') }}</th>
                                    <th>{{ Lang::get('backend.update-time') }}</th>
                                    <th>{{ Lang::get('backend.operate') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                <tr id="articleList-data-id-{{ $data->id }}">
                                    <td class="center">{{{ $data->title}}}</td>
                                    <td class= "center">{{{ $data->course->name}}}</td>
                                    <td class="center">{{{ $data->author}}}</td>
                                    <td class="center">{{{ $data->created_at }}}</td>
                                    <td class="center">
                                         {!! AclWidget::change(route('backend_course_articles_change-status'), 'course', 'articles', 'change-status', Lang::get('backend.button-status.article-status.'.$data->draft), 'status-id-'.$data->id, $data->id) !!}

                                    </td>
                                    <td class="updater">{{{ $data->updater}}}</td>
                                    <td class="center" >{{{ $data->updated_at}}}</td>
                                    <td class= "center">

                                         {!! AclWidget::edit(route('backend_course_articles_update', ['id' => $data->id]), 'course', 'articles', 'update', null) !!}
                                         {!! AclWidget::delete(route('backend_course_articles_softdelete', false), 'course', 'articles', 'softdelete', 'articleList', $data->id ) !!}



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



@stop

@section('scripts')
    @parent
    <script type="text/javascript">
        init.push(function () {
            $('#articleList').dataTable();
            $('#articleList_wrapper .table-caption').text(' 教程文章列表');
            $('#articleList_wrapper .dataTables_filter input').attr('placeholder', 'Search...');
            $('#articleList_wrapper .dataTables_empty').text('No data !');

        });

        window.PixelAdmin.start(init);


    </script>


 
@stop
