<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/panel/article_list.css">
	<script type="text/javascript" src='/microweb/Public/Static/jquery-2.0.3.min.js'></script>
	<script type="text/javascript">
		var APP = '/microweb';
	</script>
	<script type="text/javascript" src="/microweb/Public/Home/js/panel/article_list.js"></script>
</head>
<body>
	<div id="article_list">
		<ul class="tab_nav">
<!-- 			<li class="active"><a href="#base_setting"></a>常规</li>
<li><a href="#advance_setting">展示设置</a>
</li> -->
		</ul>
		<ul class="setting">

			<li>
				<div>
					<label>模块标题:&nbsp;</label><input type="text" name="" value="文章列表">
					<label for="">请选择栏目:</label>

					<select name="column_list" id="column">
						<?php if(is_array($column_list)): $i = 0; $__LIST__ = $column_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" data="<?php echo ($vo["url"]); ?>" class="column_item"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
			</li>
			<li>
				<br>
				<div>
					<span>列表样式:</span>
					<br>
					<div id="style_list">
						<div class="pattern" va="121">
							<div class="hr"><img src="/microweb/Public/Home/images/article/article_list1.jpg"></div>
						</div>
						<div class="pattern" va="121">
							<div class=""><img src="/microweb/Public/Home/images/article/article_list2.jpg"></div>
						</div>
						<div class="pattern" va="121">
							<div class=""><img src="/microweb/Public/Home/images/article/article_list3.jpg"></div>
						</div>
						<div class="clear_both"></div>
					</div>
				</div>
			</li>
			<li>
				<div class="">
					<span>列表条件:</span>
					<div class="type_list">
						<div class="article_type">
							<span class="select_all">
								<!--<label for="type_all">全选</label>-->
								<input id="type_all" type="checkbox" name="type[]" value="0">
							</span>
							<span>文章分类</span>
						</div>
						<form id="type_data">
							<ul class="article_type_item">
							<?php if(empty($type_list)): ?>请先添加文章和分类
							<?php else: ?>
								<?php if(is_array($type_list)): $i = 0; $__LIST__ = $type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
										<input class="type_checkbox" id="sort_<?php echo ($vo["id"]); ?>" type="checkbox" name="type[]" value="<?php echo ($vo["id"]); ?>">
										<label for="sort_<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></label>
									</li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
							</ul>
						</form>
					</div>
				</div>

				<div id="top-alert-back">
					<div id="top-alert" class="alert alert-warning alert-dismissible" role="alert">
					      <button type="button" class="close"><span aria-hidden="true">×</span></button>
					      <div class="alert-content"></div>
					</div>
				</div>
				<!-- <fieldset>
					<legend>请选择列表的条件</legend>
				<div>
					<span>显示的文章</span>
					<span><?php echo ($display_status); ?></span>
				</div>
					<div>
						<span>文章分类</span>
						<br>
				<input id="check_all" type="radio" name="choose_show" value="true" placeholder="" checked="checked">
				<label for="check_all">全部</label>
				<input id="choose_type" type="radio" name="choose_show" value="" placeholder="">
				<label for="choose_type">指定</label>
				<br>
						<div class="type_list">
							<form id="type_data">
								<label for="type_all">全部</label>
									<input id="type_all" type="checkbox" name="type[]" value="0">
								<br>
								<?php if(is_array($type_list)): $i = 0; $__LIST__ = $type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><label for="sort_<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></label>
										<input class="type_checkbox" id="sort_<?php echo ($vo["id"]); ?>" type="checkbox" name="type[]" value="<?php echo ($vo["id"]); ?>"><?php endforeach; endif; else: echo "" ;endif; ?>
							</form>
						</div>
					</div>
				</fieldset> -->
			</li>
		</ul>
<!-- 		<div class="button">
	<button id="save">保存</button>
	<button id="cancle">取消</button>
</div> -->
	</div>
	<div class="article_info">
		<ul>
			<?php if(is_array($article_info)): $i = 0; $__LIST__ = $article_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php $ii = $vo['id']; echo U('Panel/article_info?article_id='.$ii);?>"><?php echo ($vo["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
	<input id="target_url" type="hidden" name="" value="<?php echo U('Panel/article_type');?>">
	<input id="article_url" type="hidden" name="" value="<?php echo U('Panel/article_info');?>?article_id=">
	<input id="img_url" type="hidden" name="" value="<?php echo C('UPLOAD_ROOT');?>">
	<input id="home_img" type="hidden" name="" value="/microweb/Public/Home/images">
	<input type='hidden' id="controller-id" value="<?php echo ($controller_id); ?>">
	<input id="status" type="hidden" name="" value="<?php echo ($status); ?>">
	<script type="text/javascript">
		var temp = $(".article_info")[0].innerHTML;
	</script>
</body>
</html>