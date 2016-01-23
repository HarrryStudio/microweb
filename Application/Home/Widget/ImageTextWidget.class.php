<?php
namespace Home\Widget;
use Home\Widget;

/**
*
*/
class ImageTextWidget extends Widget
{

	function __construct($theme,$resource,$option)
	{
		parent::__construct($theme,$resource,$option);
		$this->name = 'ImageText';
	}

	public function controller($site_id,$data)
	{
		if (!empty($data)) {
			$this->assign('status', true);
			$this->assign('now_theme', $data['theme']);
		}
        $map['article.site_id'] = $site_id;
        $map['article.status'] = 0;
        $list = D('article')->Image_text_widget_article_list($map);

		$theme_list = $this->get_theme_list();
		$this->assign('list', $list);
		$this->assign('theme_list', $theme_list);
		$this->assign('theme', $this->theme);
        $this->assign('controller_id',I('id'));
		$this->display('Panel/'.'image_text');
	}

	public function index($site_id,$dynamic = false)
	{
		$map['article.id'] = $this->option['article_id'];
		$map['article.site_id'] = $site_id;
		$map['article.status'] = 0;
		$article = D('article')->get_article($map);
		$article['content'] = htmlspecialchars_decode($article['content']);
        // $this->option['article_content'] = htmlspecialchars_decode($this->option['article_content']);
		$this->assign('article', $article);
		$this->assign('index',$this->option['index']);
		$this->assign('cname',$this->name);
		$this->assign('option', $this->option);
		$this->insert_content($dynamic);
	}

	public function get_theme_list()
	{
		return $theme;
	}

	public function filter_theme_link($theme){
	  return $theme.'_image_text';
	}

	public function filter_theme_template($theme){
	  return 'first';
	}

}

?>
