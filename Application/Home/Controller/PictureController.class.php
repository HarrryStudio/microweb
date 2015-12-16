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
}