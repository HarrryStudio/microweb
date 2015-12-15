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
    }

    public function controller($is_edit){
        $this->assign("status", $is_edit);
        $this->display("Panel/notice");
    }

    public function get_theme_list(){

    }

    public function filter_theme_template($theme){
        return $theme;
    }

    public function index(){
        $this -> assign("controllerName",$this->name);
        $this -> assign("popupCon",$this->resource);
        $this -> assign("title",$this->option['title']);
        $this -> assign("url",$this->option['icon']);
        $this -> assign("NoticeType",$this->option['type']);
        $this -> insert_content();
    }
}