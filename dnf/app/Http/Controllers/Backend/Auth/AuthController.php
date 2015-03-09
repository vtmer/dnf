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
        if (!User::hasUserByName($username))
            return Js::error(Lang::get('params.10002'));
        if (Auth::attempt(['name' => $username, 'password' => $password]))
            return redirect()->back();

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
