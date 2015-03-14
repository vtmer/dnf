DROP TABLE IF EXISTS `dnf_admin_access`;
CREATE TABLE `dnf_admin_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL COMMENT '角色的ID',
  `permission_id` int(11) NOT NULL COMMENT '节点的ID',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '标识是用户组还是用户 1为用户组 2为用户,默认为用户组',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='权限表' ;


DROP TABLE IF EXISTS `dnf_admin_permission`;
CREATE TABLE `dnf_admin_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) COMMENT '模块',
  `class` varchar(255) NOT NULL COMMENT '类',
  `function` varchar(255) NOT NULL COMMENT '方法',
  `name` varchar(255) NOT NULL COMMENT '节点的名字',
  `display` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1为显示为菜单，0则不显示',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '节点的父节点，此值一般用于输出树形结构，0则为顶级',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `level` tinyint(2) NOT NULL DEFAULT '1' COMMENT '第几级菜单',
  `mark` varchar(255) DEFAULT NULL COMMENT '备注',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除(0未删除 1删除)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='权限节点表';



DROP TABLE IF EXISTS `dnf_admin_users`;
CREATE TABLE `dnf_admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '用户密码',
  `group_id` int(11) NOT NULL,
  `realname` varchar(255) DEFAULT '' COMMENT '真实性名',
  `token` varchar(255) NOT NULL COMMENT '用户注册时的密钥',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `mobile` varchar(11) DEFAULT NULL COMMENT '手机',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户禁用0正常的1',
  `mark` varchar(255) DEFAULT '' COMMENT '备注',
  `last_login_ip` varchar(255) DEFAULT NULL COMMENT '最后登录ip',
  `last_login_time` bigint(20) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT '' COMMENT 'Remember_token',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户表';

INSERT INTO `dnf_admin_users` (`id`, `name`, `password`, `group_id`, `realname`, `token`, `created_at`, `updated_at`, `mobile`, `status`, `mark`, `last_login_ip`, `last_login_time`, `remember_token`, `is_deleted`) VALUES
(1, 'root', '$2y$10$4eNKAlHS6qK7th0Dj.rW1eUHldux4rNILIl42mJL2PIGabDGdEdeK', 1, '叶子鑫', '', 0, 0, NULL, 1, '', NULL, NULL, '', 0);


DROP TABLE IF EXISTS `dnf_admin_user_groups`;
CREATE TABLE IF NOT EXISTS `dnf_admin_user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '用户组名',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `mark` varchar(255) DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否禁用',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '用户组等级，低等级的不能对高等级的用户做修改',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除(0未删除 1删除)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户组表' ;

INSERT INTO `dnf_admin_user_groups` (`id`, `name`, `created_at`, `updated_at`, `mark`, `status`, `level`, `is_deleted`) VALUES
(1, '超级用户组', '', '', '123123', 1, 999, 0);


