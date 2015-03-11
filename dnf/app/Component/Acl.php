<?php namespace App\Component;

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
        // TODO: 检查权限
        return true;
    }
}
