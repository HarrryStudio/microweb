<?php
namespace Home\Model;
use Think\Model;

/**
* 产品模型类
*/
class ProductionModel extends Model
{
	protected $_validate = array(
        array('name','require','产品标题不能为空',self::MODEL_BOTH),
        array('name','/^([\x{4e00}-\x{9fa5}A-Za-z0-9_]){1,30}+$/u','文章标题由1-20位汉字或字母或数字组成',self::MODEL_BOTH),
        array('price','require','产品价格不能为空',self::MODEL_BOTH),
        array('price','/^(\d{1,6})|(\d{1,6}\.\d{1,2})/','产品价格为非负实数(至多6位整数和2位小数)',self::MODEL_BOTH),
        array('url','require','产品跳转链接不能为空',self::MODEL_BOTH),
        array('type','require','产品类型不能为空',self::MODEL_BOTH),
        array('desc','require','产品详细介绍不能为空',self::MODEL_BOTH),
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
	* 添加产品
	* @param $site_id 网站id
	* @param $data AJAX返回数据
	*/
	public function add_production($data)
	{
		$data = $this->create($data);
        if(empty($data)){
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
        }else{
        	$this->error = '产品配图不能为空！';
        	return false;
        }
        if(empty($data['id'])){ //新增数据
            $id = $this->add($data); //添加行为
            if(!$id){
                $this->error = '新增产品出错！';
                return false;
            }
        } else { //更新数据
            $status = $this->save($data); //更新基础内容
            if(false === $status){
                $this->error = '修改产品出错！';
                return false;
            }
        }
    	return $data;
	}

	/**
	* 修改产品状态
	* @param $production_id 产品id
    * @param $status 要得到的状态
    * @return Boolean
	*/
	public function update_production_status($site_id,$production_id,$status)
	{
		$production_id = is_array($production_id) ? implode(',',$production_id) : $production_id;
    	$where = array('id' => array('in', $production_id ), 'site_id' => $site_id);
    	$data['update_time'] = NOW_TIME;
    	$data['status'] = $status;
    	return $this->where($where)->save($data);
	}

	/**
     * 设置产品类型
     * @return [type] [description]
     */
	public function change_production_type($site_id,$id,$type)
	{
		$id = is_array($id) ? implode(',',$id) : $id;
        $where = array('id' => array('in', $id ),'site_id' => $site_id);
        $data['update_time'] = NOW_TIME;
        $data['type'] = $type;
        return $this->where($where)->save($data);
	}

	/**
	* 获得产品列表
	* @param $site_id 网站id
	* @return array('result'=>数据,'page'=>分页信息)
	*/
	public function get_production_list($site_id)
	{
		$map['a.site_id'] = $site_id;
    	$map['a.status'] = array('neq',1);//不显示已删除产品

    	$type = I('type',-1);//默认所有类型
        $name = I('name');
        /*搜索条件*/
        if($type != '' && (int)$type >= 0){
            $map['a.type'] = $type;
            $data['type'] = $type;
        }
        if(!empty($name)){
            $map['a.name'] = array('like','%'.$name.'%');
            $data['name'] = $name;
        }
        $count = (int)C('ARTICLE_PAGE_CONUT');//默认分页条件
    	$total = $this->alias('a')->join('left join production_type as b on a.type = b.id')
    				  ->where($map)
    				  ->count();
    	$page = new \Think\Page($total,$count);
    	$result = $this->alias('a')->field('a.*,b.name as class_name')
    				->join('left join production_type as b on a.type = b.id')
    				->where($map)
    				->order('create_time desc')
    				->limit($page->firstRow.','.$page->listRows)
    				->select();
    	return array('result'=>$result,'page'=>$page->show(),'search'=>$data);
	}

	/**
	* 获得产品详细信息
	* @param $production_id 产品id
	* @param $site_id 网站id
	*/
	public function get_production_info($site_id,$production_id)
	{
	    $production_info = $this->alias('a')
                           ->field('a.*,b.savepath,b.savename')
                           ->join('left join home_picture as b on a.pic_id = b.id')
                           ->where(array('a.status' => array('NEQ',1),'a.id'=>$production_id,'a.site_id' => $site_id))
                           ->find();
        if(!empty($production_info['savename'])){
            $production_info['img_url'] = C('UPLOAD_ROOT').$production_info['savepath'].$production_info['savename'];
        }
        return $production_info;
	}

	/**
	* 产品排序
	*/
	public function sort_production($production_id)
	{
		# code...
	}
}