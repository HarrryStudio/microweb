<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/panel/article_sort.css">
	<script type="text/javascript" src='/microweb/Public/Static/jquery-2.0.3.min.js'></script>
	<script type="text/javascript">
		var APP = '/microweb';
	</script>
	<script type="text/javascript" src="/microweb/Public/Home/js/panel/article_sort.js"></script>
</head>
<body>
	<div id="article_sort">
<!-- 		<ul class="tab_nav">
	<li class="active"><a href="#base_setting"></a>常规</li>
	<li><a href="#advance_setting">展示设置</a>
	</li>
</ul> -->
		<ul class="setting">
			<li>
				<div>
					<label>模块标题:&nbsp;</label><input type="text" name="" value="文章分类">
				</div>
			</li>
			<li>
			<li>
				<div>
					<div class="type_list">
						<span class="select_text">选择文章:</span>
						<span class="select_all">
							<input id="type_all" type="checkbox" name="type[]" value="0">
							<label for="type_all">All</label>
						</span>
						<form id="type_data">
							<ul>
								<li><span></span><span class="content">分类</span><span class="select_span">栏目</span></li>
								<li><span></span><span class="content">分类</span><span class="select_span">栏目</span></li>
							<?php if(is_array($type_list)): $i = 0; $__LIST__ = $type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
								<span><input class="type_checkbox" id="sort_<?php echo ($vo["id"]); ?>" type="checkbox" name="type[]" value="<?php echo ($vo["id"]); ?>">
								</span><span class="content"><label for="sort_<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></label>
								</span><span class="select_span"><select name="vo2.id">
									<?php if(is_array($column_list)): $i = 0; $__LIST__ = $column_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo2["id"]); ?>" data="<?php echo ($vo2["url"]); ?>"><?php echo ($vo2["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
								</select></span></li><?php endforeach; endif; else: echo "" ;endif; ?>
							</ul>
						</form>
					</div>
				</div>
			</li>
		</ul>
	</div>
	<div class="article_sort_info">
		<ul>
		<?php if(is_array($type_list)): $i = 0; $__LIST__ = $type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php $ii = $vo['name']; echo U('Panel/article_sort_info?article_sort_id='.$ii);?>"><?php echo ($vo["name"]); ?></a></li>		
			<hr><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
	<input type='hidden' id="controller-id" value="<?php echo ($controller_id); ?>">
	<input id="status" type="hidden" name="" value="<?php echo ($status); ?>">
</body>
</html>
				<!-- <fieldset>
					<legend>请选择文章分类</legend>
					<div>
						<div class="type_list">
							<form id="type_data">
								<label for="type_all">全部</label>
								<input id="type_all" type="checkbox" name="type[]" value="0">
								<br>
								<?php if(is_array($type_list)): $i = 0; $__LIST__ = $type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><label for="sort_<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></label>
									<input class="type_checkbox" id="sort_<?php echo ($vo["id"]); ?>" type="checkbox" name="type[]" value="<?php echo ($vo["id"]); ?>">
									<select name="vo2.id">
										<?php if(is_array($column_list)): $i = 0; $__LIST__ = $column_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo2["id"]); ?>" data="<?php echo ($vo2["url"]); ?>"><?php echo ($vo2["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
									</select><?php endforeach; endif; else: echo "" ;endif; ?>
							</form>
						</div>
						<div class="column_list">
							<label for="type_all">选择栏目</label>
							<br>
				<?php if(is_array($column_list)): $i = 0; $__LIST__ = $column_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><label for="column_list_<?php echo ($vo["id"]); ?>"></label>
				<input class="column_list_checkbox" id="column_list_<?php echo ($vo["id"]); ?>" type="radio" name="column" data="" value="<?php echo ($vo["id"]); ?>"><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div>
				</fieldset>
							</li> -->