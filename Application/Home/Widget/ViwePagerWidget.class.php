<?php
/**
 * Created by PhpStorm.
 * User: 杨亚东
 * Date: 2015/12/10
 * Time: 18:16
 */

namespace Home\Widget;
use Home\Widget;

class ViwePagerWidget extends Widget
{
    public function __construct($theme,$resource,$config) {
        parent::__construct($theme,$resource,$config);
        $this->name = "ViwePager";
        $this -> theme = "viwepager";
    }

    public function controller($is_edit){
        $this -> assign("controllerName",$this->name);
        $is_edit = I('get.is_edit',0);
        if(!empty($is_edit)){       //判断是否为编辑
            $this->assign("status", 1);
        }
//        $album_id = I('album_id');
        $json_data = I("post.json_data");
        if(empty($json_data)){
            $album = D('Album');
            $album_list = $album -> get_album_list(session('site_id'));
            $this -> assign('album_list',$album_list);
            $this->display("Panel/viwePager");
        }else{
            $photo = D("Picture");
            $pic = $photo -> getPicture($json_data["resource"]);
            $this -> assign("frist_img",$pic[0]["savepath"].$pic[0]["savename"]);
            $this -> assign("pic_list",$pic);
            $this -> assign("pic_num",count($pic));
//            $this -> assign("title",$json_data["option"]["title"]);
            $this -> assign("type",$json_data["option"]["type"]);
            $this -> index();
        }
    }

    public function get_theme_list(){

    }

    public function filter_theme_template($theme){
        return $theme;
    }

    public function index(){
        $this->insert_content();
    }
}
?>