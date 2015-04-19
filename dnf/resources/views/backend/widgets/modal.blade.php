<!-- Modal -->
<div id="envelope" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">@lang('backend.send-envelope')</h4>
            </div>
            <form data-action="{{ route('backend_inbox_send') }}" class="new-mail-form form-horizontal" method="POST" id="mail">
            <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row form-group">
                        <div class="col-sm-12 select2-primary">
                            <select multiple="multiple" id="receiver" name="receiver_id[]" class="form-control" placeholder="@lang('backend.messages.select-user')">
                                @foreach($sUsers as $user)
                                <option value="{{ $user->id }}" >{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <textarea  class="form-control" name="content" id="content"></textarea>
                            <div id="content-limit-label" class="limiter-label">{{ Lang::get('backend.character-left') }} : <span class="limiter-count"></span></div>
                        </div>
                    </div>

            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('backend.cancel')</button>
                <button id="mail-send" type="submit" class="btn btn-primary">@lang('backend.send')</button>
            </div>
            </form>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- /.modal -->

