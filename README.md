# tp5-auth
> 这是一个基于ThinkPHP5框架的Auth类库

## 案例展示
> 基于ThinkPHP5开发呈现权限管理的效果  
![Image text](http://images.22058.com/github/tp5-auth/auth_2.jpg)  
![Image text](http://images.22058.com/github/tp5-auth/auth_3.jpg)

## 安装
> composer require zhujinkui/tp5-auth

## 说明
> AUTH（基于用户角色的访问控制），就是用户通过角色与权限进行关联。简单地说，一个用户拥有若干角色，每一个角色拥有若干权限。这样，就构造成“用户-角色-权限”的授权模型。在这种模型中，用户与角色之间，角色与权限之间，一般者是多对多的关系。（如下图）  
![Image text](http://images.22058.com/github/tp5-auth/auth_1.jpg)  

## 原理
> Auth权限认证是按规则进行认证,在数据库中我们有:

- 认证规则表 （think_auth_rule） 
- 认证用户组表 (think_auth_group) 
- 认证用户组授权权限表（think_auth_group_access）

> 我们在认证规则表中定义权限规则， 在认证用户组表中定义每个用户组有哪些权限规则，在认证用户组授权权限表中定义用户所属的用户组。 

> 举例说明：
> 我们要判断用户是否有显示一个操作按钮的权限， 首先定义一个规则， 在规则表中添加一个名为 show_button 的规则。然后在认证用户组表添加一个用户组，定义这个用户组有show_button 的权限规则（think_auth_group表中rules字段存得时规则ID，多个以逗号隔开）， 然后在用户组明细表定义 UID 为1 的用户 属于刚才这个的这个用户组。 


## 配置
> 将目录下auth.php配置文件复制到TP5框架定义应用目录(默认：application,如修改则填写修改名称即可)，例如：application/extra下,如无extra文件，创建一个即可。  

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

## 代码举例使用
> 建立Base控制器作为所有模块基类
```
<?php
namespace app\common\controller;
use think\Controller;

class Base extends Controller
{
    public function _initialize()
	{
		// 自动动态获取URL需要自行处理
		$url = "Admin/Index/index";
		// 自动动态获取用户UID需要自行处理
		$uuid = 1;

		//实力化权限类库
        $auth =  new \think\auth\Auth();

        if (!$auth->check($url, $uuid)) {
            $this->error('没有权限！');
        }
    }
 }
 
```

> 在数据库中添加的节点规则格式为： “模块-控制器名称-方法名称”，Auth类还可以多个规则一起认证 如： 
```
$auth->check('rule1,rule2',uid); 

```
> 表示 认证用户只要有rule1的权限或rule2的权限，只要有一个规则的权限，认证返回结果就为true 即认证通过。 默认多个权限的关系是 “or” 关系，也就是说多个权限中，只要有个权限通过则通过。 我们也可以定义为 “and” 关系
```
$auth->check('rule1,rule2',uid,'and'); 

```
> 第三个参数指定为"and" 表示多个规则以and关系进行认证， 这时候多个规则同时通过认证才有权限。只要一个规则没有权限则就会返回false。

> Auth认证，一个用户可以属于多个用户组。 比如我们对 show_button这个规则进行认证， 用户A 同时属于 用户组1 和用户组2 两个用户组 ， 用户组1 没有show_button 规则权限， 但如果用户组2 有show_button 规则权限，则一样会权限认证通过。 
```
$auth->getGroups(uid)

```  

> 通过上面代码，可以获得用户所属的所有用户组，方便我们在网站上面显示。Auth类还可以按用户属性进行判断权限， 比如按照用户积分进行判断， 假设我们的用户表(think_member)有字段score记录了用户积分。我在规则表添加规则时，定义规则表的condition字段，condition字段是规则条件，默认为空 表示没有附加条件，用户组中只有规则就通过认证。如果定义了condition字段，用户组中有规则不一定能通过认证，程序还会判断是否满足附加条件。比如我们添加几条规则： 

```
`name`字段：grade1 `condition`字段：{points}<100 <br/>
`name`字段：grade2 `condition`字段：{points}>100 and {points}<200<br/>
`name`字段：grade3 `condition`字段：{points}>200 and {points}<300
```  

> 这里 `{points}` 表示 `think_members` 表 中字段 `points` 的值。 
