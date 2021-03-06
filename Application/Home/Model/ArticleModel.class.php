<?php
namespace Home\Model;
use Think\Model;

class ArticleModel extends Model{
    protected $_validate = array(
        array('title','require','文章标题不能为空',self::MODEL_BOTH),
        array('content','require','文章内容不能为空',self::MODEL_BOTH),
        array('title','/^([\x{4e00}-\x{9fa5}A-Za-z0-9_]){1,30}+$/u','文章标题由1-20位汉字或字母或数字组成',self::MODEL_BOTH),
    );
	/**
     * 自动完成
     * @var array
     */
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );

    /**
     * 一篇文章的具体信息
     * @param $site_id 网站id
     * @param $article_id  文章id
     */
    public function get_article_info($site_id,$article_id){
        $article_info = $this->alias('a')
                           ->field('a.*,b.savepath,b.savename')
                           ->join('left join home_picture as b on a.pic_id = b.id')
                           ->where(array('a.status' => array('gt',-1),'a.id'=>$article_id,'a.site_id' => $site_id))
                           ->find();
        if(!empty($article_info['savename'])){
            $article_info['img_url'] = C('UPLOAD_ROOT').$article_info['savepath'].$article_info['savename'];
        }
        return $article_info;
    }

    /**
     * 网站下所有文章的具体信息
     * @param $site_id 网站id
     */
    public function get_all_info($site_id){
        $article_info = $this->alias('a')
                           ->field('a.*,b.savepath,b.savename')
                           ->join('left join home_picture as b on a.pic_id = b.id')
                           ->where(array('a.status' => array('gt',-1),'a.site_id' => $site_id))
                           ->select();
                           //echo $this->getLastSql();
        $upload_path = C('UPLOAD_ROOT');
        foreach($article_info as $key => $value){
            if(!empty($article_info[$key]['savename'])){
                $article_info[$key]['img_url'] = $upload_path.$article_info[$key]['savepath'].$article_info[$key]['savename'];
            }
        }
        return $article_info;
    }

    /**
     *得到文章列表
     *@return  array('result'=>数据,'page'=>分页信息)
     */
    public function get_article_list($site_id){
    	$map['a.site_id'] = $site_id;
    	$map['a.status'] = array('neq',-1);

        $type_id = I('type_id',-1);
        $title = I('title');
        /*搜索条件*/
        if($type_id != '' && (int)$type_id >= 0){
            $map['a.type_id'] = $type_id;
            $data['type_id'] = $type_id;
        }
        if(!empty($title)){
            $map['a.title'] = array('like','%'.$title.'%');
            $data['title'] = $title;
        }
    	$count = (int)C('ARTICLE_PAGE_CONUT');
    	$total = $this->alias('a')->join('left join article_type as b on a.type_id = b.id')
    				  ->where($map)
    				  ->count();
    	$page = new \Think\Page($total,$count);
    	$result = $this->alias('a')->field('a.*,b.name')
    				->join('left join article_type as b on a.type_id = b.id')
    				->where($map)
    				->order('is_top desc,create_time desc')
    				->limit($page->firstRow.','.$page->listRows)
    				->select();
                    //echo $this->getLastSql();
    	return array('result'=>$result,'page'=>$page->show(),'search'=>$data);
    }

    /**
     * 更新/插入文章
     * @return [type] [description]
     */
    public function insert_article($data){
        $data = $this->create($data);
        if(empty($data)){
            $this->error = "没有数据";
            return false;
        }
        foreach ($_FILES as $key => $value) {
            $file = $value['name'];
        }
        if(!empty($file)){
            $Picture = D('Picture');
            $pic_driver = C('PICTURE_UPLOAD_DRIVER');
            $info = $Picture->upload(
                $_FILES,
                C('PICTURE_UPLOAD'),
                C('PICTURE_UPLOAD_DRIVER'),
                C("UPLOAD_{$pic_driver}_CONFIG")
            );
            if(empty($info)){
                $this->error = "上传图片失败";
                return false;
            }else{
                foreach ($info as $key => &$value) {
                    $data['pic_id'] = $value['id'];
                }
            }
        }
        if(empty($data['id'])){ //新增数据
            $id = $this->add($data); //添加行为
            if(!$id){
                $this->error = '新增文章出错！';
                return false;
            }
        } else { //更新数据
            $status = $this->save($data); //更新基础内容
            if(false === $status){
                $this->error = '修改文章出错！';
                return false;
            }
        }
    	return $data;
    }

    /**
     * 更改文章的状态
     * @param  $id     被改文章
     * @param  $status 要得到的状态
     * @return Boolean
     */
    public function update_article_status($site_id,$id,$status){
    	$id = is_array($id) ? implode(',',$id) : $id;
    	$where = array('id' => array('in', $id ), 'site_id' => $site_id);
    	$data['update_time'] = NOW_TIME;
    	$data['status'] = $status;
    	if($status != 0){
    		$data['is_top'] = 0;
    	}
    	return $this->where($where)->save($data);

    }

    /**
     * 设置文章类型
     * @return [type] [description]
     */
    public function change_article_type($site_id,$id,$type){
        $id = is_array($id) ? implode(',',$id) : $id;
        $where = array('id' => array('in', $id ),'site_id' => $site_id);
        $data['update_time'] = NOW_TIME;
        $data['type_id'] = $type;
        return $this->where($where)->save($data);
    }

    /**
     * 置顶/取消置顶(顶:1 踩:0)
     * @return [type] [description]
     */
    public function top_article($site_id,$id,$status){
        $where = array('id' => $id , 'site_id' => $site_id);
        $data['update_time'] = NOW_TIME;
        $data['is_top'] = $status;
        return $this->where($where)->save($data);
    }

    /**
    * 文章列表类取得列表方法
    * map 条件
    * 文章记录
    */
    public function article_widget_list($map = null)
    {
        $map['article.status'] = 0;
        $Article = M('article');
        $article_info = $Article
          ->field('article.id, b.savepath, b.savename, article.title, article.content')
          ->join('left join home_picture as b ON  article.pic_id = b.id')
          ->where($map)
          ->order('article.is_top desc, article.create_time desc')
          ->limit(5)
          ->select();

        $article_default_img_path = C('ARTICLE_DEFAULT_IMG_PATH');
        $article_default_img_name = C('ARTICLE_DEFAULT_IMG_NAME');
        foreach ($article_info as $key => $value) {
          $article_info[$key]['content'] = htmlspecialchars_decode($value['content']);
          if (empty($value[$key]['savename'])) {
            $article_info[$key]['savepath'] = $article_default_img_path;
            $article_info[$key]['savename'] = $article_default_img_name;
          }
          else{
            $article_info[$key]['savepath'] = __UPLOADS__.$value['savepath'];
          }
        }
        return $article_info;
    }
    /*
    * 图文展示空间获得列表
    * map 条件
    * data
    */
    public function Image_text_widget_article_list($map = null)
    {
      $count = $this->where($map)->count();
      $Page = new \Think\Page($count,5);
      $show = $Page->show();
      $article_list = $this->join('LEFT JOIN home_picture as b on b.id = article.pic_id')
            ->where($map)
            ->field('article.id, article.title, article.content, b.savepath, b.savename')
            ->order('article.is_top desc, article.create_time desc')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();

/*      $article_default_img_path = C('ARTICLE_DEFAULT_IMG_PATH');
      $article_default_img_name = C('ARTICLE_DEFAULT_IMG_NAME');*/
      foreach ($list as $key => $value) {
          $article_list['key']['content'] = htmlspecialchars_decode($article_list['content']);
/*          if (empty($value['savename'])) {
            $article_list['key']['savepath'] = $article_default_img_path;
            $article_list['key']['savepath'] = $article_default_img_name;
          }*/
      }
      $p = I('get.p');
      $list['article_list'] = $article_list;
      if (!empty($p)) {
        $list['page'] = $show;
      }
      return $list;
    }
    public function get_article($map)
    {
      $article = $this->join('left join home_picture as b on b.id = article.pic_id')
        ->where($map)
        ->field('article.id, article.title, article.content, b.savepath, b.savename')
        ->find();
      return $article;
    }
}
