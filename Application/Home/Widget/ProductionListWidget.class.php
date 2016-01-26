<?php
/**
 * User: lingduanhua
 * Date: 2016/1/25
 * Time: 14:47
 */
namespace Home\Widget;
use Home\Widget;

class ProductionListWidget extends Widget{
    public function __construct($theme,$resource,$config) {
        parent::__construct($theme,$resource,$config);
        $this->name = "productionList";
    }

    public function controller($site_id,$data){
        $this->display("Panel/production_list");
    }

    public function filter_theme_template($theme){
        return $theme;
    }

    public function index($site_id,$dynamic = false){

    }
}
