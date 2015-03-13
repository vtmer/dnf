<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class BaseController extends Controller {

    /**
     * 初始化
     * @middleware: AdminAuth
     */
    public function __construct()
    {
        $this->middleware('admin.auth');
        $this->middleware('acl.auth');
    }

}
