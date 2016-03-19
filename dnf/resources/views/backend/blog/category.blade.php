@extends('backend.layouts.dashboard')

@section('title')
{{ Lang::get('backend.title.blog.category') }}
@stop

@section('container')
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div id="content-wrapper">
    <div class="page-header">
        <div class="row">
            <!-- Page header, center on small screens -->
            <h1 class="col-xs-12 col-sm-10 text-center text-left-sm"><i class="fa fa-book page-header-icon"></i>&nbsp;&nbsp;{{ Lang::get('backend.category-management') }}</h1>
            <div class="col-xs-12 col-sm-2">
                   <div class="row">
                    <hr class="visible-xs no-grid-gutter-h">
                    <!-- "Create project" button, width=auto on desktops -->
                      <button class="btn btn-primary btn-lg"  data-toggle="modal" data-target="#new_myModal_cata">

                      <span  class="fa-pencil-square"   style="font-size: 18px;"></span>
                      创建新栏目
                     </button>
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
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="categoryList">
                            <thead>
                                <tr>
                                    <th>{{ Lang::get('backend.form.blog.category') }}</th>
                                    <th>{{ Lang::get('backend.form.blog.creator') }}</th>
                                    <th>{{ Lang::get('backend.form.blog.category-time') }}</th>
                                    <th>{{ Lang::get('backend.form.blog.updater') }}</th>
                                    <th>{{ Lang::get('backend.form.blog.update-time') }}</th>
                                    <th>{{ Lang::get('backend.edit') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                <tr id="categoryList-data-id-{{ $data->id }}">
                                    <td class="category">{{{ $data->category }}}</td>
                                    <td class="creator">{{{ $data->creator }}}</td>
                                    <td class="center">{{{ $data->created_at }}}</td>
                                    <td class="updater">{{{ $data->updater}}}</td>
                                    <td class="center" >{{{ $data->updated_at}}}</td>
                                    <td class= "center">
                                    <input type="hidden"  calss="updater_id" id="updater_id"  name="updater_id" value="{{{ $data->id}}}"/>
                                     <button class="btn btn-primary btn-rounded update-cate" data-toggle="modal" data-target="#update_myModal_cata">
                                     <i class="fa fa-pencil"></i></a>
                                     </button>

                                        {!! AclWidget::delete(route('backend_blog_category_delete', false), 'blog', 'category', 'delete', 'categoryList', $data->id ) !!}
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

<div class="modal fade" id="new_myModal_cata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
     <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title" id="myModalLabel">创建新栏目</h3>
        </div>
               <form id="form_category"  action="{{route("backend_blog_category_create")}}"   method="POST"  class="panel form-horizontal">
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="modal-body">
       <div class="form-group">
        <label for="category" class="col-sm-2 control-label">{{ Lang::get('backend.form.blog.category')}}：</label>
          <div class="col-sm-10">
                <div class="has-feedback">
                     <input type="text" class="form-control" name="category"  id="category" placeholder='栏目名'>
                     <i class="fa fa-asterisk form-control-feedback"> </i>
                    <input type="hidden" id="updater"  name="updater" value=' 无' />
               </div>
          </div>
        </div>

    </div><!--/.modal-body-->
    <div class="modal-footer">
    <button type="submit" class="btn btn-primary" >创建</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    </div>
    </form>
      </div><!-- /.modal-content -->

   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="update_myModal_cata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
     <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title" id="myModalLabel">更新栏目</h3>
        </div>
  <form id="form_category"  action="{{route("backend_blog_category_update")}}"   method="POST"  class="panel form-horizontal">
 <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="modal-body">
       <div class="form-group">
        <label for="category" class="col-sm-2 control-label">{{ Lang::get('backend.form.blog.category')}}：</label>
          <div class="col-sm-10">
                <div class="has-feedback">
                     <input type="text" class="form-control " name="category" id='update-cate'  >
                <i class="fa fa-asterisk form-control-feedback"> </i>
                 <input type="hidden"  name="creator"  id="update-creator" >
                 <input type="hidden"  name="id"  id="update-creator-id" >
               </div>
          </div>
        </div>

    </div><!--/.modal-body-->
    <div class="modal-footer">
    <button  type="submit" class="btn btn-primary" >保存</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    </div>
    </form>
      </div><!-- /.modal-content -->

   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div> <!-- / #content-wrapper -->

@stop

@section('scripts')
    @parent
    <script type="text/javascript">
        init.push(function () {
            $('#categoryList').dataTable();
            $('#categoryList_wrapper .table-caption').text('栏目列表');
            $('#categoryList_wrapper .dataTables_filter input').attr('placeholder', 'Search...');
            $('#categoryList_wrapper .dataTables_empty').text('No data !');
            $("#form_category")  .validate({ focusInvalid: true, errorPlacement: function () {} });
            $('#category').rules("add", {
                required: true,
                maxlength: 20
             });
              $('#creator').rules("add", {
              required:true
           });
            $('#updater').rules("add", {
                required: true,
                maxlength: 20
             });
        });

        window.PixelAdmin.start(init);


    </script>
    <script>
   $(".update-cate").click(function () {
     var text  =  $(this).parent().siblings("td.category").text() ;
    $("#update-cate").val(text);
1
    var creator  =  $(this).parent().siblings("td.creator").text() ;
    $("#update-creator").val(creator);

        var updater_id  =  $(this).siblings($("#updater_id")).attr("value") ;
    $("#update-creator-id").val(updater_id);

    });
    </script>



@stop
