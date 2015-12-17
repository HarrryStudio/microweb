<?php
namespace Home\Widget;
use Home\Widget;

class ArticleSortWidget extends Widget
{

  function __construct($theme,$resource,$option)
  {
    parent::__construct($theme,$resource,$option);
    $this->name = 'ArticleSort';
  }

  public function controller($is_edit)
  {
/*    $is_edit = I('get.is_edit',0);
    if(!empty($is_edit)){
        $this->assign("status",1);
    }*/
    $Type = M('type');
    $is_edit = I('get.is_edit',0);
    $map['site_id'] = session('site_id');
    $type_list = $Type->field('id, name')
    ->where($map)->select();
    $User_column = M('user_column');
    $column_list = $User_column->where($map)->select();
    if (empty($column_list)) {
        $column_list[0]['id'] = 1;
        $column_list[0]['name'] = "新闻动态";
    };
    $this->assign('type_list',$type_list);
    $this->assign('column_list',$column_list);
    $this->assign('controller_id',I('id'));
    $this->display('panel/article_sort');
  }

  public function index()
  {
    var_dump($this->option);
    $this->assign('option', $this->option);
    $this->insert_content(); 
  }

  public function get_theme_list()
  {
    return $theme;
  }

  public function filter_theme_link($theme){
    return $theme.'_article_sort';
  }

  public function filter_theme_template($theme){
    return 'first';
  }

}



 ?>
