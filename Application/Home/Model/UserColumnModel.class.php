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

	public function get_column_info($site_id){
    	 $result = $this->field('user_column.id,name,forbidden,sort,url,savepath,savename')
                     ->join('left join picture on user_column.icon = picture.id')
					 ->where(array('site_id' => $site_id))
					 ->order('sort')
					 ->select();
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

    public function add_column($pic_id = null){
        //新建html
        $m = M();
        $m->startTrans();
        $html_id = $m->table('html')->add(array('html'=>''));
        if(!$html_id){
            $m->rollback();
            $this->error = '生成页面失败';
            return false;
        }
        $site_id = session("site_id");
        //添加栏目信息
        $max = M()->table("user_column")
                   ->where(array('site_id' => $site_id ))
                   ->max('sort');
        
        $data['site_id'] = $site_id;
        $data['html_id'] = $html_id;
        $data['name'] = I("post.name");
        $data['sort'] = (int)$max + 1;
        $data['url'] = I("post.link");
        if($pic_id > 0){
	        $data['icon'] = $pic_id;
        }
        $column_id = M()->table("user_column")->data($data)->add();
        // echo M()->getLastSql();
        if(!$column_id){
        	$m->rollback();
            $this->error = '添加失败';
            return;
        }
        $m->commit();
        $data['column_id'] = $column_id;
        return $data;
    }

    public function edit_column($pic_id = null){
        $data = I('post.');
        if($pic_id > 0){
        	$data['icon'] = $pic_id;
        }
        if ( $this->create($data) && $this->save() ){
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
}