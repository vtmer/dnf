<?php namespace App\Widgets\Backend;

use App\Component\Acl;
use Lang;

class AclWidget
{

    /**
     * 生成状态改变的文字button
     *
     * @param $formUrl
     * @param string $module
     * @param string $class
     * @param string $function
     * @param string $buttonName
     *
     */
    public function change($formUrl, $module, $class, $function, $buttonName, $buttonId, $id)
    {
        $hasAcl = $this->_hasPermission($module, $class, $function);

        $htmlChange = $hasAcl ?
            '<a id="'.$buttonId.'" title="'.Lang::get('backend.change').'"
            href="javascript:ajaxChange(\''.$formUrl.'\', \''.$buttonId.'\', \''.$id.'\')"'.
            ' class="btn btn-primary btn-rounded">'.$buttonName.'</a>' :
            '<button class="btn btn-primary btn-rounded disabled">'.$buttonName.'</button>';

        return $htmlChange;
    }

    /**
     * 生成文字button
     *
     * @param $formUrl
     * @param string $module
     * @param string $class
     * @param string $function
     * @param string $buttonName
     *
     */
    public function button($formUrl, $module, $class, $function, $buttonName)
    {
        $hasAcl = $this->_hasPermission($module, $class, $function);

        $htmlChange = $hasAcl ?
            '<a href="'.$formUrl.'" class="btn btn-primary btn-rounded">'
            .$buttonName.'</a>' :
            '<a class="btn btn-primary btn-rounded disabled">'.$buttonName.'</a></div>';

        return $htmlChange;
    }

    /**
     * 生成add Button
     *
     * @param $formUrl
     * @param string $module
     * @param string $class
     * @param string $function
     * @param string $buttonName
     */
    public function add($formUrl, $module, $class, $function,$buttonName) {
        $hasAcl = $this->_hasPermission($module, $class, $function);

        $htmlAdd = $hasAcl ?
            '<a href="'.$formUrl.'" class="btn btn-primary btn-labeled" style="width:
            100%;"><span class="btn-label icon fa fa-plus"></span>'.$buttonName.'</a>' :
            '<a class="btn btn-primary btn-labeled disabled" style="width: 100%;">
            <span class="btn-label icon fa fa-plus"></span>'.$buttonName.'</a>';

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
    public function edit($formUrl, $module, $class, $function, $data) {
        $hasAcl = $this->_hasPermission($module, $class, $function);

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
    public function delete($formUrl, $module = '', $class, $function, $tableList, $data) {
        $hasAcl = $this->_hasPermission($module, $class, $function);

        $htmlDel = $hasAcl ?
            '<a title="'.Lang::get('backend.delete').'"
            href="javascript:ajaxDelete(\''.$formUrl.'\', \''.$tableList.'\', \''.$data.'\')"'.
            ' class="btn btn-primary btn-rounded"><i class="fa fa-times-circle"></i></a>' :
            '<button class="btn btn-primary btn-rounded disabled"><i class="fa fa-times-circle"></i></button>';

        return $htmlDel;
    }

    /**
     * 权限检查
     *
     * @return boolean
     */
    private function _hasPermission($module, $class, $function)
    {
        return Acl::checkHasPermission($module, $class, $function);
    }

}
