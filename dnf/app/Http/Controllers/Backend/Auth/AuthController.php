<?php namespace App\Http\Controllers\Backend\Auth;

use Route;
use Auth;
use Hash;
use Lang;
use App\Component\Js;
use Request;
use App\Models\Backend\User;
use App\Http\Controllers\Controller;

class AuthController extends Controller {

	/**
     * 页面：登陆页面
	 *
	 * @return Response
	 */
	public function index()
	{
        if (Auth::check()) return redirect()->route('backend_dashboard_index');
        return view('backend.login.index');
	}

    /**
     * 动作：登陆
     *
     * @return Redirect
     */
    public function login()
    {
        $username = Request::input('username', false);
        $password = Request::input('password', false);

        if (!$username || !$password)
            return Js::error(Lang::get('params.10001'));

        $user = User::hasUserByName($username);
        if (!$user) return Js::error(Lang::get('params.10002'));

        // 是否禁止登陆
        if (!$user->status || !$user->group->status)
            return Js::error(Lang::get('params.10009'));


        if (Auth::attempt(['name' => $username, 'password' => $password])) {
            $user->last_login_time = time();
            $user->last_login_ip = Request::ip();
            $user->save();
            return redirect()->back();
        }

        return Js::error(Lang::get('params.10003'));
    }

    /**
     * 动作：退出
     *
     * @return Redirect
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('backend_auth_auth_login');
    }

}
