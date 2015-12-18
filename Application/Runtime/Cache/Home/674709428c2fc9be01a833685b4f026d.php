<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no" />
	<title>index</title>
	<link rel="stylesheet" type="text/css" href="/microweb/UserFiles/Public/Static/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/microweb/UserFiles/Public/Theme/Public/index.css">
	<?php if(empty($theme )): ?><link rel="stylesheet" type="text/css" id="theme-css" href="/microweb/UserFiles/Public/Theme/theme-default/theme.css">
		<script type="text/javascript" id="theme-js" src="/microweb/UserFiles/Public/Theme/theme-default/theme.js"></script>
	<?php else: ?>
		<link rel="stylesheet" type="text/css" id="theme-css" href="/microweb/UserFiles/Public/Theme/<?php echo ($theme); ?>/theme.css">
		<script type="text/javascript" id="theme-js" src="/microweb/UserFiles/Public/Theme/<?php echo ($theme); ?>/theme.js"></script><?php endif; ?>
	<!-- <link rel="stylesheet" type="text/css" href="/microweb/UserFiles/Public/Controller/PicturesShow/PicPhoneShow.css">
	<link rel="stylesheet" type="text/css" href="/microweb/UserFiles/Public/Controller/article_list/article_list_show_all.css">
	<link rel="stylesheet" type="text/css" href="/microweb/UserFiles/Public/Controller/image_text/image_text_show_all.css">
	<link rel="stylesheet" type="text/css" href="/microweb/UserFiles/Public/Controller/article_sort/article_sort_show.css">
	<link rel="stylesheet" type="text/css" href="/microweb/UserFiles/Public/Controller/nav/nav_all.css"> -->

	<script type="text/javascript" src='/microweb/UserFiles/Public/Static/jquery-2.0.3.min.js'></script>
    <script type="text/javascript" src='/microweb/UserFiles/Public/Static/bootstrap/js/bootstrap.js'></script>
	<script type="text/javascript" src='/microweb/UserFiles/Public/Theme/Public/index.js'></script>
	<script type="text/javascript" src='/microweb/Public/Home/js/panel/drag.js'></script>
	<!-- <script type="text/javascript" src='/microweb/UserFiles/Public/Controller/Viwepager/viwepagerPhone.js'></script>
	<script type="text/javascript" src='/microweb/UserFiles/Public/Controller/PicturesShow/PicPhoneShow.js'></script>
    <script type="text/javascript" src='/microweb/UserFiles/Public/Controller/article_list/article_list.js'></script> -->
</head>
<body>
	<div class="side main">
		<div class="user-bar">
			<div class="head-icon" style="background-image:url(<?php echo C('UPLOAD_ROOT'); echo ($user_info["head_img"]); ?>)"></div>
			<div class="user-name"><?php echo ($user_info["nickname"]); ?></div>
		</div>
		<div class="nav-move nav-move-left"></div>
		<div class="nav-bar">
			<?php if(is_array($nav_list)): $i = 0; $__LIST__ = $nav_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['id'] == $now_column): ?><div class="nav-item active" data-column="<?php echo ($vo["id"]); ?>">
				<?php else: ?>
					<?php if($vo['forbidden'] == 1): ?><div class="nav-item forbidden" data-column="<?php echo ($vo["id"]); ?>">
					<?php else: ?>
						<div class="nav-item" data-column="<?php echo ($vo["id"]); ?>"><?php endif; endif; ?><a href="<?php echo ($vo["url"]); ?>.html">
					<span class='nav-icon' style="background-image:url(<?php echo ($vo["icon_url"]); ?>)"></span>
					<span class="nav-name"><?php echo ($vo["name"]); ?></span></a>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<div class="nav-move nav-move-right"></div>
	</div>
	<div class="header main">
		<div class="menu-button"></div>
		<h1><?php echo ($site_name); ?></h1>
	</div>
	<div class="top-bar main zi"></div>
	<div class="clearfix main"></div>
	<div class="background main" <?php if(!empty($back_url)): ?>style="background-image:url(<?php echo C('UPLOAD_ROOT'); echo ($back_url); ?>)"<?php endif; ?>></div>
	<div class="center main" id="browser_frame" ondragenter='dragenter(event)' ondrop='drop(event)'>
		<?php echo ($content); ?>
		<div class='pro' ondragover='allow(event)'></div>
	</div>
	<div class="footer main">
		<div class="footer-border"></div>
		<div class="foot-text">
			<p>©2015 <?php echo ($site_name); ?> 版权所有</p>
			<p>技术支持：marchsoft</p>
		</div>
	</div>
</body>
</html>