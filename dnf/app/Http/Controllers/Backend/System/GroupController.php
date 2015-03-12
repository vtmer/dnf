<?php namespace App\Http\Controllers\Backend\System;

use App\Models\Backend\System\Acl as AclModel;
use App\Models\Backend\System\Group as GroupModel;
use App\Component\Js;
use Request;
use Input;
use Auth;
use Lang;
use App\Models\Backend\System\Access as AccessModel;
use App\Component\Acl;
use App\Http\Requests\GroupRequest;
use App\Http\Controllers\Backend\BaseController;

class GroupController extends BaseController {

    /**
     * 页面：菜单功能管理
     *
     * @return Response
     */
    public function index()
    {
        $datas = GroupModel::all();
        return view('backend.group.index', [
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
        return view('backend.group.add', [
            'formUrl' => route('backend_system_group_add'),
        ]);
    }

    /**
     * 动作：菜单功能保存
     *
     * @return Response
     */
    public function _add(GroupRequest $request)
    {
        $data = array_except(Input::all(), '_token');
        $group = GroupModel::create($data);

        if (!isset($group->id))
            return Js::error(Lang::get('backend.save-failed'));

        return redirect()->route('backend_system_group_index');
    }

    /**
     * 页面：菜单功能编辑
     *
     * @return Response
     */
    public function edit()
    {
        $id = Request::get('id');
        $group = GroupModel::find($id);

        // TODO 1 改为 UserModel::rootId
        # 只有root 才可以编辑 root group
        if ($id == GroupModel::rootGroupId && Auth::user()->id != 1)
            return Js::error(Lang::get('params.10007'));


        if (null == $group) return Js::error(Lang::get('backend.none-data'));

        return view('backend.group.add', [
            'data' => $group,
            'formUrl' => route('backend_system_group_edit'),
        ]);
    }

    /**
     * 动作：菜单功能编辑保存
     *
     * @return Response
     */
    public function _edit(GroupRequest $request)
    {
        $data = array_except(Input::all(), '_token');

        // TODO 1 改为 UserModel::rootId
        # 只有root 才可以编辑 root group
        if ($data['id'] == GroupModel::rootGroupId && Auth::user()->id != 1)
            return Js::error(Lang::get('params.10007'));

        $group = GroupModel::find($data['id']);
        if (!$group) return Js::error(Lang::get('backend.none-data'));

        $group->update($data);

        return redirect()->route('backend_system_group_index');
    }

    /**
     * 页面：用户组权限
     *
     * @return Response
     */
    public function acl()
    {
        $id = Request::get('id');
        $group = GroupModel::find($id);

        // 不允许改变root group status
        if ($id == GroupModel::rootGroupId)
            return Js::error(Lang::get('params.10007'));

        // 用户的用户组level判断
        if (!GroupModel::hasGroupLevelPermission($id, Auth::user()))
            return Js::response(Lang::get('params.10006'), false);

        if (null == $group) return Js::error(Lang::get('backend.none-data'));
        $menus = AclModel::getAllMenu();

        return view('backend.group.acl', [
            'formUrl' => route('backend_system_group_acl'),
            'menus' => $menus,
            'data' => $group,
            'permission' => AccessModel::getUserPermission(Auth::user()->id),
        ]);
    }

    /**
     * 动作：设置用户组权限
     *
     * @return Response
     */
    public function _acl()
    {
        $permissions = Input::get('permission', []);
        $id = Input::get('id', false);

        if (!$id || !is_numeric($id)) return Js::error(Lang::get('params.10001'));

        // 用户的用户组level判断
        if (!GroupModel::hasGroupLevelPermission($id, Auth::user()))
            return Js::error(Lang::get('params.10006'));

        $permissions = array_unique($permissions);
        $permissions = array_map('intval', $permissions);
        if (!AccessModel::setPermission($permissions, $id))
            return Js::error(Lang::get('params.10008'));

        return redirect()->route('backend_system_group_index');
    }

    /**
     * 动作：删除菜单功能
     * 支持单个删除
     *
     * @return Response
     */
    public function _delete()
    {
        $id = Input::get('id', false);
        if (!$id || !is_numeric($id)) return Js::response(Lang::get('params.10001'), false);

        # 不允许删除root group
        if ($id == GroupModel::rootGroupId)
            return Js::response(Lang::get('params.10007'), false);


        // 该用户所属用户组level是否大于要删除的用户组, 低于则没有权限删除
        if (!GroupModel::hasGroupLevelPermission($id, Auth::user()))
            return Js::response(Lang::get('params.10006'), false);

        if (!GroupModel::deleteById($id, Auth::user()->id))
            return Js::response(Lang::get('params.10005'), false);

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

        # 数据不存在
        $group = GroupModel::find($id);
        if (!$group) return Js::response(Lang::get('params.10004'), false);

        # 不允许改变root group status
        if ($id == GroupModel::rootGroupId)
            return Js::response(Lang::get('params.10007'), false);

        // 该用户所属用户组level是否高于操作Group
        if (!GroupModel::hasGroupLevelPermission($id, Auth::user()))
            return Js::response(Lang::get('params.10006'), false);

        // 保存
        $group->status = $group->status ? 0 : 1;
        if (!$group->save())
            return Js::response(Lang::get('params.10008'), false);

        $buttonChangeName = Lang::get('backend.button-status.status.'.$group->status);
        return Js::response(null, true, false, $buttonChangeName);
    }

}
