<?php
/**
 * Created by PhpStorm.
 * User: 杨亚东
 * Date: 2015/12/10
 * Time: 18:15
 */

namespace Home\Widget;
use Home\Widget;

class BannerWidget extends Widget
{
    public function __construct($theme,$resource,$config) {
        parent::__construct($theme,$resource,$config);
        $this->name = "Banner";
        $this->theme = 'banner';
    }

    public function controller($is_edit){
        $this -> assign("controllerName",$this->name);
        $is_edit = I('get.is_edit',0);
        if(!empty($is_edit)){
            $this->assign("status", 1);
        }
        $album_id = I('album_id');
        $json_data = I("post.json_data");
        if(!empty($album_id)){//请求数据(模板里的)
            $photo = D("Picture");
            $pic = $photo -> getPicture($album_id);
            $this->ajaxReturn($pic);
        }elseif(!empty($json_data)){ //返回页面(ifrom里的)
            $this -> assign("url",$json_data["resource"]);
//            $html = $this -> fetch('Widget/Banner:banner');
//            $this->ajaxReturn($html);
            $this -> index();
        }else{//显示模板
            $album = D('Album');
            $album_list = $album -> get_album_list(session('site_id'));
            $this -> assign('album_list',$album_list);
            $photo = D("Picture");

//            if(){
//                $album_id = $album_list[0]['id'];
//            }else{
//                $album_id =
//            }
//            $pic = $photo -> getPicture($album_id);

            $pic = $photo -> getPicture($album_list[0]['id']);
            $this -> assign('album_pic',$pic);
            $this->display("Panel/banner");
        }
    }

    public function get_theme_list(){

    }

    public function filter_theme_template($theme){
        return $theme;
    }

    public function index(){
        $this -> insert_content();
    }
}