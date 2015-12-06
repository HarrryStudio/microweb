<?php
namespace Home\Model;
use Think\Model;

/**
* 相册模型
*/
class AlbumModel extends Model{	
	protected $_validate = array(
		array('name','/^([\x{4e00}-\x{9fa5}A-Za-z0-9_]){1,20}+$/u','相册名由1-20位汉字或字母或数字组成',self::MODEL_BOTH),
		array('name','checkName','相册名不能重复',0,'callback',self::MODEL_BOTH),
	);

	/**
	 * 相册名不能重复
	 */
	protected function checkName(){
		$name = I('name');
		$site_id = I('site_id');
		$album_id = I('album_id');
		if($site_id){
			$map = array('name'=>$name, 'site_id'=>$site_id);
			$res = $this->where($map)->find();
			// var_dump($res);
			return empty($res);
		}elseif($album_id){
			$site = $this->field('site_id')->where(array('id'=>$album_id))->find();
			$map = array('name'=>$name, 'site_id'=>$site['site_id']);
			$res = $this->where($map)->find();
			return empty($res);
		}
		
	}
	/**
	 * 得到album的列表
	 * @param  $site_id 网站id
	 * @return 数据 | false
	 */
	public function get_album_list($site_id){
		$map['site_id'] = $site_id;
		return $this->field('id,name,create_time,update_time')
					->where($map)
					->order('create_time desc')
					->select();
	}

	/**
	 * 得到photo列表
	 * @param  $album_id 相册id
	 * @return 数据 | false
	 */
	public function get_photo_list($album_id){
		$map['album_id'] = $album_id;
		$map['home_picture.status'] = 0;
		$Photo = M('photo');
		$result = $Photo->field('photo.id,savename,savepath,size')
						// ->join('left join album on photo.album_id = album.id right join picture on photo.pic_id = picture.id')
						// author zhangbo    
						// modify  split  admin  & home   picture table
						->join('left join album on photo.album_id = album.id right join home_picture on photo.pic_id = home_picture.id')
						->where($map)
						->order('photo.create_time desc')
						->select();
		if($result === false){
			$this->error = $Photo->getError();
		}
		return $result;
	}

	/**
	 * 删除相册
	 * @param  $album_id 相册id
	 * @return 数据 | false
	 */
	public function del_album($album_id){
		$model = M();
		$model->startTrans();
		$map['album_id'] = $album_id;
		$sql = $model->field('pic_id as id')->table('photo')->where($map)->select(false);
		/*将picture表中的对应文件的used-1 表示被使用位置-1*/
		$result = $model->table('picture')->where('id in ('.$sql.') ')->setDec('used');
		if($result === false){
			$model->rollback();
			$this->error = $model->getError();
			return false;
		}
		/*将photo表中相册下的数据删除*/
		$result = $model->table('photo')->where($map)->delete();
		if($result === false){
			$model->rollback();
			$this->error = $model->getError();
			return false;
		}
		/*将album表中的一条记录删除*/
		$result = $model->table('album')->where(array('id'=>$album_id))->delete();
		if(!$result){
			$model->rollback();
			$this->error = $model->getError();
			return false;
		}
		$model->commit();
		D('Picture')->removeFile();
		return true;
	}
}