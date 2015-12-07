<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/12/1
 * Time: 20:27
 */

namespace Home;
use Think\Controller;
use Think\Think;

class Widget extends Controller{

    protected $thme = null;

    protected $resource = null;

    protected $option = null;

    public $name = "";

    public function __construct($theme,$resource,$option) {
        $this->view     = Think::instance('Think\View');
        $this->theme    = $theme;
        $this->resource = $resource;
        $this->option   = $option;
    }


//    public function assign($name,$value=''){
//        if(is_array($name)) {
//            $this->tVar   =  array_merge($this->tVar,$name);
//        }else {
//            $this->tVar[$name] = $value;
//        }
//    }


    public function insert_content($content = null){
        $Template = Think::instance('Think\\Template');
        $templateFile = $this->loadtemplet($this->theme);
        if('php' == strtolower(C('TMPL_ENGINE_TYPE'))) { // 使用PHP原生模板
            $_content   =   $content;
            // 模板阵列变量分解成为独立变量
            extract($this->tVar, EXTR_OVERWRITE);
            // 直接载入PHP模板
            empty($_content)?include $templateFile:eval('?>'.$_content);
        }else{
            // 视图解析标签
            $Template->fetch($templateFile,$this->view->tVar,C('TMPL_CACHE_PREFIX'));
        }
    }

    public function get_josn(){
        return json_encode(
            array(
                'name'     =>  $this->name,
                'theme'    =>  $this->theme,
                'resource' =>  $this->resource,
                'config'   =>  $this->config
            )
        );
    }


    public function loadtemplet($template){
        $template_name = C('WIDGET_TEMPLATE_ROOT').$this->name."/".$template.C('WIDGET_TEMPLATE_SUFFIX');
        $dir_name = C('WIDGET_PUBLIC_ROOT').$this->name;
        $data = [];
        if(is_dir($dir_name)){
            if(is_dir($dir_name."/js")){
                if ($dh = opendir($dir_name."/js")) {
                    while (($file = readdir($dh)) !== false) {
                        $data['js'] = $file;
                        //$data['public'] .= '<script type="text/javascript" src="'.$file.'"></script>'."\n";
                    }
                    closedir($dh);
                }
            }
            if(is_dir($dir_name."/css")){
                if ($dh = opendir($dir_name."/css")) {
                    while (($file = readdir($dh)) !== false) {
                        $data['css'] = $file;
                        //$data['public'] .= '<link rel="stylesheet" type="text/css" href="'.$file.'">'."\n";
                    }
                    closedir($dh);
                }
            }
        }
        return $data;
    }



}
