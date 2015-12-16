<?php
namespace Admin\Controller;
use Think\Controller;

/**
* 微站管理
*/
class StationController extends BaseController{
	
	public function index(){
		$this->assign("meta_title","微站列表");
		$sql = "SELECT s.*, u.nickname AS NAME, u.account AS ac FROM site_info AS s JOIN user_info AS u ON s.user_id=u.id WHERE u.status=0 and s.site_name like '%".$_GET['nickname']."%' or u.status=0 and s.id like '%".$_GET['nickname']."%' or u.status=0 and u.nickname like '%".$_GET['nickname']."%'";
		$res = M("site_info")->query($sql);
		$Page = new \Think\Page(count($res),10);
		$sql .= " limit ".$Page->firstRow.",".$Page->listRows;
		$res = M("site_info")->query($sql);
		$show = $Page->show();
		$this->assign("list", $res);
		$this->assign("_page", $show);
		$this->display();
	}
}

?>