@extends('backend.layouts.dashboard')

@section('title')
{{ Lang::get('backend.title.aboutus.create') }}
@stop

@section('container')
<style type="text/css">
	.btn{display: block;margin-top: 10px;}
</style>
<div id="content-wrapper">
    <div class="row">
        <div class="col-sm-12">

            <form id="form_vtmer"  action="{{ $formUrl }}"   method="POST"  class="panel form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                 <input type="hidden" name="id" value="{{ $data->id or '' }}">
                 <input type="hidden" name="updater"  id="updater" value='无' />
                <div class="panel-heading">
                    <span class="panel-title">{{ Lang::get('backend.add-vtmer')}}</span>

                </div>


                <div class="panel-body">
                    <div class="form-group">
                          <label for="title" class="col-sm-1 control-label">头像：</label>
                          <div class="col-sm-9">
                              <div class="has-feedback">
                                  <img width="100" id="demo-img" src="{{{$data->img_URL or ''}}}">
                                   <input type="hidden" name="img_URL" id="img_URL" value="{{{$data->img_URL or ''}}}" >
                                   <br>
                                  <button class="btn btn-primary" type="button" onclick="uploadPic('demo-img');" />上传头像</button>
                              </div>
                         </div>
                      </div> <!-- / .form-group -->

                      <div class="form-group">
                          <label for="title" class="col-sm-1 control-label">{{ Lang::get('backend.form.aboutus.name')}}：</label>
                          <div class="col-sm-9">
                              <div class="has-feedback">
                                   <input type="text" class="form-control" name="name" id="name"   value="{{ $data->name or old('name') }}"  placeholder="填写姓名">
                                   <i class="fa fa-asterisk form-control-feedback"></i>
                              </div>
                         </div>
                      </div> <!-- / .form-group -->


                    <div class="form-group">
                      <label for="time" class="col-md-1 control-label">{{ Lang::get('backend.form.aboutus.time')}}：</label>
                        <div class="col-sm-9">
                          <div class="has-feedback">
                            
                                <div class="input-group date" id="time">
                                  <input type="text" class="form-control" name="time"  value="{{ $data->time or ''}}" >
                                        <span class="input-group-addon">
                                           <i class="fa fa-calendar"></i>
                                      </span>
                                </div>
                           </div> 
                        </div>
                    </div>    

                      <div class="form-group">
                          <label for="title" class="col-sm-1 control-label">{{ Lang::get('backend.form.aboutus.email')}}：</label>
                          <div class="col-sm-9">
                              <div class="has-feedback">
                                   <input type="email" name="email" class="form-control"  value="{{ $data->email or old('email') }}"  placeholder="填写邮箱，格式为example@exam.com">
                                   <i class="fa fa-asterisk form-control-feedback"></i>
                              </div>
                         </div>
                      </div> <!-- / .form-group -->

                      <div class="form-group">
                          <label for="title" class="col-sm-1 control-label">{{ Lang::get('backend.form.aboutus.blog')}}：</label>
                          <div class="col-sm-9">
                              <div class="has-feedback">
                                   <input type="url" class="form-control form-group-margin"name="blog" id="blog"   value="{{ $data->blog or old('blog') }}"  placeholder="填写blog，格式为http://example.com">
                                   <i class="fa fa-asterisk form-control-feedback"></i>
                              </div>
                         </div>
                      </div> <!-- / .form-group -->



                 <div class="form-group">
                      <label for="introduction" class="col-md-1 control-label">{{ Lang::get('backend.form.aboutus.introduction')}}：</label>
                        <div class="col-sm-9">
                          <div class="has-feedback">
                             <textarea  class="form-control"  name="introduction"  id="introduction" >{{ $data->introduction or old('introduction') }}</textarea>
                             <i class="fa fa-asterisk form-control-feedback"></i>
                             <div id="introduction-label" class="limiter-label">字数剩余: <span class="limiter-count"></span></div>
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


@stop
@section('scripts')
    @parent
                          <script type="text/javascript">
                   
                               $('#time').datepicker({
                                      format: 'yyyy-mm-dd'
                               });
                        </script>

                        <script >                    
                              init.push(function () {
                                    $("#introduction").limiter(300, { label: '#introduction-label' });
                              });

                      
                        </script>


@stop