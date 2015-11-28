<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 帮助教程
 */
class HelpController extends BaseController {
    public function index(){
        $res = M("guide") -> find();
        $this->init_head("帮助教程",4,1,1);
        $this -> assign("help",$res);
        $this -> display();
    }
}