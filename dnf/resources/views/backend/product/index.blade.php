@extends('backend.layouts.dashboard')

@section('title')
{{ Lang::get('backend.title.product.index') }}
@stop

@section('container')

<!-- 轮播插件的css  -->
<style type="text/css">
.banner { position: relative; overflow: auto; }
    .banner li { list-style: none; }
        .banner ul li { float: left; }

  .banner .dots { position: absolute; left: 200; bottom: 20px; }
   .banner .dots li { display: inline-block; 
                                   width: 10px;
                                    height: 10px; margin: 0 4px; 
                                    text-indent: -999em; 
                                    border: 2px solid #000;
                                     border-radius: 6px; 
                                     cursor: pointer; 
                                     opacity: .4; -webkit-transition: background .5s, opacity .5s; -moz-transition: background .5s, opacity .5s; transition: background .5s, opacity .5s; } 
   .banner .dots li.active { background: #fff; opacity: 1; }      
</style>



<div id="content-wrapper">
    <div class="page-header">
        <div class="row">
            <!-- Page header, center on small screens -->
            <h1 class="col-xs-12 col-sm-10 text-center text-left-sm"><i class="fa fa-pencil page-header-icon"></i>&nbsp;&nbsp;{{ Lang::get('backend.product-management') }}</h1>
            <div class="col-xs-12 col-sm-2">
                <div class="row">
                    <hr class="visible-xs no-grid-gutter-h">

                    <!-- "Create project" button, width=auto on desktops -->
                    <div class="pull-right col-xs-12 col-sm-auto">{!! AclWidget::add(route('backend_product_product_create'), 'product', 'product', '_create', Lang::get('backend.add-product')) !!}</div>
                    <div class="visible-xs clearfix form-group-margin"></div>
                      </div>
                    <div class="visible-xs clearfix form-group-margin"></div>
                </div>
            </div>
        </div>

         @foreach($datas as $data)
        <div  class="col-md-6" >
	<div class="panel">
		<div class="panel-heading"   id ="head{{{$data->id}}}">
		<span class="panel-title" > <strong>{{{$data->name}}}</strong></span>&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp
                               
                                    {!! AclWidget::edit(route('backend_product_product_update', ['id' => $data->id]), 'product', 'product', 'update', null) !!}
                                    &nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp
		                      <button class="btn btn-danger btn-rounded fa-trash-o " type="button" onclick="delProduct({{{$data->id}}},'{{ csrf_token() }}')" ></button>
                            </div>
		<div class="panel-body"   id ="panel-body{{$data->id}}">
                		<h4><strong> 产品名称:   </strong>{{{$data->name}}}</h4>
                		<hr>
                		<h4><strong>产品持有人/公司     :</strong> {{{$data->holder}}}</h4>
                		<hr>
                		<h4><strong>产品链接         :</strong><a  href = "{{{$data->url}}}">  {{{$data->url}}}</a> </h4>
                		<hr>
                		<h4><strong>产品简介   :</strong><br> {{{$data->description}}}</h4>
                		<hr>
                		<h4><strong>产品图片      :<h5>(可用方向键← →移动)</h5>  </strong> </h4><br>

                                    <!--   将以逗号隔开的图片的url分离出来并且去掉空的url   -->
                                     <?php $img_URLs = array_filter(explode(",",$data->img_URL)) ;?>    
                                
                                   <!--   展示图片   -->
                                    <div class="banner">
                                        <ul>
                                            @foreach($img_URLs as $img_URL) 
                                            <li> <img  id="img" width="300"src="{{{ $img_URL}}}"></li>
                                            @endforeach
                                        </ul>
                                    </div>
		  
		</div>
           </div>
           </div>
            @endforeach   
    </div> <!-- / .page-header -->


@stop

@section('scripts')
    @parent
               <script src="//code.jquery.com/jquery-latest.min.js"></script>
               <script src="//unslider.com/unslider.js"></script>
               <script>
                $(function() {
                    $('.banner').unslider({
                        speed: 500,               //  The speed to animate each slide (in milliseconds)
                        delay: 3000,              //  The delay between slide animations (in milliseconds)
                        complete: function() {},  //  A function that gets called after every slide animation
                        keys: true,               //  Enable keyboard (left, right) arrow shortcuts
                        dots: true,               //  Display dot navigation
                        fluid: false              //  Support responsive design. May break non-responsive designs

                    });
                });

                function del(id){
                var r = confirm("Are  you  sure?");
                if (r == true) {
                      $("#panel-body"+id).remove();
                      $("#head"+id).remove();
                } 
              }


                function delProduct(product,csrf_token){
                    $.post("{{{route('backend_product_product_delete')}}}",
                            {
                               _token:csrf_token,
                                id:product,
                                
                            }); 
                      del(product);

               }


               </script>

@stop
