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

    # 登陆验证
    Route::group(['middleware' => 'admin.auth'], function () {

        # 后台首页
        Route::get('/', [
            'as' => 'backend_dashboard_index',
            'uses' => 'Backend\DashboardController@index'
        ]);

        # 页面: 修改当前用户信息
        Route::get('/account', [
            'as' => 'backend_dashboard_user_account',
            'uses' => 'Backend\DashboardController@account',
        ]);

        # 动作: 修改当前用户信息
        Route::post('/account', [
            'as' => 'backend_dashboard_user_account',
            'uses' => 'Backend\DashboardController@_account',
        ]);

        # 站内信
        Route::group(['prefix' => 'inbox'], function () {

            Route::get('/', [
                'as' => 'backend_inbox_index',
                'uses' => 'Backend\Inbox\InboxController@index',
            ]);

            Route::post('/unread', [
                'as' => 'backend_inbox_unread',
                'uses' => 'Backend\Inbox\InboxController@unread',
            ]);

            Route::post('/read', [
                'as' => 'backend_inbox_read',
                'uses' => 'Backend\Inbox\InboxController@read',
            ]);

            Route::post('/sended', [
                'as' => 'backend_inbox_sended',
                'uses' => 'Backend\Inbox\InboxController@sended',
            ]);

            Route::post('/send', [
                'as' => 'backend_inbox_send',
                'uses' => 'Backend\Inbox\InboxController@_send',
            ]);

            Route::post('/flag', [
                'as' => 'backend_inbox_flag',
                'uses' => 'Backend\Inbox\InboxController@_flag',
            ]);
        });


        # 权限验证
        Route::group(['middleware' => 'acl.auth'], function () {

            # 系统管理
            Route::group(['prefix' => 'system'], function() {

                # 菜单功能管理
                Route::group(['prefix' => 'acl'], function() {

                    # 页面：菜单功能首页
                    Route::get('/index', [
                        'as' => 'backend_system_acl_index',
                        'uses' => 'Backend\System\AclController@index'
                    ]);

                    # 页面：菜单功能添加
                    Route::get('/add', [
                        'as' => 'backend_system_acl_add',
                        'uses' => 'Backend\System\AclController@add'
                    ]);
                    # 动作：菜单功能添加
                    Route::post('/add', [
                        'as' => 'backend_system_acl_add',
                        'uses' => 'Backend\System\AclController@_add'
                    ]);

                    # 动作：菜单功能编辑
                    Route::get('/edit', [
                        'as' => 'backend_system_acl_edit',
                        'uses' => 'Backend\System\AclController@edit'
                    ]);
                    # 动作：菜单功能编辑保存
                    Route::post('/edit', [
                        'as' => 'backend_system_acl_edit',
                        'uses' => 'Backend\System\AclController@_edit'
                    ]);

                    # 动作：菜单功能删除
                    Route::post('/delete', [
                        'as' => 'backend_system_acl_delete',
                        'uses' => 'Backend\System\AclController@_delete'
                    ]);
                });

                # 用户组管理
                Route::group(['prefix' => 'group'], function() {

                    # 页面：用户组首页
                    Route::get('/index', [
                        'as' => 'backend_system_group_index',
                        'uses' => 'Backend\System\GroupController@index'
                    ]);

                    # 页面: 用户组添加
                    Route::get('/add', [
                        'as' => 'backend_system_group_add',
                        'uses' => 'Backend\System\GroupController@add'
                    ]);
                    # 动作：用户组添加
                    Route::post('/add', [
                        'as' => 'backend_system_group_add',
                        'uses' => 'Backend\System\GroupController@_add'
                    ]);

                    # 页面：用户组编辑
                    Route::get('/edit', [
                        'as' => 'backend_system_group_edit',
                        'uses' => 'Backend\System\GroupController@edit'
                    ]);
                    # 动作：用户组编辑保存
                    Route::post('/edit', [
                        'as' => 'backend_system_group_edit',
                        'uses' => 'Backend\System\GroupController@_edit'
                    ]);

                    # 动作：用户组删除
                    Route::post('/delete', [
                        'as' => 'backend_system_group_delete',
                        'uses' => 'Backend\System\GroupController@_delete'
                    ]);

                    # 动作：改变用户组状态
                    Route::post('/change-status', [
                        'as' => 'backend_system_group_change-status',
                        'uses' => 'Backend\System\GroupController@_changeStatus'
                    ]);

                    # 页面：用户组权限
                    Route::get('/acl', [
                        'as' => 'backend_system_group_acl',
                        'uses' => 'Backend\System\GroupController@acl'
                    ]);
                    # 动作J：用户组权限保存
                    Route::post('/acl', [
                        'as' => 'backend_system_group_acl',
                        'uses' => 'Backend\System\GroupController@_acl'
                    ]);

                });

                # 用户管理
                Route::group(['prefix' => 'user'], function() {

                    # 页面：用户首页
                    Route::get('/index', [
                        'as' => 'backend_system_user_index',
                        'uses' => 'Backend\System\UserController@index'
                    ]);

                    # 页面: 用户添加
                    Route::get('/add', [
                        'as' => 'backend_system_user_add',
                        'uses' => 'Backend\System\UserController@add'
                    ]);
                    # 动作：用户添加
                    Route::post('/add', [
                        'as' => 'backend_system_user_add',
                        'uses' => 'Backend\System\UserController@_add'
                    ]);

                    # 页面：用户编辑
                    Route::get('/edit', [
                        'as' => 'backend_system_user_edit',
                        'uses' => 'Backend\System\UserController@edit'
                    ]);
                    # 动作：用户编辑保存
                    Route::post('/edit', [
                        'as' => 'backend_system_user_edit',
                        'uses' => 'Backend\System\UserController@_edit'
                    ]);

                    # 动作：用户删除
                    Route::post('/delete', [
                        'as' => 'backend_system_user_delete',
                        'uses' => 'Backend\System\UserController@_delete'
                    ]);

                    # 动作：改变用户组状态
                    Route::post('/change-status', [
                        'as' => 'backend_system_user_change-status',
                        'uses' => 'Backend\System\UserController@_changeStatus'
                    ]);

                    # 页面：用户权限
                    Route::get('/acl', [
                        'as' => 'backend_system_user_acl',
                        'uses' => 'Backend\System\UserController@acl'
                    ]);
                    # 动作：用户权限保存
                    Route::post('/acl', [
                        'as' => 'backend_system_user_acl',
                        'uses' => 'Backend\System\UserController@_acl'
                    ]);

                });
            });
    Route::group(['prefix' => 'blog'], function() {
          #栏目管理
       Route::group(array('prefix' => 'category'),function () {
           #栏目列表
           route::get('/',array(
                   'as'=> 'backend_blog_category_index',
 		   'uses'=>'Backend\Blog\CategoryController@showCategory'
           ));
           #新建栏目
           Route::post('/create',array(
            'as' => 'backend_blog_category_create',
            'uses' =>'Backend\Blog\CategoryController@createCategory'
           ));

           #修改栏目
           Route::post('/update',array(
            'as' => 'backend_blog_category_update',
            'uses'=>'Backend\Blog\CategoryController@updateCategory'
           ));

           #删除栏目
           Route::post('/delete',array(
            'as' => 'backend_blog_category_delete',
            'uses' => 'Backend\Blog\CategoryController@deleteCategory'
           ));
        });

       #标签管理
       Route::group(array('prefix' => 'tag'),function () {
           #标签列表
           route::get('/',array(
                   'as'=> 'backend_blog_tag_index',
 		   'uses'=>'Backend\Blog\TagController@showTag'
           ));
           #新建标签
           Route::post('/create',array(
            'as' => 'backend_blog_tag_create',
            'uses' =>'Backend\Blog\TagController@createTag'
           ));

           #修改标签
           Route::post('/update',array(
            'as' => 'backend_blog_tag_update',
            'uses'=>'Backend\Blog\TagController@updateTag'
           ));

           #删除标签
           Route::post('/delete',array(
            'as' => 'backend_blog_tag_delete',
            'uses' => 'Backend\Blog\TagController@deleteTag'
           ));
        });


        #文章管理
        Route::group(array('prefix'=>'articles'), function () {

           #文章列表页面
           Route::get('/',array(
            'as' => 'backend_blog_articles_index',
            'uses'=>'Backend\Blog\ArticleController@getArticles'
           ));
           #文章添加页面
           Route::get('/create',array(
            'as'=> 'backend_blog_articles_create',
            'uses'=>'Backend\Blog\ArticleController@_create'
           ));
           # 回收站页面
           Route::get('/trashed',array(
            'as' => 'backend_blog_articles_trashed',
            'uses' => 'Backend\Blog\ArticleController@getTrashedArticles'
           ));

           # 文章发表
           Route::post('/create',array(
            'as' => 'backend_blog_articles_create',
            'uses' => 'Backend\Blog\ArticleController@createArticle'
           ));


          # 文章编辑页面
           Route::get('/update', array(
           'as' => 'backend_blog_articles_update',
           'uses' => 'Backend\Blog\ArticleController@update'
         ));


            # 文章修改
            Route::post('/update', array(
            'as' => 'backend_blog_articles_update',
            'uses' => 'Backend\Blog\ArticleController@_update'
            ));

            # 改变文章的发布状态
            Route::post('/change-status', array(
            'as' => 'backend_blog_articles_change-status',
            'uses' => 'Backend\Blog\ArticleController@_changeStatus'
            ));

            # 文章彻底删除
            Route::post('/delete', array(
            'as' => 'backend_blog_articles_delete',
            'uses' => 'Backend\Blog\ArticleController@deleteTrashedArticle'
            ));


            # 文章软删除
            Route::post('/softdelete',array(
            'as' => 'backend_blog_articles_softdelete',
            'uses' =>'Backend\Blog\ArticleController@softdeleteArticle'
            ));



             # 文章恢复
             Route::post('/restore', array(
                'as' => 'backend_blog_articles_restore',
                'uses' => 'Backend\Blog\ArticleController@restoreTrashedArticle'
            ));
             # 改变文章排序
            Route::post('/sort', array(
                'as' => 'backend_blog_articles_sort',
                'uses' => 'Backend\Blog\ArticleController@articleSort'
            ));

        });
       });
    });
   });
 });
