<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo ($meta_title); ?> | 微网站生成系统</title>
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Static/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/base.css">
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/side.css">
	<script type="text/javascript" src='/microweb/Public/Static/jquery-2.0.3.min.js'></script>
	<script type="text/javascript" src="/microweb/Public/Static/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/microweb/Public/Home/js/base.js"></script>
	<script type="text/javascript" src="/microweb/Public/Static/uploadifive/jquery.uploadifive.min.js"></script>
	<script type="text/javascript" src="/microweb/Public/Static/uploadify/jquery.uploadify.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Static/uploadify/uploadify.css">
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Static/layer/layer.css">
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Static/layer/green_theme.css">
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/side.css">
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/website/photo.css">
	<script type="text/javascript" src='/microweb/Public/Static/layer/layer.js'></script>

</head>
<body>
	<!-- 头部 -->
	<div class="header">
		<div class="auto-center">
			<!-- logo -->
			<div class="logo">Logo</div>
			<!-- 主导航 -->
			<ul class="main-nav">
				<li class="nav-item"><a href="<?php echo U('Website/index');?>" >我的网站</a></li>
				<li class="nav-item"><a href="<?php echo U('Account/personalDetails');?>" >账户信息</a></li>
				<li class="nav-item"><a href="<?php echo U('Message/index');?>" >留言</a></li>
				<li class="nav-item"><a href="<?php echo U('Help/index');?>" >帮助教程</a></li>
			</ul>
			<!-- /主导航 -->
			<!-- 登录状态信息 -->
			<div class="login-bar">
				<div class="head-icon">
					<a href="<?php echo U('Account/personalDetails');?>">
						<?php if(empty($head_img)): ?><img src="/microweb/Public/Home/images/head_img/user.png" alt="head-img" class="head-img">
						<?php else: ?>
							<img src="/microweb/Uploads/<?php echo ($head_img); ?>" alt="head-img"><?php endif; ?>
					</a>
				</div>
				
				<?php if(is_login()): ?><a class="login-status logout-butotn" href="<?php echo U('Login/logout');?>">退出</a>
				<?php else: ?>
					<a class="login-status login-button"  href="<?php echo U('Login/login');?>">登录</a><?php endif; ?>

			</div>
			<!-- /登录状态信息 -->
		</div>
	</div>
	<div class="senior-nav">
		
	</div>
	<!-- /头部 -->
	<!-- 中间 -->
	<div class="center">
		<!-- 边栏 -->
		<div class="side">
			<div class="side-head">网站资源</div>
			<div class="side-item"><a href="/microweb/index.php/Home/Website/album_list/site_id/<?php echo ($site_id); ?>">相册</a></div>
			<div class="side-item"><a href="/microweb/index.php/Home/Website/article_list/site_id/<?php echo ($site_id); ?>">文章</a></div>
		</div>
		<!-- /边栏 -->
		<!-- 内容区 -->
		<div class="content">
			<?php $site_id = (int)session('site_id'); if( $site_id > 0 ){ echo '<div class="to-panel"><a href="/microweb/index.php/Home/Panel/index/site_id/'.$site_id.'">前往编辑页</a></div>'; } ?>
			
	<!-- <div class="centent-head">相册详情</div> -->
	<div class="album-info">
		<span class="alubm-name"><?php echo ($album_info['name']); ?></span>
		<button id="update-photo-button">上传图片</button>
	</div>
	<!-- <input id="uploadify_url" type="hidden" value="/microweb/Public/Static/uploadify/"> -->
	<!-- <input id="upload_url" type="hidden" value="<?php echo U('Picture/uploadPicture');?>"> -->
	
	<!-- <input id="file_upload" name="file_upload" type="file" multiple="true"> -->
	<!-- <?php echo (dump($photo_list)); ?> -->
	<input id="del-photo-url" type="hidden" value="/microweb/index.php/Home/Website/del_photo">
	<div class="photo-bar">
		<?php if(is_array($photo_list)): foreach($photo_list as $key=>$vo): ?><div class="photo-item" data-id="<?php echo ($vo["id"]); ?>">
				<img src="<?php echo C('UPLOAD_ROOT'); echo ($vo['savepath']); echo ($vo['savename']); ?>" alt="<?php echo ($vo['savename']); ?>">
				<div class="photo-opreration">
					<div class="photo-del glyphicon glyphicon-trash"></div>
				</div>
			</div><?php endforeach; endif; ?>
	</div>

		</div>
		<!-- 内容区 -->
	</div>
	<!-- /中间 -->
	<!-- 页脚 -->
	<div class="footer">
		
	</div>
	<input id="primary-index" type="hidden" value="<?php echo ($primary_index); ?>">
	<input id="senior-index" type="hidden" value="<?php echo ($senior_index); ?>">
	<input id="nav-index" type="hidden" value="<?php echo ($nav_index); ?>">
	<!-- /页脚 -->
	
<div class="upload-photo-body">
	<div class="upload-photo-dialog">
		<div class="upload-photo-dialog-title">
			<span>上传图片</span>
			<span class="upload-photo-dialog-close">&#10006;</span>
		</div>
		<div class="upload-photo-dialog-content">
			<div class="upload-photo-option-bar">
			</div>
			<div class="upload-photo-div">
				<div class="chose-photo">
					<button class="chose-photo-button">选择图片</button>
					<form id="upload-file-form" action="/microweb/index.php/Home/Website/upload_photo" method="post" enctype="multipart/form-data" >
					<input type="text" name="album_id" value="<?php echo I('get.album_id');?>">
					</form>
				</div>
				<div class="update-photo">
					<div class="update-photo-list">
						<div class="add-update-photo">
							添加图片
						</div>
					</div>
					<div class="update-photo-operation">
						<button class="start-update">开始上传</button>
						<div class="upload-progress-bar">
							<progress value="0" max="0" style="display: inline-block;"></progress><span></span>%
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="top-alert-back">
	<div id="top-alert" class="alert alert-warning alert-dismissible" role="alert">
	      <button type="button" class="close"><span aria-hidden="true">×</span></button>
	      <div class="alert-content"></div>
	</div>
<div id="top-alert-back">

	<script type="text/javascript" src="/microweb/Public/Static/uploadify/jquery.uploadify.min.js"></script>
	<script type="text/javascript" src="/microweb/Public/Home/js/website/photo_list.js"></script>

</body>
</html>