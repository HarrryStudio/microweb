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

    public function controller($is_edit){
        $album = D('Album');
        $album_list = $album -> get_album_list(session('site_id'));
        $this -> assign('album_list',$album_list);
        $this->assign("status", $is_edit);//±à¼­(1)ORÌí¼Ó(0)
        $this->display("Panel/picturesShow");
    }

    public function get_theme_list(){

    }

    public function filter_theme_template($theme){
        return $theme;
    }

    public function index(){
        $photo = D("Picture");
        $pic = $photo -> getPicture($this->resource);
        $this -> assign("frist_img",$pic[0]["savepath"].$pic[0]["savename"]);
        $this -> assign("pic_list",$pic);
        $this -> assign("type",$this->option["type"]);
        $this -> assign("title",$this->option["title"]);
        $this -> assign("controllerName",$this->name);
        $this -> insert_content();
    }

}
?>