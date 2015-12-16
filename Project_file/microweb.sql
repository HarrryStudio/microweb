# Host: localhost  (Version: 5.6.12-log)
# Date: 2015-08-06 23:19:46
# Generator: MySQL-Front 5.3  (Build 4.214)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "admin_info"
#

DROP TABLE IF EXISTS `admin_info`;
CREATE TABLE `admin_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` char(15) NOT NULL COMMENT '账号',
  `password` char(32) NOT NULL COMMENT '密码',
  `phone` char(11) NOT NULL COMMENT '电话',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除状态',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员信息';

#
# Data for table "admin_info"
#


#
# Structure for table "album"
#

DROP TABLE IF EXISTS `album`;
CREATE TABLE `album` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0' COMMENT '网站id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '相册名',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='相册';

#
# Data for table "album"
#


#
# Structure for table "answer"
#

DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `question_id` int(11) NOT NULL COMMENT '问题ID',
  `answer` varchar(15) NOT NULL COMMENT '答案',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1禁用,0正常',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='密保问题答案';

#
# Data for table "answer"
#


#
# Structure for table "article"
#

DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属用户ID',
  `content` text COMMENT '内容',
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '标题',
  `pic_id` int(11) NOT NULL DEFAULT '0' COMMENT '图片id',
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT '类型',
  `author` varchar(10) DEFAULT NULL COMMENT '作者',
  `source` varchar(60) DEFAULT NULL COMMENT '来源',
  `url` varchar(100) DEFAULT NULL COMMENT '网址',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章';

#
# Data for table "article"
#


#
# Structure for table "background"
#

DROP TABLE IF EXISTS `background`;
CREATE TABLE `background` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '名字',
  `pic_id` int(11) NOT NULL DEFAULT '0' COMMENT '背景图片的id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `forbidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '禁用',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='背景';

#
# Data for table "background"
#


#
# Structure for table "column"
#

DROP TABLE IF EXISTS `column`;
CREATE TABLE `column` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '栏目名',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '摆放顺序',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `forbidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '禁用',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='栏目';

#
# Data for table "column"
#


#
# Structure for table "controller"
#

DROP TABLE IF EXISTS `controller`;
CREATE TABLE `controller` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(10) NOT NULL DEFAULT '' COMMENT '控件名',
  `intro` varchar(255) DEFAULT NULL COMMENT '空间描述',
  `url` varchar(40) NOT NULL DEFAULT '' COMMENT '地址',
  `icon` varchar(40) NOT NULL DEFAULT '' COMMENT '图标',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '摆放顺序',
  `forbidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '禁用 0 ： 正常 1：禁用',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0 ： 正常 1 ： 删除',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='控件';

#
# Data for table "controller"
#


#
# Structure for table "forbidden"
#

DROP TABLE IF EXISTS `forbidden`;
CREATE TABLE `forbidden` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '被禁用户',
  `reason` varchar(30) NOT NULL DEFAULT '' COMMENT '禁用原因',
  `num` tinyint(1) DEFAULT '0' COMMENT '禁用次数',
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '禁用时间',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='禁用表';

#
# Data for table "forbidden"
#


#
# Structure for table "message"
#

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '建站人',
  `way` tinyint(1) NOT NULL DEFAULT '0' COMMENT '方式  0 ： 用户给后台 1：回台回复',
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '发送时间',
  `content` varchar(140) DEFAULT '' COMMENT '内容',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='留言';

#
# Data for table "message"
#


#
# Structure for table "node_info"
#

DROP TABLE IF EXISTS `node_info`;
CREATE TABLE `node_info` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '菜单名',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单节点表';

#
# Data for table "node_info"
#


#
# Structure for table "photo"
#

DROP TABLE IF EXISTS `photo`;
CREATE TABLE `photo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL DEFAULT '0' COMMENT '相册id',
  `pic_id` int(11) NOT NULL DEFAULT '0' COMMENT '图片id',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户图片表';

#
# Data for table "photo"
#


#
# Structure for table "picture"
#

DROP TABLE IF EXISTS `picture`;
CREATE TABLE `picture` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `savename` varchar(40) NOT NULL DEFAULT '' COMMENT '文件名',
  `savepath` varchar(20) NOT NULL DEFAULT '' COMMENT '文件夹名',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5码',
  `size` int(11) NOT NULL DEFAULT '0' COMMENT '文件大小',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图片表';

#
# Data for table "picture"
#


#
# Structure for table "problem"
#

DROP TABLE IF EXISTS `problem`;
CREATE TABLE `problem` (
  `id` int(2) NOT NULL,
  `user_id` int(10) NOT NULL,
  `question` varchar(30) NOT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1禁用,0正常',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='密保问题';

#
# Data for table "problem"
#


#
# Structure for table "site_info"
#

DROP TABLE IF EXISTS `site_info`;
CREATE TABLE `site_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '网站ID',
  `site_name` varchar(32) NOT NULL COMMENT '网站名',
  `user_id` int(11) NOT NULL COMMENT '所属用户ID',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除状态',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `url` varchar(32) NOT NULL COMMENT '网站的url',
  `size` int(11) NOT NULL DEFAULT '0' COMMENT '网站文件夹大小 (字节数)',
  `click_num` int(11) NOT NULL DEFAULT '0' COMMENT '点击量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户网站';

#
# Data for table "site_info"
#


#
# Structure for table "theme"
#

DROP TABLE IF EXISTS `theme`;
CREATE TABLE `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='主题';

#
# Data for table "theme"
#


#
# Structure for table "type"
#

DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `title` varchar(10) DEFAULT '' COMMENT '类型名',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章类型';

#
# Data for table "type"
#


#
# Structure for table "user_info"
#

DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `account` char(15) NOT NULL COMMENT '账户',
  `password` char(32) NOT NULL COMMENT '密码',
  `phone` char(11) NOT NULL COMMENT '电话',
  `email` varchar(40) DEFAULT NULL COMMENT '邮箱',
  `head_img` char(40) DEFAULT NULL COMMENT '头像地址',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除状态',
  `forbidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1禁用,0未禁用',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户信息';

#
# Data for table "user_info"
#

