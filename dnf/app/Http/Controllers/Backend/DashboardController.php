<?php namespace App\Http\Controllers\Backend;

use Request;
use App\Http\Requests\UserRequest;
use App\Models\Backend\User as UserModel;
use Auth;
use Input;
use Lang;
use App\Models\Backend\System\Action as ActionModel;
use App\Component\Js;
use Hash;

class DashboardController extends BaseController {

    /**
     * 登陆验证
     */
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

	/**
     * 页面：后台首页
	 *
	 * @return Response
	 */
	public function index()
	{
        $actions = ActionModel::orderBy('created_at',SORT_DESC)->simplePaginate(8);
        return view('backend.dashboard.index', [
            'actions' => $actions,
        ]);
	}

    /**
     * 页面：修改个人信息
     *
     * @return Response
     */
    public function account()
    {
        // 数据存在
        $user = UserModel::find(Auth::user()->id);
        if (null == $user) return Js::error(Lang::get('backend.none-data'));

        return view('backend.user.account', [
            'data' => $user,
            'formUrl' => route('backend_dashboard_user_account'),
        ]);
    }

    /**
     * 动作：用户编辑保存
     *
     * @return Response
     */
    public function _account(UserRequest $request)
    {
        $data = array_except(Input::all(), ['password_confirmation', '_token']);
        if (null == Input::get('password')) {
            $data = array_except(Input::all(), 'password');
        } else {
            // 是否与原密码相同
            $credentials = ['password' => Input::get('old_password', false)];
            if (Auth::validate($credentials)) return Js::error(Lang::get('params.10010'));
            $data['password'] = Hash::make($data['password']);
        }

        Auth::user()->update($data);

        return redirect()->route('backend_dashboard_index');
    }

}
