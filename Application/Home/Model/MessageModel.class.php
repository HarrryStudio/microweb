<?php
namespace Home\Model;
use Think\Model;
/**
*gao
*/
class MessageModel extends Model{
	public function index(){
		$account = session("user_info")['account'];
		$UserInfo = M("user_info as u");
		$count = $UserInfo->where("u.account='".$account."'")->count();
		if ($count > 50) {
			$limit = $count - 50;
		} else {
			$limit = 0;
		}
		$list = $UserInfo
			->join("right join message as m on u.id=m.user_id")
			->field("u.head_img as img,u.account,m.way as way,m.time,m.content")
			->where("u.account='".$account."'")
			->limit($limit, 50)
			->select();
		return $list;
	}




/*	public function index(){
		$account = session("user_info")['account'];
		$UserInfo = M("user_info as u");
		$count = $UserInfo->count();
		$list = $UserInfo
			->join("right join message as m on u.id=m.user_id")
			->field("u.head_img as img,u.account,m.way as way,m.time,m.content")
			->where("u.account='".$account."'")
			->limit($count, 50)
			->select();
			return $UserInfo->getLastSql();
		// return $list;
	}*/
}
?>