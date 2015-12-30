/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.6.21 : Database - microweb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`microweb` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `microweb`;

/*Table structure for table `admin_info` */

DROP TABLE IF EXISTS `admin_info`;

CREATE TABLE `admin_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` char(15) NOT NULL COMMENT '账号',
  `admin_name` char(15) DEFAULT '""' COMMENT '管理员姓名',
  `password` char(32) NOT NULL COMMENT '密码',
  `phone` char(11) NOT NULL COMMENT '电话',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除状态',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员信息';

/*Data for the table `admin_info` */

insert  into `admin_info`(`id`,`account`,`admin_name`,`password`,`phone`,`status`,`create_time`,`update_time`) values (1,'admin','\"\"','e10adc3949ba59abbe56e057f20f883e','15617198028',0,0,0);

/*Table structure for table `album` */

DROP TABLE IF EXISTS `album`;

CREATE TABLE `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0' COMMENT '网站id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '相册名',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='相册';

/*Data for the table `album` */

insert  into `album`(`id`,`site_id`,`name`,`create_time`,`update_time`) values (19,61,'ling',1446813475,1446813475),(21,62,'album_one',1450408452,1450409644);

/*Table structure for table `answer` */

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='密保问题答案';

/*Data for the table `answer` */

insert  into `answer`(`id`,`user_id`,`question_id`,`answer`,`status`,`create_time`,`update_time`) values (4,5,1,'ling',0,1446813218,1446813218),(5,5,2,'ling',0,1446813218,1446813218),(6,5,3,'ling',0,1446813218,1446813218);

/*Table structure for table `article` */

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='文章';

/*Data for the table `article` */

insert  into `article`(`id`,`site_id`,`content`,`title`,`pic_id`,`type_id`,`author`,`source`,`url`,`create_time`,`update_time`,`status`,`is_top`) values (23,61,'&lt;p&gt;vklehgpohgoihglkhkjlhafiophrihgopahbfkl;&lt;/p&gt;','linglingling',75,12,'方式','地方','www.baidu.com',1446815098,1446815098,0,0),(24,62,'&lt;p&gt;dfgdsfgdfsgdfscvbxcbbggfdgbvcxbrgdfbcvxbgfdbvcxbrgbvcgrgcxbverag&lt;/p&gt;&lt;p&gt;gfdsgdsgfdsgfdg&lt;/p&gt;&lt;p&gt;gfdsgdfsg&lt;/p&gt;&lt;p&gt;gfdsgfdg&lt;/p&gt;&lt;p&gt;gdfs&lt;/p&gt;&lt;p&gt;gfdg&lt;/p&gt;&lt;p&gt;dfsg&lt;/p&gt;&lt;p&gt;fdsg&lt;/p&gt;&lt;p&gt;dfsg&lt;/p&gt;&lt;p&gt;fds&lt;/p&gt;&lt;p&gt;gdfsg&lt;/p&gt;','article_one',1,26,'fdsaf','fdsaf','fgds',1450401658,1450403058,0,0),(25,62,'&lt;p&gt;fdsafdsaf&lt;/p&gt;','article_two',2,27,'fdsaf','fsdf','fdsaf',1450402160,1450403015,0,1),(26,62,'&lt;p&gt;fdsafdsaf&lt;/p&gt;','gdfagdf',0,28,'fdsa','dsaf','fdsa',1450403028,1450403042,-1,0),(27,62,'&lt;p&gt;fdsafdsafdsaf&lt;/p&gt;','xcf',0,0,'fds','fds','fdsafdsafds',1450403080,1450403080,0,0);

/*Table structure for table `article_type` */

DROP TABLE IF EXISTS `article_type`;

CREATE TABLE `article_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `name` varchar(40) DEFAULT '' COMMENT '类型名',
  `sort` int(11) NOT NULL COMMENT '排序',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='文章类型';

/*Data for the table `article_type` */

