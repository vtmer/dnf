@extends('backend.layouts.dashboard')

@section('title')
{{ Lang::get('backend.title.aboutus.index') }}
@stop

@section('container')

<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div id="content-wrapper">
    <div class="page-header">
        <div class="row">
            <!-- Page header, center on small screens -->
            <h1 class="col-xs-12 col-sm-10 text-center text-left-sm"><i class="fa fa-pencil page-header-icon"></i>&nbsp;&nbsp;{{ Lang::get('backend.trashed-vtmer') }}</h1>
            <div class="col-xs-12 col-sm-2">
                <div class="row">
                    <hr class="visible-xs no-grid-gutter-h">             
                
                      </div>

                    <div class="visible-xs clearfix form-group-margin"></div>
                </div>
            </div>
        </div>
    </div> <!-- / .page-header -->
       @foreach($datas as $data)
            <div class="col-md-4">
                <div class="panel panel-info panel-dark  panel-body-colorful widget-profile widget-profile-centered">
                    <div class="panel-heading">
                       <img  src="{{{$data->img_URL}}}" alt="头像" class="widget-profile-avatar">
                        <div class="widget-profile-header">
                               <span>{{{ $data->name }}}</span><br>
                                <a href="{{{ $data->blog}}}"> {{{ $data->blog}}}</a>
                        </div>
                         <br>
                        <div><span class=" fa-envelope">&nbsp;&nbsp;</span>{{{ $data->email}}}</div>
                         <br>
                            <div><span class=" fa-clock-o">&nbsp;&nbsp;</span>{{{ $data->time}}}</div>
                    </div> <!-- / .panel-heading -->
                    <div class="panel-body">
                        <div class="widget-profile-text" style="padding: 0;">
                             {{{ $data->introduction}}}
                        </div>
                        <hr>

                          <div class="col-md-7" >             
                                             <form id="form_vtmer"  action="{{ route('backend_aboutus_vtmer_restore') }}"  method="POST"  >
                                                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                     <input type="hidden" name="id" value="{{ $data->id or '' }}">
                                                     <button type="submit" class="btn btn-primary" > 恢复</button>
                                             </form>
                                   
                        </div>
                         <div class="col-md-4" >             
                                             <form id="form_vtmer"  action="{{ route('backend_aboutus_vtmer_delete') }}"  method="POST"  >
                                                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                     <input type="hidden" name="id" value="{{ $data->id or '' }}">
                                                     <button type="submit" class="btn btn-rounded btn-primary fa-trash-o" > </button>
                                             </form>
                                   
                        </div>
                    </div>
                </div> <!-- / .panel -->
<!-- /7. $PROFILE_WIDGET_CENTERED_EXAMPLE -->

            </div>
         @endforeach      
</div>




@stop
