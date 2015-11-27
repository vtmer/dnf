@extends('backend.layouts.dashboard')

@section('title')
{{ Lang::get('backend.title.blog.create') }}
@stop

@section('container')
<div id="content-wrapper">

  <style type="text/css">
  .btn{display: block;margin-top: 10px;}
</style>
    <div class="row">
        <div class="col-sm-12">

            <form id="form_article"  action="{{ $formUrl }}"   method="POST"  class="panel form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                 <input type="hidden" name="id" value="{{ $data->id or '' }}">
                 <input type="hidden" name="updater"  id="updater" value='无' />
                <div class="panel-heading">
                    <span class="panel-title">{{ Lang::get('backend.create')}}</span>

                </div>

                 <div class="form-group">
                          <label for="title" class="col-sm-1 control-label">图片：</label>
                          <div class="col-sm-10">
                              <div class="has-feedback">
                                  <img width="300" id="img" src="{{{$data->img_URL or ''}}}">
                                   <input type="hidden" name="img_URL" id="img_URL" value="{{{$data->img_URL or ''}}}" >
                                   <br>
                                  <button class="btn btn-primary" type="button" onclick="uploadPic('img');" />上传图片</button>
                              </div>
                         </div>
               </div> <!-- / .form-group -->


               <div class="panel-body">
                    <div class="form-group">
                        <label for="title" class="col-sm-1 control-label">{{ Lang::get('backend.form.blog.title')}}：</label>
                        <div class="col-sm-9">
                            <div class="has-feedback">
                                <input type="text" class="form-control" name="title" id="title"   value="{{ $data->title or old('title') }}"  placeholder="文章标题">
                                <i class="fa fa-asterisk form-control-feedback"></i>
                            </div>
                        </div>
                      </div> <!-- / .form-group -->




                     <div class="form-group">
                      <label for="tag" class="col-md-1 control-label">{{ Lang::get('backend.form.blog.tag')}}：</label>
                          <div class="col-md-9 select2-primary">
                              <div class=" select2-disabled-examples select2-colors-examples">
                                <div class="select2-primary">
                                  <select  id = "tag"  name="tag_id[]" multiple="multiple"  class="form-control" placeholder= "请选择标签（可多选）">
                                  <option></option>
                                    @foreach($tags as $tag)
                                    <option value="{{ $tag['id'] }}"
                                    @if(isset($data)  )
                                    @foreach($data->tags as $Tag)
                                        @if($Tag->id == $tag->id)
                                        selected
                                    @endif

                                    @endforeach
                                      @endif
                                    >{{{ $tag->tag }}}</option>
                                    @endforeach
                                </select>
                               </div>
                            </div>
                        </div>

                               <button  type="button"  class="btn btn-primary"  data-toggle="modal" data-target="#new_myModal_tag" >
                               <span  class=" fa-tag"   style="font-size: 20px;"></span>
                                </button>

                    </div>


                    <div class="form-group">
                        <label for="author" class="col-sm-1 control-label">{{ Lang::get('backend.form.blog.author')}}：</label>
                        <div class="col-sm-9">
                            <div class="has-feedback">
                                <input type="text" class="form-control" name="author" id="author" value="{{ $data->author or old('author') }}" placeholder="请输入作者名字">
                                <i class="fa fa-asterisk form-control-feedback"></i>
                            </div>
                         </div>
                    </div> <!-- / .form-group -->

                  <div class="form-group">
                      <label for="source" class="col-md-1 control-label">{{ Lang::get('backend.form.blog.source')}}：</label>
                        <div class="col-sm-9">
                          <div class="has-feedback">
                            <input type="text" class="form-control" name="source" id="source" value="{{ $data->source or old('source') }}"  placeholder="@lang('backend.messages.input-source')">
                             <i class="fa fa-asterisk form-control-feedback"></i>
                           </div>
                        </div>
                    </div>

                 <div class="form-group">
                      <label for="description" class="col-md-1 control-label">{{ Lang::get('backend.form.blog.description')}}：</label>
                        <div class="col-sm-9">
                          <div class="has-feedback">
                            <input type="text" class="form-control" name="description" id="description" value="{{ $data->description or old('description') }}"  placeholder="@lang('backend.messages.input-source')">
                             <i class="fa fa-asterisk form-control-feedback"></i>
                           </div>
                        </div>
                    </div>



                  <!-- editor -->
                   <div class="form-group">
                     <label for="content" class="col-sm-1 control-label">{{ Lang::get('backend.form.blog.content')}}：</label>
                        <div class="col-sm-10">
                            <div class="has-feedback">
                             <textarea  class="form-control"  name="content"  id="content" > {{ $data->content or old('content') }}</textarea>
                            </div>
                     </div>
                  </div> <!-- / .form-group -->

                    <div class="form-group">
                      <label for="draft" class="col-md-1 control-label">{{ Lang::get('backend.form.blog.category')}}：</label>
                          <div class="col-md-9 select2-primary">
                            <div class="has-feedback">
                           <select id="category" name="category_id" class="form-control">
                             <option></option>
                                    @foreach($categorys as $category)
                                    <option value="{{{ $category->id }}}" @if(isset($data) && $category->id ==$data->category->id) selected @endif>{{{ $category->category }}}</option>
                                    @endforeach
                                </select>
                              </div>
                        </div>
                    </div>

                    <div class="form-group">
                      <label for="draft" class="col-md-1 control-label">{{ Lang::get('backend.form.blog.status')}}：</label>
                          <div class="col-md-9 select2-primary">
                            <div class="has-feedback">
                            <select id="draft" name="draft" class="form-control form-group-margin">
                               <option></option>
                                <option value="0" @if(isset($data) && $data['draft'] == '0' )selected @endif>{{ Lang::get('backend.form.blog.post')}}</option>
                                <option value="1" @if(isset($data) && $data['draft'] == '1' )selected @endif>{{ Lang::get('backend.form.blog.trashed')}}</option>
                            </select>
                          </div>
                    </div>
                  </div>

                           <div class="form-group" style="margin-bottom: 0;">
                           <div class="col-sm-offset-8 col-sm-10">
                             <button type="submit" class="btn btn-primary" > {{ Lang::get('backend.upload') }}</button>
                           </div>
                       </div> <!-- / .form-group -->
                  </div>
           </form>
      </div>
   </div>



