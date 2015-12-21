<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/12/1
 * Time: 20:27
 */

namespace Home\Widget;
use Home\Widget;

class PicturesShowWidget extends Widget
{
    public function __construct($theme,$resource,$config) {
        parent::__construct($theme,$resource,$config);
        $this->name = "PicturesShow";
    }

    public function controller($site_id,$data){
        $album = D('Album');
        $album_list = $album -> get_album_list(session('site_info')['id']);
        $this -> assign('album_list',$album_list);
        $theme = M("controller")
            -> field("picture.savepath,picture.savename,theme.name")
            -> join("theme ON controller.id=theme.controller_id")
            -> join("picture ON picture.id=theme.pic_id")
            -> where("theme.status=0 and controller.cname='PicturesShow'")
            -> select();
        $this -> assign('theme',$theme);
        if(!empty($data)){
            $this->assign("status",true);
            $this->assign("title",$data['option']['title']);
            $this->assign("primary_album",$data["resource"]);
            $this->assign("primary_type",$data["option"]['type']);
        }else{
            $this->assign("title",'图片展示');
            $this->assign("primary_album",$album_list[0]['id']);
            $this->assign("primary_type",$theme[0]['name']);
        }
        $this->display("Panel/picturesShow");
    }

    public function get_theme_list(){

    }

    public function filter_theme_template($theme){
        return $theme;
    }

    public function index($site_id,$dynamic = false){
        $photo = D("Picture");
        $pic = $photo -> getPicture($this->resource);
        $this -> assign("frist_img",$pic[0]["savepath"].$pic[0]["savename"]);
        $this -> assign("pic_list",$pic);
        $this -> assign("type",$this->option["type"]);
        $this -> assign("title",$this->option["title"]);
        $this -> assign("controllerName",$this->name);
        $this->insert_content($dynamic);
    }

}
?>