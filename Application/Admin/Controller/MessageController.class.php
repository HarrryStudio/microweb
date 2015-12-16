<?php
namespace Admin\Controller;
use Think\Controller;

/**
* 留言信息管理模块
*/
class MessageController extends BaseController{

//默认留言首页查询数据
	public function index(){
		$type = I("get.type");
		$condition = I("get.nickname");
        $list = D("Message")->index($condition,$type);
        int_to_string($list);
        $this->assign('list', $list['value']);
        $this->assign('_page', $list['show']);
        $this->meta_title = '栏目信息';
		$this->display();
	}

//留言信息批量删除
	public function changeStatus(){
		$id = array_unique((array)I('id',0));
		$id = is_array($id) ? implode(',',$id) : $id;
		if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['id'] = array('in',$id);
        $res = M("message")->where($map)->delete();
        if ($res) {
			$this->success("删除成功");
        }else{
        	$this->error("对不起，删除失败");
        }
	}

//查询留言信息
	public function details(){
		$user_id = (int)I("seat");
		$res = D("Message")->details($user_id);
		$this->assign("modular", "留言空间");
		$this->assign("list", $res);
		$this->assign("user_id", $user_id);
		$this->display();
	}

//回复留言信息

	public function reply_message(){
		$data['user_id'] = I("post.id");
		$data['content'] = I("post.content");
		$data['way'] = 1;
		$data['time'] = time();
		$res = M("message")->data($data)->add();
		$this->ajaxReturn($res);
	}
}
?>