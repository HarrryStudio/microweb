<?php
/**
 * Created by PhpStorm.
 * User: ั๎ัวถซ
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
    }

    public function controller($is_edit){
        $album = D('Album');
        $album_list = $album -> get_album_list(session('site_id'));
        $this -> assign('album_list',$album_list);
        $this->assign("status", $is_edit);
        $this->display("Panel/viwePager");
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
        $this -> assign("pic_num",count($pic));
//            $this -> assign("title",$json_data["option"]["title"]);
//        $this -> assign("type",$json_data["option"]["type"]);
        $this -> assign("type",$this->option["type"]);
        $this -> assign("controllerName",$this->name);
        $this->insert_content();
    }
}
?>