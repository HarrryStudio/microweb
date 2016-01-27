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

//产品控制器
	public function produce()
	{
		$this->assign("meta_title","产品信息");
		$data = D("Station")->produce($_GET['nickname']);
		$this->assign("list",$data['info']);
        $this->assign('_page',$data['show']);               // 赋值分页输出
		$this->display();
	}

//获取分页
	public function getpage(){
		$count = M("production")->where("status=0")->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count,10);            // 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();                     // 分页显示输出
        return $show;
	}
//删除产品信息
	public function del_pro()
	{
		$where["id"] = $_POST["pro_id"];
		$data["status"] = 1;
		$res = M("production")->data($data)->where($where)->save();
		$data["rowNum"] = $res;
		$data["page"] = $this->getpage();
		$this->ajaxReturn($data);
	}



}

?>