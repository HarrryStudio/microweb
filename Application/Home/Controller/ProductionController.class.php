<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 产品
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
        $article_list = $result['result'];
        $type_list = M('article_type')
                        ->field('id,name')
                        ->where(array('site_id'=>$site_id))
                        ->order('sort')
                        ->select();
        $this->assign('type_list', $type_list);
        $this->assign('site_id', $site_id);
        $this->assign('article_list', $article_list);
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
        // $this->ajaxReturn($data);
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
}
