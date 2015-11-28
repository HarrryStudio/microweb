<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 我的网站
 */
class WebsiteController extends BaseController { 
	/**
	 * 网站列表
	 */
    public function index(){
    	$SiteInfo = D("SiteInfo");
    	$user_info = I('session.user_info');
    	$site_list = $SiteInfo->get_site_list($user_info['id']);
        $this->init_head("网站列表");
    	$this->assign('site_list',$site_list);
    	$this->display();
    }
    /**
     * 判断网站是否属于用户
     * @return [type] [description]
     */
    public function allow_site($id){
        $site_info = session('site_info');
        if( in_array($id, $site_info)){
            return true;
        }
    }
    /**
     * 判断相册是否属于用户
     * @return [type] [description]
     */
    public function allow_album($id){
        $site_info = session('site_info');
        $site_ids = is_array($site_info) ? implode(',',$site_info) : $site_info;
        $where['site_id'] = array('in', $site_ids );
        $where['id'] = $id;
        $result = M('album')->where($where)->find();
        return !!$result;
    }
    /**
     * 判断照片是否属于用户(批量)
     * @return [type] [description]
     */
    public function allow_photo($id){
        $site_info = session('site_info');
        $site_ids = is_array($site_info) ? implode(',',$site_info) : $site_info;
        $id = is_array($id) ? implode(',',$id) : $id;
        $where['b.site_id'] = array('not in', $site_ids );
        $where['a.id'] = array('in', $id );
        $result = M()->table('photo as a')
                     ->join('album as b on a.album_id = b.id')
                     ->where($where)
                     ->find();
        return !$result;
    }
    /**
     * 判断文章是否属于用户(批量)
     * @return [type] [description]
     */
    public function allow_article($id){
        $site_info = session('site_info');
        $site_ids = is_array($site_info) ? implode(',',$site_info) : $site_info;
        $id = is_array($id) ? implode(',',$id) : $id;
        $where['site_id'] = array('not in', $site_ids );
        $where['id'] = array('in', $id );
        $result = M()->table('article')
                     ->where($where)
                     ->find();
        return !$result;
    }
    /**
     * 判断类型是否属于用户
     * @return [type] [description]
     */
    public function allow_type($id){
        $site_info = session('site_info');
        $site_ids = is_array($site_info) ? implode(',',$site_info) : $site_info;
        $where['site_id'] = array('in', $site_ids );
        $where['id'] = $id;
        $result = M('type')->where($where)->find();
        return !!$result;
    }
    /**
     * [删除网站]
     * @return [type] [0(成功)或1(失败)]
     * $map    条件
     * $result 删除结果
     * $ajax   返回结果
     * 
     */
    public function delete_site(){
        if(!$this->allow_site(I('post.id'))){
            $ajax['code'] = 1;
            $this->ajaxReturn($ajax);
            return;
        }
    	$SiteInfo = M("SiteInfo");
    	$map['id'] = I('post.id');
    	$data['status'] = 1;
    	$result = $SiteInfo->where($map)->save($data);
    	if ($result) {
    		$ajax['code'] = 0;
    		$ajax['id'] = $map['id'];
    	}else {
    		$ajax['code'] = 1;
    	}
        $key = array_keys($_SESSION['site_info'],$map['id']);
        unset($_SESSION['site_info'][$key['0']]);
        if(session('site_id') == $map['id']){
            session('site_id',null);
        }
    	$this->ajaxReturn($ajax);
    }

    /**
     * 检查网站数量
     * $map   条件 （user_id  &  status）
     * @return 0（可添加）或1（不可添加） message 提示信息
     */
    public function check_site_num(){
    	$SiteInfo = M('SiteInfo');
    	$map['user_id'] = session('user_info')['id'];
    	$map['status'] = 0;
    	$site_num = $SiteInfo->where($map)->count();
    	if ((int)$site_num >= (int)C('MAX_SITE_NUM')) {
    		$ajax['code'] = 1;
    		$ajax['message'] = "已达上限";
    	}
    	else {
    		$ajax['code'] = 0;
    	}
    	$this->ajaxReturn($ajax);
    }

