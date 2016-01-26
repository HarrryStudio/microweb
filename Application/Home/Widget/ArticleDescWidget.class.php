<?php
namespace Home\Widget;
use Home\Widget;
/**
 * 文章列表控件
 * Created by zhangbo
 * data 2015 12 7
 * 文章列表控件
 */
class ArticleDescWidget extends Widget
{

  function __construct($theme,$resource,$option)
  {
    parent::__construct($theme,$resource,$option);
    $this->name = 'ArticleDesc';
    $this->theme = 'article';
  }

  public function controller($site_id, $data)
  {
    // if (!empty($data)) {
    //   $this->assign('option', $data['option']);
    //   $this->assign('theme', $data['theme']);
    // }
    // $map['site_id'] = $site_id;
    $this->assign('resource_id', $this->resource);
    $this->display('Panel/article_desc');
  }

  public function index($site_id,$dynamic = false,$article_info)
  {
    $article_info = $article_info ? $article_info : $this->get_resource_info();
    $this->assign("article_info", $article_info);
    $this->assign('option', $this->option);
    $this->insert_content($dynamic);
  }

  public function get_resource_info(){
      return D('article')->get_article_info($site_id,$this->resource);
  }

}
 ?>
