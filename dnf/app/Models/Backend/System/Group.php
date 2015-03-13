<?php namespace App\Models\Backend\System;

use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\User;
use App\Models\Backend\BaseModel;

class Group extends BaseModel {

    /**
     * 超级用户组id
     *
     * @var const
     */
    const rootGroupId = 1;

    protected $table = "admin_user_groups";

    protected $fillable = ['name', 'level', 'status', 'mark', 'created_at', 'updated_at'];

    /**
     * 检查当前用户的用户组level
     *
     * @return boolean
     */
    public static function hasGroupLevelPermission($id, $user)
    {
        if ($user->id == User::rootId) return true;

        $userGroupLevel = $user->group->level;

        $group = static::find($id);
        if ($group->level > $userGroupLevel) return false;

        return true;
    }

    /**
     * 根据ID删除用户组，
     * 改组下用户也会被删除
     *
     * @return boolean
     */
    public static function deleteById($id, $uId)
    {
        // 改组下用户
        $users = static::find($id)->users();

        $userIdArr = [];
        foreach ($users as $user) {
            $userIdArr[] = $user->id;
        }

        // 删除权限
        Access::where('role_id', $id)->where('type', Access::groupType)->delete();
        Access::whereIn('role_id', $userIdArr)->where('type', Access::userType)->delete();

        // 删除该组下用户
        Access::destroy($userIdArr);

        return static::destroy($id);
    }

    /**
     * 关联用户表
     * 一对多
     *
     * @return Users
     */
    public function users()
    {
        return $this->hasMany('App\Models\Backend\User','id','group_id');
    }


}
