<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/microweb/Public/Static/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/panel/viwepager.css">
    <!--<link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/panel/alert_info.css">-->
    <script type="text/javascript" src='/microweb/Public/Static/jquery-2.0.3.min.js'></script>
    <script type="text/javascript" src="/microweb/Public/Static/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/microweb/Public/Home/js/panel/viwepager.js"></script>
    <!--<script type="text/javascript" src="/microweb/Public/Home/js/panel/alert_info.js"></script>-->
</head>
<body>
    <div id="PicturesShow">
        <div class="content">
            <!--<div class="title">-->
                <!--<span>模块标题:</span>-->
                <!--<span>-->
                    <!--<input type="text" class="setTitle" value="轮播图"/>-->
                <!--</span>-->
            <!--</div>-->
            <div class="type">
                <div class="title_hint">
                    <div class="type_title">轮播样式:</div>
                    <div class="hint">
                        <span>[注：最多显示10张图片]</span>
                    </div>
                </div>

                <div class="img">
                    <!--<img type="1" src="/microweb/Public/Home/images/panel/such1.jpg">-->
                    <!--<img type="2" src="/microweb/Public/Home/images/panel/such2.jpg">-->
                    <!--<img type="3" src="/microweb/Public/Home/images/panel/such4.jpg">-->
                    <?php if(empty($theme)): else: ?>
                        <?php if(is_array($theme)): foreach($theme as $key=>$vo): if($vo["name"] == $primary_type): ?><img class="pitch_on" type="<?php echo ($vo["name"]); ?>" src="/microweb/Uploads/<?php echo ($vo["savepath"]); echo ($vo["savename"]); ?>">
                            <?php else: ?>
                                <img class="pitch_on_no" type="<?php echo ($vo["name"]); ?>" src="/microweb/Uploads/<?php echo ($vo["savepath"]); echo ($vo["savename"]); ?>"><?php endif; endforeach; endif; endif; ?>
                </div>
            </div>
            <div style="clear: both"></div>
            <div class="selectAlbum">
                <div>
                    <span>选择相册:</span>
                </div>
                <div class="albumList">
                    <?php if(empty($album_list)): ?><h3 style="text-align: center; color: red;">无相册,请去添加</h3>
                    <?php else: ?>
                        <table class="albumListContent">
                            <?php if(is_array($album_list)): foreach($album_list as $key=>$vo): if($vo["id"] == $primary_album): ?><tr id="pitch_album" style="background: #D3D1CB;" date="<?php echo ($vo["id"]); ?>">
                                        <td class="ablumName">
                                            <?php echo ($vo["name"]); ?>
                                        </td>
                                        <td class="identification">
                                            <img src="/microweb/Public/Home/images/panel/viwepagerAdd1.png">
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <tr date="<?php echo ($vo["id"]); ?>">
                                        <td class="ablumName">
                                            <?php echo ($vo["name"]); ?>
                                        </td>
                                        <td class="identification">
                                            <img src="/microweb/Public/Home/images/panel/viwepagerAdd2.png">
                                        </td>
                                    </tr><?php endif; endforeach; endif; ?>
                        </table><?php endif; ?>

                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="controller-id" value="<?php echo ($controllerId); ?>" />
    <input type="hidden" id="status" value="<?php echo ($status); ?>">
    <input type="hidden" id="save_widget" value="<?php echo U('Panel/save_widget');?>">
    <!--<div id="top-alert-back">-->
        <!--<div id="top-alert" class="alert alert-warning alert-dismissible" role="alert">-->
            <!--<button type="button" class="close_hint"><span aria-hidden="true">×</span></button>-->
            <!--<div class="alert-content"></div>-->
        <!--</div>-->
    <!--</div>-->
</body>
</html>