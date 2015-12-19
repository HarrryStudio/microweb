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
    $map['site_id'] = session('site_info.id');
    $type_list = D('ArticleType')->get_type_list($map);
    $column_list = D('UserColumn')->get_user_column($map);
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
    $Type = D('ArticleType');
    $type_list = $Type->get_type_list();
    // $this->assign('option', $this->option);
    $this->assign('option', "asdfasdfs");
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
