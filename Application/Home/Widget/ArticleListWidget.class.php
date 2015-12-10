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
    $this->assign('controller_id',I('id'));
    $this->assign('type_list',$type_list);
    $this->display('panel/article_list');
    

    // $getType = I('get.type');

  }

  public function index()
  {

      if (I('post.type')[0] == 0) {

      } else {
          $map['article.type_id'] = array(in, I('post.type'));
      }
      $map['article.status'] = 0;
      $Article = M('article');
      $article_info = $Article
        ->field('article.id, picture.savepath, picture.savename, article.title, article.content')
        ->join('left join picture ON  article.pic_id = picture.id')
        ->where($map)
        ->order('article.is_top desc, article.create_time desc')
        ->limit(5)
        ->select();

      $article_default_img_path = C('ARTICLE_DEFAULT_IMG_PATH');
      $article_default_img_name = C('ARTICLE_DEFAULT_IMG_NAME');
      foreach ($article_info as $key => $value) {
        $article_info[$key]['content'] = htmlspecialchars_decode($val);
        if (empty($value['savename'])) {
          $value[$key]['savepath'] = $ARTICLE_DEFAULT_IMG_PATH;
          $value[$key]['savename'] = $ARTICLE_DEFAULT_IMG_NAME;
        }
      }
    $this->assign("article_info", $article_info);
    $this->insert_content(); 
  }

  public function get_theme_list()
  {

  }

  public function filter_theme_link($theme){
    // return $theme.''
  }

  public function filter_theme_template($theme){

  }



}



 ?>
