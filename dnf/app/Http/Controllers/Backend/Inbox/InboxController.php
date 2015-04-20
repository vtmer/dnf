<?php namespace App\Http\Controllers\Backend\Inbox;

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Requests\MailRequest;
use Request;
use App\Models\Backend\User as UserModel;
use App\Models\Backend\Inbox\Mail as MailModel;
use Auth;
use Input;
use Lang;
use App\Component\Js;
use Vinkla\Pusher\Facades\Pusher;

class InboxController extends DashboardController {

    /**
     * 页面：站内信首页
     *
     * @return Response
     */
    public function index()
    {
        return view('backend.inbox.index');
    }

    /**
     * 页面： 未读站内信
     *
     * @return Response
     */
    public function unread()
    {
        $receiver = Auth::user();
        $mails = MailModel::getMailBySR($receiver->id)->simplePaginate(12);
        return view('backend.inbox.unread', ['mails' => $mails]);
    }

    /**
     * 页面： 已读站内信
     *
     * @return Response
     */
    public function read()
    {
        $receiver = Auth::user();
        $mails = MailModel::getMailBySR($receiver->id, 0, 1)->simplePaginate(12);
        return view('backend.inbox.read', ['mails' => $mails]);
    }

    /**
     * 页面：已发送
     *
     * @return Response
     */
    public function sended()
    {
        $receiver = $sender = Auth::user();
        $mails = MailModel::getMailBySR(0, $sender->id, false)->simplePaginate(12);
        return view('backend.inbox.sended', ['mails' => $mails]);
    }

    /**
     * 动作： 发送信件
     *
     * @return Response
     */
    public function _send(MailRequest $request)
    {
        $sender = Auth::user();
        $data = array_except(Input::all(), '_token');
        $data['receiver'] = UserModel::getUsersNameById($data['receiver_id']);
        if (!MailModel::mPush($data, $sender))
            return Js::response(Lang::get('params.10008'), false, false);

        foreach ($data['receiver_id'] as $rId) {
            Pusher::trigger('mail', $rId, [
                'id' => MailModel::getIdByReceiverId($rId)->id,
                'sender_id' => $sender->id,
                'sender_name' => Auth::user()->name,
                'msg' => $data['content'],
            ]);
        }

        return Js::response(Lang::get('params.20001'), true, false);
    }

    /**
     * 动作： 标记信件
     *
     * @return Response
     */
    public function _flag()
    {
        $id = Input::get('id', false);
        if (!$id && !is_numeric($id))
            return Js::response(Lang::get('10001'));

        $mail = MailModel::find($id);
        if (null == $mail) return Js::response(Lang::get('backend.none-data'));

        $mail->flag = 1;
        $mail->save();

        return Js::response();
    }
}
