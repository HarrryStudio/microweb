<?php
namespace Admin\Model;
use Think\Model;

class StationModel extends BaseModel{

//查询产品数据库
	public function produce()
	{
		$table = M("production as p")
			->join(" left join site_info as s on p.site_id = s.id")
			->join(" left join home_picture as h on p.pic_id = h.id")
			->join(" left join production_type as pt on p.type = pt.id")
			->field(" s.site_name,p.id,p.name,p.pic_id,p.desc,p.url,p.price,p.status,p.creat_time,h.savepath,h.savename,pt.name as typename")
			->where(" p.status=0 and s.site_name like '%".$_GET['nickname']."%' or p.status=0 and p.name like '%".$_GET['nickname']."%'");
		$data['info'] = $table->page($_GET['p'].',10')->select();
		for($i=0; $i < count($data['info']); $i++){
			$data['info'][$i]["status"] = "删除";
		}
		// 查询满足要求的总记录数
		$count = $table->count();
        $Page  = new \Think\Page($count,10);            // 实例化分页类 传入总记录数和每页显示的记录数
        $data['show']  = $Page->show();                     // 分页显示输出
		return $data;
	}


}

?>