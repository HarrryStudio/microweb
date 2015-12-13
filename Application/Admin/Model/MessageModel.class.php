<?php 
namespace Admin\Model;
use Think\Model;
	
class MessageModel extends BaseModel{


//默认留言首页查询数据及分页功能
	/**
	 * 亚东学长的
	 */
/*	public function index($condition="",$type=""){
		$sql = "SELECT m.*,u.nickname AS NAME, u.account AS ac FROM message AS m RIGHT JOIN user_info AS u ON m.user_id=u.id";
		if (!empty($condition)) {
			$sql .= " where m.id like '%".$condition."%'";
		}
		if (!empty($type) && $type!= 2) {
			$sql .= " where m.way like '%".$type."%'";
		}
		if ($type==2) {
			$sql .= " where m.way = 0";
		}
		$value = M("message")->query($sql);
		$Page = new \Think\Page(count($value),10);
		$sql .= " limit ".$Page->firstRow.",".$Page->listRows;
		$list['value'] = M("message")->query($sql);
		$list["show"] = $Page->show();

		return $list;
	}*/
	/**
	 * 修改后的
	 * @param  string $condition [description]
	 * @param  string $type      [description]
	 * @return [type]            [description]
	 */
	public function index($condition="",$type=""){
		// $sql = "SELECT * FROM(SELECT * FROM message ORDER BY message.time desc)  message INNER JOIN user_info GROUP BY user_id ORDER BY message.time desc";
		$sql = "SELECT message.*,user_info.account , user_info.nickname FROM message inner join (SELECT user_id , max(time) as time FROM message group by user_id) as a on a.user_id = message.user_id and a.time = message.time  INNER JOIN user_info ON message.user_id=user_info.id WHERE user_info.status=0";
		if (!empty($condition)) {
			$sql .= " and (message.id like '%".$condition."%'";
			$sql .= " or user_info.account like '%".$condition."%'";
			$sql .= " or user_info.nickname like '%".$condition."%')";


		}
		if (!empty($type) && $type!= 2) {
			$sql .= " and message.way=".$type;
		}
		if ($type==2) {
			$sql .= " and message.way = 0";
		}
		//$sql .= "  GROUP BY user_id ORDER BY user_info.id,message.time DESC";
		$value = M("message")->query($sql);

		$Page = new \Think\Page(count($value),10);
		$sql .= " limit ".$Page->firstRow.",".$Page->listRows;
		$list['value'] = M("message")->query($sql);
		$list["show"] = $Page->show();
		return $list;
	}

	public function details($user_id=""){
		$map['user_id'] = $user_id;
		$model = M();
		$list = $model->table("message m left join user_info u on m.user_id=u.id")
			->field("m.id,m.way,m.time,m.content,u.nickname as name,u.head_img as img")
			->where($map)->order("time asc")->limit(50)->select();
		return $list;
	}

}
?>