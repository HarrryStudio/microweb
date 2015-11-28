<?php
return array(
	//'配置项'=>'配置值'
	'TMPL_PARSE_STRING'  =>  array(
							 	'__JS__'     => __ROOT__.'/Public/Home/js',
							 	'__CSS__'    => __ROOT__.'/Public/Home/css',
							 	'__IMAGES__' => __ROOT__.'/Public/Home/images',
							 	'__STATIC__' => __ROOT__.'/Public/Static',
							 	'__THEME__'  => __ROOT__.'/UserFiles/Public/Theme',
							 	'__USER__'	 => __ROOT__.'/UserFile',
							 	'__P_CSS__'  => __ROOT__.'/Public/Controller',
							 	'__P_JS__'   => __ROOT__.'/Public/Controller',
							 	'__P_IMAGES__'   => __ROOT__.'/Public/Controller',
							 	'__USERFILES__' =>__ROOT__.'/UserFiles',
							 	'__UPLOADS__' =>__ROOT__.'/Uploads',
						     ),
	/* 图片上传相关配置 */
    'PICTURE_UPLOAD' => array(
		'mimes'    => '', //允许上传的文件MiMe类型
		'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
		'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
		'autoSub'  => true, //自动子目录保存文件
		'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
		'rootPath' => './Uploads/', //保存根路径
		'savePath' => 'img/', //保存路径
		'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
		'saveExt'  => '', //文件保存后缀，空则使用原后缀
		'replace'  => false, //存在同名是否覆盖
		'hash'     => true, //是否生成hash编码
		'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
    ), //图片上传相关配置（文件上传类配置）

    'PICTURE_UPLOAD_DRIVER'=>'local',
    //本地上传文件驱动配置
    'UPLOAD_LOCAL_CONFIG'=>array(),

    'ARTICLE_PAGE_CONUT' => 2,

    'UPLOAD_ROOT' => __ROOT__.'/Uploads/',

	"FILE_UPLOAD_OPTION"     =>  array(
								'rootpath' => __ROOT__.'/Uploads/files',
							),
	"MAX_SITE_NUM" => 3,

	'TEMP_DIR'   => './Temp/',
	'USER_FILE_DIR' =>'./UserFiles', //用户文件存放位置

	define ('IMAGES', __ROOT__.'/Public/Home/images')

);