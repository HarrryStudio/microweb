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

    protected $theme = null;

    protected $resource = null;

    protected $option = null;

    public $name = "";

    public function __construct($theme = "", $resource = "", $option = "") {
        $this->view     = Think::instance('Think\View');
        $this->theme    = $theme;
        $this->resource = $resource;
        $this->option   = $option;
    }

    public function index($site_id,$dynamic = false){
        echo "I'm a widget to insert into phonepage";
    }


    public function controller($site_id,$data){
        echo "I'm a html to show on iframe";
    }


//    public function assign($name,$value=''){
//        if(is_array($name)) {
//            $this->tVar   =  array_merge($this->tVar,$name);
//        }else {
//            $this->tVar[$name] = $value;
//        }
//    }


    public function insert_content($dynamic = false){
        $Template = Think::instance('Think\\Template');
        $templateFile = $this->load_template_file();
        if($dynamic){
            $this->export_theme_link($this->name,$this->theme);
        }
        // 视图解析标签
        $Template->fetch($templateFile,$this->view->get(),C('TMPL_CACHE_PREFIX'));
    }

    public function get_json(){
        return
            array(
                'name'     =>  $this->name,
                'theme'    =>  $this->theme,
                'resource' =>  $this->resource,
                'option'   =>  $this->option
            );

    }

    public function filter_theme_template($theme){
        return $theme;
    }


    public function filter_theme_link($theme){
        return $theme;
    }


    public function load_template_file($name,$theme){
        $name = $name ? $name : $this->name;
        $theme = $theme ? $theme : $this->theme;
        $theme = $this->filter_theme_template($theme);
        $template_name = C('WIDGET_TEMPLATE_ROOT').$name."/".$theme.C('WIDGET_TEMPLATE_SUFFIX');
        return $template_name;
    }

    /**
     * @param $name 空间名
     * @return $array js,css
     */
    public function load_template_link($name,$theme){
        $name = $name ? $name : $this->name;
        $theme = $theme ? $theme : $this->theme;
        $theme = $this->filter_theme_link($theme);
        $root = C('WIDGET_PUBLIC_PATH');
        if(file_exists(".".$root."public.js")){
            $data["js"][] = __ROOT__.$root."public.js";
        }
        if(file_exists(".".$root."public.css")){
            $data["css"][] = __ROOT__.$root."public.css";
        }
        $widget = $root.$name."/";
        if(is_dir(".".$widget)){
            if(is_dir(".".$widget."js")){
                if(file_exists(".".$widget."js/public.js")){
                    $data["js"][] = __ROOT__.$widget."js/public.js";
                }
                if(file_exists(".".$widget."js/".$theme.".js")){
                    $data["js"][] = __ROOT__.$widget."js/".$theme.".js";
                }
            }
            if(is_dir(".".$widget."css")){
                if(file_exists(".".$widget."css/public.css")){
                    $data["css"][] = __ROOT__.$widget."css/public.css";
                }
                if(file_exists(".".$widget."css/".$theme.".css")){
                    $data["css"][] = __ROOT__.$widget."css/".$theme.".css";
                }
            }
        }
        return $data;
    }

    public function export_theme_link($name,$theme){
        $data = $this->load_template_link($name,$theme);
        echo '<script type="text/javascript">';
        // foreach( $data['css'] as $value ){
        //     echo '<link rel="stylesheet" type="text/css" href="'.$value.'" media="all" title="no title" charset="utf-8">';
        // }
        // foreach( $data['js'] as $value ){
        //     echo '<script type="text/javascript" src="'.$value.'"></script>';
        // }
        foreach( $data['css'] as $value ){
            echo 'dynamicLoading.css("'.$value.'");';
        }
        foreach( $data['js'] as $value ){
            echo 'dynamicLoading.js("'.$value.'");';
        }

        foreach ($data['js'] as $value) {
            echo 'dynamicLoading.js("'.__ROOT__.$value.'");';
        }
        echo "</script>";

    }

}
