<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 我的网站
 */
class AlbumController extends ResourceController {
    /**
     * 网站资源管理
     * 显示相册列表
     */
    public function index(){
        $session_site = session("site_info");
        $site_id = $session_site['id'];
        $Album = D('Album');
        $album_list = $Album->get_album_list($site_id);
        $this->assign("site_id",$id);
        $this->assign("album_list",$album_list);
        $this->init_head("图册");
        $this->display();
    }
    /**
     * 创建相册
     * $data[] 收集的数据
     * @return $ajax 0（成功）| 1（失败）message   提示信息
     */
    public function create_album(){
        $data['site_id'] = $this->site_info['id'];
        $data['name'] = I('name');
        $Album = D('Album');
        if ($Album->create($data)) {
            if ($Album->add() != 0) {
                $ajax['code'] = 0;
                $ajax['message'] = $Album->getError();
            }
        }else {
            $ajax['code'] = 1;
            $ajax['message'] = $Album->getError();
        }
        $this->ajaxReturn($ajax);
    }

    /**
     * 修改相册名
     */
    public function edit_album(){
        $return  = array('status' => 1, 'info' => '修改成功', 'data' => '');
        $album_id = I('post.album_id');
        $name = I('post.name');
        if(empty($album_id)){
            $return['status'] = 0;
            $return['info'] = "请选择相册";
            $this->ajaxReturn($return);
            return;
        }
        $Album = D('Album');
        $data['name'] = $name;
        $data['id'] = $album_id;
        $data['site_id'] = $this->site_info['id'];
        $data = $Album->create($data);
        if(!$data){
            $return['status'] = 0;
            $return['info'] = $Album->getError();
            $this->ajaxReturn($return);
            return;
        }
        $result = $Album->where(array('id'=>$album_id))->save();
        if($result === false){
            $return['status'] = 0;
            $return['info'] = $Album->getError();
        }else{
            $return['status'] = 1;
        }
        $this->ajaxReturn($return);
    }

    /**
     * 删除图册
     * @return [type] [description]
     */
    public function del_album(){
        $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');
        $album_id = I('post.album_id');
        if(empty($album_id)){
            $return['status'] = 0;
            $return['info'] = "请选择相册";
            $this->ajaxReturn($return);
            return;
        }
        $Album = D('Album');
        $result = $Album->del_album($this->site_info['id'],$album_id);
        if($result){
            $return['status'] = 1;
        }else{
            $return['status'] = 0;
            $return['info'] = $Album->getError();
        }
        $this->ajaxReturn($return);
    }

    /**
     * 相册详细信息
     * $album_list  相册图片列表
     */
    public function photo_list(){
        $this->init_head("图片");
        $album_id = I('get.album_id');
        $Album = D('Album');
        $album_info = $Album->field('id,site_id,name,create_time,update_time')
                            ->where(array('id' => $album_id,'site_id'=>$this->site_info['id']))
                            ->find();
        $photo_list = $Album->get_photo_list($album_id);

        $this->meta_title = "相册详细";
        $this->assign('photo_list',$photo_list);
        $this->assign('album_info',$album_info);
        $this->display();
    }
    public function allow_album($album_id){
        return M('album')->where(array('id' => $album_id, 'site_id' => $this->site_info['id']))->find();
    }
    /**
     * 上传图片
     * @return error | info
     */
    public function upload_photo(){
        //  /* 返回标准数据 */
        $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');
        $album_id = I('post.album_id');
        $site_id = $this->site_info['id'];
        if(empty($album_id)){
            $return['status'] = 0;
            $return['info'] = "请选择相册";
            $this->ajaxReturn($return);
            return;
        }
        if(!$this->allow_album($album_id)){
            $ajax['status'] = 0;
            $ajax['info'] = "无权修改该相册内容";
            $this->ajaxReturn($ajax);
            return;
        }
        //TODO:上传到远程服务器
        $Picture = D('Picture');
        $pic_driver = C('PICTURE_UPLOAD_DRIVER');
        $info = $Picture->upload(
            $_FILES,
            C('PICTURE_UPLOAD'),
            C('PICTURE_UPLOAD_DRIVER'),
            C("UPLOAD_{$pic_driver}_CONFIG")
        );

        if($info){ //文件上传成功，记录文件信息
            foreach ($info as $key => &$value) {
                $data[] = array('album_id' => $album_id, 'site_id'=> $site_id,'pic_id' => $value['id'], 'create_time' => time());
            }
            $Photo = M('photo');
            $result = $Photo->addAll($data);
            if($result){
                $return['status'] = 1;
            }else{
                $return['status'] = 0;
                $return['info']   = $Photo->getError();
            }
        } else {
            $return['status'] = 0;
            $return['info']   = $Picture->getError();
        }

        $this->ajaxReturn($return);
    }

    /**
     * 删除图片
     * @return [type] [description]
     */
    public function del_photo(){
        $return  = array('status' => 1, 'info' => '删除成功', 'data' => '');
        $id = I('post.photo_id');
        $id = is_array($id) ? implode(',',$id) : $id;
        if(empty($id)){
            $return['status'] = 0;
            $return['info'] = "请选择图片";
            $this->ajaxReturn($return);
            return;
        }
        $m = M();
        $m->startTrans();
        $where = array('id' => array('in', $id ),'site_id' => $this->site_info['id']);
        $result = $m->table('photo')->field('pic_id')->where($where)->select();
        if(empty($result)){
            $return['status'] = 0;
            $return['info'] = "找不到图片";
            $this->ajaxReturn($return);
            return;
        }
        $pics = [];
        foreach($result as $key => $value){
            $pics[] = $value['pic_id'];
        }
        $result = $m->table('home_picture')->where(array('id' => array('in',$pics)))->setDec('used');
        if($result !== false){
            $result = $m->table('photo')->where($where)->delete();
            if($result !== false){
                $m->commit();
                D('Picture')->removeFile();  // 删除废物
                $return['status'] = 1;
            }else{
                $model->rollback();
                $return['status'] = 0;
                $return['info'] = $model->getError();
            }
        }else{
            $model->rollback();
            $return['status'] = 0;
            $return['info'] = $model->getError();
        }
        $this->ajaxReturn($return);
    }

}
