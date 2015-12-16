<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 前台基类
 */
class BaseController extends Controller {
    final public function _initialize(){
        if(IS_GET){
            $_POST = $_GET;
        }
        //判断是否登录
        if(!is_login()){
        	// $this->redirect('Login/login',null, 3, '跳转到登录页面...');
            $this->redirect('Login/login');
        }
    }

    /**
     * 初始化head信息
     * @param title 		: 网页title321
     *        primary_index : 一级导航索引
     *        senior_index  : 二级导航索引
     *        nav_index     : 三级导航索引
     */
    public function init_head($title = "微网站生成系统",$primary_index = 1,$senior_index = 1,$nav_index = 1){
    	$this->assign("meta_title", $title);
    	$this->assign("primary_index", $primary_index);
    	$this->assign("senior_index", $senior_index);
    	$this->assign("nav_index", $nav_index);
        $this->assign("head_img", session('user_info.head_img'));
    }


    /**
     * 空方法
     * 访问不存在方法显示404图片
     */
    public function _empty(){
        echo "<img src='" . IMAGES . '/404.gif' . "' style='margin:10% 28%;' />";
    }
}