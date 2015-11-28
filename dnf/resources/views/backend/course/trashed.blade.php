@extends('backend.layouts.dashboard')

@section('title')
{{ Lang::get('backend.title.course.trashed') }}
@stop

@section('container')
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div id="content-wrapper">
    <div class="page-header">
        <div class="row">
            <!-- Page header, center on small screens -->
            <h1 class="col-xs-12 col-sm-10 text-center text-left-sm"><i class="fa-trash-o page-header-icon"></i>&nbsp;&nbsp;{{ Lang::get('backend.trashed') }}</h1>
            <div class="col-xs-12 col-sm-2">
                <div class="row">
                    <hr class="visible-xs no-grid-gutter-h">


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
                                    <th>{{ Lang::get('backend.Forcibly remove') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                                               <tr id="articleList-data-id-{{ $data->id }}">
                                    <td class="center">{{{ $data->title}}}</td>
                                    <td class= "center">
                                                    @foreach($courses as $course)
                                                          @if($data->course_id == $course->id)
                                                                {{{$course->name}}}
                                                                {{{$course_id = $course->id}}}
                                                            @endif
                                                    @endforeach
                                    </td>
                                    <td class="center">{{{ $data->author}}}</td>
                                    <td class="center">{{{ $data->created_at }}}</td>
                                    <td class="center">
                                         {!! AclWidget::change(route('backend_course_articles_change-status'), 'course', 'articles', 'change-status', Lang::get('backend.button-status.article-status.'.$data->draft), 'status-id-'.$data->id, $data->id) !!}

                                    </td>
                                    <td class="updater">{{{ $data->updater}}}</td>
                                    <td class="center" >{{{ $data->updated_at}}}</td>
                                  <td class= "center">
                                             <form id="form_article"  action="{{ route('backend_course_articles_restore') }}"  method="POST"  >
                                                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                     <input type="hidden" name="id" value="{{ $data->id or '' }}">
                                                     <input type="hidden" name="course_id" value="{{ $course_id }}">
                                                     <button type="submit" class="btn btn-primary" >恢复</button>
                                             </form>
                                         </td>      
                                          <td class= "center">
                                             <form id="form_article"  action="{{ route('backend_course_articles_delete') }}"  method="POST"  >
                                                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                     <input type="hidden" name="id" value="{{ $data->id or '' }}">
                                                     <button type="submit" class="btn btn-rounded btn-primary fa-trash-o" > </button>
                                             </form>
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
            $('#articleList_wrapper .table-caption').text('文章列表');
            $('#articleList_wrapper .dataTables_filter input').attr('placeholder', 'Search...');
            $('#articleList_wrapper .dataTables_empty').text('No data !');

        });

        window.PixelAdmin.start(init);


    </script>


 
@stop
