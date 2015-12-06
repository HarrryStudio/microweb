<?php
namespace Home\Model;
use Think\Model;
use Think\Upload;

/**
 * 图片模型
 * 负责图片的上传
 */

class PictureModel extends Model{
    /**
     * 自动完成
     * @var array
     */
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_INSERT),
        array('used', 1, self::MODEL_INSERT),
    );

    /**
     * 文件上传
     * @param  array  $files   要上传的文件列表（通常是$_FILES数组）
     * @param  array  $setting 文件上传配置
     * @param  string $driver  上传驱动名称
     * @param  array  $config  上传驱动配置
     * @return array           文件上传成功后的信息
     */
    public function upload($files, $setting, $driver = 'Local', $config = null){
        /* 上传文件 */
        $setting['callback'] = array($this, 'isFile');
		$setting['removeTrash'] = array($this, 'removeTrash');
        $Upload = new Upload($setting, $driver, $config);
        $info   = $Upload->upload($files);
        if($info){ //文件上传成功，记录文件信息
            foreach ($info as $key => &$value) {
                /* 已经存在文件记录 */
                if(isset($value['id']) && is_numeric($value['id'])){
                    $this->where(array('id' => $value['id']))->setInc('used');
                    continue;
                }
                /* 记录文件信息 */
                if($this->create($value) && ($id = $this->add())){
                    $value['id'] = $id;
                } else {
                    //TODO: 文件上传成功，但是记录文件信息失败，需记录日志
                    unset($info[$key]);
                }
            }
            return $info; //文件上传成功
        } else {
            $this->error = $Upload->getError();
            return false;
        }
    }

    /**
     * 下载指定文件
     * @param  number  $root 文件存储根目录
     * @param  integer $id   文件ID
     * @param  string   $args     回调函数参数
     * @return boolean       false-下载失败，否则输出下载文件
     */
    public function download($root, $id, $callback = null, $args = null){
        /* 获取下载文件信息 */
        $file = $this->find($id);
        if(!$file){
            $this->error = '不存在该文件！';
            return false;
        }

        /* 下载文件 */
        switch ($file['location']) {
            case 0: //下载本地文件
                $file['rootpath'] = $root;
                return $this->downLocalFile($file, $callback, $args);
            case 1: //TODO: 下载远程FTP文件
                break;
            default:
                $this->error = '不支持的文件存储类型！';
                return false;

        }

    }

    /**
     * 检测当前上传的文件是否已经存在
     * @param  array   $file 文件上传数组
     * @return boolean       文件信息， false - 不存在该文件
     */
    public function isFile($file){
        if(empty($file['md5'])){
            throw new \Exception('缺少参数:md5');
        }
        /* 查找文件 */
		$map = array('md5' => $file['md5'],'sha1'=>$file['sha1'],);
        return $this->field(true)->where($map)->find();
    }

    /**
     * 下载本地文件
     * @param  array    $file     文件信息数组
     * @param  callable $callback 下载回调函数，一般用于增加下载次数
     * @param  string   $args     回调函数参数
     * @return boolean            下载失败返回false
     */
    private function downLocalFile($file, $callback = null, $args = null){
        if(is_file($file['rootpath'].$file['savepath'].$file['savename'])){
            /* 调用回调函数新增下载数 */
            is_callable($callback) && call_user_func($callback, $args);

            /* 执行下载 */ //TODO: 大文件断点续传
            header("Content-Description: File Transfer");
            header('Content-type: ' . $file['type']);
            header('Content-Length:' . $file['size']);
            if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) { //for IE
                header('Content-Disposition: attachment; filename="' . rawurlencode($file['name']) . '"');
            } else {
                header('Content-Disposition: attachment; filename="' . $file['name'] . '"');
            }
            readfile($file['rootpath'].$file['savepath'].$file['savename']);
            exit;
        } else {
            $this->error = '文件已被删除！';
            return false;
        }
    }

	/**
	 * 清除数据库存在但本地不存在的数据
	 * @param $data
	 */
	public function removeTrash($data){
		$this->where(array('id'=>$data['id'],))->delete();
	}

    /**
     * 清除数据库中的废物数据和相对文件
     */
    public function removeFile(){
        $trash = $this->where(array('used'=>0))->select();
        $file = "";
        foreach ($trash as $key => $value) {
            $file = C('UPLOAD_ROOT').$value['savepath'].$value['savename'];
            if( is_file( $file ) ){
                $result = unlink($file);
                if(!$result){
                    $model->rollback();
                    $this->error = "删除文件".$file."失败";
                    return false;
                }else{
                    $this->delete($value['id']);
                }
            }
        }
    }

    public function deleteFile($id){
        
        $info = $this->where(array('id'=>$id))->find();
        if(empty($info)){
            return false;
        }

        if((int)$info['used'] > 1){
            if(!$this->where(array('id'=>$id))->setDec('used')){
                return false;
            }
        }
        $this->startTrans();
        if(!$this->where(array('id'=>$id))->delete()){
            return false;
        }
        $file = C('UPLOAD_ROOT').$info['savepath'].$info['savename'];
        if( is_file($file) ){
            if(@unlink($file)){
                $this->commit();
                return true;
            }else{
                $this->rollback();
                return false;
            }
        }
    }

    /*
     * 联结photop、icture
     * 根据图册id(album_id)查询图片
     */
    public function getPicture($album_id){
        $photo = M('photo');
        $where['album_id'] = $album_id;
        $pic = $photo
            ->where($where)
            ->join('picture on photo.pic_id = picture.id')
            ->field('picture.savepath,picture.savename')
            ->select();
        if(empty($pic)){
            $pic = "false";
        }
        return $pic;
    }
}