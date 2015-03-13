<?php namespace App\Models\Backend\System;

use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\User;
use App\Models\Backend\BaseModel;

class Acl extends BaseModel {

    private $rootId = 1;

    protected $table = "admin_permission";

    protected $fillable = ['name', 'module', 'class', 'function', 'pid',
                           'mark', 'created_at', 'updated_at', 'level'];

    /**
     * 根据ID删除菜单，
     * 子菜单会被删除
     *
     * @return boolean
     */
    public static function deleteById($id, $pid)
    {
        $ids = [];

        // push 子菜单id
        $subAcls = static::where('pid', '=', $id)->get();
        foreach ($subAcls as $acl) {
            $ids[] = $acl->id;
        }

        // 顶级菜单
        if (0 == $pid) {
            // push 三级菜单
            $tAcls = static::whereIn('pid', $ids)->get();
            foreach ($tAcls as $acl) {
                $ids[] = $acl->id;
            }
        }

        $ids[] = $id;

        // 删除access中的关联数据
        Access::whereIn('permission_id', $ids)->delete();
        return static::destroy($ids);
    }

    /**
     * 取出二层菜单并构造格式
     *
     * @return array
     */
    public static function menu()
    {
        $menu = [];
        // 顶级菜单
        $tops = static::where('pid', '=', '0')->get();
        foreach ($tops as $key => $top) {
            $menu[$key] = $top;
            $menu[$key]['sub'] = static::where('pid', '=', $top->id)->get();
        }

        return $menu;
    }

    /**
     * 通过菜单层级取出菜单
     *
     * @return array
     */
    public static function menuByLevel($level, $id)
    {
        if ($level == 1) {
            // 顶级菜单， 该菜单没有子菜单
            $subAcls = static::where('pid', '=', $id)->first();
            if(null == $subAcls) {
                $menu = static::menu();
                foreach($menu as $key => $acl) {
                    if ($acl->id == $id) {
                        unset($menu[$key]);
                        break;
                    }
                }
                return $menu;
            } else return false;
            // 顶级菜单，有子菜单，父级菜单不可更能
        } elseif ($level == 2) {
            // 二级菜单
            return static::where('pid', '=', '0')->get();
        } else {
            return static::menu();
        }

    }

    /**
     * 通过Uid 取出菜单
     *
     * @return array
     */
    public static function getMenuByUid($uId)
    {
        if (User::rootId == $uId) {
            return static::menu();
        }

        $user = User::find($uId);

        // 先根据用户读取menu
        $accesses = Access::where('role_id', $uId)->where('type', Access::userType)->get();
        if ($accesses->isEmpty()) {
            $accesses = Access::where('role_id', $user->group->id)
                            ->where('type', Access::groupType)->get();
        }


        $aclArr = [];
        foreach ($accesses as $access) $aclArr[] = $access->permission_id;

        # 顶级菜单
         $menus = static::whereIn('id', $aclArr)->where('pid', 0)->get();
        foreach ($menus as $key => $menu) {
            $menus[$key]['sub'] = static::whereIn('id', $aclArr)->where('pid', $menu->id)->get();
        }

        return $menus;

    }

    /**
     * 获取全部菜单:总共三级
     *
     * @return array
     */
    public static function getAllMenu()
    {
        // 二层菜单
        $tlMenus = static::menu();
        foreach ($tlMenus as $topKey => $topMenu) {
            foreach ($topMenu['sub'] as $subKey => $subMenu) {
            $tlMenus[$topKey]['sub'][$subKey]['sub'] =
                static::where('pid', '=', $subMenu->id)->get();
            }
        }

        return $tlMenus;
    }

    /**
     * 获取全部权限，构造key-value
     *
     * @return array
     */
    public static function getAllAcl()
    {
        $menus = static::all();

        $acls = [];
        foreach ($menus as $menu) {
            $key = implode('_', [$menu->module, $menu->class, $menu->function]);
            $acls[$key] = $menu->id;
        }

        return $acls;
    }

}
