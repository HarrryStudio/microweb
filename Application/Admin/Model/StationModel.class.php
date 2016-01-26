<?php
namespace Admin\Model;
use Think\Model;

class StationModel extends BaseModel{

//查询产品数据库
	public function produce()
	{
		$info = M("production as p")->join("site_info as s on p.site_id = s.id")
		->field("s.site_name,p.name,p.type,p.pic_id,p.desc,p.url,p.price,p.status,p.creat_time")
		->page($_GET['p'].',10')
		->select();
		for($i=0; $i < count($info); $i++){
			$info[$i]["desc"] = mb_strimwidth($info[0]["desc"], 0, 30,"...","utf-8");
		}
		return $info;
	}


}

?>