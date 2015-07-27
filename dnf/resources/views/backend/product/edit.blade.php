@extends('backend.layouts.dashboard')

@section('title')
{{ Lang::get('backend.title.product.update') }}
@stop

@section('container')
<div id="content-wrapper">
    <div class="row">
        <div class="col-sm-12">

            <form id="form_product"  action="{{ $formUrl }}"   method="POST"  class="panel form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                 <input type="hidden" name="id" value="{{ $data->id or '' }}">
                 <input type="hidden" name="updater"  id="updater" value='无' />
                <div class="panel-heading">
                    <span class="panel-title">{{ Lang::get('backend.edit-product')}}</span>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-1 control-label">{{ Lang::get('backend.form.product.name')}}：</label>
                        <div class="col-sm-9">
                            <div class="has-feedback">
                                <input type="text" class="form-control" name="name" id="name"   value="{{ $data->name or old('name') }}"  placeholder="产品案例名称">
                                <i class="fa fa-asterisk form-control-feedback"></i>
                            </div>
                        </div>
                      </div> <!-- / .form-group -->   

                    <div class="form-group">
                        <label for="holder" class="col-sm-1 control-label">{{ Lang::get('backend.form.product.holder')}}：</label>
                        <div class="col-sm-9">
                            <div class="has-feedback">
                                <input type="text" class="form-control" name="holder" id="holder" value="{{ $data->holder or old('holder') }}" placeholder="产品持有人/公司">
                                <i class="fa fa-asterisk form-control-feedback"></i>
                            </div>
                         </div>
                    </div> <!-- / .form-group --> 


                <div class="form-group">
                        <label for="url" class="col-sm-1 control-label">{{ Lang::get('backend.form.product.url')}}：</label>
                        <div class="col-sm-9">
                            <div class="has-feedback">
                                <input type="url" class="form-control" name="url" id="url" value="{{ $data->url or old('url') }}" placeholder="链接">
                                <i class="fa fa-asterisk form-control-feedback"></i>
                            </div>
                         </div>
                    </div> <!-- / .form-group --> 

                 <div class="form-group">
                      <label for="description" class="col-md-1 control-label">{{ Lang::get('backend.form.product.description')}}：</label>
                        <div class="col-sm-9">
                          <div class="has-feedback">
                            <input type="text" class="form-control" name="description" id="description" value="{{ $data->description or old('description') }}"  placeholder="@lang('backend.messages.input-source')">
                             <i class="fa fa-asterisk form-control-feedback"></i>
                           </div> 
                        </div>
                    </div>    


                          <!--   将以逗号隔开的图片的url分离出来并且去掉空的url   -->
                          <?php $img_URLs = array_filter(explode(",",$data->img_URL)) ; $id = 0; ?>    

                     <div class="form-group" id = "pic">
                          <label for="title" class="col-sm-1 control-label">图片：</label>
                         @foreach($img_URLs as $img_URL) 
                          <?php $id = $id+1?>
                         <div class="col-sm-3  div{{{$id}}}">
                              <div class="has-feedback">
                                  <img width = "auto" height = "200" id="{{{$id}}}" src="{{{$img_URL}}}">
                                   <input type="hidden" name="{{{$id}}}_URL" id="{{{$id}}}_URL" value="{{{$img_URL}}}" >
                                   <br><br>
                                  <button class="btn btn-primary btn-rounded  fa-cloud-upload " type="button" onclick="uploadPic('{{{$id}}}');" />上传</button>
                                   <button class="btn btn-danger btn-rounded {{{$id}}} fa-trash-o " type="button" onclick="del({{{$id}}})" /></button>
                                    <br><br>
                              </div>
                         </div>
                                @endforeach

                      </div> <!-- / .form-group -->
                        <br>

                          <div class="form-group" style="margin-bottom: 0;">
                           <div class="col-sm-offset-4 col-sm-10">
                             <button class="btn btn-success btn-rounded   fa-plus-square" id="shangChuan1" type="button" onclick="add()" />添加图片</button>
                           </div>
                       </div> <!-- / .form-group -->


                            <div class="form-group" style="margin-bottom: 0;">
                           <div class="col-sm-offset-8 col-sm-10">
                             <button type="submit" class="btn btn-primary" > {{ Lang::get('backend.upload') }}</button>
                           </div>
                       </div> <!-- / .form-group -->            
                  </div>
           </form>
      </div>
   </div>
@stop


@section('scripts')
    @parent
              <script>
              function del(id){
                var r = confirm("Are  you  sure?");
                if (r == true) {
                      $(".div"+id).remove();
                } 
              }

              var num = 20;
                function add(){
                   $(" <div class=\"col-sm-3  div"+num+"\" ><div class=\"has-feedback\"><img width = \"auto\"height=\"200\" id=\""+num+"\" src=> <input type=\"hidden\" name=\""+num+"_URL\" id=\""+num+"_URL\" value=>"+  
                    "<br><button class=\"btn btn-primary btn-rounded  fa-cloud-upload \" type=\"button\" onclick=\"uploadPic('"+num+"');\" >"+"上传"+"</button>"+
                    " <button class=\"btn btn-danger btn-rounded "+num+" fa-trash-o \" type=\"button\" onclick=\"del("+num+")\" ></button>"+"</div></div>").appendTo($("#pic"));
                  num++;
                 }
              </script>


@stop
