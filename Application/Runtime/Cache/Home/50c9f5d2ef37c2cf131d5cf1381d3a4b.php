<?php if (!defined('THINK_PATH')) exit();?>
<link rel="stylesheet" type="text/css" href="/microweb/Public/Static/bootstrap/css/bootstrap.css">
    <script type="text/javascript" src='/microweb/Public/Static/jquery-2.0.3.min.js'></script>
    <script type="text/javascript" src="/microweb/Public/Static/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/login.css">


    <form class="form-horizontal" role="form">
        <div class="close">
            <span class="glyphicon glyphicon-remove"></span>
        </div>
        <div class="form-group">
            <!-- <label for="inputEmail3" class="col-sm-2 control-label">账户</label> -->
            <div class="col-sm-3">
                <input type="text" class="form-control account" id="inputEmail3" placeholder="登陆账户..." value="<?php echo (cookie('user_account')); ?>">
            </div>
        </div>
        <div class="form-group">
            <!-- <label for="inputPassword3" class="col-sm-2 control-label">密码</label> -->
            <div class="col-sm-3">
                <input type="password" class="form-control password" id="inputPassword3" placeholder="登陆密码..." value="<?php echo (cookie('user_password')); ?>">
            </div>
        </div>
        <div class="form-group">
            <!-- <label for="authCode" class="col-sm-2 control-label">验证码</label> -->
            <div class="col-sm-3">
                <input type="text" class="form-control" id="authCode" placeholder="验证码...">
                <img src="verify" border="0" title="点击刷新" alt="验证码" id="authImg"  onClick="this.src=this.src+'?'+Math.random()"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <div class="checkbox">
                    <div class="col-sm-3"><input id="checkbox_ok" type="checkbox" class="remember"></div>
                    <label for="checkbox_ok">记住密码</label>
                </div>
                <div class="forgetPassword">
                     <a href="forgotPassword">忘记密码</a>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <button type="button" class="btn btn-default login" value="<?php echo U('Website/index');?>">登录</button>
            </div>
            <div class="col-sm-offset-2 col-sm-3">
                <a href="register" class="btn register">注册账号</a>
            </div>
        </div>
    </form>
    <input id="home" type="hidden" name="" value="<?php echo U('Home/Index/index');?>">

    <div id="top-alert-back">
        <div id="top-alert" class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close_hint"><span aria-hidden="true">×</span></button>
            <div class="alert-content"></div>
        </div>
    </div>


    <script type="text/javascript" src="/microweb/Public/Home/js/login.js"></script>