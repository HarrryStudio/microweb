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
    
	<link rel="stylesheet" type="text/css" href="/microweb/Public/Admin/css/Backstage/reception_index.css" />

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
            

            
	<div class="main-title"><h2><?php echo ($modular); ?></h2> 
		<button id="bt">添加图片</button>
	</div>
	<div id="layer">
		<input type="file" id="file_upload" name="file_upload" multiple="true">
	</div>
	<div id="pic">
		<?php if(!empty($list)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="pic_info">
				<div class="img_delete">
					<div class="pic_img">
						<img src="<?php echo '/microweb/Uploads/'; echo ($vo["savepath"]); echo ($vo["savename"]); ?>">
					</div>
					<div class="del" val="<?php echo ($vo["id"]); ?>"><img src="/microweb/Public/Admin/images/delete.png"></div>
				</div>
				<span class="label">所在目录：</span> <div title="双击修改" value="<?php echo ($vo["id"]); ?>" class="theme_url">
				<!--<?php echo ($vo["addr"]); ?>-->
					<?php if(empty($vo["addr"])): ?><span style="color: red;">目录为空，主题无效</span>
					<?php else: ?>
						<?php echo ($vo["addr"]); endif; ?>
					<input type="hidden" class="id" value="<?php echo ($vo["id"]); ?>">
					</div>
				<div class="pic_time">
					<label>更新时间：</label><?php echo date("Y-m-d", $vo['update_time']);?>
				</div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
		<?php else: ?>
			<img id="empty_file" src="/microweb/Public/Admin/images/empty.png"/><?php endif; ?>
	</div>
	<input type="hidden" id="addr" value="<?php echo U('editaddr');?> ">
	<input type="hidden" id="delete" value="<?php echo U('deltheme');?>">

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

	$(".theme_url").keydown(function (event) {
		if(event.keyCode == 13) {
			$(this).blur();
		}
	})
	$(".theme_url").dblclick(function(){
		// $(".theme_url").attr("contentEditable", "false");
		that = $(this);
		that.attr("contentEditable", "true");
		that.focus();
		var old_content = that.html();
		if(old_content.indexOf("主题无效")!=-1){
			that.html("");
		}
		var seat = that.attr("value");
		that.unbind("blur");
		that.blur(function(){
			$(".theme_url").attr("contentEditable", "false");
			var content = $(this).text();
			content = content.replace(/(^\s*)|(\s*$)/g, "");
			if(content.indexOf('../')!=-1||content.indexOf('./')!=-1||/[\u4E00-\u9FA5]/g.test(content)){
				that.html("<span style='color: red;'>格式错误，主题无效</span>");
//				alert("格式错误");
			}else{
				if(content == ""){
					that.html(old_content);
					return;
				}
				var addr = $("#addr").attr("value");
				$.post(addr,{content:content,seat:seat},function(response){
					// if (response) {
					// 	window.location.reload();
					// };
				});
			}
		});
	})

	$(".img_delete").mouseover(function(){
		$(this).find(".del").toggle();
	}).mouseout(function(){
		$(this).find(".del").toggle();
	});

	$(".del").click(function(){
		if(!confirm("你确定要删除?")){
			return;
		}
		var set_id = $(this).attr("val");
		url = $("#delete").attr("value");
		$.post(url,{id:set_id},function(data){
			// console.log(data)
			if (data){
				window.location.reload();
			}else{
				alert("删除失败");
			}
		});
	})

	 $("#bt").click(function(){
	 	$("#layer").toggle();
	 });
 		
	$('#file_upload').uploadify({
		'swf'      : '/microweb/Public/Static/uploadify/uploadify.swf',
        'uploader' : '/microweb/index.php/Admin/Reception/uploadtheme',
        'buttonText' : '请选择文件',
        // 'fileTypeExts' :    '*.jpg; *.png; *.JPG ; *.PNG',
        'onUploadSuccess' : function(file, data, response) {
        	if (data == 1) {
        		alert("图片信息重复");
        	}
			setTimeout(function(){
	        	window.location.reload();
	        },500);
	// console.log(data);
        }
	});

</script>

</body>
</html>