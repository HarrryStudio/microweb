<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 操作面板
 */
class PictureController extends Controller {
	/**
     * 上传图片
     * @author huajie <banhuajie@163.com>
     */
    public function uploadPicture($option = array()){
        //TODO: 用户登录检测
        /* 返回标准数据 */
        $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');
        /* 调用文件上传组件上传文件 */
        $Picture = D('Picture');
        $pic_driver = C('PICTURE_UPLOAD_DRIVER');
        $info = $Picture->upload(
            $_FILES,
            array_merge(C('PICTURE_UPLOAD'),$option),
            C('PICTURE_UPLOAD_DRIVER'),
            C("UPLOAD_{$pic_driver}_CONFIG")
        ); //TODO:上传到远程服务器

        /* 记录图片信息 */
        if($info){
            $return['status'] = 1;
            $return = array_merge($info, $return);
        } else {
            $return['status'] = 0;
            $return['info']   = $Picture->getError();
        }
        //print_r($info);
        /* 返回JSON数据 */
        return $return;
    }

    public function upload_editor(){
        $file_info = $this->uploadPicture();
        if($file_info['status'] > 0){
            $filepath = $file_info['upfile']["savepath"] . $file_info['upfile']["savename"];
            $data['pic_id'] = $file_info['upfile']['id'];
            $data['title'] = htmlspecialchars($_POST['pictitle'], ENT_QUOTES);
            $data['site_id'] = session("site_info.id");
            $m = M();
            $result = $m->table('editor_pic')->add($data);
            if($result){
                $file_info['info'] = "SUCCESS";
            }else{
                $file_info['info'] = "上传图片失败";
                $Picture = D('Picture');
                $Picture->deleteFile($data['pic_id']);
            }
        }
        /**
         * 向浏览器返回数据json数据
         * {
         *   'url'      :'a.jpg',   //保存后的文件路径
         *   'title'    :'hello',   //文件描述，对图片来说在前端会添加到title属性上
         *   'original' :'b.jpg',   //原始文件名
         *   'state'    :'SUCCESS'  //上传状态，成功时返回SUCCESS,其他任何值将原样返回至图片上传框中
         * }
         */
        echo "{'url':'" . $filepath
            . "','title':'" . $data['title'] 
            . "','original':'" . $file_info["upfile"]["name"] 
            . "','state':'" . $file_info['info'] . "'}";
        

    }
}