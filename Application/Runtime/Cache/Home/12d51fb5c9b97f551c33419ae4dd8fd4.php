<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/microweb/Public/Static/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/panel/PicturesShow.css">
    <!--<link rel="stylesheet" type="text/css" href="/microweb/Public/Home/css/panel/alert_info.css">-->
    <script type="text/javascript" src='/microweb/Public/Static/jquery-2.0.3.min.js'></script>
    <script type="text/javascript" src="/microweb/Public/Static/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/microweb/Public/Home/js/panel/PicturesShow.js"></script>
    <!--<script type="text/javascript" src="/microweb/Public/Home/js/panel/alert_info.js"></script>-->
</head>
<body>
    <div id="PicturesShow">
        <div class="content">
            <div class="title">
                <span>模块标题:</span>
                <span>
                    <input type="text" class="setTitle" value="图片展示"/>
                </span>
            </div>
            <div class="type">
                <div class="type_title">图册样式:</div>
                <div class="img">
                    <div class="pattern">
                        <div class="hr"><img type="1" src="/microweb/Public/Home/images/panel/such2.jpg"></div>
                    </div>
                    <div class="pattern">
                        <div class=""><img type="2" src="/microweb/Public/Home/images/panel/such3.jpg"></div>
                    </div>
                    <div class="pattern">
                        <div class=""><img type="3" src="/microweb/Public/Home/images/panel/square.png"></div>
                    </div>
                </div>
                <!--<div class="hint">-->
                    <!--<span>[注：该样式最多显示10张图片]</span>-->
                <!--</div>-->
            </div>
            <div class="selectAlbum">
                <div>
                    <span>选择相册:</span>
                </div>
                <div class="albumList">
                    <table class="albumListContent">
                        <?php if(empty($album_list)): ?><h3 style="text-align: center; color: red;">无相册,请去添加</h3>
                        <?php else: ?>
                            <?php if(is_array($album_list)): foreach($album_list as $key=>$vo): ?><tr date="<?php echo ($vo["id"]); ?>">
                                    <td class="ablumName">
                                        <?php echo ($vo["name"]); ?>
                                    </td>
                                    <td class="identification">
                                        <img src="/microweb/Public/Home/images/panel/viwepagerAdd2.png">
                                    </td>
                                </tr><?php endforeach; endif; endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="controller-id" value="<?php echo ($controllerId); ?>"/>
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