<?php

return [
    'dnf' => '官网',
    'logout' => '退出',
    'dashboard' => '仪表盘',
    'where' => '所在位置',
    'signin' => '登陆',
    'username' => '用户名',
    'password' => '密码',
    'add-menu'=> '增加功能菜单',
    'add-group'=> '增加用户组',
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
    ],

    # website page title
    'title' => [
        'index' => 'Vtmer官网后台',
        'login' => 'Vtmer官网后台-登陆',
        'acl' => [
            'index' => '菜单管理',
            'add' => '添加菜单',
        ],
    ],

    # messages
    'messages' => [
        'about-module' => '如果涉及模块名，那么请填写，否则可以不填写',
        'select-parent' => '请选择父级功能',
        'cant-change' => '不可更改',
        'confirm' => '确定此操作吗?',
    ],

    # rules messages
    'rules' => [
        'max' => [
            'name' => '名称长度最长为：',
            'module' => '模块名长度最长为：',
            'mark' => '备注名长度最长为：',
        ],
        'required' => [
            'name' => '名称不为空',
            'module' => '模块名不为空',
            'class' => '类名不为空',
            'function' => '函数名不为空',
        ],
        'unique' => [
            'name' => '名称必须唯一',
        ],
        'integer' => [
            'pid' => '父级菜单值数据类型错误',
            'level' => '等级数据类型错误',
        ],
        'between' => [
            'level' => '等级范围为',
        ],
    ],
];
