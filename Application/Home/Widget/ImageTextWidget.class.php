<?php
namespace Home\Widget;
use Home\Widget;

/**
* 
*/
class ImageTextWidget extends Widget
{
	
	function __construct($theme,$resource,$config)
	{
		parent::__construct($theme,$resource,$config);
		$this->name = 'image_text';
	}

	public function controller()
	{
/*		        $is_edit = I('get.is_edit',0);
		        if(!empty($is_edit)){
		            $this->assign("status", 1);
		        }*/
		        $map['article.site_id'] = session('site_id');
		        $Article = M('article');
		        $count = $Article->where($map)->count();
		        $Page = new \Think\Page($count,5);
		        $show = $Page->show();
		        $article_list = $Article
		        ->join('JOIN picture on picture.id = article.pic_id')
		        ->where($map)
		        ->field('article.id, article.title, article.content, picture.savepath, picture.savename')
		        ->order('article.is_top desc, article.create_time desc')
		        ->limit($Page->firstRow.','.$Page->listRows)
		        ->select();
		        foreach ($article_list as $key => $value) {
		            foreach ($value as $k => $val) {
		                if($k == "content"){
		                    $article_list[$key][$k] = htmlspecialchars_decode($val);
		                }
		            }
		        }
		        $p = I('get.p');
		        if (!empty($p)) {
		            $data['article_list'] = $article_list;
		            $data['page'] = $show;
		            $this->ajaxReturn($data);
		        }
		        $this->assign("article_list",$article_list);
		        $this->assign("page",$show);
		        $this->assign('controller_id',I('id'));
		$this->display('panel/'.$this->name);
	}

	public function index()
	{
		
		// 就跟 controller 的 index的一样
	}

/*	public function insert_content()
	{
		// Panel 里 会调用这个方法去获取 widget 插入到手机面板里的html
		// 平时用的$this->display()  就改成 $this->insert_content()
	}*/
}

?>