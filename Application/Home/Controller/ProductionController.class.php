<?php
namespace Home\Controller; 
use Think\Controller;
/**
 * 我的网站
 */
class ProductionController extends ResourceController {
    /**
     * 文章列表页
     * @return [type] [description]
     */
    public function index(){
        $this->init_head("产品",1,1,3);
        $this->display();
    }
    /**
     * 管理产品类型页
     */
    public function set_classify(){
        $this->init_head("类型管理",1,1,3);
        $site_id = $this->site_info['id'];
        $type_list = M('production_type')
                        ->field('id,name')
                        ->select();
                        // print_r($type_list);
        $this->assign("site_id",$site_id);
        $this->assign("type_list",$type_list);
        $this->display();
    }
 
   /**
     * 添加/重命名产品类型
     */
    public function add_type(){
        $return  = array('status' => 0, 'info' => '添加成功', 'data' => '');
        $data = I('post.');
        $data['site_id'] = $this->site_info['id'];
        $Type = D('ProductionType');
        $result = $Type->add_type($data);
        if($result){
            $return['status'] = 1;
        }else{
            $return['info'] = $Type->getError();
        }
        $this->ajaxReturn($return);
    }
    /**
     * 删除类型
     * @return [type] [description]
     */
    public function del_type(){
        $return  = array('status' => 0, 'info' => '删除成功', 'data' => '');
        $id = I('post.id');
        if(empty($id) ){
            $return['info'] = "请选择要删除的类型";
            $this->ajaxReturn($return);
            return;
        }
        $Type = M('production_type');
        $result = $Type->where(array('id'=>$id,'site_id' => $this->site_info['id']))->delete();
        if($result){
            $return['status'] = 1;
        }else{
            $return['info'] = $Type->getError();
        }
        $this->ajaxReturn($return);
    }
}
