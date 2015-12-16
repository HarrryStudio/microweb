<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 主页
 */
class IndexController extends Controller {
    public function index(){
    	// $this->init_head("lingduanhua");
    	$this->display();
    }
}