<?php namespace App\Models\Backend\System;

use Illuminate\Database\Eloquent\Model;
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
        // TODO
        // $groupLevel = $user->group()->level;
        $userGroupLevel = 100;

        $group = static::find($id);
        if ($group->level >= $userGroupLevel) return false;

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
        // TODO
        // $userGroupId = $user->group()->id;
        $userGroupId = 1;
        if ($userGroupId == $id)
            return false;

        // TODO 删除该组下用户
        // $deleteUser = static::whereIn('id', $ids)->users()->delete();
        $deleteUser = true;

        Access::where('role_id', $id)->where('type', Access::groupType)->delete();

        if ($deleteUser)
            return static::destroy($id);

        return false;
    }

    /**
     * 关联用户表
     * 一对多
     *
     * @return Users
     */
    public function users()
    {
        // TODO
        //return $this->hasMany('User','group_id');
    }


}
