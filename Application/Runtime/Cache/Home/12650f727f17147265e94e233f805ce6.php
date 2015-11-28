<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no" />
	<title>index</title>
	<link rel="stylesheet" type="text/css" href="/microweb/UserFiles/Public/Static/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/microweb/UserFiles/Public/Theme/Public/index.css">
	<link rel="stylesheet" type="text/css" id="theme-css" href="/microweb/UserFiles/Public/Theme/theme-default/theme.css">

<!-- 	<style type="text/css">
	.article_detail .article_content{
		padding: 5px;
	}

</style> -->


	<script type="text/javascript" src='/microweb/UserFiles/Public/Static/jquery-2.0.3.min.js'></script>
    <script type="text/javascript" src='/microweb/UserFiles/Public/Static/bootstrap/js/bootstrap.js'></script>
	<script type="text/javascript" src='/microweb/UserFiles/Public/Theme/Public/index.js'></script>
	<script type="text/javascript" src='/microweb/Public/Home/js/panel/drag.js'></script>
	<style type="text/css">
		.article_detail{
			padding: 0 2%;

		}
		.article_content{
			padding: 0 2%;
			font-size: 0.8rem;
		}
		.article_content p{
			text-indent: 2rem;
		}
	</style>
</head>
<body>
	<div class="side main">
		<div class="user-bar">
			<div class="head-icon"></div>
			<div class="user-name"></div>
		</div>
		<div class="nav-move nav-move-left"></div>
		<div class="nav-bar">
			<?php if(is_array($nav_list)): $i = 0; $__LIST__ = $nav_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><!-- //高亮 -->
				<?php if($vo['id'] == $now_column): ?><div class="nav-item active" data-column="<?php echo ($vo["id"]); ?>">
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
	<div class="background main"></div>
	<div class="center main" id="browser_frame" ondragenter='dragenter(event)' ondrop='drop(event)'>
		<?php echo ($content); ?>
		<span id="back" class="glyphicon glyphicon-chevron-left" onclick="fun()"></span>
		<div class="background_img">
			<img src="/microweb/Uploads/img/<?php echo ($article_item['savepath']); echo ($article_item['savename']); ?>" alt="<?php echo ($article['savename']); ?>">
		</div>
		<h4 style="text-align: center"><?php echo ($article_item['title']); ?></h4>
		<div class="article_detail" style="text-indent: 2rem">
			作者：<span><?php echo ($article_item['author']); ?></span>
			创建时间：<span><?php echo (date("y-m-d",$article_item['create_time'])); ?></span>

		</div>
		<div class="article_content">
			<?php echo (htmlspecialchars_decode($article_item['content'])); ?>
		</div>
	</div>
	<div class="footer main">
		<div class="footer-border"></div>
		<div class="foot-text">
			<p>©2015 <?php echo ($site_name); ?> 版权所有</p>
			<p>技术支持：marchsoft</p>
		</div>
	</div>
</body>
<script type="text/javascript">
	// $("#back").click(function () {
	// 	alert($(".nav-item.active").find('a').html());
	// 	$(".nav-item.active").find('a').click();
	// })
	function fun(){
		alert($(".nav-item.active").find('a').html());
		$(".nav-item.active").find('a').click();
	}
</script>
</html>