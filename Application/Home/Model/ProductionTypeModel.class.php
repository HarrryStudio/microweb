<?php
namespace Home\Model;
use Think\Model;

class ProductionTypeModel extends Model{
    protected $tableName = 'production_type';
    protected $_validate = array(
        array('name','require','请填写类型名称',self::MODEL_BOTH),
        array('name','/^([\x{4e00}-\x{9fa5}A-Za-z0-9_]){1,20}+$/u','类型名由1-20位汉字或字母或数字组成',self::MODEL_BOTH),
        array('name','','帐号名称已经存在！',0,'unique',1), 
        //array('name','checkName',"类型名不能重复",0,'callback',self::MODEL_BOTH)
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
        } else {
            $status = $this->add($data);
        }
        return $status != false;
    }
    public function get_type_list($map)
    {
        $map['site_id'] = session('site_info.id');
        $type_list = $this->where($map)->select();
        return $type_list;
    }

}
