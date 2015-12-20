<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/panel/magic.css">
	<script type="text/javascript" src='/microweb/Public/Static/jquery-2.0.3.min.js'></script>
	<script type="text/javascript">
		var APP = '/microweb';
	</script>
	<script type="text/javascript" src="/microweb/Public/Home/js/panel/magic.js"></script>
</head>

<body>
	<div id="box">
		<div class="pattern" va="first">
			<div class="hr"><img src="/microweb/Public/Controller/nav/Images/nav-1.png" /></div>
		</div>
		<div class="pattern" va="second">
			<div class=""><img src="/microweb/Public/Controller/nav/Images/nav-2.png" /></div>
		</div>
		<div class="pattern" va="third">
			<div class=""><img src="/microweb/Public/Controller/nav/Images/nav-3.jpg" /></div>
		</div>
		<div class="pattern" va="forth">
			<div class=""><img src="/microweb/Public/Controller/nav/Images/nav-4.jpg" /></div>
		</div>
		<div class="pattern" va="fifth">
			<div class=""><img src="/microweb/Public/Controller/nav/Images/nav-5.jpg" /></div>
		</div>
		<div class="pattern" va="sixth">
			<div class=""><img src="/microweb/Public/Controller/nav/Images/nav-6.jpg" /></div>
		</div>
		<!-- <?php if(is_array($theme_list)): $i = 0; $__LIST__ = $theme_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="pattern" va="$vo.name">
				<div class=""><img src="$vo.pic_path" /></div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?> -->
	</div>
	<input type="hidden" id="url" value="<?php echo U('column_title');?>">
	<input type="hidden" id="web_info" value="<?php echo session('site_id');?>">
	<input type="hidden" id="controller-id" value="<?php echo ($controllerId); ?>" />
	<input type="hidden" id="status" value="<?php echo ($status); ?>">
</body>
</html>