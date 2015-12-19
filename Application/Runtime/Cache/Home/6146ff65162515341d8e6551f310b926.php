<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/panel/image_text.css">
	<script type="text/javascript" src='/microweb/Public/Static/jquery-2.0.3.min.js'></script>
	<script type="text/javascript" src='/microweb/Public/Home/js/panel/image_text.js'></script>
</head>

<body>
	<div id="image_text">
		<?php echo (dump($data)); ?>
		<ul class="setting">
			<li>
				<div>
					<label>模块标题:&nbsp;</label><input type="text" name="" value="图文展示">
				</div>
			</li>
			<li>
				<div>
					<p>选择样式:</p>
					<div id="style_list">
						<div class="pattern" data-style="first">
							<div class="hr"><img src="/microweb/Public/Home/images/article/image_text1.jpg"></div>
						</div>
						<div class="pattern" data-style="second">
							<div class=""><img src="/microweb/Public/Home/images/article/image_text2.jpg"></div>
						</div>
						<div class="pattern" data-style="third">
							<div class=""><img src="/microweb/Public/Home/images/article/image_text3.jpg"></div>
						</div>
						<div class="pattern" data-style="fourth">
							<div class=""><img src="/microweb/Public/Home/images/article/image_text4.jpg"></div>
						</div>
					</div>
				</div>
			</li>
		</ul>
<!-- 		<div class="img_list">
	<p>选择图片</p>
		<?php if(is_array($img_list)): $i = 0; $__LIST__ = $img_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="pattern2" va="121">
			<div>
			<img src="/microweb/Uploads/<?php echo ($vo["savepath"]); echo ($vo["savename"]); ?>">
			</div>
		</div><?php endforeach; endif; else: echo "" ;endif; ?>
</div> -->
		<div class="article_list">
			<p>选择文章</p>
			<ul>
				<?php if(is_array($data['article_list'])): $i = 0; $__LIST__ = $data['article_list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="article_item">
						<input id="article_<?php echo ($vo["id"]); ?>" type="radio" name="article_id" value="<?php echo ($vo["id"]); ?>">
						<label for="article_<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></label>
						<img src="/microweb/Public/Home/images/panel/viwepagerAdd2.png">
						<input type="hidden" name="" value="<?php echo ($vo["content"]); ?>">
						<input class="img_src" type="hidden" name="" value="/microweb/Uploads/<?php echo ($vo["savepath"]); echo ($vo["savename"]); ?>">
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
		<div class="page" onclick="return false">
			<?php echo ($data['page']); ?>
		</div>
	</div>
	<input id="target_url" type="hidden" name="" value="<?php echo U('Panel/article_info');?>">
	<input id="controller-id" type="hidden" name="" value="<?php echo ($controller_id); ?>">
	<input id="status" type="hidden" name="" value="<?php echo ($status); ?>">
</body>
</html>