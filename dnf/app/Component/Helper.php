<?php namespace App\Component;

use Route;

class Helper
{
    public static function routeByAcl($client, $menu)
    {
        $module = $menu->module;
        $class = $menu->class;
        $function = $menu->function;
        if (null != $module)
            $routeAlias = '/'.$client.'/'.$module.'/'.$class.'/'.$function;
        else
            $routeAlias = '/'.$client.'/'.$class.'/'.$function;

        return $routeAlias;
    }

    /**
     * 判断当前是否处于改module, $class
     *
     * @return boolean
     */
    public static function menuTopSite($module, $class = false)
    {
        $currentUri = Route::current()->getUri();
        $uriArray = explode("/", $currentUri);

        if (isset($uriArray[1]) && $uriArray[1] === $module) {
            if ($class) {
                return $class == $uriArray[2] ? true : false;
            }
            return true;
        }

        return false;
    }

}