    /**生成静态页面*/
    protected function init_site($site_id){
        /*获取 后台设置的nav*/
        $nav = M('topic as a')->field('a.id, a.name, a.sort , a.url, a.icon, CONCAT(savepath,savename) as icon_url')
                              ->join('left join picture as b on a.icon = b.id')
                              ->where(array('a.status'=>0,'a.forbidden'=>0))
                              ->select();
        if($nav === false){
            return false;
        }
        $m = M();
        $m->startTrans();
        /*新建空白html 并生成对应用户的nav*/
        foreach ($nav as $key => $value) {
            $html_id = $m->table('html')->add(array('html'=>''));
            if(!$html_id){
                $m->rollback();
                return false;
            }
            $data['site_id'] = $site_id;
            $data['html_id'] = $html_id;
            $data['name']    = $value['name'];
            $data['sort']    = $key + 1;
            $data['url']     = $value['url'];
            $data['icon']    = $value['icon']; 
            $column_id = $m->table('user_column')->add($data);
            if(!$column_id){
                $m->rollback();
                return false;
            }
            $nav[$key]['column_id'] = $column_id;
            $nav[$key]['html_id'] = $html_id;
        }
        $m->commit();
        return true;
    }

    /**
     * 添加网站
     * create 时 model里面自动验证
     * $data[] 需要添加的数据
     * $map    条件
     * @return $ajax 0（成功）或1（失败） [添加结果] message 提示信息
     */
    public function add_site(){
    	$data['site_name'] = I('post.site_name');
    	$data['url'] = I('post.url');
    	$data['user_id'] = session('user_info')['id'];
    	$data['create_time'] = time();
    	$data['update_time'] = time();
    	$map['user_id'] = $data['user_id'];
    	$map['status'] = 0;
    	$SiteInfo = D("SiteInfo");
        $SiteInfo->startTrans();
    	$result = $SiteInfo->create($data);

    	if (!$result) {
    		$ajax['code'] = 1;
    		$ajax['message'] = $SiteInfo->getError();
    		$this->ajaxReturn($ajax);
    	}
    	else {
    		$add_result = $SiteInfo->where($map)->add();
    		if ($add_result) {
                $result = $this->init_site($add_result);
                if($result){
    			    $ajax['code'] = 0;
                    $SiteInfo->commit();
                }else{
                    $SiteInfo->rollback();
                    $ajax['code'] = 1;
                    $ajax['message'] = "初始化网站失败";
                }
    		}
    		else {
                $SiteInfo->rollback();
    			$ajax['code'] = 1;
    			$ajax['message'] = "添加失败,请稍后再试";
    		}
            array_push($_SESSION['site_info'], $add_result);
	    	$this->ajaxReturn($ajax);
    	}
    }

    /**
     * 网站资源管理
     * 显示相册列表
     */
    public function album_list(){
        $id = I('get.site_id');
        if(empty($id)){
            $id = session('site_id');
        }else{
            if(!$this->allow_site($id)){
                $this->error("无权访问该网站");
                return;
            }
            session('site_id',$id);
        }
    	$Album = D('Album');
    	$album_list = $Album->get_album_list($id);
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
        if(!$this->allow_site(I('site_id'))){
            $ajax['code'] = 1;
            $ajax['message'] = "无权修改该网站内容";
            $this->ajaxReturn($ajax);
            return;
        }
        $data['site_id'] = I('site_id');
        $data['name'] = I('name');
        $data['create_time'] = time();
        $data['update_time'] = time();
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
        if(!$this->allow_album($album_id)){
            $ajax['status'] = 0;
            $ajax['info'] = "无权修改该相册内容";
            $this->ajaxReturn($ajax);
            return;
        }
        if(empty($name)){
            $return['status'] = 0;
            $return['info'] = "请填写相册名";
            $this->ajaxReturn($return); 
            return;
        }
        $Album = D('Album');
        $data['name'] = $name;
        $data['update_time'] = time();
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
        if(!$this->allow_album($album_id)){
            $ajax['status'] = 0;
            $ajax['info'] = "无权删除该相册";
            $this->ajaxReturn($ajax);
            return;
        }
        $Album = D('Album');
        $result = $Album->del_album($album_id);
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
        if(!$this->allow_album($album_id)){
            $this->error("无权访问该相册");
            return;
        }
        $Album = D('Album');
        $album_info = $Album->field('id,site_id,name,create_time,update_time')
                            ->where(array('id' => $album_id))
                            ->find();
        $photo_list = $Album->get_photo_list($album_id);
    
        $this->meta_title = "相册详细";
        $this->assign('photo_list',$photo_list);
        $this->assign('album_info',$album_info);
        $this->display();      
    }

