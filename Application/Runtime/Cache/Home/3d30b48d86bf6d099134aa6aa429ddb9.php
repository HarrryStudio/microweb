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
	<script type="text/javascript" >
		var APP = "/microweb";
	</script>
	
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/website/index.css">

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
				<?php if(is_login()): ?><a onclick="return confirm('确定要退出?')" class="login-status logout-butotn" href="<?php echo U('Login/logout');?>">退出</a>
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
		<div class="side-head">我的网站</div>
		<div class="side-item"><a href="/microweb/index.php/Home/Website/index.html">网站列表</a></div>
	</div>

		<!-- /边栏 -->
		<!-- 内容区 -->
		<div class="content">
			
	<input id="delete_site_url" type="hidden" value="/microweb/index.php/Home/Website/delete_site">
	<input id="compile_site_url" type="hidden" value="<?php echo U('Panel/index');?>">
	<input id="download_site_url" type="hidden" value="/microweb/index.php/Home/Website/download_site">
	
	<input id="resource_management_site_url" type="hidden" value="/microweb/index.php/Home/Website/album_list">
	<div class="centent-head">
		网站列表
	</div>
	<?php if(is_array($site_list)): foreach($site_list as $key=>$vo): ?><div class="list" id="list_<?php echo ($vo["id"]); ?>" data="<?php echo ($vo["id"]); ?>">
			<div class="site-show">
				<!-- <div class="site-face" url="
				<?php  ?>
				">
					&#936;
					<img src="" alt="<?php echo ($vo['site_name']); ?>">
				</div> -->

				<div class="site-info">
					<span class="site-name"><?php echo ($vo['site_name']); ?></span>
					<span class="site-url" ><?php echo ($vo['url']); ?></span>
					<div class="site-status">
						<?php if($vo['status'] == 0): ?><span class="normal">[正常]</span>
						<?php else: ?><span class="fordidden">[禁用]</span><?php endif; ?>
					</div>
				</div>
			</div>
			<div class="site-other">
				<!-- <div class="site-status-item">
					<label>大 小：</label>
					<span><?php echo formatSize($vo['size']);?></span>
				</div> -->
				<div class="site-status-item">
					<label>点 击 量：</label>
					<span><?php echo ($vo['click_num']); ?></span>
				</div>
				<div class="site-status-item">
					<label>创建时间：</label>
					<span><?php echo (date("Y-m-d",$vo['create_time'])); ?></span>
				</div>
				<div class="site-status-item">
					<label>更新时间：</label>
					<span><?php echo (date("Y-m-d",$vo['update_time'])); ?></span>
				</div>
			</div>
			<div class="site-do">
				<input type="hidden" value="<?php echo ($vo["id"]); ?>">
				<button title="编辑" class="download_site" type="button" class="btn btn-default btn-lg">
					<span class="glyphicon glyphicon-download-alt"  aria-hidden="true"></span> 下载
				</button>
				<button title="资源管理" class="resource_management_site" type="button" class="btn btn-default btn-lg">
					<span class="glyphicon glyphicon-cog"  aria-hidden="true"></span>
					 管理
				</button>
				<button title="删除" class="delete_site" type="button" class="btn btn-default btn-lg">
					<span class="glyphicon glyphicon-remove"  aria-hidden="true"></span> 删除
				</button>
			</div>
		</div><?php endforeach; endif; ?>
	<?php if(count($site_list) < C('MAX_SITE_NUM')): ?><div target-url="/microweb/index.php/Home/Website/check_site_num" class="add_site_button" type="button">
		<div class="add-button">&#10010;</div>
	</div><?php endif; ?>
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
					新建网站
	            </h4>
	         </div>
	         <div class="modal-body">
				<form class="add-site-form" action="">
					<div>
						<label for="site_name">请输入网站名字：</label>
						<input id="site_name" type="text" name="site_name" class="form-control" value="">
					</div>
					<div>
						<label for="site_url">请输入二级域名：</label>
						<input id="site_url" placeholder="example" type="text" name="url" class="form-control" value="">
					</div>
				</form>
	         </div>
	         <div class="modal-footer">
	            <button type="button" class="btn btn-default" 
	               data-dismiss="modal">关闭
	            </button>
	            <button id="create_new_site" type="button" target_url="/microweb/index.php/Home/Website/add_site" class="btn btn-primary">
	               提交更改
	            </button>
	         </div>
	      </div>
		</div>
	</div>

	<!-- 模态框（Modal） -->
	<div class="modal fade" id="confirm_modal" tabindex="-1" role="dialog" 
	   aria-labelledby="myModalLabel" aria-hidden="true">
	   <div class="modal-dialog">
	      <div class="modal-content">
	         <div class="modal-header">
	            <button type="button" class="close" 
	               data-dismiss="modal" aria-hidden="true">
	                  &times;
	            </button>
	            <h4 class="modal-title" id="myModalLabel">
					退出
	            </h4>
	         </div>
	         <div class="modal-body">
				<form action="">
					<div>
						<p>删除后将清除所有相关资源,确认要删除吗？</p>
					</div>
				</form>
	         </div>
	         <div class="modal-footer">
	            <button type="button" class="btn btn-default" 
	               data-dismiss="modal">取消
	            </button>
	            <button type="button" class="btn btn-primary confirm">
	               确认
	            </button>
	         </div>
	      </div>
		</div>
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
	
	<!-- <div id="top-alert" class="alert alert-warning alert-dismissible" role="alert">
	      <button type="button" class="close"><span aria-hidden="true">×</span></button>
	      <div class="alert-content">Best check yo self, you're not looking too good.</div>
    </div> -->

<div id="top-alert-back">
	<div id="top-alert" class="alert alert-warning alert-dismissible" role="alert">
	      <button type="button" class="close"><span aria-hidden="true">×</span></button>
	      <div class="alert-content"></div>
	</div>
</div>
	
	<script type="text/javascript" src="/microweb/Public/Home/js/website/index.js"></script>

</body>
</html>