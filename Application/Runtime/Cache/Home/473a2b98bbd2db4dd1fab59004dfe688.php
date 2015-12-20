<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head id = "adafd">
	<meta charset="UTF-8">
	<title>编辑面板|微网站生成系统</title>
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Static/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Static/layer/layer.css">
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Static/layer/panel_theme.css">
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/panel/index2.css">
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/panel/column.css">
	<script type="text/javascript" src='/microweb/Public/Static/jquery-2.0.3.min.js'></script>
	<script type="text/javascript" src='/microweb/Public/Static/layer/layer.js'></script>
	<script type="text/javascript" src="/microweb/Public/Home/js/panel/index/frame.js"></script>
	<script type="text/javascript" src="/microweb/Public/Home/js/panel/index/column.js"></script>
	<script type="text/javascript" src="/microweb/Public/Home/js/panel/index/index.js"></script>
</head>
<body>
	<div class="header">
		<!-- 主导航 -->
		<div class="auto-center">
			<div class="logo">Logo</div>
			<ul class="main-nav">
				<li class="nav-item"><a class="win" href="<?php echo U('Website/index');?>" >我的网站</a></li>
				<li class="nav-item"><a class="win" href="<?php echo U('Article/index');?>" >资源管理</a></li>
				<li class="nav-item"><a class="win" href="<?php echo U('Help/index');?>" >帮助教程</a></li>
			</ul>
			<!-- /主导航 -->
			<!-- 按钮栏 -->
			<div class="header-button-bar">
				<button class="save-all" data-type
				="writeHtml" change-flag="false" data-back="<?php echo ($site_info['back'] ? $site_info['back'] : 0); ?>" data-theme="<?php echo ($site_info['theme'] ? $site_info['theme'] : 0); ?>">保存</button>
				<!-- <button class="preview">预览</button> -->
			</div>
		</div>
		<!-- /按钮栏 -->
	</div>
	<!-- /头部 -->
	<!-- 中间 -->
	<div class="middle">
		<div class="main">
			<!-- 左边栏 -->
			<div class="side-left">
				<div class="left-side-title">
					<h3>新增控件</h3>
					<h4>INSERT CONTROLLER</h4>
				</div>
				<div class="left-side-body">
					<div class="left-side-page">
						<div class="left-side-page-bar">
						<?php
 $count = count($controller_list); $num = $count / 8; for($i = 0; $i < $num; $i ++){ ?>
							<div class="left-side-page-item"><div class="point"></div></div>
						<?php } ?>
						</div>
					</div>
					<div class="controller-body">
						<div class="controller-list-bar">
							<?php
 for($i = 0; $i < $count;){ ?>
									<div class="controller-list-item">
							<?php
 for($j = 0; $j < 8 && $i < $count; $j ++,$i ++){ ?>
										<div class="controller-item" draggable="true" index="<?php echo ($controller_list[$i]['id']); ?>" data-name="<?php echo ($controller_list[$i]['cname']); ?>">
											<div class="controller-icon" style="background-image:url( <?php echo C('UPLOAD_ROOT'); echo ($controller_list[$i]['icon']); ?>)">
												<div class="controller-intro"><?php echo ($controller_list[$i]['intro']); ?></div>
											</div>
											<p><?php echo ($controller_list[$i]['name']); ?></p>
										</div>
							<?php
 } echo "</div>"; } ?>
						</div>
					</div>
				</div>
			</div>
			<!-- /左边栏 -->
			<!-- 内容区 -->
			<div class="center">
				<div class="main-panel">
					<div class="phone">
						<div class="screen">
							<!-- <div class="search-bar">
								<input name="dd" type="text" class="search-input" />
							</div> -->
							<div class="browser">
							<iframe id="panel-frame" name="panelFrame" src="/microweb/index.php/Home/Panel/readHtml/column_id/<?php echo ($nowColumn["id"]); ?>" width="100%" height="100%">
							</iframe>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /内容区 -->
			<!-- 右边栏 -->
			<div class="side-right">
				<div class="right-side-title">
					<h3>栏目导航</h3>
					<h4>CONLUNM NAV</h4>
				</div>
				<div class="right-side-body">
					<div class="column-panel">
						<div class="column-table-head">
							<table class="column-table" cellspacing="0">
								<thead>
									<tr>
										<th width="38%">栏目名称</th>
										<th width="24%">开启栏目</th>
										<th width="38%">操作</th>
									</tr>
								</thead>
							</table>
						</div>
						<div class="column-table-body">
							<table class="column-table">
								<tbody>
									<?php if(is_array($column_info)): $i = 0; $__LIST__ = $column_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr index='<?php echo ($vo["id"]); ?>' data-icon='<?php echo ($vo["icon_url"]); ?>' data-link='<?php echo ($vo["url"]); ?>' data-name='<?php echo ($vo["name"]); ?>' data-forbide='<?php echo ($vo["forbidden"]); ?>' data-sort='<?php echo ($vo["sort"]); ?>' data-icon="<?php echo C('PICTURE_UPLOAD_ROOT'); echo ($vo["savepath"]); echo ($vo["savename"]); ?>">
											<td class="column-name"><span class='rel-name'><?php echo ($vo["name"]); ?><span></td>
											<td class="column-forbidden">
												<?php if($vo["forbidden"] == 1): ?><span class='forbide forbidden'>
												<?php else: ?>
													<span class='forbide allowed'><?php endif; ?></span>
											</td>
											<td class="column-do-bar">
												<span class="column-do-item column-edit glyphicon glyphicon-pencil"></span>
												<span class="column-do-item column-del glyphicon glyphicon-remove"></span>
												<span class="column-do-item column-up glyphicon glyphicon-arrow-up"></span>
												<span class="column-do-item column-down glyphicon glyphicon-arrow-down"></span>

											</td>
										</tr><?php endforeach; endif; else: echo "" ;endif; ?>
								</tbody>
							</table>
						</div>
						<div class="column-other">
							<div class="column-add">添加栏目</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /右边栏 -->
		</div>
	</div>
	<!-- /中间 -->
	<!-- 页脚 -->
	<div class="footer">
		<div class="footer-nav">
			<div class="updown glyphicon glyphicon-chevron-up"></div>
			<button class="footer-nav-button theme">主题</button>
			<button class="footer-nav-button back-img">背景</button>
		</div>
		<div class="footer-body">
			<div class="footer-bar">
				<div class="footer-item theme-list-bar">
					<div class="list-arrow left-arrow"></div>
					<div class="theme-list">
						<div class="theme-item default" data-id='0'>

						</div>
						<?php if(is_array($theme_list)): $i = 0; $__LIST__ = $theme_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="theme-item change-flag" data-id='<?php echo ($vo["id"]); ?>' addr="/microweb/UserFiles/Public/Theme/<?php echo ($vo["addr"]); ?>"><img src="/microweb/Uploads/<?php echo ($vo["savepath"]); echo ($vo["savename"]); ?>"></div><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
					<div class="list-arrow right-arrow"></div>
				</div>
				<div class="footer-item back-img-list-bar">
					<div class="list-arrow left-arrow"></div>
					<div class="back-list">
						<div class="back-item default" data-id='0'>
							<!-- <img src="/microweb/Uploads/<?php echo ($vo["savepath"]); echo ($vo["savename"]); ?>"> -->
							<div class="null-back"></div>
							<div class="back-name"><span>空</span></div>
						</div>
						<?php if(is_array($back_list)): $i = 0; $__LIST__ = $back_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="back-item change-flag" data-id='<?php echo ($vo["id"]); ?>'>
								<img src="/microweb/Uploads/<?php echo ($vo["savepath"]); echo ($vo["savename"]); ?>">
								<div class="back-name"><span><?php echo ($vo["name"]); ?></span></div>
							</div><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
					<div class="list-arrow right-arrow"></div>
				</div>
			</div>
		</div>

	</div>
	<!-- /页脚 -->
	<input id="contro-root" type="hidden" value="<?php echo C('CONTROLLER_ROOT_PATH');?>/" />
	<input type="hidden" id="add-column-url" value="/microweb/index.php/Home/Panel/add_column">
	<input type="hidden" id="edit-column-url" value="/microweb/index.php/Home/Panel/edit_column">
	<input type="hidden" id="forbide-column-url" value="/microweb/index.php/Home/Panel/forbide_column">
	<input type="hidden" id="del-column-url" value="/microweb/index.php/Home/Panel/del_column">
	<input type="hidden" id="sort-column-url" value="/microweb/index.php/Home/Panel/sort_column">

	<input type="hidden" id="writeHtml-url" now-column="<?php echo ($nowColumn["id"]); ?>" value="/microweb/index.php/Home/Panel/writeHtml/column_id/">
	<input type="hidden" id="writeArticle-url" value="/microweb/index.php/Home/Panel/writeArticle/">
	<input type="hidden" id="readHtml-url" value="/microweb/index.php/Home/Panel/readHtml/column_id/">
	<input type="hidden" id="control-widget-url" value="/microweb/index.php/Home/Panel/control_widget/name/">
	<input type="hidden" id="save-widget-url" value="<?php echo U('Panel/save_widget');?>">
	<div id="top-alert-back">
		<div id="top-alert" class="alert alert-warning alert-dismissible" role="alert">
		      <button type="button" class="close"><span aria-hidden="true">×</span></button>
		      <div class="alert-content"></div>
		</div>
	</div>
		<form id="iframe-form" method="post" target="controEdit" action="" accept-charset="UTF-8" hidden="true"><input type="text" name="data"></form>
	<script type="text/javascript">
		/**
		 * 弹出信息框
		 * @param  string text 输出文字
		 * @param  int type 方式  1:success  0:error  2:warning
		 */
		function alert_info(text,type){
			var top_alert = $('#top-alert');
			top_alert.find(".alert-content").text(text);
			if(type == 1){
				top_alert.removeClass('alert-danger alert-warning').addClass('alert-success');
			}else if(type == 0){
				top_alert.removeClass('alert-success alert-warning').addClass('alert-danger');
			}else{
				top_alert.removeClass('alert-success alert-danger').addClass('alert-warning');
			}
			$('#top-alert-back').show();
			top_alert.animate({"opacity":1},250);

			setTimeout(function(){
			    $('#top-alert').find('button').click();
			},2000);
		}
		$('.close').click(function(){
			$('#top-alert').animate({"opacity":0},250,function(){$('#top-alert-back').hide()});
		});
	</script>
</body>
</html>