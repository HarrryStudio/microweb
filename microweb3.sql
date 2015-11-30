/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : microweb

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-09-12 17:28:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_info
-- ----------------------------
DROP TABLE IF EXISTS `admin_info`;
CREATE TABLE `admin_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` char(15) NOT NULL COMMENT '账号',
  `admin_name` char(20) NOT NULL COMMENT '姓名',
  `password` char(32) NOT NULL COMMENT '密码',
  `phone` char(11) NOT NULL COMMENT '电话',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除状态',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员信息';

-- ----------------------------
-- Records of admin_info
-- ----------------------------
INSERT INTO `admin_info` VALUES ('1', 'admin', '', 'e10adc3949ba59abbe56e057f20f883e', '', '0', '0', '0');

-- ----------------------------
-- Table structure for album
-- ----------------------------
DROP TABLE IF EXISTS `album`;
CREATE TABLE `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0' COMMENT '网站id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '相册名',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='相册';

-- ----------------------------
-- Records of album
-- ----------------------------
INSERT INTO `album` VALUES ('1', '1', 'test1', '1442049594', '1442049594');

-- ----------------------------
-- Table structure for answer
-- ----------------------------
DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `question_id` int(11) NOT NULL COMMENT '问题ID',
  `answer` varchar(15) NOT NULL COMMENT '答案',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1禁用,0正常',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='密保问题答案';

-- ----------------------------
-- Records of answer
-- ----------------------------
INSERT INTO `answer` VALUES ('1', '1', '1', 'asd', '0', '1442045283', '1442045283');
INSERT INTO `answer` VALUES ('2', '1', '3', 'asd', '0', '1442045283', '1442045283');
INSERT INTO `answer` VALUES ('3', '1', '2', 'asd', '0', '1442045283', '1442045283');

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属网站ID',
  `content` text COMMENT '内容',
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '标题',
  `pic_id` int(11) NOT NULL DEFAULT '0' COMMENT '图片id',
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT '类型',
  `author` varchar(10) DEFAULT NULL COMMENT '作者',
  `source` varchar(60) DEFAULT NULL COMMENT '来源',
  `url` varchar(100) DEFAULT NULL COMMENT '网址',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 -1:删除 0:启用 1:禁用',
  `is_top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章';

-- ----------------------------
-- Records of article
-- ----------------------------

-- ----------------------------
-- Table structure for background
-- ----------------------------
DROP TABLE IF EXISTS `background`;
CREATE TABLE `background` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '名字',
  `pic_id` int(11) NOT NULL DEFAULT '0' COMMENT '背景图片的id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `forbidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '禁用',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='背景';

-- ----------------------------
-- Records of background
-- ----------------------------

