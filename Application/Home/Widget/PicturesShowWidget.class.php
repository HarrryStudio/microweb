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
        $this -> theme ="PicturesShow";
    }

    public function controller(){
        $this -> assign("controllerName",$this->name);
        $is_edit = I('get.is_edit',0);
        if(!empty($is_edit)){
            $this->assign("status", 1);
        }
        $json_data = I("post.json_data");
        if(!empty($json_data)){
            $photo = D("Picture");
            $pic = $photo -> getPicture($json_data['resource']);
            $this -> assign("frist_img",$pic[0]["savepath"].$pic[0]["savename"]);
            $this -> assign("pic_list",$pic);
            $this -> assign("type",$json_data["option"]["type"]);
            $this -> assign("title",$json_data["option"]["title"]);
            $this -> index();
        }else{  //»ñµÃÍ¼²áÃû
            $album = D('Album');
            $album_list = $album -> get_album_list(session('site_id'));
            $this -> assign('album_list',$album_list);
            $this->display("Panel/picturesShow");
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
?>