insert  into `article_type`(`id`,`site_id`,`name`,`sort`,`create_time`,`update_time`) values (12,61,'ling',1,1446815050,1446815050),(13,61,'harrry',2,1446815063,1446815063),(14,0,'type_one',1,1450399794,1450399794),(15,0,'fdsaf',1,1450399863,1450399863),(16,0,'fdsaf',1,1450399869,1450399869),(17,0,'fdsaf',1,1450399869,1450399869),(18,0,'fdsaf',1,1450399869,1450399869),(19,0,'fdsaf',1,1450399869,1450399869),(20,0,'fdsaf',1,1450399870,1450399870),(21,0,'fdsaf',1,1450399870,1450399870),(22,0,'fdsaf',1,1450399870,1450399870),(23,0,'fdsaf',1,1450399870,1450399870),(24,0,'fdsaf',1,1450399870,1450399870),(25,0,'ccvxcv',1,1450399882,1450399882),(26,62,'type_zero',1,1450399954,1450400286),(27,62,'type_second',3,1450399969,1450400577),(28,62,'type_three',4,1450399982,1450400574),(29,62,'type_first',2,1450400001,1450400577);

/*Table structure for table `background` */

DROP TABLE IF EXISTS `background`;

CREATE TABLE `background` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '名字',
  `pic_id` int(11) NOT NULL DEFAULT '0' COMMENT '背景图片的id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `forbidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '禁用',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='背景';

/*Data for the table `background` */

insert  into `background`(`id`,`name`,`pic_id`,`status`,`forbidden`,`create_time`,`update_time`) values (1,'power-6.jpg',80,0,0,1450429295,1450429295),(2,'power-3.jpg',81,0,0,1450429538,1450429538);

/*Table structure for table `controller` */

DROP TABLE IF EXISTS `controller`;

CREATE TABLE `controller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(10) NOT NULL DEFAULT '' COMMENT '控件名',
  `intro` varchar(255) DEFAULT NULL COMMENT '空间描述',
  `cname` varchar(40) NOT NULL DEFAULT '' COMMENT 'widget名字',
  `icon` varchar(40) NOT NULL DEFAULT '' COMMENT '图标',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '摆放顺序',
  `forbidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '禁用 0 ： 正常 1：禁用',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0 ： 正常 1 ： 删除',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='控件';

/*Data for the table `controller` */

insert  into `controller`(`id`,`name`,`intro`,`cname`,`icon`,`sort`,`forbidden`,`status`,`create_time`,`update_time`) values (14,'魔方导航','表格','Magic','',4,0,0,1439514594,1439514660),(15,'文章列表','李彪','ArticleList','',8,0,0,1439514594,1439641585),(16,'图文展示','图片','image_text','',7,0,0,1439514594,1439514660),(17,'轮播图','文章','Viwepager','',1,0,0,1439514594,1439514660),(18,'文章分类','投标','ArticleSort','',3,0,0,1439514594,1439514660),(19,'横幅','','/banner','controller/2015-11-06/563c9a6a88dd0.jpg',2,0,0,1439514594,1446812266),(20,'图片展示',NULL,'PicturesShow','',5,0,0,1439514594,1439514594),(21,'滚动公告',NULL,'notice','',6,0,0,1439514594,1439514594);

/*Table structure for table `forbidden` */

DROP TABLE IF EXISTS `forbidden`;

CREATE TABLE `forbidden` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '被禁用户',
  `reason` varchar(30) NOT NULL DEFAULT '' COMMENT '禁用原因',
  `num` tinyint(1) DEFAULT '0' COMMENT '禁用次数',
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '禁用时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='禁用表';

/*Data for the table `forbidden` */

/*Table structure for table `guide` */

DROP TABLE IF EXISTS `guide`;

