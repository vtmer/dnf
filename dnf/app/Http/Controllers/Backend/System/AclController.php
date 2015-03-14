<?php namespace App\Http\Controllers\Backend\System;

use App\Models\Backend\System\Acl as AclModel;
use App\Models\Backend\System\Action as ActionModel;
use App\Component\Js;
use Request;
use Input;
use Lang;
use App\Http\Requests\AclRequest;
use App\Http\Controllers\Backend\BaseController;

class AclController extends BaseController {

    /**
     * 页面：菜单功能管理
     *
     * @return Response
     */
    public function index()
    {
        $datas = AclModel::all();
        return view('backend.acl.index', [
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
        // 取出菜单, 二级
        $menus = AclModel::menu();

        return view('backend.acl.add', [
            'formUrl' => route('backend_system_acl_add'),
            'menus' => $menus,
        ]);
    }

    /**
     * 动作：菜单功能保存
     *
     * @return Response
     */
    public function _add(AclRequest $request)
    {
        $data = array_except(Input::all(), '_token');

        // 菜单层级
        if (0 == $data['pid']) {
            $data['level'] = 1;
        } else {
            $parentMenu = AclModel::where('id', '=', $data['pid'])->first();
            $data['level'] = $parentMenu->level + 1;
        }

        $acl = AclModel::create($data);
        if (!isset($acl->id))
            return Js::error(Lang::get('backend.save-failed'));

        // 写入操作
        ActionModel::createOneAction('1', $acl->name);
        return redirect()->route('backend_system_acl_index');
    }

    /**
     * 页面：菜单功能编辑
     *
     * @return Response
     */
    public function edit()
    {
        $id = Request::get('id');
        $acl = AclModel::find($id);
        if (null == $acl) return Js::error(Lang::get('backend.none-data'));
        // 取出该菜单层级取出相应层级
        $menus = AclModel::menuByLevel($acl->level, $acl->id);

        return view('backend.acl.add', [
            'data' => $acl,
            'formUrl' => route('backend_system_acl_edit'),
            'menus' => $menus,
        ]);
    }

    /**
     * 动作：菜单功能编辑保存
     *
     * @return Response
     */
    public function _edit(AclRequest $request)
    {
        $data = array_except(Input::all(), '_token');
        $acl = AclModel::find($data['id']);
        if (null == $acl) return Js::error(Lang::get('backend.none-data'));
        if (0 == $data['pid']) {
            $data['level'] = 1;
        } else {
            $parentMenu = AclModel::where('id', '=', $data['pid'])->first();
            $data['level'] = $parentMenu->level + 1;
        }

        // 写入操作
        ActionModel::createOneAction('2', $acl->name, $acl->name. " => ".$data['name']);
        $acl->update($data);

        return redirect()->route('backend_system_acl_index');
    }

    /**
     * 动作：删除菜单功能
     * 只支持单个删除
     *
     * @return Response
     */
    public function _delete()
    {
        $id = Input::get('id', false);
        if (!$id || !is_numeric($id))
            return Js::response(Lang::get('params.10001'), false);

        $acl = AclModel::find($id);
        if (!$acl) return Js::response(Lang::get('params.10004'), false);
        if(!AclModel::deleteById($id, $acl->pid)) return Js::response(Lang::get('params.10005'), false);

        // 写入操作
        ActionModel::createOneAction('3', $acl->name);
        return Js::response($id, true, false);
    }

}
