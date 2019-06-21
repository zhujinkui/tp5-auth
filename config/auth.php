<?php
// 配置文件
// +----------------------------------------------------------------------
// | PHP version 5.4+
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.17php.cn, All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhujinkui <developer@zhujinkui.com>
// +----------------------------------------------------------------------

return [
	// +----------------------------------------------------------------------
	// | 安全设置
	// +----------------------------------------------------------------------

	// 默认认证网关
	'auth_gateway'      => 'Admin/Login/index',
	// 管理员用户key
	'adminauth_key'     => 'developer@zhujinkui.com',
	// 超级管理员用户ID
	'administrator'     => 1,
	// SESSION识别标识
	'auth_session'      => 'auth_access',
	// 是否开启测试数据操作
	'show_testdata'     => false,
	// 认证开关
	'auth_on'           => true,
	// 认证方式，1为实时认证；2为登录认证。
	'auth_type'         => 1,
	// 用户组数据表名
	'auth_group'        => 'auth_group',
	// 用户-用户组关系表
	'auth_group_access' => 'auth_group_access',
	// 权限规则表
	'auth_rule'         => 'auth_rule',
	// 用户信息表
	'auth_user'         => 'member',
];