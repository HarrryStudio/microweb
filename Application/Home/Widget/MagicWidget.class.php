<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/12/1
 * Time: 20:27
 */

namespace Home\Widget;
use Home\Widget;

class MagicWidget extends Widget
{
    public function __construct($theme,$resource,$config) {
        parent::__construct($theme,$resource,$config);
        $this->name = "Magic";
    }

    public function controller($site_id,$data){
        $theme_list = $this->get_theme_list();
        if(!empty($data)){
            $this->assign("now_theme",$data['theme']);
            $this->assign("status",true);
        }
        $this->assign("theme_list",$theme_list);
        $this->assign("theme",$this->theme);
        $this->display("Panel/magic");
    }

    public function get_theme_list(){

    }


    public function index($site_id,$dynamic = false){
        $nav_list = D('UserColumn')->get_nav_list($site_id);
        $this->assign('nav_list',$nav_list);
        $this->assign('cname',$this->name);
        $this->assign('theme',$this->theme);
        $this->insert_content($dynamic);
    }

    public function filter_theme_link($theme){
        return $theme."_nav";
    }

    public function filter_theme_template($theme){
        return "one";
    }


}