<div class="modal fade" id="new_myModal_tag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
     <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title" id="myModalLabel"><i class="fa fa-tag page-header-icon"></i>&nbsp;&nbsp;创建新标签</h3>
             </div>


               <form id="form_tag"  action="{{route("backend_blog_tag_create")}}"   method="POST"  class="panel form-horizontal">
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                       <div class="form-group">
                        <label for="tag" class="col-sm-2 control-label">{{ Lang::get('backend.form.blog.tag')}}：</label>
                          <div class="col-sm-10">
                                <div class="has-feedback">
                                     <input type="text" class="form-control" name="tag"  id="tag" placeholder='标签名'>
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



@stop
@section('scripts')
    @parent
                          <script>
                            // Replace the <textarea id="editor1"> with a CKEditor
                            // instance, using  configuration.
                          CKEDITOR.replace( 'content',

                         {
                              filebrowserBrowseUrl : "{{{ URL::asset('packages/ckfinder/ckfinder.html')}}}",
                             filebrowserImageBrowseUrl : "{{{ URL::asset('packages/ckfinder/ckfinder.html?Type=Images')}}}",
                             filebrowserFlashBrowseUrl : "{{{ URL::asset('packages/ckfinder/ckfinder.html?Type=Flash')}}}",
                             filebrowserUploadUrl : "{{{ URL::asset('packages/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files')}}}",
                             filebrowserImageUploadUrl : "{{{ URL::asset('packages/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images')}}}",
                              filebrowserFlashUploadUrl : "{{{ URL::asset('packages/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash')}}}"
                         });

                          </script>
                          <script type="text/javascript">
                                init.push(function () {
                                // Single select
                                $("#category").select2({
                                allowClear: true,
                                placeholder: "<?php echo Lang::get('backend.messages.select-category'); ?>"
                                });

                                // Single select
                                $("#draft").select2({
                                allowClear: true,
                                placeholder: "<?php echo Lang::get('backend.messages.select-status'); ?>"
                                 });
                                });
                               window.PixelAdmin.start(init);
                          </script>
                           <script>
                                  function movieFormatResult(movie) {
                                    var markup = "<table class='movie-result'><tr>";
                                    if (movie.posters !== undefined && movie.posters.thumbnail !== undefined) {
                                      markup += "<td class='movie-image' style='vertical-align: top'><img src='" + movie.posters.thumbnail + "' style='max-width: 60px; display: inline-block; margin-right: 10px; margin-left: 10px;' /></td>";
                                    }
                                    markup += "<td class='movie-info'><div class='movie-title' style='font-weight: 600; color: #000; margin-bottom: 6px;'>" + movie.title + "</div>";
                                    if (movie.critics_consensus !== undefined) {
                                      markup += "<div class='movie-synopsis'>" + movie.critics_consensus + "</div>";
                                    }
                                    else if (movie.synopsis !== undefined) {
                                      markup += "<div class='movie-synopsis'>" + movie.synopsis + "</div>";
                                    }
                                    markup += "</td></tr></table>";
                                    return markup;
                                  }

                                  function movieFormatSelection(movie) {
                                    return movie.title;
                                  }

                                  init.push(function () {
                                    // Disabled state
                                    $(".select2-disabled-examples select").select2({ placeholder: 'Select option...' });

                                    // Colors
                                    $(".select2-colors-examples select").select2();
                            });
                        </script>

@stop
