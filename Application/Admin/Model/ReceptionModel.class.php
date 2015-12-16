<?php
namespace Admin\Model;
use Think\Model;

class ReceptionModel extends BaseModel{

	public function index(){
		$model = M(); 
		$list = $model->table("background b left join picture p on b.pic_id=p.id")
		   ->field("b.id,b.name,p.savename,p.savepath,p.update_time")
		   ->where("b.status=0")->select();
		return $list;
	}

	public function theme(){
		$model = M();
		$list = $model->table("theme as t left join picture as p on t.pic_id=p.id")
			->field("t.update_time,t.addr, t.id, p.savepath, p.savename")
			->where("t.status=0")->select();
		return $list;
	}

}
?>