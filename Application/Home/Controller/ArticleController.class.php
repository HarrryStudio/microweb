<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 我的网站
 */
class ArticleController extends ResourceController {
    /**
     * 文章列表页
     * @return [type] [description]
     */
    public function index(){
        $this->init_head("文章",1,1,2);
        $site_id = $this->site_info['id'];
        $Atrticle = D('Article');
        $result = $Atrticle->get_article_list($site_id);
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
     * 修改文章状态(启用:0 禁用:1 删除:-1)
     * @return [type] [description]
     */
    public function update_article_status(){
        $return  = array('status' => 0, 'info' => '操作成功', 'data' => '');
        $ids = I('ids');
        $status = I('get.status')?I('get.status'):I('post.status',0);
        if(empty($ids)){
            $return['info'] = "请选择文章";
            $this->ajaxReturn($return);
            return;
        }
        $Atrticle = D('Article');
        $result = $Atrticle->update_article_status($this->site_info['id'],$ids,$status);
        if($result !== false){
            $return['status'] = 1;
        }else{
            $return['info'] = "操作失败";
        }
        $this->ajaxReturn($return);
    }

    /**
     * 置顶/取消置顶(顶:1 踩:0)
     * @return [type] [description]
     */
    public function top_article(){
        $return  = array('status' => 0, 'info' => '操作成功', 'data' => '');
        $id = I('id');
        $status = I('status',0);
        if(empty($id)){
            $return['info'] = "请选择文章";
            $this->ajaxReturn($return);
            return;
        }
        $Atrticle = D('Article');
        $result = $Atrticle->top_article($this->site_info['id'],$id,$status);
        if($result !== false){
            $return['status'] = 1;
        }else{
            $return['info'] = '操作失败';
        }
        $this->ajaxReturn($return);
    }

    /**
     * 设置文章类型
     * @return [type] [description]
     */

    public function change_article_type(){
        $return  = array('status' => 0, 'info' => '修改成功', 'data' => '');
        $ids = I('ids');
        $type = I('get.type_id');
        if(empty($ids)){
            $return['info'] = "请选择文章";
            $this->ajaxReturn($return);
            return;
        }
        if(empty($type)){
            $return['info'] = "请选择类型";
            $this->ajaxReturn($return);
            return;
        }
        $Atrticle = D('Article');
        $result = $Atrticle->change_article_type($this->site_info['id'],$ids,$type);
        if($result !== false){
            $return['status'] = 1;
        }else{
            $return['info'] = $Atrticle->getError();
        }
        $this->ajaxReturn($return);

    }

    /**
     * 添加文章页面
     * @return [type] [description]
     */
    public function add_article(){
        $this->init_head("文章",1,1,2);
        $site_id = $this->site_info['id'];
        $article_id = I('get.article_id');
        if(!empty($article_id)){
            $article_info = D('article')->get_article_info($site_id,$article_id);
            $this->assign('article_info',$article_info);
            $this->assign('is_edit',1);
        }
        $type_list = M('article_type')
                        ->field('id,name')
                        ->where(array('site_id'=>$site_id))
                        ->order('sort')
                        ->select();
        $this->assign('type_list', $type_list);
        $this->assign('site_id', $site_id);
        $this->display();
    }

    /**
     * 插入新建文章
     * @return [type] [description]
     */
    public function insert_article(){
        $return  = array('status' => 0, 'info' => '添加成功', 'data' => '');
        $data = I('post.');
        $data['site_id'] = $this->site_info['id'];
        $Article = D('Article');
        $result = $Article->insert_article($data);
        if($result){
            $return['status'] = 1;
        }else{
            $return['status'] = 0;
            $return['info'] = $Article->getError();
        }
        $this->ajaxReturn($return);
    }

    /**
     * 编辑文章
     * @return [type] [description]
     */
    public function edit_article(){
        $return  = array('status' => 0, 'info' => '添加成功', 'data' => '');
        $article_id = I('post.id');
        if(empty($article_id)){
            $return['info'] = "请选择文章";
            $this->ajaxReturn($return);
            return;
        }
        $Article = D('Article');
        $result = $Article->insert_article(I('post.'));
        if($result){
            $return['status'] = 1;
        }else{
            $return['status'] = 0;
            $return['info'] = $Article->getError();
        }
        $this->ajaxReturn($return);
    }

    /**
     * 管理文章类型页
     */
    public function set_classify(){
        $this->init_head("分类管理",1,1,2);
        $site_id = $this->site_info['id'];
        $type_list = M('article_type')
                        ->field('id,name,sort')
                        ->where(array('site_id' => $site_id))
                        ->order('sort')
                        ->select();
                        // print_r($type_list);
        $this->assign("site_id",$site_id);
        $this->assign("type_list",$type_list);
        $this->display();
    }

    /**
     * 添加/重命名类型
     */
    public function add_type(){
        $return  = array('status' => 0, 'info' => '添加成功', 'data' => '');
        $data = I('post.');
        $data['site_id'] = $this->site_info['id'];
        $Type = D('ArticleType');
        $result = $Type->add_type($data);
        if($result){
            $return['status'] = 1;
        }else{
            $return['info'] = $Type->getError();
        }
        $this->ajaxReturn($return);
    }

    /**
     * 类型调序
     * @return [type] [description]
     */
    public function type_change_sort(){
        $return  = array('status' => 0, 'info' => '调序成功', 'data' => '');
        $Type = D('ArticleType');
        $now_type_id = I('post.now_type_id');
        $to_type_id = I('post.to_type_id');
        if(empty($now_type_id) || empty($to_type_id)){
            $return['info'] = "请选择要移动的类型";
            $this->ajaxReturn($return);
            return;
        }
        $result = $Type->type_change_sort($this->site_info['id'],$now_type_id,$to_type_id);
        if(!$result){
            $return['info'] = $Type->getError();
            $this->ajaxReturn($return);
            return;
        }
        $return['status'] = 1;
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
        $Type = M('article_type');
        $result = $Type->where(array('id'=>$id,'site_id' => $this->site_info['id']))->delete();
        if($result){
            $return['status'] = 1;
        }else{
            $return['info'] = $Type->getError();
        }
        $this->ajaxReturn($return);
    }

}
