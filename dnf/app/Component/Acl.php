<?php namespace App\Component;

use App\Models\Backend\System\Access as AccessModel;
use App\Models\Backend\System\Acl as AclModel;
use App\Models\Backend\User as UserModel;
use Auth;
use Cache;
use Carbon\Carbon;

class Acl
{

    /**
     * 检查有无权限访问操作
     *
     * @param string $module
     * @param string $class
     * @param string $function
     * @return boolean
     */
    public static function checkHasPermission($module, $class, $function)
    {
        if (Auth::user()->isRoot()) return true;

        if (!Cache::has('permissions')) {
            $permissions = AccessModel::getPermission();
            $acls = AclModel::getAllAcl();
            $expiresAt = Carbon::now()->addMinutes(1);

            Cache::add('permissions', $permissions, $expiresAt);
            Cache::add('acls', $acls, $expiresAt);
        } else {
            $permissions = Cache::get('permissions');
            $acls = Cache::get('acls');
        }

        $key = implode('_', [$module, $class, $function]);
        if (!array_key_exists($key, $acls)) {
            return false;
        }
        return in_array($acls[$key], $permissions);
    }
}
