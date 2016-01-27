<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 我的网站
 */
class ProductionController extends ResourceController {
	/**
	* 产品列表页
	* @return
	*/
	public function index(){
        $this->init_head("产品",1,1,3);
        $site_id = $this->site_info['id'];
        $Production = D('Production');
        $result = $Production->get_production_list($site_id);
        $production_list = $result['result'];
        $type_list = M('production_type')
                        ->field('id,name')
                        ->where(array('site_id'=>$site_id))
                        // ->order('sort')
                        ->select();
        $this->assign('type_list', $type_list);
        $this->assign('site_id', $site_id);
        $this->assign('production_list', $production_list);
        $this->assign('search', $result['search']);
        $this->assign('page', $result['page']);
        $this->assign('now_page', I('p'));
        $this->display();
    }

    /**
     * 添加产品页面
     * @return [type] [description]
     */
    public function add_production(){
        $this->init_head("产品",1,1,3);
        $site_id = $this->site_info['id'];
        $production_id = I('get.production_id');
        if(!empty($production_id)){
            $production_info = D('production')->get_production_info($site_id,$production_id);
            $this->assign('production_info',$production_info);
            $this->assign('is_edit',1);
        }
        $type_list = M('production_type')
                        ->field('id,name')
                        ->where(array('site_id'=>$site_id))
                        // ->order('sort')
                        ->select();
        $this->assign('type_list', $type_list);
        $this->assign('site_id', $site_id);
        $this->display();
    }

    /**
     * 插入新增产品
     * @return [type] [description]
     */
    public function insert_production(){
        $return  = array('status' => 0, 'info' => '添加成功', 'data' => '');
        $data = I('post.');
        $data['site_id'] = $this->site_info['id'];
        $Production = D('Production');
        $result = $Production->add_production($data);
        if($result){
            $return['status'] = 1;
        }else{
            $return['status'] = 0;
            $return['info'] = $Production->getError();
        }
        $this->ajaxReturn($return);
    }

    /**
     * 编辑产品
     * @return [type] [description]
     */
    public function edit_production(){
        $return  = array('status' => 0, 'info' => '添加成功', 'data' => '');
        $production_id = I('post.id');
        if(empty($production_id)){
            $return['info'] = "请选择文章";
            $this->ajaxReturn($return);
            return;
        }
        $Production = D('Production');
        $result = $Production->add_production(I('post.'));
        if($result){
            $return['status'] = 1;
        }else{
            $return['status'] = 0;
            $return['info'] = $Production->getError();
        }
        $this->ajaxReturn($return);
    }

    /**
     * 修改产品状态(启用:0 禁用:-1 删除:1)
     * @return [type] [description]
     */
    public function update_production_status(){
        $return  = array('status' => 0, 'info' => '操作成功', 'data' => '');
        $ids = I('ids');
        $status = I('get.status')?I('get.status'):I('post.status',0);
        if(empty($ids)){
            $return['info'] = "请选择文章";
            $this->ajaxReturn($return);
            return;
        }
        $Production = D('Production');
        $result = $Production->update_production_status($this->site_info['id'],$ids,$status);
        if($result !== false){
            $return['status'] = 1;
        }else{
            $return['info'] = "操作失败";
        }
        $this->ajaxReturn($return);
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
