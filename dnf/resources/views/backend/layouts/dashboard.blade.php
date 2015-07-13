@extends('backend.layouts.base')

@section('body')
<script>var init = [];</script>
<script src="{{ asset('asset/js/backend/demo.js') }}"></script>
<div id="main-wrapper">
    <div id="main-navbar" class="navbar navbar-inverse" role="navigation">
        <!-- Main menu toggle -->
        <button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span></button>
        <div class="navbar-inner">
            <!-- Main navbar header -->
            <div class="navbar-header">
                <!-- Logo -->
                <a href="index.html" class="navbar-brand">
                    Vtmer Studio
                </a>
                <!-- Main navbar toggle -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>
            </div> <!-- / .navbar-header -->
            <div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse">
                <div>
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#">{{ Lang::get('backend')['dnf'] }}</a>
                        </li>
                    </ul> <!-- / .navbar-nav -->
                    <div class="right clearfix">
                        <ul class="nav navbar-nav pull-right right-navbar-nav">
                            <li class="nav-icon-btn nav-icon-btn-success dropdown">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="label unread">{{ $sUnreadNums ? $sUnreadNums : "" }}</span>
                                    <i class="nav-icon fa fa-envelope" style="line-height: inherit;"></i>
                                    <span class="small-screen-text">Income messages</span>
                                </a>

                                <!-- MESSAGES -->

                                <div class="dropdown-menu widget-messages-alt no-padding" style="width: 301px;">
                                    <div class="messages-list" id="main-navbar-messages">
                                        @foreach($sMails as $mail)
                                        <div class="message" data-id="{{ $mail->id }}">
                                            <a class="message-subject">{{ $mail->content }}</a>
                                            <div class="message-description">
                                                <a>{{ $mail->sender_name }}</a>
                                                &nbsp;--&nbsp;
                                                <span class="time" data-created="{{ $mail->created_at }}">{{ Helper::mdate($mail->created_at) }}</span>
                                            </div>
                                        </div> <!-- / .message -->
                                        @endforeach
                                    </div> <!-- / .messages-list -->
                                    <a href="{{ route('backend_inbox_index') }}" class="messages-link">@lang('backend.more-message')</a>
                                </div> <!-- / .dropdown-menu -->
                            </li>
<!-- /3. $END_NAVBAR_ICON_BUTTONS -->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle user-menu" data-toggle="dropdown">
                                    <span>{{ Auth::user()->realname }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="" data-toggle="modal" data-target="#envelope"><i class="dropdown-icon fa fa-rocket"></i>&nbsp;&nbsp;{{ Lang::get('backend.send-envelope') }}</a></li>
                                    <li><a href="{{ route('backend_inbox_index') }}"><i class="dropdown-icon fa fa-envelope"></i>&nbsp;&nbsp;{{ Lang::get('backend.envelope') }}</a></li>
                                    <li><a href="{{ route('backend_dashboard_user_account') }}"><i class="dropdown-icon fa fa-cog"></i>&nbsp;&nbsp;{{ Lang::get('backend.account') }}</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{ route('backend_auth_auth_logout')}}"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;{{ Lang::get('backend.logout') }}</a></li>
                                </ul>
                            </li>
                        </ul> <!-- / .navbar-nav -->
                    </div> <!-- / .right -->
                </div>
            </div> <!-- / #main-navbar-collapse -->
        </div> <!-- / .navbar-inner -->
    </div> <!-- / #main-navbar -->

    <div id="main-menu" role="navigation">
        <div id="main-menu-inner">
            <ul class="navigation">
                <li>
                    <a href="{{ route('backend_dashboard_index') }}"><i class="menu-icon fa fa-dashboard"></i><span class="mm-text">{{ Lang::get('backend.dashboard') }}</span></a>
                </li>
                {!! App\Widgets\Backend\MenuWidget::menu() !!}
            </ul> <!-- / .navigation -->
        </div> <!-- / #main-menu-inner -->
    </div> <!-- / #main-menu -->

    @yield('container')

    <div id="main-menu-bg"></div>
</div> <!-- / #main-wrapper -->

@include('backend.widgets.modal')

@stop

@section('scripts')
<script src="{{ asset('asset/js/backend/pusher.min.js') }}"></script>
<script src="{{ asset('asset/js/backend/common.js') }}"></script>
    @parent
    <script type="text/javascript">
        window.PixelAdmin.start(init);
        chbind("<?php echo Lang::get('backend.pusher.channel.mail'); ?>", <?php echo Auth::user()->id; ?>, pushMsg);
    </script>
@stop
