<?php
/**
 * Created by PhpStorm.
 * User: ���Ƕ�
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
        $id = I("id");      //�ؼ�id
        $this -> assign("controllerId",$id);
        $is_edit = I('get.is_edit',0);
        if(!empty($is_edit)){       //�ж��Ƿ�Ϊ�༭
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