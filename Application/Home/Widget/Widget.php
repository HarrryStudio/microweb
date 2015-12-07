<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/12/1
 * Time: 20:27
 */

namespace Think\Home;


class Widget {

    protected $thme = null;

    protected $resource = null;

    protected $view = null;

    public $tVar = array();

    public public function __construct($theme,$resource) {
        $this->view     = Think::instance('Think\\Template');
        $this->theme    = $theme;
        $this->resource = $resource;
    }


    public function assign($name,$value=''){
        if(is_array($name)) {
            $this->tVar   =  array_merge($this->tVar,$name);
        }else {
            $this->tVar[$name] = $value;
        }
    }


    public function show($templateFile){
        if('php' == strtolower(C('TMPL_ENGINE_TYPE'))) { // 使用PHP原生模板
            $_content   =   $content;
            // 模板阵列变量分解成为独立变量
            extract($this->tVar, EXTR_OVERWRITE);
            // 直接载入PHP模板
            empty($_content)?include $templateFile:eval('?>'.$_content);
        }else{
            // 视图解析标签
            $this->view->fetch("",$this->tVar,C('TMPL_CACHE_PREFIX'));
        }
    }
} 