<?php if (!defined('THINK_PATH')) exit();?><div class='controller' data-name='<?php echo ($controllerName); ?>'>
    <div class='controller-title'><?php echo ($title); ?></div>
    <div style='height: 25px;'>
        <?php if(!empty($url)): ?><span style='float: left; display: inline-block;'><img src="<?php echo ($url); ?>"></span><?php endif; ?>
        <?php if(NoticeType == 'cell'): ?><marquee  style='font-size: 14px; width: 90%; float: left; height:21px;' scrollAmount=1 direction=up onmouseover=stop() onmouseout=start()>
            <?php if(is_array($popupCon)): foreach($popupCon as $key=>$vo): ?><span style='margin-left: 10%; display: inline-block;'><?php echo ($vo["con"]); ?></span><br/><?php endforeach; endif; ?>
        <?php else: ?>
            <marquee  style='font-size: 14px; width: 90%; float: left; height:21px;' scrollAmount=3 onmouseover=stop() onmouseout=start()>
            <?php if(is_array($popupCon)): foreach($popupCon as $key=>$vo): ?><span style='margin-left: 10%; display: inline-block;'><?php echo ($vo["con"]); ?></span><?php endforeach; endif; endif; ?>
        </marquee>
    </div>
</div>