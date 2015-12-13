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
/*		$is_edit = I('get.is_edit',0);
        if(!empty($is_edit)){
            $this->assign("status", 1);
        }*/
        $map['article.site_id'] = session('site_id');
        $data = D('article')->Image_text_widget_article_list($map);
        $this->assign("data",$data);
        $this->assign('controller_id',I('id'));
		$this->display('panel/'.'image_text');
	}
	public function index()
	{
		
		$this->insert_content();
	}

}

?>