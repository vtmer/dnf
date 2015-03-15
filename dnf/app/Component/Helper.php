<?php namespace App\Component;

use Route;

class Helper
{
    public function routeByAcl($client, $menu)
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
    public function menuTopSite($module, $class = false)
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

    /**
     * 时间处理，转换为
     * 刚刚, 几秒前，几分钟前，几小时前等
     *
     * @param int $time 时间戳
     * @return string
     */
    public function mdate($time)
    {
        $text = '';
        $time = $time > time() ? time() : $time;
        $t = time() - $time;
        $y = date('Y', $time) - date('Y', time());//是否跨年

        if($t == 0) $text = '刚刚';
        else if($t < 60) $text = $t . '秒前'; // 一分钟内
        else if($t < 60 * 60) $text = floor($t / 60) . '分钟前'; //一小时内
        else if($t < 60 * 60 * 24) $text = floor($t / (60 * 60)) . '小时前'; // 一天内
        else if($t < 60 * 60 * 24 * 3) $text = floor($time/(60*60*24)) == 1 ? '昨天 ' . date('H:i', $time) : '前天 ' . date('H:i', $time) ; //昨天和前天
        else if($t < 60 * 60 * 24 * 30) $text = date('m/d H:i', $time); //一个月内
        else if($t < 60 * 60 * 24 * 365 && $y == 0) $text = date('m/d', $time); //一年内
        else $text = date('Y/m/d', $time); //一年以前

        return $text;

    }


}