-- ----------------------------
-- Table structure for column
-- ----------------------------
DROP TABLE IF EXISTS `column`;
CREATE TABLE `column` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '栏目名',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '摆放顺序',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `forbidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='栏目';

-- ----------------------------
-- Records of column
-- ----------------------------

-- ----------------------------
-- Table structure for controller
-- ----------------------------
DROP TABLE IF EXISTS `controller`;
CREATE TABLE `controller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(10) NOT NULL DEFAULT '' COMMENT '控件名',
  `intro` varchar(255) DEFAULT NULL COMMENT '空间描述',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '地址',
  `icon` varchar(40) NOT NULL DEFAULT '' COMMENT '图标',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '摆放顺序',
  `forbidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '禁用 0 ： 正常 1：禁用',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0 ： 正常 1 ： 删除',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='控件';

-- ----------------------------
-- Records of controller
-- ----------------------------

-- ----------------------------
-- Table structure for forbidden
-- ----------------------------
DROP TABLE IF EXISTS `forbidden`;
CREATE TABLE `forbidden` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '被禁用户',
  `reason` varchar(30) NOT NULL DEFAULT '' COMMENT '禁用原因',
  `num` tinyint(1) DEFAULT '0' COMMENT '禁用次数',
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '禁用时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='禁用表';

-- ----------------------------
-- Records of forbidden
-- ----------------------------

-- ----------------------------
-- Table structure for guide
-- ----------------------------
DROP TABLE IF EXISTS `guide`;
CREATE TABLE `guide` (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT '使用教程指导',
  `guide_title` char(32) NOT NULL COMMENT '教程标题',
  `content` text COMMENT '教程内容',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of guide
-- ----------------------------

-- ----------------------------
-- Table structure for html
-- ----------------------------
DROP TABLE IF EXISTS `html`;
CREATE TABLE `html` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `html` text CHARACTER SET utf8 NOT NULL COMMENT 'html内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of html
-- ----------------------------

-- ----------------------------
-- Table structure for message
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '建站人',
  `way` tinyint(1) NOT NULL DEFAULT '0' COMMENT '方式0:用户给后台;n:回复的信息id',
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '发送时间',
  `content` varchar(140) DEFAULT '' COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='留言';

-- ----------------------------
-- Records of message
-- ----------------------------

-- ----------------------------
-- Table structure for node_info
-- ----------------------------
DROP TABLE IF EXISTS `node_info`;
CREATE TABLE `node_info` (
  `id` varchar(15) NOT NULL COMMENT '后台导航表',
  `node_name` varchar(20) NOT NULL COMMENT '导航名',
  `node_url` varchar(100) DEFAULT NULL,
  `depth` tinyint(4) NOT NULL COMMENT '导航分类（主导航、子导航）',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '导航排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0：正常 1：删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of node_info
-- ----------------------------
INSERT INTO `node_info` VALUES ('01', '首页', 'Admin/Index', '1', '0', '0');
INSERT INTO `node_info` VALUES ('02', '用户管理', 'Admin/User', '1', '1', '0');
INSERT INTO `node_info` VALUES ('0201', '用户信息', null, '2', '0', '0');
INSERT INTO `node_info` VALUES ('020101', '用户列表', 'Admin/User/index', '3', '0', '0');
INSERT INTO `node_info` VALUES ('03', '微站管理', 'Admin/Station', '1', '2', '0');
INSERT INTO `node_info` VALUES ('0301', '微站信息', null, '2', '0', '0');
INSERT INTO `node_info` VALUES ('030101', '微站列表', 'Admin/Station/index', '3', '0', '0');
INSERT INTO `node_info` VALUES ('04', '前端管理', 'Admin/Reception', '1', '3', '0');
INSERT INTO `node_info` VALUES ('0401', '前端信息', null, '2', '0', '0');
INSERT INTO `node_info` VALUES ('040101', '背景管理', 'Admin/Reception/index', '3', '0', '0');
INSERT INTO `node_info` VALUES ('040102', '栏目管理', 'Admin/Reception/column', '3', '0', '0');
INSERT INTO `node_info` VALUES ('040103', '控件管理', 'Admin/Reception/widget', '3', '0', '0');
INSERT INTO `node_info` VALUES ('040104', '主题管理', 'Admin/Reception/theme', '3', '0', '0');
INSERT INTO `node_info` VALUES ('05', '网站管理', 'Admin/Website', '1', '4', '0');
INSERT INTO `node_info` VALUES ('0501', '网站信息', null, '2', '0', '0');
INSERT INTO `node_info` VALUES ('050101', '管理团队', 'Admin/Website/index', '3', '0', '0');
INSERT INTO `node_info` VALUES ('050102', '密保问题', 'Admin/Website/security', '3', '0', '0');
INSERT INTO `node_info` VALUES ('050103', '使用教程', 'Admin/Website/tutorial', '3', '0', '0');
INSERT INTO `node_info` VALUES ('06', '留言管理', 'Admin/Message', '1', '5', '0');
INSERT INTO `node_info` VALUES ('0601', '留言信息', null, '2', '0', '0');
INSERT INTO `node_info` VALUES ('060101', '信息列表', 'Admin/Message/index', '3', '0', '0');

-- ----------------------------
-- Table structure for photo
-- ----------------------------
DROP TABLE IF EXISTS `photo`;
CREATE TABLE `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL DEFAULT '0' COMMENT '相册id',
  `pic_id` int(11) NOT NULL DEFAULT '0' COMMENT '图片id',
  `create_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户图片表';

-- ----------------------------
-- Records of photo
-- ----------------------------

-- ----------------------------
-- Table structure for picture
-- ----------------------------
DROP TABLE IF EXISTS `picture`;
CREATE TABLE `picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `savename` varchar(40) NOT NULL DEFAULT '' COMMENT '文件名',
  `savepath` varchar(25) NOT NULL DEFAULT '' COMMENT '文件夹名',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5码',
  `size` int(11) NOT NULL DEFAULT '0' COMMENT '文件大小',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `used` int(11) DEFAULT NULL COMMENT '相同图片使用次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='图片表';

