<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 留言
 *gao
 */
class MessageController extends BaseController {
    public function index(){
    	$res = D("Message")->index();
    	// var_dump($res);
    	$this->init_head("留言",3,1,1);
    	$this->assign("list",$res);
    	$this->display();
    }

    public function talk(){
    	$data['user_id'] = session("user_info")['id'];
    	$data['content'] = I("post.text");
    	$data['way'] = 0;
    	$data['time'] = time();
    	$res = M("message")->data($data)->add();
    	$this->ajaxReturn($res);
    }
}
