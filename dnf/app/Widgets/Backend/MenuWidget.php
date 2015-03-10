<?php namespace App\Widgets\Backend;

use Auth;
use App\Models\Backend\System\Acl as AclModel;

class MenuWidget
{
    public static function menu()
    {
        $menus = AclModel::getMenuByUid(Auth::user()->id);
        return view('backend.widgets.navbar', [
            'mainMenus' => $menus,
        ]);
    }
}