-- ----------------------------
-- Records of picture
-- ----------------------------
INSERT INTO `picture` VALUES ('1', '55f3e17db6069.png', 'column/2015-09-12/', '92372d60879fe5c7df042597fecf6f8c', '18405', '0', '0', '0', null);
INSERT INTO `picture` VALUES ('2', '55f3e32e6d321.png', 'column/2015-09-12/', 'a70922c1916ac004bb57af3248dabd7b', '18445', '0', '0', '0', null);
INSERT INTO `picture` VALUES ('3', '55f3e353bfc2e.png', 'column/2015-09-12/', 'c742552d0c640d72fe9670dc93aab30c', '18646', '0', '0', '0', null);
INSERT INTO `picture` VALUES ('4', '55f3e9d75197d.png', 'template/2015-09-12/', 'c742552d0c640d72fe9670dc93aab30c', '18646', '0', '1442048471', '1442048471', null);

-- ----------------------------
-- Table structure for problem
-- ----------------------------
DROP TABLE IF EXISTS `problem`;
CREATE TABLE `problem` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `question` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1禁用,0正常',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='密保问题';

-- ----------------------------
-- Records of problem
-- ----------------------------

-- ----------------------------
-- Table structure for site_info
-- ----------------------------
DROP TABLE IF EXISTS `site_info`;
CREATE TABLE `site_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '网站ID',
  `site_name` varchar(32) NOT NULL COMMENT '网站名',
  `user_id` int(11) NOT NULL COMMENT '所属用户ID',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态(0:正常，1：删除)',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `url` varchar(32) NOT NULL COMMENT '网站的url',
  `size` int(11) NOT NULL DEFAULT '0' COMMENT '网站文件夹大小 (字节数)',
  `click_num` int(11) NOT NULL DEFAULT '0' COMMENT '点击量',
  `theme` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户网站';

-- ----------------------------
-- Records of site_info
-- ----------------------------
INSERT INTO `site_info` VALUES ('1', 'test1', '1', '0', '1442045356', '1442045356', 'test1', '0', '0', '0');

-- ----------------------------
-- Table structure for theme
-- ----------------------------
DROP TABLE IF EXISTS `theme`;
CREATE TABLE `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pic_id` int(11) DEFAULT '0' COMMENT '图片id',
  `addr` varchar(40) DEFAULT '' COMMENT '主题模板id',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='主题';

-- ----------------------------
-- Records of theme
-- ----------------------------
INSERT INTO `theme` VALUES ('1', '4', '', '0');

-- ----------------------------
-- Table structure for topic
-- ----------------------------
DROP TABLE IF EXISTS `topic`;
CREATE TABLE `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '栏目名',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '摆放顺序',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态(0:正常，1：删除)',
  `forbidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态(0：开启，1：禁用)',
  `url` varchar(40) DEFAULT '',
  `icon` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='栏目';

-- ----------------------------
-- Records of topic
-- ----------------------------
INSERT INTO `topic` VALUES ('1', '主页', '1', '1442046333', '1442046333', '0', '0', 'index', '1');
INSERT INTO `topic` VALUES ('2', '新闻信息', '2', '1442046766', '1442046766', '0', '0', 'news', '2');
INSERT INTO `topic` VALUES ('3', '关于我们', '3', '1442046803', '1442046803', '0', '0', 'about', '3');

-- ----------------------------
-- Table structure for type
-- ----------------------------
DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章的类型表',
  `site_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `name` varchar(10) DEFAULT '' COMMENT '类型名',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章类型';

-- ----------------------------
-- Records of type
-- ----------------------------

-- ----------------------------
-- Table structure for user_column
-- ----------------------------
DROP TABLE IF EXISTS `user_column`;
CREATE TABLE `user_column` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL COMMENT '网站ID',
  `html_id` int(11) NOT NULL COMMENT 'html_id',
  `name` varchar(8) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '栏目名',
  `forbidden` tinyint(1) NOT NULL COMMENT '是否开启',
  `sort` tinyint(3) NOT NULL COMMENT '排序',
  `url` varchar(20) NOT NULL COMMENT '网页URL',
  `icon` int(11) DEFAULT '0' COMMENT '用户图片的ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_column
-- ----------------------------

-- ----------------------------
-- Table structure for user_info
-- ----------------------------
DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `nickname` char(20) DEFAULT NULL COMMENT '用户昵称',
  `account` char(15) NOT NULL COMMENT '账户',
  `password` char(32) NOT NULL COMMENT '密码',
  `phone` char(11) DEFAULT NULL COMMENT '电话',
  `email` varchar(40) DEFAULT NULL COMMENT '邮箱',
  `head_img` char(40) DEFAULT NULL COMMENT '头像地址',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除状态',
  `forbidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1禁用,0未禁用',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户信息';

-- ----------------------------
-- Records of user_info
-- ----------------------------
INSERT INTO `user_info` VALUES ('1', null, 'a123456781', 'dc483e80a7a0bd9ef71d8cf973673924', null, null, null, '0', '0', '1442045283', '1442045283');
