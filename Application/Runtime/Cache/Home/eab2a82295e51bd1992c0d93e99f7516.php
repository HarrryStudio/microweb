<?php if (!defined('THINK_PATH')) exit();?><div class='article_list_container0 controller' data-id="<?php echo ($cname); ?>">
	<div class='controller-title'>
		<?php echo ($option['title']); ?>
	</div>
	<div class='article_info'>
		<ul class='article_list'>
		<?php if(is_array($article_info)): $i = 0; $__LIST__ = $article_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i; if($key == 0): ?><li>
				<a class='article-link main_article' href="<?php echo ($option['column_url']); ?>.html" data-url="<?php echo ($option['article_url']); echo ($item['id']); ?>/column_id/<?php echo ($item['column_id']); ?>">
				<div class='first_article' style="background-image:url(<?php echo ($item['savepath']); echo ($item['savename']); ?>); background-repeat: no-repeat; background-size:cover">
					<div class='article_title'><?php echo ($item['title']); ?></div>
				</div>
		<?php else: ?>
			<li>
				<a class='article-link sub_article' href="<?php echo ($option['column_url']); ?>.html" data-url="<?php echo ($option['article_url']); echo ($item['id']); ?>/column_id/<?php echo ($option['column_id']); ?>">
				<div class='article_text'>
					<ul><li class='article_title'><?php echo ($item['title']); ?></li></ul>
				</div>
				<div class='img_container'>
					<img src="<?php echo ($item['savepath']); echo ($item['savename']); ?>">
				</div><?php endif; ?>
				</a>
			</li>
			<?php if($key < count($article_info)-1): ?><hr /><?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
</div>