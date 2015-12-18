<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>首页|微网站生成系统</title>
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/index.css" />
	<script type="text/javascript" src='/microweb/Public/Static/jquery-2.0.3.min.js'></script>
	<script type="text/javascript" src="/microweb/Public/Home/js/index.js"></script>
</head>

<body>
	<div id="scoller_top">
	<img id="top_img" src="/microweb/Public/Home/images/back/logo.png">
		<ul>
			<a href="#first_screen"><li>首页</li></a>
			<a href="#second_screen"><li>功能</li></a>
			<a href="#third_screen"><li>特色</li></a>
			<a href="#forth_screen"><li>关于我们</li></a>
		</ul>
		<a href="<?php echo U('Login/register');?>"><div id="sign_up">注册</div></a>
		<a href="<?php echo U('Login/login');?>"><div id="sign_in">登陆</div></a>
	</div>
	<div id="scoller">
		<div id="first_screen" class="screen">
			<a href="<?php echo U('Login/login');?>" id="first_a">立即体验</a>
		</div>

		<div id="line_one" class="tabulate tilt"></div>
		<div id="line_tow" class="tabulate tilt"></div>
		<div id="second_screen" class="screen">
			<div id="intro" class="intro_show tilt"><p class="recover">特点介绍</p></div>
			<div class="trait tilt" id="first_trait">
				<div class="trait_show recover">
					<h4>便捷灵活</h4>
					&emsp;&ensp;使用者能灵活的改动布局,按照自己的想法制作出自己的个性网站。
				</div>
			</div>
			<div class="trait tilt" id="second_trait">
				<div class="trait_show recover">
					<h4>超低门槛</h4>
					&emsp;&ensp;不管你有没有专业知识，又没有开发经验，都能实现创建网站的梦想。
				</div>
			</div>
			<div class="trait tilt" id="third_trait">
				<div class="trait_show recover">
					<h4>功能全面</h4>
					&emsp;&ensp;我们提供的丰富的功能模块,比如:会员登录，栏目导航,天气信息.....
				</div>
			</div>
			<div class="trait tilt">
				<div class="trait_show recover">
					<h4>操作简单</h4>
					&emsp;&ensp;可视化编辑，只用几次点击，几次页面元素的拖拽即可实现网站的建立
				</div>
			</div>
			<div id="more_info">更多功能尽在。。。</div>
		</div>
		
		<div id="third_screen" class="screen">
			<div id="effect" class="intro_show tilt effect_show"><p class="recover">功能</p></div>
			<div id="first_line">
				<div class="function_show">标题</div>
				<div class="function_show">图册</div>
				<div class="function_show">手机网站</div>
			</div>
			<div id="second_line">
				<div class="function_show">产品系统</div>
				<div class="function_show">统计系统</div>
				<div class="function_show">可视化编程</div>
			</div>
		</div>
		
		<div id="forth_screen" class="screen">
			<div id="forth_screen_title">联系我们</div>
			<div id="forth_screen_info_left" class="tilt">
				<div class="forth_left_show recover">
					<img src="/microweb/Public/Home/images/back/clipboard.png">
				</div>
			</div>
			<div id="forth_screen_info_right" class="tilt">
				<div class="forth_right_show recover">
					<img src="/microweb/Public/Home/images/back/link.png">
					<p>qq:1009291860;&emsp;&emsp;&emsp;<br/>
						  1125269680&emsp;&emsp;
					<p>微信：1009291860&emsp;&emsp;
					<p>手机：15903037270&emsp;&ensp;
					<p>邮箱：12056367qq.com
				</div>
			</div>
		</div>
	</div>

	<div id="footer">
		技术支持：三月软件工作室 www.marchsoft.cn
	</div>
</body>
</html>