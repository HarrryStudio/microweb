<?php
namespace Home\Widget;
/**
 * 文章列表控件
 * Created by zhangbo
 * data 2015 12 7
 * 文章列表控件
 */
class ArticleListWidget extends Widget
{

  function __construct($theme,$resource,$option)
  {
    parent::__construct($theme,$resource,$option);
    $this->name = 'article_list';
  }

  public function controller($is_edit)
  {

    $this->display('panel/'.$this->name);
  }

  public function get_theme_list()
  {

  }





  protected function getDate()
  {

  }
  protected function detail()
  {
    
  }
}



 ?>
