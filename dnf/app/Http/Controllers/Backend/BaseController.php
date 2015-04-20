<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\User as UserModel;
use App\Models\Backend\Inbox\Mail as MailModel;
use View;
use Auth;

class BaseController extends Controller {

    /**
     * 初始化
     * @middleware: AdminAuth
     */
    public function __construct()
    {
        $user = Auth::user();
        $users = UserModel::select('id', 'name')
            ->where('id', '!=', $user->id)->get();
        $mails = MailModel::getMailBySRAndLimit($user->id, 0, 10);
        $sUnreadNums = MailModel::getMailBySR($user->id)->count();
        View::share('sUsers', $users);
        View::share('sMails', $mails);
        View::share('sUnreadNums', $sUnreadNums);
    }

}
