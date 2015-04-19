@extends('backend.layouts.dashboard')

@section('title')
{{ Lang::get('backend.title.inbox') }}
@stop

@section('styles')
    @parent
    <style type="text/css">
        .page-mail .mail-container {
        }
        .page-mail .mail-item {
            padding-left: 46px;
            padding-right: 14px;
        }
        .page-mail .m-from {
            position: static;
        }
        .get-url {
            cursor: pointer;
        }
    </style>
@stop

@section('body-class')
class="theme-default main-menu-animated page-mail"
@stop

@section('container')
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div id="content-wrapper">
    <div class="mail-nav">
        <div class="compose-btn">
        </div>
        <div class="navigation">
            <ul class="sections">
                <li class="active get-url" data-url="{{ route('backend_inbox_unread') }}"><a><i class="m-nav-icon fa fa-inbox"></i>@lang('backend.unread') <span class="label pull-right unread">{{ $sUnreadNums ? $sUnreadNums : ""}}</span></a></li>
                <li class="get-url" data-url="{{ route('backend_inbox_read') }}"><a><i class="m-nav-icon fa fa-check-square"></i>@lang('backend.read')</a></li>
                <li class="get-url" data-url="{{ route('backend_inbox_sended')}}"><a><i class="m-nav-icon fa fa-rocket"></i>@lang('backend.sended')</a></li>
            </ul>
        </div>
    </div>

    <div class="mail-container">
    </div>
</div> <!-- / #content-wrapper -->

@stop

@section('scripts')
    @parent
    <script type="text/javascript">
        init.push(function () {
        });
        window.PixelAdmin.start(init);

        $(document).ready(function () {
            $.post($('.navigation .sections .active').data('url'),
                {_token: $('input[name="_token"]').val()},
                function (data) {
                    $('.mail-container').empty().html(data);
                }
            );
        });

        $('.mail-container').on('click', '.flag', function () {
            $this = $(this);
            id = $this.data('id');
            $.post("<?php echo route('backend_inbox_flag'); ?>",
                {_token: $('input[name="_token"]').val(), id: id},
                function (data) {
                    data = $.parseJSON(data);
                    if (data.status == 'error') {
                        bootbox.alert({
                            message: data.message,
                            className: "bootbox-sm"
                        });
                    }
                }
            );

            $('.unread').each(function () {
                $unread = $(this);
                if (parseInt($unread.html()) != 1) $unread.html(parseInt($unread.html()) - 1);
                else $unread.html("");
            });

            // remove mail item
            mailItem = $this.parents('.mail-item');
            mailItem.remove();

            // remove mail noti
            $('#main-navbar-messages').children().each(function () {
                if($(this).data('id') == id) {
                    $(this).remove();
                }
            });
        });

        $('.get-url').on('click', function () {
            $this = $(this);
            if (!$this.hasClass('active')) {
                $this.siblings().removeClass('active');
                $this.addClass('active');
                $.post($this.data('url'), {_token: $('input[name="_token"]').val()},
                    function (data) {
                        $('.mail-container').empty().html(data);
                    }
                );
            }
        });

        $('.mail-container').on('click', '#pagination a', function (event) {
            event.preventDefault();
            url = $(this).attr('href');
            console.log(url);
            $.post(url,
                {_token: $('input[name="_token"]').val()},
                function (data) {
                    $('.mail-container').empty().html(data);
                }
            );
        });

        $('.mail-container').on('click', '#refresh', function (event) {
            $.post($('.navigation .sections .active').data('url'),
                {_token: $('input[name="_token"]').val()},
                function (data) {
                    $('.mail-container').empty().html(data);
                }
            );
        });
    </script>
@stop

