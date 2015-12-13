<?php
namespace Admin\Controller;
use Think\Controller;

/*
*后台首页
*/
class IndexController extends BaseController {

//后台首页图表信息显示
    public function index(){
    	$list['team'] = M("admin_info")->where('status=0')->field("id")->count();//团队人数
    	$list['user'] = M("user_info")->where("status=0")->field("id")->count();//用户数
    	$list['site'] = M("site_info")->where("status=0")->field("id")->count();//网站数
    	$list['article'] = M("article")->where("status=0")->field("id")->count();//文章数
    	$list['cont'] = M("controller")->where("status=0")->field("id")->count();//控件数
    	$this->meta_title = '首页信息';
		$this->assign("list", $list);
    	$this->display();
    }
}