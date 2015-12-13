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
    }

    public function controller($is_edit){
        $id = I("id");      //控件id
        $this -> assign("controllerId",$id);
        $is_edit = I('get.is_edit',0);
        if(!empty($is_edit)){       //判断是否为编辑
            $this->assign("status", 1);
        }
        $album_id = I('album_id');
        if(empty($album_id)){
            $album = D('Album');
            $album_list = $album -> get_album_list(session('site_id'));
            $this -> assign('album_list',$album_list);
            $this->display("Panel/viwePager");
        }else{
            $photo = D("Picture");
            $pic = $photo -> getPicture($album_id);
            $this->ajaxReturn($pic);
        }
    }

    public function get_theme_list(){

    }

    public function index(){
        echo "I'm widget";
    }
}
?>