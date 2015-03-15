<?php namespace App\Http\Controllers\Backend\System;

use App\Models\Backend\System\Acl as AclModel;
use App\Models\Backend\System\Group as GroupModel;
use App\Models\Backend\User as UserModel;
use App\Models\Backend\System\Access as AccessModel;
use App\Models\Backend\System\Action as ActionModel;
use App\Component\Js;
use Request;
use Input;
use Auth;
use Hash;
use Lang;
use App\Component\Acl;
use App\Http\Requests\GroupRequest;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Backend\BaseController;

class UserController extends BaseController {

    // 用户
    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = Auth::user();
    }

    /**
     * 页面：菜单功能管理
     *
     * @return Response
     */
    public function index()
    {
        $datas = UserModel::all();
        return view('backend.user.index', [
            'datas' => $datas,
        ]);
    }

    /**
     * 页面：菜单功能添加
     *
     * @return Response
     */
    public function add()
    {
        return view('backend.user.add', [
            'formUrl' => route('backend_system_user_add'),
            'groups' => GroupModel::all()
        ]);
    }

    /**
     * 动作：菜单功能保存
     *
     * @return Response
     */
    public function _add(UserRequest $request)
    {
        $data = array_except(Input::all(), '_token');
        $data = array_except(Input::all(), 'password_confirmation');
        $data['password'] = Hash::make($data['password']);
        $user = UserModel::create($data);

        if (!isset($user->id))
            return Js::error(Lang::get('backend.save-failed'));

        // 写入操作
        ActionModel::createOneAction('9', $user->name);
        return redirect()->route('backend_system_user_index');
    }

    /**
     * 页面：用户编辑
     *
     * @return Response
     */
    public function edit()
    {
        $id = Request::get('id', false);
        if (!$id || !is_numeric($id)) return Js::error(Lang::get('params.10001'));

        # 只有root 才可以编辑 root
        if ($id == UserModel::rootId && $this->user->id != UserModel::rootId)
            return Js::error(Lang::get('params.10007'));

        // 数据存在
        $user = UserModel::find($id);
        if (null == $user) return Js::error(Lang::get('backend.none-data'));

        // 当前用户的group level 必须高于修改的用户的group level
        if (!GroupModel::hasGroupLevelPermission($user->group->id, $this->user))
            return Js::error(Lang::get('params.10006'), false);

        return view('backend.user.add', [
            'data' => $user,
            'formUrl' => route('backend_system_user_edit'),
            'groups' => GroupModel::all(),
        ]);
    }

    /**
     * 动作：用户编辑保存
     *
     * @return Response
     */
    public function _edit(UserRequest $request)
    {
        $data = array_except(Input::all(), '_token');
        $data = array_except(Input::all(), 'password_confirmation');
        if (null == Input::get('password'))
            $data = array_except(Input::all(), 'password');
        else
            $data['password'] = Hash::make($data['password']);

        # 只有root 才可以编辑 root
        if ($data['id'] == UserModel::rootId && !Auth::user()->isRoot())
            return Js::error(Lang::get('params.10007'));

        $user = UserModel::find($data['id']);
        if (!$user) return Js::error(Lang::get('backend.none-data'));

        // 当前用户的group level 必须高于修改的用户的group level
        if (!GroupModel::hasGroupLevelPermission($this->user->group->id, $this->user))
            return Js::response(Lang::get('params.10006'), false);

        // 写入操作
        ActionModel::createOneAction('10', $user->name, $user->name. " => ".$data['name']);

        $user->update($data);

        return redirect()->route('backend_system_user_index');
    }

    /**
     * 页面：用户权限
     *
     * @return Response
     */
    public function acl()
    {
        $id = Request::get('id', false);
        if (!$id || !is_numeric($id)) return Js::error(Lang::get('params.10001'));

        $user = UserModel::find($id);
        if (null == $user) return Js::error(Lang::get('backend.none-data'));

        // 不允许改变root 权限
        if ($id == UserModel::rootId) return Js::error(Lang::get('params.10007'));
        // 不允许改变自己的权限
        if ($id == Auth::user()->id) return Js::error(Lang::get('params.10007'));

        // 用户的用户组level判断
        if (!GroupModel::hasGroupLevelPermission($user->group->id, $this->user))
            return Js::error(Lang::get('params.10006'));

        $menus = AclModel::getAllMenu();

        return view('backend.user.acl', [
            'formUrl' => route('backend_system_user_acl'),
            'menus' => $menus,
            'data' => $user,
            'permission' => AccessModel::getPermissionByType($user->id, AccessModel::userType),
        ]);
    }

    /**
     * 动作：设置用户权限
     *
     * @return Response
     */
    public function _acl()
    {
        $permissions = Input::get('permission', []);
        $id = Input::get('id', false);
        if (!$id || !is_numeric($id)) return Js::error(Lang::get('params.10001'));

        // 数据不存在
        $user = UserModel::find($id);
        if (!$user) return Js::response(Lang::get('params.10004'), false);

        // 用户的用户组level判断
        if (!GroupModel::hasGroupLevelPermission($user->group->id, $this->user))
            return Js::error(Lang::get('params.10006'));

        $permissions = array_unique($permissions);
        $permissions = array_map('intval', $permissions);
        if (!AccessModel::setPermission($permissions, $id, AccessModel::userType))
            return Js::error(Lang::get('params.10008'));

        // 写入操作
        ActionModel::createOneAction('13', $user->name);
        return redirect()->route('backend_system_user_index');
    }

    /**
     * 动作：删除用户
     * 支持单个删除
     *
     * @return Response
     */
    public function _delete()
    {
        $id = Input::get('id', false);
        if (!$id || !is_numeric($id)) return Js::response(Lang::get('params.10001'), false);

        // 不允许删除root
        if ($id == UserModel::rootId) return Js::response(Lang::get('params.10007'), false);
        // 不允许删除自己
        if ($id == Auth::user()->id) return Js::response(Lang::get('params.10007'), false);

        // 数据不存在
        $user = UserModel::find($id);
        if (!$user) return Js::response(Lang::get('params.10004'), false);

        // 该用户所属用户组level是否大于要删除的用户组, 低于则没有权限删除
        if (!GroupModel::hasGroupLevelPermission($user->group->id, $this->user))
            return Js::response(Lang::get('params.10006'), false);

        if (!UserModel::deleteById($id))
            return Js::response(Lang::get('params.10005'), false);

        // 写入操作
        ActionModel::createOneAction('11', $user->name);
        return Js::response(null, true, false);
    }

    /**
     * 动作：改变状态
     *
     * @return status
     */
    public function _changeStatus()
    {
        $id = Input::get('id', false);
        if ($id === false || !is_numeric($id))
            return Js::response(Lang::get('params.10001'), false);

        // 数据不存在
        $user = UserModel::find($id);
        if (!$user) return Js::response(Lang::get('params.10004'), false);

        // 不允许改变root status
        if ($id == UserModel::rootId)
            return Js::response(Lang::get('params.10007'), false);

        // 该用户所属用户组level是否高于操作Group
        if (!GroupModel::hasGroupLevelPermission($user->group->id, $this->user))
            return Js::response(Lang::get('params.10006'), false);

        // 保存
        $user->status = $user->status ? 0 : 1;
        if (!$user->save())
            return Js::response(Lang::get('params.10008'), false);

        $buttonChangeName = Lang::get('backend.button-status.status.'.$user->status);

        // 写入操作
        ActionModel::createOneAction('12', $user->name);
        return Js::response(null, true, false, $buttonChangeName);
    }

}
