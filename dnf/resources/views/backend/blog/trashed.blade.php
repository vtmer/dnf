@extends('backend.layouts.dashboard')

@section('title')
{{ Lang::get('backend.title.blog.article') }}
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
                                    <th>{{ Lang::get('backend.form.blog.title') }}</th>
                                    <th>{{ Lang::get('backend.form.blog.tag') }}</th>
                                    <th>{{ Lang::get('backend.form.blog.author') }}</th>
                                    <th>{{ Lang::get('backend.form.blog.category-belong') }}</th>
                                    <th>{{ Lang::get('backend.create-time') }}</th>
                                    <th>{{ Lang::get('backend.form.status') }}</th>
                                    <th>{{ Lang::get('backend.form.blog.deleter') }}</th>
                                    <th>{{ Lang::get('backend.update-time') }}</th>
                                    <th>{{ Lang::get('backend.operate') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                <tr id="articleList-data-id-{{ $data->id }}">
                                    <td class="center">{{{ $data->title}}}</td>
                                    <td class= "center">                                     
                                                <div class="row">
                                                        
                                                        <div  class="col-sm-12">
                                                            @foreach($data->tags as $tag) 
                                                                 <a href="#" class="label label-primary label-tag"  title = "查看标签下所有文章" > {{$tag->tag}}</a>    
                                                            @endforeach                    
                                                        </div>
                                                    </div>
                                           
                                   </td>
                                    <td class="center">{{{ $data->author }}}</td>
                                    <td class= "center">{{{ $data->category->category}}}</td>
                                    <td class="center">{{{ $data->created_at }}}</td>
                                    <td class="center">
                                         {!! AclWidget::change(route('backend_blog_articles_change-status'), 'blog', 'articles', 'change-status', Lang::get('backend.button-status.article-status.'.$data->draft), 'status-id-'.$data->id, $data->id) !!}

                                    </td>
                                    <td class="updater">{{{ $data->updater}}}</td>
                                    <td class="center" >{{{ $data->updated_at}}}</td>
                                     <td class= "center">

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
