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

    public function controller($is_edit){
        $theme_list = $this->get_theme_list();

        $this->assign("theme_list",$theme_list);
        $this->assign("is_edit",$is_edit);

        $this->display("Panel/magic");
    }

    public function get_theme_list(){

    }


    public function index(){
        $nav_list = D('UserColumn')->get_nav_list();
        $this->assign('nav_list',$nav_list);
        $this->loadtemplet($this->choose_template($data['theme']));
    }

    public function choose_template($theme_name){
        return "one";
    }


}
