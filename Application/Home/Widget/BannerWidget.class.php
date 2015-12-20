<?php
/**
 * Created by PhpStorm.
 * User: ���Ƕ�
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
    }

    public function controller($site_id,$data){
        $album = D('Album');
        $album_list = $album -> get_album_list(session('site_info')['id']);
        $this -> assign('album_list',$album_list);
        $photo = D("Picture");
        if(!empty($data)){
            $pic = $photo -> getPicture($data["option"]['albumId']);
            $this->assign("status",true);
            $this->assign("primary_album",$data["option"]['albumId']);
            $this->assign("primary_pic",$data["option"]['img_id']);
        }else{
            $pic = $photo -> getPicture($album_list[0]['id']);
            $this->assign("primary_album",$album_list[0]['id']);
            $this->assign("primary_pic",$pic[0]['id']);
        }
        $this -> assign('album_pic',$pic);
        $this->display("Panel/banner");
    }

    public function get_theme_list(){

    }

    public function filter_theme_template($theme){
        return $theme;
    }

    public function index($site_id,$dynamic = false){
        $this -> assign("controllerName",$this->name);
        $this -> assign("url",$this->resource);
        $this->insert_content($dynamic);
    }
}