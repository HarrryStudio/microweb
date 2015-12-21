<?php if (!defined('THINK_PATH')) exit();?><!--<div class='controller-title'><?php echo ($title); ?></div>-->
<div style='max-height: 230px' class='controller' data-name='<?php echo ($controllerName); ?>'>
    <div id='carousel-example-generic' class='carousel slide'>
        <div class='carousel-inner' style='height:210px'>
            <div class='item active'>
                <img style='width: 100%;height:210px;' src='/microweb/Uploads/<?php echo ($frist_img); ?>'>
            </div>
            <?php if(is_array($pic_list)): $i = 0; $__LIST__ = array_slice($pic_list,1,9,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class='item'>
                    <img style='width: 100%;height:210px;' src='/microweb/Uploads/<?php echo ($vo["savepath"]); echo ($vo["savename"]); ?>'>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    <?php if($type == 'select_down'): ?><a class='left carousel-control' href='#carousel-example-generic' data-slide='prev'>
            <span class='glyphicon glyphicon-chevron-left'></span>
        </a>
        <a class='right carousel-control' href='#carousel-example-generic' data-slide='next'>
            <span class='glyphicon glyphicon-chevron-right'></span>
        </a>
    <?php elseif($type == 'select_right'): ?>
        <ol class='carousel-indicators'>
            <li data-target='#carousel-example-generic' data-slide-to='0' class='active'><?php echo ($pic_num); ?></li>
        <?php if(is_array($pic_list)): $i = 0; $__LIST__ = array_slice($pic_list,1,9,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li data-target='#carousel-example-generic' data-slide-to="<?php echo ($key); ?>"></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ol>
    <?php elseif($type == 'down'): ?>
        <a style='margin-left:49%' class='getdown' id='down'>
            <span style='cursor: pointer;' class='glyphicon glyphicon-chevron-down'></span>
        </a><?php endif; ?>
    </div>
</div>