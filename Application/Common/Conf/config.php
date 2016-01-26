<?php
return array(
	数据库配置
	'DB_TYPE'               =>  'mysql',     // 数据库类型
	'DB_HOST'               =>  'localhost', // 服务器地址
	'DB_NAME'               =>  'microweb',          // 数据库名
	'DB_USER'               =>  'root',      // 用户名
	'DB_PWD'                =>  'zwp15225062633',          // 密码
	'DB_PORT'               =>  '3306',        // 端口
	'DB_PREFIX'             =>  '',    // 数据库表前缀

 /* 默认设定 */
    'DEFAULT_MODULE'        =>  'Home',  // 默认模块
    'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'index', // 默认操作名称


	'SHOW_PAGE_TRACE' => false,  //页面调试
	'MAX_SITE_NUM' => 3, // 用户最大建站数
    'MAX_SITE_SIZE' => 128,     // 用户总容量(单位:MB)
	'FORBIDDEN_TIMES' => array(3,7,30,100), //禁用时间(单位:天)

	'UPLOAD_PICTURE'	=>	array(
		'maxSize'	=>	3145728,
		'savePath'	=>	'img/',
		'saveName'	=>	array('uniqid',''),
		'exts'		=>	array('jpg','gif','png','jpeg'),
		'autoSub'	=>	true,
		'subName'	=>	array('date','Ymd'),
	),

	//编写编辑面板路径
	// 'CONTROLLER_ROOT_PATH' => __ROOT__.'/Public/Controller',
	'CONTROLLER_ROOT_PATH' => __ROOT__.'/index.php/Home/Panel',
);