CREATE TABLE `guide` (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT '使用教程',
  `guide_title` char(32) NOT NULL COMMENT '教程标题',
  `content` text COMMENT '教程内容',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `guide` */

/*Table structure for table `home_picture` */

DROP TABLE IF EXISTS `home_picture`;

CREATE TABLE `home_picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `savename` varchar(40) NOT NULL DEFAULT '' COMMENT '文件名',
  `savepath` varchar(20) NOT NULL DEFAULT '' COMMENT '文件夹名',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5码',
  `size` int(11) NOT NULL DEFAULT '0' COMMENT '文件大小',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `used` int(11) NOT NULL DEFAULT '1' COMMENT '被用到的数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户图片表';

/*Data for the table `home_picture` */

insert  into `home_picture`(`id`,`savename`,`savepath`,`md5`,`size`,`status`,`create_time`,`update_time`,`used`) values (1,'56735e5a59974.gif','img/2015-12-18/','82e9351044be0643311a307caa6558f5',11825,0,1450401370,1450401370,2),(2,'56736170df91a.jpg','img/2015-12-18/','c6f135264b2cf3ce613d71437bb67001',7902,0,1450402160,1450402160,3),(3,'56737ab506d8e.jpg','img/2015-12-18/','84adbf0872dc22a53e3abcf2268bff25',26378,0,1450408628,1450408628,2),(4,'56737ab50898c.jpg','img/2015-12-18/','0c7b8c25b750db98d5ad8586ef437d5a',40267,0,1450408628,1450408628,0),(5,'56737ab50b2b1.jpg','img/2015-12-18/','0e9a5874757be570d5db024f0a27c228',46144,0,1450408628,1450408628,3);

/*Table structure for table `message` */

DROP TABLE IF EXISTS `message`;

CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '建站人',
  `way` tinyint(1) NOT NULL DEFAULT '0' COMMENT '方式  0 ： 用户给后台 1：回台回复',
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '发送时间',
  `content` varchar(140) DEFAULT '' COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='留言';

/*Data for the table `message` */

/*Table structure for table `node_info` */

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

/*Data for the table `node_info` */

insert  into `node_info`(`id`,`node_name`,`node_url`,`depth`,`sort`,`status`) values ('01','首页','Admin/Index',1,0,0),('02','用户管理','Admin/User',1,1,0),('0201','用户信息',NULL,2,0,0),('020101','用户列表','Admin/User/index',3,0,0),('03','微站管理','Admin/Station',1,2,0),('0301','微站信息',NULL,2,0,0),('030101','微站列表','Admin/Station/index',3,0,0),('04','前端管理','Admin/Reception',1,3,0),('0401','前端信息',NULL,2,0,0),('040101','背景管理','Admin/Reception/index',3,0,0),('040102','栏目管理','Admin/Reception/column',3,0,0),('040103','控件管理','Admin/Reception/widget',3,0,0),('040104','主题管理','Admin/Reception/theme',3,0,0),('05','网站管理','Admin/Website',1,4,0),('0501','网站信息',NULL,2,0,0),('050101','管理团队','Admin/Website/index',3,0,0),('050102','密保问题','Admin/Website/security',3,0,0),('050103','使用教程','Admin/Website/tutorial',3,0,0),('06','留言管理','Admin/Message',1,5,0),('0601','留言信息',NULL,2,0,0),('060101','信息列表','Admin/Message/index',3,0,0);

/*Table structure for table `photo` */

DROP TABLE IF EXISTS `photo`;

CREATE TABLE `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL COMMENT '网站id',
  `album_id` int(11) NOT NULL DEFAULT '0' COMMENT '相册id',
  `pic_id` int(11) NOT NULL DEFAULT '0' COMMENT '图片id',
  `create_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COMMENT='用户图片表';

/*Data for the table `photo` */

insert  into `photo`(`id`,`site_id`,`album_id`,`pic_id`,`create_time`) values (50,61,19,69,1446813585),(51,61,19,70,1446813585),(52,61,19,71,1446813585),(53,61,19,72,1446813585),(54,61,19,73,1446813585),(56,61,19,75,1446814901),(60,62,21,1,1450409597),(61,62,21,3,1450409597),(62,62,21,2,1450409597);

/*Table structure for table `picture` */

DROP TABLE IF EXISTS `picture`;

CREATE TABLE `picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `savename` varchar(40) NOT NULL DEFAULT '' COMMENT '文件名',
  `savepath` varchar(40) NOT NULL DEFAULT '' COMMENT '文件夹名',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5码',
  `size` int(11) NOT NULL DEFAULT '0' COMMENT '文件大小',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `used` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COMMENT='图片表';

/*Data for the table `picture` */

insert  into `picture`(`id`,`savename`,`savepath`,`md5`,`size`,`status`,`create_time`,`update_time`,`used`) values (76,'566a4d90262e7.png','column/2015-12-11/','92372d60879fe5c7df042597fecf6f8c',18405,0,0,0,1),(77,'566a4dba9552f.png','column/2015-12-11/','a70922c1916ac004bb57af3248dabd7b',18445,0,0,0,1),(78,'566a4dceb5985.png','column/2015-12-11/','8a7346d9dad5919ec1e95ecc018513ac',18731,0,0,0,2),(79,'566a4dded1153.png','column/2015-12-11/','2c2e4c7e67319baf8390986d1a15cc51',18699,0,0,0,1),(80,'5673cb6f9797b.jpg','background/2015-12-18/','eafa087ec187e7a0e308d75c64f6b2c8',5414,0,1450429295,1450429295,1),(81,'5673cc61d5a81.jpg','background/2015-12-18/','84adbf0872dc22a53e3abcf2268bff25',26378,0,1450429537,1450429537,1);

/*Table structure for table `problem` */

DROP TABLE IF EXISTS `problem`;

CREATE TABLE `problem` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `question` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1禁用,0正常',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='密保问题';

/*Data for the table `problem` */

insert  into `problem`(`id`,`question`,`status`,`create_time`,`update_time`) values (1,'小学班主任',0,1440550508,1440550508),(2,'老婆手机号',0,1440550523,1440550523),(3,'母亲生日',0,1440550537,1440550537);

/*Table structure for table `site_info` */

DROP TABLE IF EXISTS `site_info`;

CREATE TABLE `site_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '网站ID',
  `site_name` varchar(32) NOT NULL COMMENT '网站名',
  `url` varchar(32) NOT NULL COMMENT '网站的url',
  `user_id` int(11) NOT NULL COMMENT '所属用户ID',
  `size` int(11) NOT NULL DEFAULT '0' COMMENT '网站文件夹大小 (字节数)',
  `theme` int(11) NOT NULL DEFAULT '0' COMMENT '主题',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `click_num` int(11) NOT NULL DEFAULT '0' COMMENT '点击量',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除状态',
  `back` int(11) NOT NULL DEFAULT '0' COMMENT '背景',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COMMENT='用户网站';

/*Data for the table `site_info` */

insert  into `site_info`(`id`,`site_name`,`url`,`user_id`,`size`,`theme`,`create_time`,`update_time`,`click_num`,`status`,`back`) values (61,'First','first',5,0,0,1446813362,1446813362,0,1,0),(62,'222','2222',5,0,0,1449194337,1449194337,0,0,0),(63,'111','harrry',5,0,0,1450533095,1450533095,0,0,0);

/*Table structure for table `theme` */

DROP TABLE IF EXISTS `theme`;

CREATE TABLE `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pic_id` int(11) NOT NULL COMMENT '图片id',
  `name` varchar(40) NOT NULL DEFAULT '""' COMMENT '主题根目录',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='主题';

/*Data for the table `theme` */

insert  into `theme`(`id`,`pic_id`,`name`,`status`,`create_time`,`update_time`) values (8,62,'theme-1',0,1446812809,1446812809),(9,63,'theme-2',0,1446812860,1446812860),(10,64,'theme-3',0,1446812880,1446812880),(11,65,'theme-4',0,1446812898,1446812898),(12,66,'theme-5',0,1446812913,1446812913),(13,67,'theme-6',0,1446812930,1446812930),(14,68,'theme-default',0,1446812975,1446812975);

/*Table structure for table `topic` */

DROP TABLE IF EXISTS `topic`;

CREATE TABLE `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '栏目名',
  `url` varchar(40) NOT NULL COMMENT '地址',
  `icon` int(11) DEFAULT NULL COMMENT '图标id',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '摆放顺序',
  `forbidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '禁用',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='栏目';

/*Data for the table `topic` */

insert  into `topic`(`id`,`name`,`url`,`icon`,`sort`,`forbidden`,`status`,`create_time`,`update_time`) values (1,'主页','index',76,1,0,0,0,1449807248),(2,'新闻消息','news',77,2,0,0,0,1449807290),(3,'关于我们','about',78,3,0,0,0,1449807310),(4,'联系我们','link',79,4,0,0,0,1449807326),(5,'帮助中心','help',78,5,0,0,0,1449807337);

/*Table structure for table `user_column` */

DROP TABLE IF EXISTS `user_column`;

CREATE TABLE `user_column` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL COMMENT '网站ID',
  `html` text NOT NULL COMMENT 'html_json',
  `name` varchar(8) NOT NULL COMMENT '栏目名',
  `forbidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启',
  `sort` tinyint(3) NOT NULL COMMENT '排序',
  `url` varchar(60) NOT NULL COMMENT '网页URL',
  `icon` int(11) DEFAULT '0' COMMENT '用户图片的ID',
  `is_static` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是 后台提供的栏目 1 是',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是默认图标  1 是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=utf8;

/*Data for the table `user_column` */

insert  into `user_column`(`id`,`site_id`,`html`,`name`,`forbidden`,`sort`,`url`,`icon`,`is_static`,`is_default`) values (201,61,'202','主页',0,1,'index',55,1,1),(202,61,'203','新闻消息',0,2,'news',56,1,1),(203,61,'204','关于我们',0,3,'about',57,1,1),(204,61,'205','联系我们',0,4,'link',58,1,1),(205,61,'206','帮助中心',0,5,'help',59,1,1),(206,62,'{\"header\":\"\",\"footer\":\"\"}','主页',0,1,'index',76,1,1),(207,62,'{\"header\":\"\",\"content\":[],\"footer\":\"\"}','消息',0,2,'news',5,1,0),(208,62,'{\"header\":\"\",\"content\":[],\"footer\":\"\"}','关于我们',0,3,'about',78,1,1),(209,62,'{\"header\":\"\",\"content\":[],\"footer\":\"\"}','联系我们',0,5,'link',79,1,1),(210,62,'{\"header\":\"\",\"content\":[],\"footer\":\"\"}','帮助中心',0,6,'help',78,1,1),(211,62,'{\"header\":\"\",\"content\":[],\"footer\":\"\"}','哎哎哎',0,4,'dfdf',3,0,0),(212,62,'{\"header\":\"\",\"content\":[],\"footer\":\"\"}','hh',0,7,'hhh',5,0,0),(213,63,'{\"header\":\"\",\"content\":[],\"footer\":\"\"}','主页',0,1,'index',76,1,1),(214,63,'{\"header\":\"\",\"content\":[],\"footer\":\"\"}','新闻消息',0,2,'news',77,1,1),(215,63,'{\"header\":\"\",\"content\":[],\"footer\":\"\"}','关于我们',0,3,'about',78,1,1),(216,63,'{\"header\":\"\",\"content\":[],\"footer\":\"\"}','联系1',0,4,'link',2,1,0),(217,63,'{\"header\":\"\",\"content\":[],\"footer\":\"\"}','帮助中心',0,5,'help',78,1,1);

/*Table structure for table `user_info` */

DROP TABLE IF EXISTS `user_info`;

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `account` char(15) NOT NULL COMMENT '账户',
  `password` char(32) NOT NULL COMMENT '密码',
  `nickname` varchar(15) DEFAULT NULL COMMENT '昵称',
  `phone` char(11) DEFAULT NULL COMMENT '电话',
  `email` varchar(40) DEFAULT NULL COMMENT '邮箱',
  `head_img` char(40) DEFAULT NULL COMMENT '头像地址',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除状态',
  `forbidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1禁用,0未禁用',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='用户信息';

/*Data for the table `user_info` */

insert  into `user_info`(`id`,`account`,`password`,`nickname`,`phone`,`email`,`head_img`,`status`,`forbidden`,`create_time`,`update_time`) values (5,'lingduanhua','e10adc3949ba59abbe56e057f20f883e','harrry','15617198028','1009291860@qq.com',NULL,0,0,1446813218,1446813218);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
