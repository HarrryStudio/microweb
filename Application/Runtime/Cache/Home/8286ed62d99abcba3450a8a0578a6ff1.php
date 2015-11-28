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
	
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/website/set_classify.css">

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
			
	<div class="centent-head">分类管理</div>
	<input id="site_id" type="hidden" value="<?php echo ($site_id); ?>">
	<input id="change-sort-url" type="hidden" value="/microweb/index.php/Home/Website/type_change_sort">
	<input id="del-type-url" type="hidden" value="/microweb/index.php/Home/Website/del_type">
	<input id="add-type-url" type="hidden" value="/microweb/index.php/Home/Website/add_type">

	<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">添加分类</button>
	<table>
		<thead>
		<tbody>
			<?php if(is_array($type_list)): $i = 0; $__LIST__ = $type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr data-id="<?php echo ($vo["id"]); ?>">
					<td class="type-name"><?php echo ($vo["name"]); ?></td>
					<td class="type-sort">
						<div class="type-sort-up glyphicon glyphicon-arrow-up"></div>
						<div class="type-sort-down glyphicon glyphicon-arrow-down"></div>
					</td>
					<td class="type-operation">
						<div class="type-edit">编辑</div>
						<div class="type-del">删除</div>
					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>

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
					<label for="type_name">请输入分类名称：</label>
					<input id="type_name" type="text" value="">
				</div>
	         </div>
	         <div class="modal-footer">
	            <button type="button" class="btn btn-default" 
	               data-dismiss="modal">关闭
	            </button>
	            <button id="create-new-type" type="button" target-url="/microweb/index.php/Home/Website/add_type" class="btn btn-primary">
	               添加
	            </button>
	         </div>
	      </div>
		</div>
	</div>
	<!-- ================ -->
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


<div id="top-alert-back">
	<div id="top-alert" class="alert alert-warning alert-dismissible" role="alert">
	      <button type="button" class="close"><span aria-hidden="true">×</span></button>
	      <div class="alert-content"></div>
	</div>
<div id="top-alert-back">

	<script type="text/javascript" src="/microweb/Public/Home/js/website/set_classify.js"></script>

</body>
</html>