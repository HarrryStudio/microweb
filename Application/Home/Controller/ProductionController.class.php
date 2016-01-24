<?php
namespace Home\Controller;
use Think\Controller;
/**
* 我的网站
*/
class ProductionController extends ResourceController
{

	/**
	* 产品列表页
	*/
	public function index()
	{
		$this->init_head("文章",1,1,2);
        $site_id = $this->site_info['id'];
        $Atrticle = D('Article');
        $result = $Atrticle->get_article_list($site_id);
        $article_list = $result['result'];
        $type_list = M('article_type')
                        ->field('id,name')
                        ->where(array('site_id'=>$site_id))
                        ->order('sort')
                        ->select();
        $this->assign('type_list', $type_list);
        $this->assign('site_id', $site_id);
        $this->assign('article_list', $article_list);
        $this->assign('search', $result['search']);
        $this->assign('page', $result['page']);
        $this->assign('now_page', I('p'));
        $this->display();
	}
}