# tp5-auth
这是一个基于ThinkPHP5框架的Auth类库

## 安装
> composer require zhujinkui/tp5-auth

## 配置
将目录下auth.php配置文件复制到TP5框架定义应用目录(默认：application,如修改则填写修改名称即可)，例如：application/extra下,如无extra文件，创建一个即可。
```
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
```

### 数据库建立
> 建立数据库(例如：system),进入system，复制以下Sql语句执行即可，建议使用MySQL版本5.7，当下数据表默认引擎InnoDB，自5.7版本以后默认默认引擎InnoDB

```
-- phpMyAdmin SQL Dump
-- 主机: localhost
-- 生成日期: 2018 年 02 月 27 日 09:20
-- 服务器版本: 5.5.53
-- PHP 版本: 7.2.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `system`
--

-- --------------------------------------------------------

--
-- 表的结构 `think_auth_group`
--

CREATE TABLE IF NOT EXISTS `think_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '分组ID',
  `name` char(100) NOT NULL COMMENT '分组名称',
  `description` varchar(255) NOT NULL COMMENT '角色描述',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '分组状态',
  `rules` char(255) NOT NULL COMMENT '节点',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- 表的结构 `think_auth_group_access`
--

CREATE TABLE IF NOT EXISTS `think_auth_group_access` (
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '用户ID',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '分组ID',
  UNIQUE KEY `uid_group_id` (`member_id`,`group_id`),
  KEY `uid` (`member_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `think_auth_rule`
--

CREATE TABLE IF NOT EXISTS `think_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '节点ID',
  `name` char(80) NOT NULL COMMENT '节点名称',
  `title` char(20) NOT NULL COMMENT '节点标题',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '节点类型',
  `node_icon` varchar(32) NOT NULL COMMENT '节点图标',
  `class_icon` varchar(32) NOT NULL COMMENT '分类图标',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '节点状态',
  `condition` char(100) NOT NULL COMMENT '节点规则',
  `sort` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `pid` smallint(6) unsigned NOT NULL COMMENT '父级ID',
  `level` tinyint(1) unsigned NOT NULL COMMENT '模块级别',
  `create_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  `update_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- 表的结构 `think_config`
--

CREATE TABLE IF NOT EXISTS `think_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL COMMENT '配置说明',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `extra` varchar(255) NOT NULL COMMENT '配置值',
  `remark` varchar(100) NOT NULL COMMENT '配置说明',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `value` text NOT NULL COMMENT '配置值',
  `default` varchar(255) NOT NULL COMMENT '默认值',
  `placeholder` varchar(255) NOT NULL COMMENT '参数提示',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `type` (`type`),
  KEY `group` (`group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- 表的结构 `think_member`
--

CREATE TABLE IF NOT EXISTS `think_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(20) NOT NULL COMMENT '用户姓名',
  `mobile` char(15) NOT NULL DEFAULT '' COMMENT '用户手机',
  `password` char(32) NOT NULL COMMENT '密码',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `exp` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '经验',
  `points` int(10) NOT NULL DEFAULT '0' COMMENT '积分',
  `register_ip` char(15) NOT NULL COMMENT '注册IP',
  `login_ip` char(15) NOT NULL COMMENT '最后登录IP',
  `login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `login_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) unsigned DEFAULT '1' COMMENT '用户状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`nickname`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=16 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

```

