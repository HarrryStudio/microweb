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
	
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/website/article.css">

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
			
	<div class="centent-head">文章
		<div class="set-bar">
			<div class="set-item classify" url='/microweb/index.php/Home/Website/set_classify/site_id/<?php echo ($site_id); ?>'>分类管理</div>
		</div>
	</div>
	<input id="site_id" type="hidden" value="<?php echo ($site_id); ?>">
	<!-- <input id="create_album_url" type="hidden" value="/microweb/index.php/Home/Website/create_album">
	<input id="edit_album_url" type="hidden" value="/microweb/index.php/Home/Website/edit_album">
	<input id="del_album_url" type="hidden" value="/microweb/index.php/Home/Website/del_album"> -->
	<input id="top-article-url" type="hidden" value="/microweb/index.php/Home/Website/top_article">
	<input id="status-article-url" type="hidden" value="/microweb/index.php/Home/Website/update_article_status">
	<div class="article-panel">
		<div class="function-bar">
			<div class="function add-article"><a href='/microweb/index.php/Home/Website/add_article/site_id/<?php echo ($site_id); ?>'>添加文章</a></div>
			<div class="function more-do">批量操作</div>
			<div class="search-bar">
				<form class="search-form">
					<div class="search-type">
						<input type="hidden" name="type_id" id="search-type-id" value="<?php echo ($seach['type_id']); ?>">
						<span class="search-type-name">所有</span>
						<span class="search-down glyphicon glyphicon-triangle-bottom"></span>
						<ul>
							<li data='-1'><a>所有</a></li>
							<li data='0'><a>未分类</a></li>
							<?php if(is_array($type_list)): $i = 0; $__LIST__ = $type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li data='<?php echo ($vo["id"]); ?>'><a><?php echo ($vo["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</div>
					<input name="title" type="text" id="search-text" value="<?php echo ($search['title']); ?>">
					<div url="/microweb/index.php/Home/Website/article_list/site_id/<?php echo ($site_id); ?>/p/<?php echo ($now_page); ?>" class="search-icon glyphicon glyphicon-search"></div>
				</form>
			</div>
		</div>
		<div class="more-do-bar">
			<div class="do-item status-article" url="/microweb/index.php/Home/Website/update_article_status/status/0">启用</div>
			<div class="do-item status-article" url="/microweb/index.php/Home/Website/update_article_status/status/1">禁用</div>
			<div class="do-item status-article" url="/microweb/index.php/Home/Website/update_article_status/status/-1">删除</div>
			<div class="do-item change-classify" url="/microweb/index.php/Home/Website/change_article_type/type_id/">修改分类
				<ul>
					<?php if(is_array($type_list)): $i = 0; $__LIST__ = $type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
					<?php if(empty($type_list)): ?><li><a id="add-type-a" href="/microweb/index.php/Home/Website/set_classify/site_id/<?php echo ($site_id); ?>">添加分类</a></li><?php endif; ?>
				</ul>
			</div>
			<div class="do-item cencel-moro-do">退出批量操作</div>
		</div>
		<div class="article-bar">
			<table class="article-table">
				<thead>
					<th class="table-checkbox"><input type="checkbox" id="chose-article"></th>
					<th class="table-title">标题</th>
					<th class="table-type">类型</th>
					<th class="table-time">创建时间</th>
					<th class="table-operation">操作</th>
				</thead>
			 	<tbody>
			 		<?php if(is_array($article_list)): $k = 0; $__LIST__ = $article_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><tr>
			 				<td><input type="checkbox" name="ids[]" class="article-item" value="<?php echo ($vo["id"]); ?>"></td>
			 				<td>
			 				<?php if($vo['status'] == 1): ?><span class="art-sta art-for"></span>
			 					<?php else: ?>
			 					<?php if($vo['is_top'] == 1): ?><span class="art-sta art-top"></span>
								<?php else: ?>
									<span class="art-sta art-nor"></span><?php endif; endif; ?>
			 				<span class="art-til"><?php echo ($vo["title"]); ?></span>
			 				</td>
			 				<td><?php echo $vo['name']? $vo['name']:"未分类" ?></td>
			 				<td><?php echo (date('Y-m-d',$vo["create_time"])); ?></td>
			 				<td class="operation-bar">
			 					<div class="dropdown">
								  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu<?php echo ($k); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								  	<span>请选择</span>
								    <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu" aria-labelledby="dropdownMenu<?php echo ($k); ?>" data-id="<?php echo ($vo["id"]); ?>" data-type='<?php echo ($vo["type_id"]); ?>'>
								  		<li class="article-option-edit"><a href="/microweb/index.php/Home/Website/add_article/article_id/<?php echo ($vo["id"]); ?>">编辑</a></li>
									  	<li class="article-option-del aritcle-status-item" data-status="-1"><a>删除</a></li>
									  	<?php if($vo['status'] == 1): ?><li class="article-option-apply aritcle-status-item" data-status="0"><a>启用</a>
									  	<?php else: ?>
									  		<li class="article-option-forbide aritcle-status-item" data-status="1"><a>禁用</a></li>
										  	<?php if($vo['is_top'] == 1): ?><li class="article-option-bottom top-status-item"  data-status="0"><a>取消置顶</a></li>
										  	<?php else: ?>
										  		<li class="article-option-top top-status-item" data-status="1"><a>设为置顶</a></li><?php endif; endif; ?>
									  	<li class="article-option-change"><a>修改分类</a></li>
									  </ul>
								</div>
			 				</td>
			 			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			 	</tbody>
			 </table> 
		</div>
		<div class="page">
			<?php echo ($page); ?>
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
					修改分类
	            </h4>
	         </div>
	         <div class="modal-body">
				<form class="change-type-form" action="">
					<div>
						<label for="type-id">请选择分类：</label>
						<input id="way" type="hidden" name="way" value="">
						<input id="type-id" type="hidden" name="type_id" value="">
						<input id="article-id" type="hidden" name="article_id"value="">
						<div class="type-dropdown">
						  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						  	<span id="type-name-span">请选择</span>
						    <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						  	<?php if(is_array($type_list)): $i = 0; $__LIST__ = $type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li data='<?php echo ($vo["id"]); ?>'><a><?php echo ($vo["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
						  </ul>
						</div>
						<?php if(empty($type_list)): ?><div class="empty-info">还没有分类,先去<a id="add-type-a" href="/microweb/index.php/Home/Website/set_classify/site_id/<?php echo ($site_id); ?>">添加分类</a>吧</div><?php endif; ?>
					</div>
				</form>
	         </div>
	         <div class="modal-footer">
	            <button type="button" class="btn btn-default" 
	               data-dismiss="modal">关闭
	            </button>
	            <button id="change-article-type" type="button" target-url="/microweb/index.php/Home/Website/change_article_type/type_id/" class="btn btn-primary">
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

<div id="top-alert-back">
	<div id="top-alert" class="alert alert-warning alert-dismissible" role="alert">
	      <button type="button" class="close"><span aria-hidden="true">×</span></button>
	      <div class="alert-content"></div>
	</div>
<div id="top-alert-back">

	<script type="text/javascript" src="/microweb/Public/Home/js/website/article.js"></script>

</body>
</html>