<?php
/**
 * Created by PhpStorm.
 * User: 杨亚东
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

    public function controller($site_id,$data){
        if(!empty($data)){
            $this->assign("status",true);
            $this->assign("popup",$data['resource']);
            $this->assign("title",$data['option']['title']);
            $this->assign("type",$data['option']['type']);
            $this->assign("icon",$data['option']['icon']);
        }else{
            $this->assign("title",'滚动公告');
        }
        $this->display("Panel/notice");
    }

    public function get_theme_list(){

    }

    public function filter_theme_template($theme){
        return $theme;
    }

    public function index($site_id,$dynamic = false){
        $this -> assign("controllerName",$this->name);
        $this -> assign("popupCon",$this->resource);
        $this -> assign("title",$this->option['title']);
        $this -> assign("url",$this->option['icon']);
        $this -> assign("NoticeType",$this->option['type']);
        $this->insert_content($dynamic);
    }
}