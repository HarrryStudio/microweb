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
    
<style type="text/css">
	th,td{cursor: default;text-align: center;}
	.tb_td{width: 8%;}
	#tb_time{width: 30%;}
	td img{	width: 15px;height: 15px;cursor: pointer;}
	.td_url{width: 300px;overflow: hidden;text-align: left;}
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
            

            
	<!-- 标题栏 -->
	<div class="main-title"> <h2>控件列表</h2> </div>
	<div class="cf">
		<div class="fl">
	        <a class="btn" href="<?php echo U('addController');?>">新 增</a>
	    </div>
		<div class="search-form fr cf">
			<div class="sleft">
				<input type="text" name="nickname" class="search-input" value="<?php echo I('nickname');?>" placeholder="请输入名称或ID">
				<a class="sch-btn" href="javascript:;" id="search" url="<?php echo U('widget');?>"><i class="btn-search"></i></a>
			</div>
		</div>
	</div>
    <!-- 数据列表 -->
    <div class="data-table table-striped">
	<table class="">
    <thead>
        <tr>
		<!-- <th class="row-selected row-selected"><input class="check-all" type="checkbox"/></th> -->
		<th style="text-align: center;">ID</th>
		<th style="text-align: center;">名称</th>
		<th style="text-align: center;">图标</th>
		<th style="text-align: center;">简介</th>
		<th style="text-align: center;">链接</th>
		<th style="text-align: center;">摆放顺序</th>
		<th style="text-align: center;">更新时间</th>
		<th style="text-align: center;">操作</th>
		</tr>
    </thead>
    <tbody>
		<?php if(!empty($list)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <!-- <td><input class="ids" type="checkbox" name="id[]" value="<?php echo ($vo["uid"]); ?>" /></td> -->
			<td><?php echo ($vo["id"]); ?> </td>
			<td><?php echo ($vo["name"]); ?> </td>
			<td><img src="/microweb/Uploads/<?php echo ($vo["icon"]); ?>"></td>
			<td><?php echo ($vo["intro"]); ?> </td>
			<td class="td_url"><a href="<?php echo ($vo["url"]); ?>"><?php echo substr($vo['url'],0,40);?>  </a></td>
			<td class="tb_td">
				<img class="up" src="/microweb/Public/Admin/images/material/up.jpg" value="<?php echo ($vo["id"]); ?>">&ensp;
				<img class="down" src="/microweb/Public/Admin/images/material/down.jpg" value="<?php echo ($vo["id"]); ?>">
			</td>
			<td><?php echo date("Y-m-d H-i-s", $vo['update_time']);?></td>
			<td><?php if(($vo["forbidden"]) == "0"): ?><a href="<?php echo U('changeStatus?type=controller&method=forbidUser&id='.$vo['id']);?>" class="ajax-get deal" style="color:red">禁用</a>&ensp;
				<?php else: ?>
				<a href="<?php echo U('changeStatus?type=controller&method=resumeUser&id='.$vo['id']);?>" class="ajax-get deal" style="color:green">启用</a>&ensp;<?php endif; ?>
				 <a href="<?php echo U('addController?seat='.$vo['id']);?>">编辑</a>&ensp;
                <a href="<?php echo U('changeStatus?type=controller&method=deleteUser&id='.$vo['id']);?>" class="confirm ajax-get deal">删除</a>
            </td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		<?php else: ?>
		<td colspan="9" class="text-center"> aOh! 暂时还没有内容! </td><?php endif; ?>
	</tbody>
    </table>
    <input id="img" type="hidden" name="" value="/microweb/Public/Admin/images/material/">
	</div>
    <div class="page">
        <?php echo ($_page); ?>
    </div>
    <input type="hidden" id="addr" value="<?php echo U('position');?>">

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
    
	<!-- // <script src="/microweb/Public/Static/thinkbox/jquery.thinkbox.js"></script> -->
<script type="text/javascript">
//导航高亮
    highlight_subnav('<?php echo U('User/index');?>');
    /**
     * 第一条上灰色
     * 最后一条下灰色
     */
    $(function() {
		var img = $("#img").val();
    	$(".up:first").attr('src', img+"up2.jpg");
    	$(".down:last").attr('src', img+"down2.jpg");
    })
//向上变换位置
	$(".up").click(function(){
		if ($(this)[0] == $(".up:first")[0]) {
			return;
		};
		var id = $(this).attr("value");
		var url = $("#addr").attr("value");
		// window.location.href = url+"/seat/"+id+"/type/"+1+"/tb/controller";
		$.ajax({
			type: "post",
			url : url,
			data: {type:"1",seat:id,tb:"controller"},
			success:function(data){
				window.location.reload();
			},
			error:function(request){
				// console.log(request);
				var error = "<span id='sp' style='width:100%;height:40px;background:red;float:left;margin-top:-10px;margin-left:-80px;z-index:10'><h2 style='color:white;'>"+request+"</h2></span>";
				$(".main-title").append(error);
				setTimeout(function(){
		            $("#sp").remove();
		        },2000);
		        return;
			}
		})
	})

//向下调整位置
	$(".down").click(function(){
		if ($(this)[0] == $(".down:last")[0]) {
			return;
		};
		var id = $(this).attr("value");
		var url = $("#addr").attr("value");
		$.ajax({
			type: "post",
			url : url,
			data: {type:"2",seat:id,tb:"controller"},
			success:function(data){
				window.location.reload();
			},
			error:function(request){
				var error = "<span id='sp' style='width:90%;height:40px;background:red;float:left;margin-left:-80px;z-index:10'><h2 style='color:white;'>"+request+"</h2></span>";
				$(".main-title").append(error);
				setTimeout(function(){
		            $("#sp").remove();
		        },2000);
		        return;
			}
		})
	})
	
	$(".deal").click(function(){
		setTimeout(function(){
			window.location.reload();
		},1000)
	})

	//搜索功能
	$("#search").click(function(){
		var url = $(this).attr('url');
        var query  = $('.search-form').find('input').serialize();
        query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g,'');
        query = query.replace(/^&/g,'');
        if( url.indexOf('?')>0 ){
            url += '&' + query;
        }else{
            url += '?' + query;
        }
		window.location.href = url;
	});
	//回车搜索
	$(".search-input").keyup(function(e){
		if(e.keyCode === 13){
			$("#search").click();
			return false;
		}
	});
    
</script>

</body>
</html>