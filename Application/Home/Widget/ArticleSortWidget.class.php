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

  public function controller($site_id,$data)
  {
    $theme_list = $this->get_theme_list();
    if (!empty($data)) {
      $this->assign('status',1);
      $this->assign('now_theme',$data['theme']);
    }
    $map['site_id'] = $site_id;
    $type_list = D('ArticleType')->get_type_list($map);
    $column_list = D('UserColumn')->get_user_column($map);
    if (empty($column_list)) {
        $column_list[0]['id'] = 1;
        $column_list[0]['name'] = "新闻动态";
    };
    $this->assign('theme_list',$theme_list);
    $this->assign('type_list',$type_list);
    $this->assign('column_list',$column_list);
    $this->assign('controller_id',I('id'));
    $this->display('Panel/article_sort');
  }

  public function index($site_id,$dynamic = false)
  {
    $Type = D('ArticleType');
    $info = $this->option['info'];
    $sort_ids;
    foreach ($info as $item_key => $item) {
      $sort_ids[] = $item['id'];
    }
    $map['id'] = array('in', $sort_ids);
    $type_list = $Type->get_type_list($map);
    foreach ($type_list as $item_key => $item) {
      foreach ($info as $key => $value) {
        if ($item['id'] == $value['id']) {
          $type_list[$item_key]['column_url'] = $value['column_url'];
          $type_list[$item_key]['column_id'] = $value['column_id'];
        }
      }
    }
    $this->option['info'] = $type_list;
    $this->assign('cname', $this->name);
    $this->assign('theme', $this->theme);
    $this->assign('option',$this->option);
    $this->insert_content($dynamic);
  }

  public function get_theme_list()
  {
    return $this->$theme;
  }

  public function filter_theme_link($theme){
    return $theme.'_article_sort';
  }

  public function filter_theme_template($theme){
    return 'first';
  }

}



 ?>
