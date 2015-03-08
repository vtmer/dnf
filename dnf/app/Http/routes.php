<?php

/*
|--------------------------------------------------------------------------
| 备注
|--------------------------------------------------------------------------
| 路由的命名关系到权限控制，请按照下例格式来命名
| 'as' => 'backend|frontend_[模块名_]类名_方法名'
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


# 后台路由组
Route::group(['prefix' => 'backend'], function() {

    # 页面：管理员登陆
    Route::get('/login', [
        'as' => 'backend_auth_auth_index',
        'uses' => 'Backend\Auth\AuthController@index'
    ]);
    # Post: 管理员登陆
    Route::post('/login',[
        'as' => 'backend_auth_auth_login',
        'uses' => 'Backend\Auth\AuthController@login'
    ]);
    # Get: 管理员退出
    Route::get('/logout', [
        'as' => 'backend_auth_auth_logout',
        'uses' => 'Backend\Auth\AuthController@logout'
    ]);

    # 后台首页
    Route::get('/', [
        'as' => 'backend_dashboard_index',
        'uses' => 'Backend\DashboardController@index'
    ]);

});
