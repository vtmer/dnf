<?php namespace App\Models\Backend;

use App\Models\Backend\System\Access;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract {


    use Authenticatable, CanResetPassword;

    const rootId = 1;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin_users';

    protected $fillable = ['name', 'password', 'group_id', 'realname', 'token',
                           'created_at', 'updated_at', 'mobile', 'status', 'mark',
                           'last_login_ip', 'last_login_time', 'remember_token',
                           'is_deleted'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * 根据用户名查询用户
     *
     * @return object | null
     */
    public static function hasUserByName($username)
    {
        return static::where('name', '=', $username)->first();
    }

    /**
     * 删除用户
     *
     * @return boolean
     */
    public static function deleteById($uId)
    {
        $status = Access::where('role_id', $uId)
            ->where('type', Access::userType)->delete();

        if(!static::find($uId)->delete())
            return false;

        return true;

    }

    /**
     * 关联用户组
     * 一对一
     *
     * @return group
     */
    public function group()
    {
        return $this->belongsTo('App\Models\Backend\System\Group', 'group_id', 'id');
    }

    /**
     * 是否是root用户
     *
     * @return boolean
     */
    public function isRoot()
    {
        if ($this->id == self::rootId)
            return true;

        return false;
    }

    /**
     * 获取用户名,ID
     *
     * @return array
     */
    public static function getUsersNameById($ids)
    {
        return static::select('id', 'name')->whereIn('id', $ids)->get();
    }

}
