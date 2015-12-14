<?php
/**
 * Created by PhpStorm.
 * User: ÑîÑÇ¶«
 * Date: 2015/12/10
 * Time: 18:15
 */

namespace Home\Widget;
use Home\Widget;

class NoticeWidget extends Widget
{
    public function __construct($theme,$resource,$config) {
        parent::__construct($theme,$resource,$config);
        $this->name = "Notice";
        $this -> theme = "notice";
    }

    public function controller($is_edit){
        $this -> assign("controllerName",$this->name);
        $is_edit = I('get.is_edit',0);
        $json_data = I("post.json_data");
        if(!empty($is_edit)) {
            $this->assign("status", 1);
        }
        if(!empty($json_data)){
            $this -> assign("popupCon",$json_data['resource']);
            $this -> assign("title",$json_data['option']['title']);
            $this -> assign("url",$json_data['option']['icon']);
            $this -> assign("NoticeType",$json_data['option']['type']);
            $this -> index();
        }else{
            $this->display("Panel/notice");
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