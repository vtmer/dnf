<?php namespace App\Widgets\Backend;

use App\Component\Acl;
use Lang;

class AclWidget
{

    /**
     * 生成add Button
     *
     * @param $formUrl
     * @param string $module
     * @param string $class
     * @param string $function
     * @param string $buttonName
     */
    public static function add($formUrl, $module, $class, $function,$buttonName) {
        $hasAcl = static::_hasPermission($module, $class, $function);

        $htmlAdd = $hasAcl ?
            '<a href="'.$formUrl.'" class="btn btn-primary btn-labeled" style="width:
            100%;"><span class="btn-label icon fa fa-plus"></span>'.$buttonName.'</a></div>' :
            '<a class="btn btn-primary btn-labeled disabled" style="width: 100%;">
            <span class="btn-label icon fa fa-plus"></span>'.$buttonName.'</a></div>';

        return $htmlAdd;
    }

    /**
     * 生成edit Button
     *
     * @param $formUrl
     * @param string $module
     * @param string $class
     * @param string function
     * @param array|integer data
     */
    public static function edit($formUrl, $module, $class, $function, $data) {
        $hasAcl = static::_hasPermission($module, $class, $function);

        $htmlEdit = $hasAcl ?
            '<a title="'.Lang::get('backend.edit').'" href="'.$formUrl.
            '" class="btn btn-primary btn-rounded"><i class="fa fa-pencil"></i></a>' :
            '<button class="btn btn-primary btn-rounded disabled"><i class="fa fa-pencil"></i></button>';

        return $htmlEdit;
    }

    /**
     * 生成html,post删除数据
     *
     * @param string $module
     * @param string $class
     * @param string function
     * @param array|integer data
     */
    public static function delete($formUrl, $module = '', $class, $function, $tableList, $data) {
        $hasAcl = static::_hasPermission($module, $class, $function);

        $htmlDel = $hasAcl ?
            '<a title="'.Lang::get('backend.delete').'"
            href="javascript:ajaxDelete(\''.$formUrl.'\', \''.$tableList.'\', \''.$data.'\')"'.
            ' class="btn btn-primary btn-rounded"><i class="fa fa-pencil"></i></a>' :
            '<button class="btn btn-primary btn-rounded disabled"><i class="fa fa-pencil"></i></button>';

        return $htmlDel;
    }

    /**
     * 权限检查
     *
     * @return boolean
     */
    private static function _hasPermission($module, $class, $function)
    {
        return Acl::checkHasPermission($module, $class, $function);
    }

}
