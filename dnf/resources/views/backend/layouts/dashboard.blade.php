@extends('backend.layouts.base')

@section('container')
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">{{ Lang::get('backend.where') }} :</div>
        <li class="active"><a href="#">{{ Lang::get('backend.dashboard') }}</a></li>
    </ul>
    <div></div>
</div> <!-- / #content-wrapper -->
@stop

