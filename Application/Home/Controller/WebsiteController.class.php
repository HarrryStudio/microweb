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

    private function choose_site($site_id){
        $site_info = session('site_info');
        if($site_info['id'] == $site_id){
            return true;
        }
        $user_info = I('session.user_info');
        $site_info = M('site_info')
                        ->field('id,site_name,url,theme,back')
                        ->where(array('id' => $site_id,'user_id'=>$user_info['id'],'status'=>0,'forbidden'=>0))
                        ->find();
        if(!empty($site_info)){
            session('site_info',$site_info);
            return true;
        }
        return false;
    }

    public function toResource($site_id = null){
        if(!empty($site_id)){
            if(!$this->choose_site($site_id)){
                $this->redirect('Website/Index');
            }
        }
        //$this->redirect('Article/Index');
    }

    public function toPanel($site_id = null){
        if(!empty($site_id)){
            if(!$this->choose_site($site_id)){
                $this->redirect('Website/Index');
            }
        }
        $this->redirect('Panel/Index');
    }

    /**
     * 添加网站
     * create 时 model里面自动验证
     * $data[] 需要添加的数据
     * $map    条件
     * return $ajax 0（成功）或1（失败） [添加结果] message 提示信息
     */
    public function add_site(){

        $SiteInfo = D("SiteInfo");
        $result = $SiteInfo->add_site();

        if (!$result) {
            $ajax['code'] = 1;
            $ajax['message'] = $SiteInfo->getError();
            $this->ajaxReturn($ajax);
        }else{
            $ajax['code'] = 0;
        }
        $this->ajaxReturn($ajax);
        return;
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
        $site_session = session('site_info');
        if( $map['id'] == $site_session['id']){
            session('site_info',null);
        }
    	$this->ajaxReturn($ajax);
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
