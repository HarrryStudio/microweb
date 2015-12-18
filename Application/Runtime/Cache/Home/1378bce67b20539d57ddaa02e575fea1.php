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
	
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/website/resource.css">

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
			
	<div class="centent-head">图册</div>
	<input id="site_id" type="hidden" value="<?php echo ($site_id); ?>">
	<input id="create_album_url" type="hidden" value="/microweb/index.php/Home/Website/create_album">
	<input id="edit_album_url" type="hidden" value="/microweb/index.php/Home/Website/edit_album">
	<input id="del_album_url" type="hidden" value="/microweb/index.php/Home/Website/del_album">
	<?php if(is_array($album_list)): foreach($album_list as $key=>$vo): ?><div class="album-item" data-id="<?php echo ($vo["id"]); ?>">
			<div class="del_album-bar"><span>&#10006;</span></div>
			<div>
				<div class="album-name">
					<label class="album-name-label"  data-toggle="tooltip" data-placement="top" title="Tooltip on top"><?php echo ($vo['name']); ?></label>
					<input class="album-name-input form-control" value="<?php echo ($vo['name']); ?>">
					<a class="album-name-button" href="/microweb/index.php/Home/Website/photo_list/album_id/<?php echo ($vo["id"]); ?>">打开</a>
				</div>
				<!-- <img src="" alt="<?php echo ($vo["name"]); ?>"> -->
				<div class="album-info">
					<div class="album-info-item create-time">
						<span><?php echo (date('Y-m-d',$vo['create_time'])); ?></span>
					</div>
					<div class="album-info-item update-time">
						<span><?php echo (date('Y-m-d',$vo["update_time"])); ?></span>
					</div>
				</div>
			</div>	
		</div><?php endforeach; endif; ?>
	<!-- 添加相册模态框 -->
	<!-- ====================== -->
	<div class="add-album" class="btn btn-default btn-lg" data-toggle="modal" data-target="#myModal">
		<div class="add-album-button">&#10010;</div>
	</div>
	<!-- 模态框（Modal） -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" 
	   aria-labelledby="myModalLabel" aria-hidden="true">
	   <div class="modal-dialog">
	      <div class="modal-content">
	         <div class="modal-header">
	            <button type="button" class="close" 
	               data-dismiss="modal" aria-hidden="true">
	                  &times;
	            </button>
	            <h4 class="modal-title" id="myModalLabel">
					添加相册
	            </h4>
	         </div>
	         <div class="modal-body">
				<div>
					<label for="site_name">请输入相册名字：</label>
					<input id="site_name" type="text" value="">
				</div>
	         </div>
	         <div class="modal-footer">
	            <button type="button" class="btn btn-default" 
	               data-dismiss="modal">关闭
	            </button>
	            <button id="create_new_album" type="button" target_url="/microweb/index.php/Home/Website/add_site" class="btn btn-primary">
	               创建
	            </button>
	         </div>
	      </div>
		</div>
	</div>
	<!-- ================ -->


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
	
	<div class="tooltip top" role="tooltip">
        <div class="tooltip-arrow"></div>
        <div class="tooltip-inner">
            双击修改
        </div>
    </div>

<div id="top-alert-back">
	<div id="top-alert" class="alert alert-warning alert-dismissible" role="alert">
	      <button type="button" class="close"><span aria-hidden="true">×</span></button>
	      <div class="alert-content"></div>
	</div>
<div id="top-alert-back">

	<script type="text/javascript" src="/microweb/Public/Home/js/website/resource.js"></script>

</body>
</html>