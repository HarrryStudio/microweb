<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 资源
 */
class ResourceController extends BaseController {
    protected $site_info = null;
    final public function _initialize(){
        parent::_initialize();
        if(!is_choose_site()){
            $this->redirect('Website/Index');
        }
        $this->site_info = session("site_info");
    }
}
