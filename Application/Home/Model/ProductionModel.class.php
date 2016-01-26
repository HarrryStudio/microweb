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
        // array('type','require','产品类型不能为空',self::MODEL_BOTH),
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
	* 删除产品
	* @param $production_id 产品id
	*/
	public function delete_production($production_id)
	{
		# code...
	}

	/**
	* 修改产品信息
	* @param $production_id 产品id
	*
	*/
	public function update_production($production_id)
	{
		# code...
	}

	/**
	* 获得产品列表
	* @param $site_id 网站id
	* @return array('result'=>数据,'page'=>分页信息)
	*/
	public function get_production_list($site_id)
	{
		$map['a.site_id'] = $site_id;
    	$map['a.status'] = array('neq',-1);

    	$type = I('type',-1);
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
	}

	/**
	* 获得产品详细信息
	* @param $production_id 产品id
	*
	*/
	public function get_production_info($production_id)
	{
		# code...
	}

	/**
	* 产品排序
	*
	*
	*/
	public function sort_production($production_id)
	{
		# code...
	}
}