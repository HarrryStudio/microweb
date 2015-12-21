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

  public function controller($site_id, $data)
  {
    if (!empty($data)) {
      $this->assign('status',1);
      $this->assign('now_theme', $data['theme']);
    }
    $Type = M('article_type');
    $map['site_id'] = $site_id;
    $type_list = $Type->field('id, name')->where($map)->select();
    $column_list = M('user_column')->where($map)->select();
    $this->assign("column_list", $column_list);
    $this->assign('type_list', $type_list);
    $this->assign('theme_list', $this->get_theme_list());
    $this->display('panel/article_list');
  }

  public function index($site_id,$dynamic = false)
  {
    if (!I('post.type')[0] == 0) {
        $map['article.type_id'] = array(in, I('post.type'));
    }
    $map['site_id'] = $site_id;
    $article_info = D('article')->article_widget_list($map);
    $this->assign("article_info", $article_info);
    $this->assign('cname', $this->name);
    $this->assign('option', $this->option);
    $this->insert_content($dynamic); 
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
