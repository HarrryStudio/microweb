<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>|系统管理平台</title>
    <link href="/microweb/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/microweb/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/microweb/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/microweb/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/microweb/Public/Admin/css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Admin/css/blue_color.css" media="all">
    <link rel="stylesheet" type="text/css" href="/microweb/Public/Static/uploadifive/uploadifive.css" media="all">
    <link rel="stylesheet" type="text/css" href="/microweb/Public/Admin/css/Backstage/mybase.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/microweb/Public/Static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/microweb/Public/Static/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/microweb/Public/Admin/js/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="/microweb/Public/Admin/js/common.js"></script>
    <script type="text/javascript" src="/microweb/Public/Static/uploadifive/jquery.uploadifive.min.js"></script>
    <script type="text/javascript" src="/microweb/Public/Static/uploadify/jquery.uploadify.min.js"></script>

    <!--<![endif]-->
    
<style>
    body{
    	padding-top: 40px;
        padding-left: 0px;
    }
    #main{
        background: #F6F6F6;
    }
    #home_page_top{
    	width: 95%;
    	height:80px;
    	margin: 20px auto;
    	/*background: #ADD8E6 ;*/
    }
    .show_mod{
        width: 16%;
        height: 100%;
        float: left;
        /*background:  red ;*/
        margin-left: 3%;
        border: 1px solid #ADD8E6;
    }
    #show_mod_one{
        margin-left: 4%;
    }
    .show_mod_left{
        width: 43%;
        opacity: 0.7;
        border-right: 2px solid rgb(233,233,233);
    }
    .show_mod_right{
        width: 55%;
    }
    .show_mod_left,.show_mod_right{
        height: 100%;
        float: left;
        /*line-height: 6em;*/
        background: white;
        text-align: center;
    }
    .show_mod_left img{
        width: 90px;
        height: 80px;
    }
    .show_mod_right_up{
        width: 100%;
        height: 56%;
        line-height: 3em;
        /*border-bottom: 2px solid rgb(233,233,233);*/
    }
    .show_mod_right_down{
        width: 100%;
        height: 42%;
        line-height: 2em;
    }
    #home_page_introduce{
    	width: 95%;
    	height:300px;
    	margin: 0 auto;
        margin-top: 50px;
    	/*background: #00FFFF;*/
        /*border: 1px solid #cdcdcd; */
    }
    #tb{
        width: 98%;
        height: 300px;
        float: left;
        margin-left: 1%;
    }
    #tab{
        margin-left: 10%;
    }
    td{
        border-bottom: 1px solid rgb(233,233,233);
    }
    #td_first{
        width: 100%;
        height: 35px;
        background: #eeeeee;
    }
</style>

