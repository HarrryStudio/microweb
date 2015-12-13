<?php
namespace Home\Widget;
use Home\Widget;
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
    $this->name = 'ArticleList';
  }

  public function controller($is_edit)
  {
/*    if(!empty($is_edit)){
        $this->assign("status",1);
    }*/
    
    $Type = M('type');
    $map['site_id'] = session('site_id');
    $type_list = $Type->field('id, name')->where($map)->select();
    
    $Column = M('user_column');
    $column_list = $Column->where($map)->select();
    
    $this->assign("column_list", $column_list);
    $this->assign('controller_id', I('id'));
    $this->assign('type_list', $type_list);
    //$this->assign('option', $option);
    $this->display('panel/article_list');
  }

  public function index()
  {
    if (I('post.type')[0] == 0) {

    } else {
        $map['article.type_id'] = array(in, I('post.type'));
    }
    $article_info = D('article')->article_widget_list($map);
    $this->assign("article_info", $article_info);
    $this->assign('cname', $this->name);
    $this->assign('option', $this->option);
    $this->insert_content(); 
  }

  public function get_theme_list()
  {
    return $theme;
  }

  public function filter_theme_link($theme){
    return $theme.'_article_list';
  }

  public function filter_theme_template($theme){
    return $theme;
  }

}



 ?>
