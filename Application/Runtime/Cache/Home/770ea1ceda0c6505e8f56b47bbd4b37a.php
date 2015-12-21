<?php if (!defined('THINK_PATH')) exit();?><div class='controller' data-name='<?php echo ($controllerName); ?>'>
    <div class='controller-title'><?php echo ($title); ?></div>
    <?php if($type == 'tile'): ?><div class='picShowList'>
            <?php if(is_array($pic_list)): foreach($pic_list as $key=>$vo): ?><img src='/microweb/Uploads/<?php echo ($vo["savepath"]); ?>/<?php echo ($vo["savename"]); ?>'><?php endforeach; endif; ?>
    <?php elseif($type == 'select_right'): ?>
        <div class='showPic showRight'>
            <img src='/microweb/Uploads/<?php echo ($frist_img); ?>'>
        </div>
        <div class='NavRight'>
            <?php if(is_array($pic_list)): foreach($pic_list as $key=>$vo): ?><img src='/microweb/Uploads/<?php echo ($vo["savepath"]); ?>/<?php echo ($vo["savename"]); ?>'><?php endforeach; endif; ?>
    <?php else: ?>
        <div class='showPic showDown'>
            <img src='/microweb/Uploads/<?php echo ($frist_img); ?>'>
        </div>
        <div class='NavDown'>
            <?php if(is_array($pic_list)): foreach($pic_list as $key=>$vo): ?><img src='/microweb/Uploads/<?php echo ($vo["savepath"]); ?>/<?php echo ($vo["savename"]); ?>'><?php endforeach; endif; endif; ?>
        </div>
</div>