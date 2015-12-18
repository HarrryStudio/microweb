<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript"></script>
<div style='display: inline-block;' class='controller show_nav' data-name='<?php echo ($cname); ?>'>
  <?php if(is_array($nav_list)): $key = 0; $__LIST__ = $nav_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><div class="nav_all nav">
      <a href="<?php echo ($vo["url"]); ?>">
        <div style="background-image: url(<?php echo ($vo["img"]); ?>)"></div>
        <p><?php echo ($vo["name"]); ?></p>
        <span>></span>
      </a>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
  <div class='clear_float'></div>
</div>