    /**
     * 上传图片
     * @return error | info
     */
    public function upload_photo(){
        //  /* 返回标准数据 */
        $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');
        $album_id = I('post.album_id');
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
                $data[] = array('album_id' => $album_id, 'pic_id' => $value['id'], 'create_time' => time());
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
        if(!$this->allow_photo($id)){
            $ajax['status'] = 0;
            $ajax['info'] = "无权删除该图片";
            $this->ajaxReturn($ajax);
            return;
        }
        $model = M();
        $model->startTrans();
        $where = array('id' => array('in', $id ));
        $sql = $model->table('photo')->field('pic_id')->where($where)->select(false);
        $result = $model->table('picture')->where('id in ('.$sql.') ')->setDec('used');
        if($result !== false){
            $result = $model->table('photo')->where($where)->delete();
            if($result !== false){
                $model->commit();
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

    /**
     * 文章列表页
     * @return [type] [description]
     */
    public function article_list(){ 
        $this->init_head("文章",1,1,2);
        $site_id = I('get.site_id');
        if(empty($site_id)){
            $site_id = session('site_id');
        }else{
            if(!$this->allow_site($site_id)){
                $this->error("无权访问该网站");
                return;
            }
        }
        $Atrticle = D('Article');
        $result = $Atrticle->get_article_list($site_id);
        $article_list = $result['result'];
        $type_list = M('type')
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
        if(!$this->allow_article($ids)){
            $return['info'] = "无权修改某个文章";
            $this->ajaxReturn($return);
            return;
        }
        $Atrticle = D('Article');
        $result = $Atrticle->update_article_status($ids,$status);
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
        if(!$this->allow_article($id)){
            $return['info'] = "无权修改某个文章";
            $this->ajaxReturn($return);
            return;
        }
        $Atrticle = D('Article');
        $result = $Atrticle->top_article($id,$status);
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
        if(!$this->allow_article($ids)){
            $return['info'] = "无权修改某个文章";
            $this->ajaxReturn($return);
            return;
        }
        $Atrticle = D('Article');
        $result = $Atrticle->change_article_type($ids,$type);
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
        $site_id = I('get.site_id');
        $article_id = I('get.article_id');
        if(!empty($article_id)){
            if(!$this->allow_article($article_id)){
                $this->error("无权修改该网站内容");
                return;
            }
            $article_info = M()->table('article as a')
                               ->field('a.*,b.savepath,b.savename')
                               ->join('left join picture as b on a.pic_id = b.id')
                               ->where(array('a.status' => array('gt',-1),'a.id'=>$article_id))
                               ->find();
            $this->assign('article_info',$article_info);
            $this->assign('is_edit',1);
            $site = M('article')->field('site_id')->find($article_id);
            $site_id = $site['site_id'];
        }else{
            if(empty($site_id)){
                $this->error("请选择网站");
                return;
            }
            if(!$this->allow_site($site_id)){
                $this->error("无权修改该网站内容");
                return;
            }
        }
        $type_list = M('type')
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
        $site_id = I('post.site_id');
        if(empty($site_id)){
            $return['info'] = "请选择网站";
            $this->ajaxReturn($return); 
            return;
        }
        if(!$this->allow_site($site_id)){
            $ajax['status'] = 0;
            $ajax['info'] = "无权修改该网站内容";
            $this->ajaxReturn($ajax);
            return;
        }
        $Article = D('Article');
        $result = $Article->insert_article();
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
        if(!$this->allow_article($article_id)){
            $ajax['status'] = 0;
            $ajax['info'] = "无权修改该文章内容";
            $this->ajaxReturn($ajax);
            return;
        }
        $Article = D('Article');
        $result = $Article->insert_article();
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
        $site_id = I('site_id');
        if(!$this->allow_site($site_id)){
            $this->error("无权修改该网站内容");
            return;
        }
        $type_list = M('type')
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
        $type_id = I('post.type_id');
        $site_id = I('post.site_id');
        $name = I('post.name');
        if(empty($name)){
            $return['info'] = "请填写分类名称";
            $this->ajaxReturn($return); 
            return;
        }
        if(!preg_match('/^([\x{4e00}-\x{9fa5}A-Za-z0-9_]){1,20}+$/u',$name)){
            $return['info'] = "分类名由1-20位汉字或字母或数字组成";
            $this->ajaxReturn($return); 
            return;
        }
        $Type = M('type');
        $data['name'] = I('post.name');
        $data['site_id'] = (int)$site_id;
        $check = $Type->where($data)->find();
        if(!empty($check)){
            $return['info'] = "分类名不能重复";
            $this->ajaxReturn($return); 
            return;
        }
        $data['update_time'] = time();
        if(empty($type_id)){
            if(empty($site_id)){
                $return['info'] = "请选择网站";
                $this->ajaxReturn($return); 
                return;
            }
            if(!$this->allow_site($site_id)){
                $ajax['status'] = 0;
                $ajax['info'] = "无权修改该网站内容";
                $this->ajaxReturn($ajax);
                return;
            }
            $data['create_time'] = time();
            $max = $Type->where(array('site_id'=>$site_id))->max('sort');
            $data['sort'] = (int)$max + 1;
            $result = $Type->add($data);
        }else{
            if(!$this->allow_type($type_id)){
                $ajax['status'] = 0;
                $ajax['info'] = "无权删除该类型";
                $this->ajaxReturn($ajax);
                return;
            }
            $result = $Type->where(array('id'=>$type_id))->save($data);
        }
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
        $now_type_id = I('post.now_type_id');
        $to_type_id = I('post.to_type_id');
        
        if(empty($now_type_id) || empty($to_type_id)){
            $return['info'] = "请选择要移动的类型";
            $this->ajaxReturn($return); 
            return;
        }
        if(!$this->allow_type($now_type_id) || !$this->allow_type($to_type_id)){
            $ajax['status'] = 0;
            $ajax['info'] = "无权修改该类型";
            $this->ajaxReturn($ajax);
            return;
        }

        $Type = M('type');
        $now_sort = $Type->field('sort')->where(array('id'=>$now_type_id))->find();
        $to_sort = $Type->field('sort')->where(array('id'=>$to_type_id))->find();
        $temp = $now_sort['sort'];
        $Type->startTrans();
        $data['update_time'] = time();
        $data['sort'] = $to_sort['sort'];
        $result = $Type->where(array('id'=>$now_type_id))->save($data);
        if(!$result){
            $Type->rollback();
            $return['info'] = $Type->getError();
            $this->ajaxReturn($return); 
            return;
        }
        $data['sort'] = $temp;
        $result = $Type->where(array('id'=>$to_type_id))->save($data);
        if(!$result){
            $Type->rollback();
            $return['info'] = $Type->getError();
            $this->ajaxReturn($return); 
            return;
        }
        $Type->commit();
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
        if(!$this->allow_type($id)){
            $ajax['status'] = 0;
            $ajax['info'] = "无权删除该类型";
            $this->ajaxReturn($ajax);
            return;
        }
        $Type = M('type');
        $result = $Type->where(array('id'=>$id))->delete();
        if($result){
            $return['status'] = 1;
        }else{
            $return['info'] = $Type->getError();
        }
        $this->ajaxReturn($return);
    }

    /*下载文件*/
    public function download_site(){
        $site_id = I('site_id',session('site_id'));
        if(empty($site_id)){
            return $this->error('请选择网站');
        }
        $site_info = M()->table('site_info')
                        ->field('site_name,url')
                        ->where(array('id'=>$site_id,'status'=>0))
                        ->find();
        if(empty($site_info)){
            return $this->error('此网站无效');
        }
        $info = M()->table('user_column')
                   ->field('user_column.*,html.html')
                   ->join('html on html.id = user_column.html_id')
                   ->where(array('site_id'=>$site_id,'forbidden'=>0))
                   ->order('sort')
                   ->select();
        if(empty($info)){
            return $this->error('没有找到文件');
        }
        $rootpath = C('TEMP_DIR').$site_info['url']."/";
        if(!mkdir($rootpath)){
            var_dump($info);
            echo $rootpath;
            return;
            return $this->error('创建根目录失败');
        }
        $user_info = M()->table('user_info')->field('nickname,head_img')->find(session('user_info')['id']);
        $nav = M()->table('user_column as a')
                  ->field('a.id , a.name, a.sort, a.forbidden, a.url, savepath,savename')
                  ->join('left join picture as b on a.icon = b.id')
                  ->where(array('site_id'=>$site_id))
                  ->order('sort')
                  ->select();
        $root = C('UPLOAD_ROOT');
        foreach ($nav as $key => $value) {
            $nav[$key]['icon_url'] = $root.$value['savepath'].$value['savename'];
        }
        $this->assign('user_info',$user_info);
        $this->assign('site_name',$site_info['site_name']);
        $this->assign('nav_list',$nav);
        /*生成html*/
        foreach ($info as $key => $value) {
            $this->assign('now_column',$value['id']);
            $this->assign('content',$value['html']);
            $html = $this->fetch('Public/theme');
            $html = $this->replaceHtml($html);
            $result = file_put_contents($rootpath.$value['url'].'.html',$html);
            if(!$result){
                ////***删除文件**///
                deleteAll($rootpath);
                return $this->error('下载失败:html失败'); 
            }
        } 
        $article_info = M()->table('article')
                           ->where(array('site_id'=>$site_id,'status'=>0))
                           ->select();
        $article_path = $rootpath.'/article/';
        if(!mkdir($article_path)){
            deleteAll($rootpath);
            return $this->error('创建文章目录失败');
        }
        foreach ($article_info as $key => $value) {
            $this->assign('article_item',$value);
            $article_html = $this->fetch('Panel/article_info');
            $article_html = $this->replaceHtml($article_html);
            $result = file_put_contents($article_path.$value['id'].'.html',$article_html);
            if(!$result){
                ////***删除文件**///
                deleteAll($rootpath);
                return $this->error('下载失败:article失败'); 
            }
        }
        /*引入js css*/
        $js = xCopy(C('USER_FILE_DIR'),$rootpath);
        /*引入img*/
        $img_path = $rootpath.'Uploads/';
        $img_info = M()->table('photo as a')
                       ->field('c.savename,c.savepath')
                       ->join('album as b on a.album_id = b.id')
                       ->join('picture as c on a.pic_id = c.id')
                       ->where(array('b.site_id' => $site_id))
                       ->select();
        $uploads_path = C('PICTURE_UPLOAD')['rootPath'];
        foreach ($img_info as $key => $value) {
            hCopy($uploads_path.$value['savepath'].$value['savename'],$img_path.$value['savepath'].$value['savename']);
        }
        /*生成zip*/
        load("@.HZip#class");
        $zip_name = C('TEMP_DIR').$site_info['url'].'.zip';
        $zip = \HZip::zipDir(C('TEMP_DIR').$site_info['url'],$zip_name);
        /*下载*/
        header ( "Cache-Control: max-age=0" );
        header ( "Content-Description: File Transfer" );
        header ( 'Content-disposition: attachment; filename=' . basename ( $zip_name ) ); // 文件名
        header ( "Content-Type: application/zip" ); // zip格式的
        header ( "Content-Transfer-Encoding: binary" ); //二进制文件
        header ( 'Content-Length: ' . filesize ( $zip_name ) ); // 告诉浏览器，文件大小
        @readfile ( $zip_name );//输出文件;
        unlink($zip_name);
        deleteAll($rootpath);
    }
    function replaceHtml($html){
        $user_files = C('TMPL_PARSE_STRING')['__USERFILES__'];
        $uploads = C('TMPL_PARSE_STRING')['__UPLOADS__'];
        $html =  str_replace($user_files,'.',$html);
        return  str_replace($uploads,'./Uploads',$html);
    }
}