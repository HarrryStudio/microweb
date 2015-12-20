<?php
namespace Home\Model;
use Think\Model;

class ArticleTypeModel extends Model{
     protected $tableName = 'article_type';

    protected $_validate = array(
        array('name','require','请填写分类名称',self::MODEL_BOTH),
        array('name','/^([\x{4e00}-\x{9fa5}A-Za-z0-9_]){1,20}+$/u','分类名由1-20位汉字或字母或数字组成',self::MODEL_BOTH),
        array('name','checkName',"分类名不能重复",0,'callback',self::MODEL_BOTH)
    );
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );

    /**
	 * 分类名不能重复
	 */
	protected function checkName($data){
		$map = array('name'=>$data['name'], 'site_id'=>$data['site_id']);
		$res = $this->where($map)->find();
		return empty($res);
	}

    public function add_type($data){
        $data = $this->create($data);
        if(empty($data)){
            return false;
        }
        if($data['id']){
            $status = $this->save($data);
        }else{
            $max = $this->where(array('site_id'=>$data['site_id']))->max('sort');
            $data['sort'] = (int)$max + 1;
            $status = $this->add($data);
        }
        return $status != false;
    }

    public function type_change_sort($site_id,$now_type_id,$to_type_id){
        $now_sort = $this->field('sort')->where(array('id'=>$now_type_id,'site_id'=>$site_id))->find();
        $to_sort = $this->field('sort')->where(array('id'=>$to_type_id,'site_id'=>$site_id))->find();
        if(empty($now_sort) || empty($to_sort)){
            $this->error = "没有找到此分类";
            return false;
        }
        $temp = $now_sort['sort'];
        $this->startTrans();
        $data['update_time'] = time();
        $data['sort'] = $to_sort['sort'];
        $result = $this->where(array('id'=>$now_type_id))->save($data);
        if(!$result){
            $this->rollback();
            return fasle;
        }
        $data['sort'] = $temp;
        $result = $this->where(array('id'=>$to_type_id))->save($data);
        if(!$result){
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }

    public function get_type_list($map)
    {
        $map['site_id'] = session('site_info.id');
        $type_list = $this->where($map)->select();

        return $type_list;
    }

}