</head>
<body>
    <!-- 头部 -->
    <div class="header">
        <!-- Logo -->
        <span class="logo">微站后台管理</span>
        <!-- /Logo -->

        <!-- 主导航 -->
        <ul class="main-nav">
            <?php if(is_array($top_menu)): $i = 0; $__LIST__ = $top_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="state_color"><a href="<?php echo (U($menu["node_url"])); ?>"><?php echo ($menu['node_name']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- /主导航 -->

        <!-- 用户栏 -->
        <div class="user-bar">
            <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu hidden">
                <li class="manager">你好，<em title="<?php echo session('admin_user');?>"><?php echo session('admin_user');?></em></li>
                <li><a href="<?php echo U('Website/addUser?choice=1');?>">修改信息</a></li>
                <!-- <li><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li> -->
                <!-- <li><a href="<?php echo U('User/updateNickname');?>">修改昵称</a></li> -->
                <li><a href="<?php echo U('Public/logout');?>">退出</a></li>
            </ul>
        </div>
    </div>
    <!-- /头部 -->

    <!-- 边栏 -->
    <div class="sidebar">
        <!-- 子导航 -->
        
            <div id="subnav" class="subnav">
                <?php if(!empty($_extra_menu)): ?>
                    <?php echo extra_menu($_extra_menu,$__MENU__); endif; ?>
                <?php if(is_array($child_menu)): $i = 0; $__LIST__ = $child_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
                    <?php if(!empty($sub_menu)): if(!empty($key)): ?><h3><i class="icon icon-unfold"></i><?php echo ($key); ?></h3><?php endif; ?>
                        <ul class="side-sub-menu">
                            <?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                                    <a class="item" href="<?php echo (U($menu["node_url"])); ?>"><?php echo ($menu["node_name"]); ?></a>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul><?php endif; ?>
                    <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        
        <!-- /子导航 -->
    </div>
    <!-- /边栏 -->

    <!-- 内容区 -->
    <div id="main-content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div id="main" class="main">
            
            <!-- nav -->
            <?php if(!empty($_show_nav)): ?><div class="breadcrumb">
                <span>您的位置:</span>
                <?php $i = '1'; ?>
                <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
                    <?php else: ?>
                    <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
                    <?php $i = $i+1; endforeach; endif; ?>
            </div><?php endif; ?>
            <!-- nav -->
            

            
  
	<div id="home_page_top">
        <div class="show_mod" id="show_mod_one">
            <div class="show_mod_left"><img src="/microweb/Public/Admin/images/material/tuandui.jpg"></div>
            <div class="show_mod_right">
                <div class="show_mod_right_up"><h2> <?php echo ($list["team"]); ?> </h2></div>
                <div class="show_mod_right_down">团队规模</div>
            </div>
        </div>
        <div class="show_mod">
            <div class="show_mod_left"><img src="/microweb/Public/Admin/images/material/yonghu.png"></div>
            <div class="show_mod_right">
                <div class="show_mod_right_up"><h2> <?php echo ($list["user"]); ?> </h2></div>
                <div class="show_mod_right_down">用户数</div>
                
            </div>
        </div>
        <div class="show_mod">
            <div class="show_mod_left"><img src="/microweb/Public/Admin/images/material/wangzhan.png"></div>
            <div class="show_mod_right">
                <div class="show_mod_right_up"><h2> <?php echo ($list["site"]); ?> </h2></div>
                <div class="show_mod_right_down">网站数</div>
            </div>
        </div>
        <div class="show_mod">
            <div class="show_mod_left"><img src="/microweb/Public/Admin/images/material/kongjian.jpg"></div>
            <div class="show_mod_right">
                <div class="show_mod_right_up"><h2> <?php echo ($list["cont"]); ?> </h2></div>
                <div class="show_mod_right_down">控件数</div>
            </div>
        </div>
        <div class="show_mod">
            <div class="show_mod_left"><img src="/microweb/Public/Admin/images/material/wenzhang.png"></div>
            <div class="show_mod_right">
                <div class="show_mod_right_up"><h2> <?php echo ($list["article"]); ?> </h2></div>
                <div class="show_mod_right_down">文章数</div>
            </div>
        </div>
	</div>

	<div id="home_page_introduce">
		<table id="tb">
            <td id="td_first"><h3> 微站信息介绍--》 </h3></td><tr/>
            <td>研发团队：&emsp;三月软件工作室之创新团队</td><tr/>
            <td>团队规定：&emsp;日工作，日完成，日总结，日汇报，拒绝迟到早退</td><tr/>
            <td>团队方向：&emsp;三十年专注 PHP</td><tr/>
            <td>团队信条：&emsp;专注从简，优中选优，团结协作</td><tr/>
            <td>产品介绍：&emsp;适用于win系列/linux系统，便于所有人士组建自己网站的微站产品</td><tr/>
            <td>组建日期：&emsp;2015/08/05</td>
        </table>
	</div>


        </div>
        <div class="cont-ft">
            <div class="copyright">
                <div class="fl">感谢使用<a href="/microweb/index.php/Admin/index/index" target="_blank">微站</a>管理平台</div>
                <!-- <div class="fr">V<?php echo (ONETHINK_VERSION); ?></div> -->
            </div>
            <input type="hidden" id="nums" value = '<?php echo ($urlcolor); ?>'>
            <input type="hidden" id="leftnums" value = '<?php echo ($lefturlcolor); ?>'>
        </div>
    </div>
    <!-- /内容区 -->
    <script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "/microweb", //当前网站地址
            "APP"    : "/microweb/index.php", //当前项目地址
            "PUBLIC" : "/microweb/Public", //项目公共目录地址
            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
    <script type="text/javascript" src="/microweb/Public/Static/think.js"></script>
    <script type="text/javascript">

        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
            $subnav.find("a[href='" + url + "']").parent().addClass("current");

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });

            $("#subnav h3 a").click(function(e){e.stopPropagation()});

            //主导航
            var i = 0;
            $('.state_color').each(function(){
                if($('.state_color:eq('+i+') a:only-child').attr('href') == $('#nums').val()+'/index'){
                    $('.state_color:eq('+i+')').addClass('current');
                }
                i++;
            });
            var j = 0;
            $('.item').each(function(){
                if($('.item:eq('+j+')').attr('href') == $('#leftnums').val()){
                    $('.item:eq('+j+')').parent().addClass('current');
                }
                j++;
            });


            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

	        /* 表单获取焦点变色 */
	        $("form").on("focus", "input", function(){
		        $(this).addClass('focus');
	        }).on("blur","input",function(){
				        $(this).removeClass('focus');
			        });
		    $("form").on("focus", "textarea", function(){
			    $(this).closest('label').addClass('focus');
		    }).on("blur","textarea",function(){
			    $(this).closest('label').removeClass('focus');
		    });

            // 导航栏超出窗口高度后的模拟滚动条
            var sHeight = $(".sidebar").height();
            var subHeight  = $(".subnav").height();
            var diff = subHeight - sHeight; //250
            var sub = $(".subnav");
            if(diff > 0){
                $(window).mousewheel(function(event, delta){
                    if(delta>0){
                        if(parseInt(sub.css('marginTop'))>-10){
                            sub.css('marginTop','0px');
                        }else{
                            sub.css('marginTop','+='+10);
                        }
                    }else{
                        if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                            sub.css('marginTop','-'+(diff-10));
                        }else{
                            sub.css('marginTop','-='+10);
                        }
                    }
                });
            }
        }();
    </script>
    
	<script type="text/javascript">
		$(function(){
	        $('.copyright').html('<div class="copyright"> ©2015 新乡三月软件科技有限公司版权所有</div>');
	        $('.sidebar').remove();
	    })
    </script>

</body>
</html>