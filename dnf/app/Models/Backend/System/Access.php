<?php namespace App\Models\Backend\System;

use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\BaseModel;

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
     * 获取用户的权限
     *
     * @return array
     */
    public static function getUserPermission($uId)
    {
        # TODO Get user Permission
        return [0,1];
    }
}
