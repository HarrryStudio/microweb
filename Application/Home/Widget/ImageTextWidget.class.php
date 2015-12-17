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

	public function controller()
	{
        $map['article.site_id'] = session('site_id');
        $data = D('article')->Image_text_widget_article_list($map);
        $this->assign("data",$data);
        $this->assign('controller_id',I('id'));
		$this->display('panel/'.'image_text');
	}

	public function index()
	{
        $this->option['article_content'] = htmlspecialchars_decode($this->option['article_content']);
		$this->assign('index',$this->option['index']);
		$this->assign('cname',$this->name);
		$this->assign('option', $this->option);
		$this->insert_content();
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