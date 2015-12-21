<?php
namespace Home\Model;
use Think\Model;

/**
* 相册模型
*/
class UserColumnModel extends Model{
	protected $_validate = array(
		array('name','/^([\x{4e00}-\x{9fa5}A-Za-z0-9_]){1,20}+$/u','栏目名由1-6位汉字或字母或数字组成',self::MODEL_BOTH),
		array('url','/^([A-Za-z0-9_]){1,20}+$/','栏目名由1-20位字母或数字或下划线组成',self::MODEL_BOTH),
	);

    /**
     * 栏目信息
     * @param  int    $site_id    要查询的网站id
     * @param  bool   $forbidden  是否在乎forbidden
     * @return bool|array     false 查询失败    array 查询结果
     */
	public function get_column_info($site_id,$forbidden = false){
        $where['a.site_id'] = $site_id;
        $where['a.is_default'] = 1;
        if($forbidden){
            $where['a.forbidden'] = 0;
        }
    	$admin_result = $this->alias('a')->field('a.id, a.name, a.forbidden, a.sort, a.url, b.savepath, b.savename')
                     ->join('left join picture as b on a.icon = b.id')
					 ->where($where)
					 ->order('sort')
					 ->select();
                     $where['a.is_default'] = 0;
        $home_result = $this->alias('a')->field('a.id, a.name, a.forbidden, a.sort, a.url, b.savepath, b.savename')
                     ->join('left join home_picture as b on a.icon = b.id')
                     ->where($where)
                     ->order('sort')
                     ->select();
        $result = merge_sort($admin_result,$home_result);
		if(!$result){
			return false;
		}
		$root = C('UPLOAD_ROOT');
		foreach ($result as $key => $value) {
			$result[$key]['icon_url'] = $root.$value['savepath'].$value['savename'];
		}
		//echo $this->getLastSql();
		return $result;
    }

    /**
     * @return string  初始化的json字符串
     * @author 凌端化
     */
    private function init_html_json(){
        return json_encode( array(  "header" => "","content" => array()  ,"footer" => "" ) );
    }

    /**
     * 初始化网页(栏目)
     * @param $site_id 网站id
     * @return boolean  成功与否
     * @author 凌端化
     */
    public function initColumns($site_id){
        /*获取 后台设置的nav*/
        $nav = M('topic as a')->field('a.id, a.name, a.sort , a.url, a.icon, CONCAT(savepath,savename) as icon_url')
            ->join('left join picture as b on a.icon = b.id')
            ->where(array('a.status'=>0,'a.forbidden'=>0))
            ->select();
        if($nav === false){
            return false;
        }

        $datalist = [];

        /*初始化 html.json */
        $data['html'] = $this->init_html_json();

        /*新建空白html 并生成对应用户的nav*/
        foreach ($nav as $key => $value) {
            $data['site_id']    = $site_id;
            $data['name']       = $value['name'];
            $data['sort']       = $key + 1;
            $data['url']        = $value['url'];
            $data['icon']       = $value['icon'];
            $data['is_static']  = 1;
            $data['is_default'] = 1;
            $datalist[] = $data;
        }

        return $this->addAll($datalist);
    }

    /**
     * 添加栏目
     * @param null $pic_id  栏目图标id
     * @return bool 成功与否
     * @update harrry 2015-12-3
     */
    public function add_column($site_id,$pic_id = null){
        //添加栏目信息
        $max = M()->table("user_column")
            ->where(array('site_id' => $site_id ))
            ->max('sort');

        $data['site_id'] = $site_id;
        $data['name'] = I("post.name");
        $data['sort'] = (int)$max + 1;
        $data['url'] = I("post.link");
        $data['html'] = $this->init_html_json();
        $data['icon'] = $pic_id;
        
        if( $this->create($data) && ($column_id = $this->add()) ){
            $data['column_id'] = $column_id;
        }else{
            return false;
        }

        return $data;
    }

    public function edit_column($site_id,$pic_id = null,$is_default = 0){
        $data = I('post.');
        if($pic_id > 0){
        	$data['icon'] = $pic_id;
            $data['is_default'] = $is_default;
        }
        $id =  $data['id'];
        unset($data['id']);
        if ( $this->create($data) && $this->where(array('site_id' => $site_id, 'id' => $id))->save() !== false ){
        	// echo $this->getLastSql();
        	return $data;
        }
        return false;
    }

    public function sort_column($now_column_id,$to_column_id){
    	$now_sort = $this->field('sort')->where(array('id'=>$now_column_id))->find();
    	$to_sort = $this->field('sort')->where(array('id'=>$to_column_id))->find();
    	$temp = $now_sort['sort'];
    	$this->startTrans();
    	$data['sort'] = $to_sort['sort'];
    	$result = $this->where(array('id'=>$now_column_id))->save($data);
    	// echo $Type->getLastSql();
    	// print_r($result);
    	if(!$result){
    	    $this->rollback();
    	    return false;
    	}
    	$data['sort'] = $temp;
    	$result = $this->where(array('id'=>$to_column_id))->save($data);
    	if(!$result){
    	    $this->rollback();
    	    return false;
    	}
    	$this->commit();
    	return true;
    }


    public function get_html_json($colnum_id){
        $result = $this->field('html')->where(array('id' => $colnum_id))->find();
        return $result['html'];
    }

    // public function get_nav_list($site_id){
    //     $nav_list = $this->alias('a')
    //         ->field('a.id , a.name, a.sort, a.forbidden, a.url, savepath, savename')
    //         ->join('left join picture as b on a.icon = b.id')
    //         ->where(array('a.site_id' => $site_id , 'a.forbidden' => 0))
    //         ->order('sort')
    //         ->select();
    //     $root = C('UPLOAD_ROOT');
    //     foreach ($nav_list as $key => $value) {
    //         $nav_list[$key]['icon_url'] = $root.$value['savepath'].$value['savename'];
    //     }
    //     return $nav_list;
    // }


    /**
     * 修改html
     * @return bool  成功与否
     * @author 凌端化
     * @create 2015-12-3
     */
    public function writeHtml(){
        $id = I('get.column_id');
        //$content = htmlspecialchars_decode(I('content'));
        $content = I('content');
        if(!empty( $content )){
            $result = $this
                ->where(array('id'=>$id))
                ->save( array('html'=>json_encode($content)) );
            if($result === false){
                $this->error = 'html保存失败';
                return false;
            }
        }
        $theme = I('theme');
        $back = I('back');
        if(!empty( $theme ) || !empty( $back ) )
            $result = M()->table('site_info')
                ->where(array('id'=>session('site_id')))
                ->save(array('theme'=>I('theme'),'back'=>I('back')));
        if($result === false){
            $this->error = 'info保存失败';
            return false;
        }
        return true;
    }

    public function get_user_column($map)
    {
        $user_column = $this->where($map)->select();
        return $user_column;
    }
}
