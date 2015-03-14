<?php namespace App\Models\Backend\System;

use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\BaseModel;
use App\Models\Backend\User;
use Auth;

class Access extends BaseModel {

    const groupType = 1;

    const userType = 2;

    protected $table = "admin_access";

    protected $fillable = ['role_id', 'permission_id', 'type',
                           'created_at', 'updated_at', 'is_deleted',];


    /**
     * 设置角色权限
     *
     * @param array $permissions
     * @param int $groupId
     * @param int $type 角色类型，用户组为1,用户为2
     * @return boolean
     */
    public static function setPermission($permissions, $id, $type = 1)
    {
        // 删除旧的权限
        $status = static::where('role_id', $id)
            ->where('type', $type)->delete();

        $data = [];
        foreach($permissions as $permission) {
            $data[] = [
                'role_id' => $id,
                'type' => $type,
                'permission_id' => $permission,
                'created_at' => time(),
                'updated_at' => time(),
            ];
        }

        if (empty($data)) return true;

        return static::insert($data);

    }

    /**
     * 根据type获取用户的权限
     *
     * @return array
     */
    public static function getPermissionByType($roleId, $type = self::groupType)
    {
        $acls = static::where('role_id', $roleId)->where('type', $type)->get();

        $permissions = [];
        foreach ($acls as $acl) {
            $permissions[] = $acl->permission_id;
        }

        return $permissions;
    }

    /**
     * 获取当前用户的权限
     *
     * @return array 用户的权限 | 该用户的用户组权限
     */
    public static function getPermission()
    {
        $permissions = static::getPermissionByType(Auth::user()->id, static::userType);
        if (empty($permissions)) {
            $permissions = static::getPermissionByType(Auth::user()->group->id, static::groupType);
        }

        return $permissions;
    }

    /**
     * 检查是否有权限访问当前路由
     *
     * @param string $routeName
     * @return boolean
     */
    public static function hasRoutePermission($routeName)
    {
        if (Auth::user()->isRoot()) return true;

        $currentAcl = explode("_", $routeName);
        $module = $currentAcl[1];
        $class = $currentAcl[2];
        $function = $currentAcl[3];

        // 用户的permission
        $permissions = static::getPermission();
        // 当前请求的permision
        $acl = Acl::where('module', $module)
            ->where('class', $class)
            ->where('function', $function)->first();
        if ($acl) {
            return in_array($acl->id, $permissions);
        }

        return false;
    }

}
