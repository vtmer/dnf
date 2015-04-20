<div class="mail-container-header">@lang('backend.read')</div>

    <div class="mail-controls clearfix">
        <div class="btn-toolbar wide-btns pull-left" role="toolbar">
            <div class="btn-group">
                <button type="button" class="btn" id="refresh"><i class="fa fa-repeat"></i></button>
            </div>
        </div>

        <div class="btn-toolbar pull-right" role="toolbar">
            <div class="btn-group">
                <div id="pagination">
                    {!! $mails->render() !!}
                </div>
            </div>
        </div>
    </div>

    <ul class="mail-list">
        @foreach($mails as $mail)
        <li class="mail-item">
            <div class="m-from"><p>{{ $mail->sender_name }}</p></div>
            <div class="m-subject"><p>{{ $mail->content }}</p></div>
            <div class="m-date">{{ Helper::mdate($mail->created_at) }}</div>
        </li>
        @endforeach
    </ul>

</div>
