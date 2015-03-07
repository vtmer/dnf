<?php namespace App\Http\Controllers\Backend;

class DashboardController extends BaseController {

	/**
     * 页面：后台首页
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('backend.dashboard.index');
	}

}
