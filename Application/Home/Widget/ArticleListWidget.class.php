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

  function __construct($theme,$resource,$config)
  {
    parent::__construct($theme,$resource,$config);
    $this->name = 'article_list';
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
    $this->assign('controller_id',I('id'));
    $this->assign('type_list',$type_list);
    

    //$this->display('panel/'.$this->name);
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
