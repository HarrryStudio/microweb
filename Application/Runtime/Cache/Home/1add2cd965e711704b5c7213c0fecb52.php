<?php if (!defined('THINK_PATH')) exit();?><div class='controller show_nav <?php echo ($theme); ?>' data-name='<?php echo ($cname); ?>'>
  <?php if(is_array($nav_list)): $key = 0; $__LIST__ = $nav_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><div class="nav_all nav">
      <a href="<?php echo ($vo["url"]); ?>">
        <div style="background-image: url(<?php echo ($vo["icon_url"]); ?>)"></div>
        <p><?php echo ($vo["name"]); ?></p>
      </a>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
  <div class='clear_float'></div>
</div>