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
	<script type="text/javascript" >
		var APP = "/microweb";
	</script>
	
    <link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/personalDetails.css">
    <script type="text/javascript" src="/microweb/Public/Home/js/personalDetails.js"></script>

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
				<?php if(is_login()): ?><a onclick="return confirm('确定要退出?')" class="login-status logout-butotn" href="<?php echo U('Login/logout');?>">退出</a>
				<?php else: ?>
					<a class="login-status login-button"  href="<?php echo U('Login/login');?>">登录</a><?php endif; ?>
				
			</div>
			<!-- /登录状态信息 -->
		</div>
	</div>
	<div class="senior-nav">
		
    <ul>
        <li class="senior-nav-item"><a href="<?php echo U('personalDetails');?>">个人信息</a></li>
        <li class="senior-nav-item"><a href="<?php echo U('changeProtection');?>">账户安全</a></li>
    </ul>

	</div>
	<!-- /头部 -->
	<!-- 中间 -->
	<div class="center">
		<!-- 边栏 -->
		
    <div class="side">
        <div class="side-head">个人信息</div>
        <div class="side-item active">完善个人信息</div>
    </div>

		<!-- /边栏 -->
		<!-- 内容区 -->
		<div class="content">
			
    <form action="<?php echo U('perfect');?>" method="post" name="f1" class="form-horizontal" enctype="multipart/form-data">
        <div id="head_img">
           <div id="show_img">
                <?php if(empty($user_info['head_img'])): ?><img src="/microweb/Public/Home/images/head_img/user.png">
                <?php else: ?>
                    <img src="/microweb/Uploads/<?php echo ($user_info['head_img']); ?>"><?php endif; ?>
            </div>
            <input id="file_upload" name="file_upload" type="file" multiple="true">
        </div>
        <div class="form-group">
            <label for="account" class="col-sm-2 control-label">账户:</label>
            <div class="col-sm-10 redact">
                <input type="text" class="form-control" id="account" name="account"  readOnly="true" value="<?php echo ($user_info['account']); ?>">
            </div>
            <div class="col-sm-10 info">
                <?php echo ($user_info['account']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="nickname" class="col-sm-2 control-label">昵称:</label>
            <div class="col-sm-10 redact">
                <input type="text" class="form-control" id="nickname" name="nickname" value="<?php echo ($user_info['nickname']); ?>">
            </div>
            <div class="col-sm-10 info">
                <?php echo ($user_info['nickname']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="phone" class="col-sm-2 control-label">手机:</label>
            <div class="col-sm-10 redact">
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo ($user_info['phone']); ?>">
            </div>
            <div class="col-sm-10 info">
                <?php echo ($user_info['phone']); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">邮箱:</label>
            <div class="col-sm-10 redact">
                <input type="text" class="form-control" id="inputEmail3" name="inputEmail3" value="<?php echo ($user_info['email']); ?>">
            </div>
            <div class="col-sm-10 info">
                <?php echo ($user_info['email']); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12 redact">
                <div class="col-sm-3">
                    <input type="submit" class="btn btn-default" id="submit_btn" value="提交" abindex="1">
                </div>
                <div class="col-sm-3">
                    <a ><button type="button" class="redact_no btn btn-default">取消</button></a>
                </div>
            </div>
            <div class="col-sm-3 info">
                <input type="button" id="redact" value="编辑资料" class="btn btn-default"/>
            </div>
        </div>
    </form>

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
	
<div id="top-alert-back">
	<div id="top-alert" class="alert alert-warning alert-dismissible" role="alert">
	      <button type="button" class="close"><span aria-hidden="true">×</span></button>
	      <div class="alert-content"></div>
	</div>
</div>
	
</body>
</html>