<?php

return [
    'dnf' => '官网',
    'logout' => '退出',
    'dashboard' => '仪表盘',
    'workspace' => '工作台',
    'menu-management' => '菜单管理',
    'group-management' => '用户组管理',
    'user-management' => '用户管理',
    'newest-action' => '最新动态',
    'where' => '所在位置',
    'signin' => '登陆',
    'username' => '用户名',
    'password' => '密码',
    'add-menu'=> '增加功能菜单',
    'add-group'=> '增加用户组',
    'add-user'=> '增加用户',
    'edit-user'=> '编辑用户',
    'edit-self'=> '编辑个人信息',
    'account' => '帐号',
    'cancel' => '取消',
    'save' => '保存',
    'character-left' => '字符剩余长度',
    'sort' => '排序',
    'update-time' => '更新日期',
    'create-time' => '创建日期',
    'operate' => '操作',
    'save-failed' => '保存失败',
    'none-data' => '数据不存在',
    'edit' => '编辑',
    'delete' => '删除',
    'change' => '改变',
    'option' => '选项',
    'acl-set' => '权限设置',
    'return' => "返回",
    'all-select' => "全选",
    'envelope' => "站内信",
    'unread' => '未读',
    'read' => '已读',
    'send'=> '发送',
    'sended' => '已发送',
    'send-envelope' => '发送站内信',
    'subject' => '标题',
    'send-to' => '发送至',
    'more-message' => '更多消息',

    # status button
    'button-status' => [
        # 状态
        'status' => [
            0 => '禁止',
            1 => '正常',
        ],
    ],


    # Form Label
    'form' => [
        'menu' => '菜单名',
        'module' => '模块名',
        'class' => '类名',
        'function' => '函数名',
        'parent-function' => '父级功能',
        'mark' => '备注',
        'status' => '状态',
        'group' => '用户组名',
        'group-level' => '用户组等级',
        'user' => '用户名',
        'realname' => '真实姓名',
        'last-login-time' => '最后登陆时间',
        'mobile' => '电话',
        'password' => '密码',
        'old-password' => '原密码',
        'password-confirmation' => '重复密码',
    ],

    # website page title
    'title' => [
        'index' => 'Vtmer官网后台',
        'login' => 'Vtmer官网后台-登陆',
        'inbox' => '站内信',
        'acl' => [
            'index' => '菜单管理',
            'add' => '添加菜单',
        ],
    ],

    # messages
    'messages' => [
        'about-module' => '如果涉及模块名，那么请填写，否则可以不填写',
        'select-parent' => '请选择父级功能',
        'select-user' => '请选择用户',
        'select-group' => '请选择用户组',
        'cant-change' => '不可更改',
        'confirm' => '确定此操作吗?',
        'select-all' => '点击我全选',
    ],

    # rules messages
    'rules' => [
        'max' => [
            'name' => '名称长度最长为：',
            'module' => '模块名长度最长为：',
            'mark' => '备注名长度最长为：',
            'content' => '内容长度最长为:',
        ],
        'required' => [
            'name' => '名称不为空',
            'module' => '模块名不为空',
            'class' => '类名不为空',
            'function' => '函数名不为空',
            'realname' => "真实名称",
            'group-id' => '用户组ID不为空',
            'content' => '内容不为空',
            'receiver-id' => '接收人ID不为空',
            'receiver-name' => '接收人姓名不为空',
        ],
        'unique' => [
            'name' => '名称必须唯一',
        ],
        'integer' => [
            'pid' => '父级菜单值数据类型错误',
            'level' => '等级数据类型错误',
            'mobile' => '电话',
            'group-id' => '用户组ID数据类型错误',
            'receiver-id' => '接收人ID数据类型错误',
        ],
        'between' => [
            'name' => '名称长度范围为',
            'level' => '等级范围为',
            'mobile' => '电话范围为',
            'password' => '密码长度范围为',
        ],
        'confirmed' => [
            'password' => '密码前后不一致',
        ]
    ],

    # 动态分类
    'action' => [
        '1' => '新建了菜单',
        '2' => '编辑了菜单',
        '3' => '删除了菜单',
        '4' => '新建了用户组',
        '5' => '编辑了用户组',
        '6' => '删除了用户组',
        '7' => '更改了用户组状态',
        '8' => '更改了用户组权限',
        '9' => '新增了用户',
        '10' => '编辑了用户',
        '11' => '删除了用户',
        '12' => '更改了用户状态',
        '13' => '更改了用户权限',
    ],

    # pusher channel
    'pusher' => [
        'channel' => [
            'mail' => 'mail',
        ],
    ],
];
