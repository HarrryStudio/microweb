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
     * 进入网站时 检测合法性 并计入session
     */
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

    /**
     * 跳转到 资源管理
     */
    public function toResource($site_id = null){
        if(empty($site_id)){
            $site_info = session("site_info");
            $site_id = $site_info['id'];
        }
        if(!$this->choose_site($site_id)){
            $this->redirect('Website/Index');
        }
        $this->redirect('Article/Index');
    }

    /**
     * 跳转到 编辑面板
     */
    public function toPanel($site_id = null){
        if(empty($site_id)){
            $site_info = session("site_info");
            $site_id = $site_info['id'];
        }
        if(!$this->choose_site($site_id)){
            $this->redirect('Website/index');
        }
        $this->redirect('Panel/index');
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
    	$SiteInfo = M("SiteInfo");
    	$map['id'] = I('post.id');
        $map['user_id'] = session('user_info')['id'];
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

    /**
     * 下载文件
     */
    public function download_site(){
        $site_id = I('site_id',session('site_info.id'));
        if(empty($site_id)){
            return $this->error('请选择网站');
        }
        $site_info = M()->table('site_info')
                        ->field('site_name,url,json')
                        ->where(array('id'=>$site_id,'user_id' => session('user_info.id'),'status'=>0))
                        ->find();
        if(empty($site_info)){
            return $this->error('此网站无效');
        }
        $info = M()->table('user_column')
                   ->where(array('site_id'=>$site_id,'forbidden'=>0))
                   ->order('sort')
                   ->select();
        if(empty($info)){
            return $this->error('没有找到文件');
        }
        $rootpath = C('TEMP_DIR').$site_info['url']."/";
        if(is_dir($rootpath)){
            deleteAll($rootpath,true);
        }elseif(!mkdir($rootpath)){
            return $this->error('创建根目录失败');
        }
        $public_rootpath = $rootpath."Public/";
        if(!mkdir($public_rootpath)){
            return $this->error('创建Public目录失败');
        }
        /*=================================生成html==============================*/
        $html_rootpath = $rootpath."html/";
        if(!mkdir($html_rootpath)){
            return $this->error('创建html目录失败');
        }
        $user_info = M()->table('user_info')->field('nickname,head_img')->find(session('user_info')['id']);
        $site_common = A('Panel')->get_site_common($site_id);
        $theme_templet = $site_common['theme_templet'];
        unset($site_common['theme_templet']);
        $this->collect_link($site_common['theme_links']);
        //var_dump($site_common['theme_links']);
        $this->assign($site_common);
        $this->assign('user_info',$user_info);
        $this->assign('download',true);

        /*==================生成栏目页===================*/
        foreach ($info as $key => $value) {
            $widget_common = A('Panel')->resolve_json($site_id,$value['html']);
            $this->collect_link($widget_common['links']);
            $links = array_merge_recursive($site_common['theme_links'],$widget_common['links']) ;

            $this->assign($links);
            $this->assign('now_column',$value['id']);
            $this->assign('content',$widget_common['content']);
            $html = $this->fetch('Theme/theme');
            $html = $this->replaceHtml($html);
            $result = file_put_contents($html_rootpath.$value['url'].'.html',$html);
            if(!$result){
                ////***删除文件**///
                deleteAll($rootpath);
                return $this->error('下载失败:html失败');
            }
        }
        /*==================生成详情页===================*/
        $desc = json_decode($site_info['json'],true);
        foreach($desc as $key => $value){
            $desc_info = D($key)->get_all_info($site_id);
            $desc_path = $rootpath.'/'.$key.'/';
            if(!mkdir($desc_path)){
                deleteAll($rootpath);
                return $this->error('创建$key目录失败');
            }
            $widget = A('Panel')->load_widget(ucwords(strtolower($key)).'Desc',$value);
            $widget_link = $widget->load_template_link();
            $this->collect_link($widget_link,$rootpath);
            $links = array_merge_recursive($site_common['theme_links'],$widget_link);
            $this->assign($links);
            foreach ($desc_info as $desc_key => $desc_resource) {
                ob_start();
                ob_implicit_flush(0);
                $widget->index($site_id,null,$desc_resource);
                $content = ob_get_clean();
                \Think\Hook::listen('view_filter',$content);
                $this->assign('content' ,$content);
                $html = $this->fetch('Theme/theme');
                $html = $this->replaceHtml($html);
                $result = file_put_contents($desc_path.$desc_resource['id'].'.html',$html);
                if(!$result){
                    ////***删除文件**///
                    deleteAll($rootpath);
                    return $this->error('下载失败:article失败');
                }
            }
        }

        /*=================================引入资源文件==============================*/
        /*=============引入js css=============*/
        $this->download_theme_link($public_rootpath,$site_common['site_ifno']['theme']);
        $this->download_widget_link($public_rootpath);

        /*=============引入img=============*/
        $img_path = $rootpath.'Uploads/';
        $photo_info = M()->table('photo as a')
                       ->field('c.savename,c.savepath')
                       ->join('home_picture as c on a.pic_id = c.id')
                       ->where(array('a.site_id' => $site_id))
                       ->select();

        $admin_column_info = M()->table('user_column as a')
                                 ->field('b.savename,b.savepath')
                                ->join('left join picture as b on a.icon = b.id')
                                ->where(array('a.site_id' => $site_id, 'a.is_default' => 1))
                                ->select();
        $home_column_info = M()->table('user_column as a')
                                 ->field('b.savename,b.savepath')
                                ->join('left join home_picture as b on a.icon = b.id')
                                ->where(array('a.site_id' => $site_id, 'a.is_default' => 0))
                                ->select();
        $article_info = M()->table('article as a')
                            ->field('b.savename,b.savepath')
                            ->join('left join home_picture as b on a.pic_id = b.id')
                            ->where(array('a.site_id' => $site_id))
                            ->select();
        $img_info = array_merge($photo_info,$admin_column_info,$home_column_info,$article_info);
        $uploads_path = C('PICTURE_UPLOAD')['rootPath'];
        foreach ($img_info as $key => $value) {
            hCopy($uploads_path.$value['savepath'].$value['savename'],$img_path.$value['savepath'].$value['savename']);
        }
        /*========================生成zip==============================*/
        load("@.HZip#class");
        $zip_name = C('TEMP_DIR').$site_info['url'].'.zip';
        $zip = \HZip::zipDir(C('TEMP_DIR').$site_info['url'],$zip_name);
        /*========================下载==================================*/
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

    /**
     * 转换link字符串
     * @param links array link数组array("js" => array(),"css" => array)
     * @param rootpath 用户根目录
     */
    function collect_link(&$links,$rootpath){
        $change = "../Public";
        if(is_array($links['js'])){
            foreach ($links['js'] as $key => $value) {
                $links['js'][$key] = str_replace(__ROOT__."/Public/Home",$change,$links['js'][$key]);
            }
        }
        if(is_array($links['css'])){
            foreach ($links['css'] as $key => $value) {
                $links['css'][$key] = str_replace(__ROOT__."/Public/Home",$change,$links['css'][$key]);
            }
        }
    }

    /**
     * 复制 模板所需文件 到用户目录
     */
    function download_theme_link($public_rootpath,$theme){
        $themepath = ".".C('THEME_PUBLIC_ROOT');
        $publicpath = $public_rootpath."Theme/";
        if(!mkdir($publicpath)){
            return false;
        }
        xCopy($themepath."Static",$publicpath);
        xCopy($themepath."Public",$publicpath);
        if(empty($theme)){
            $theme = "default";
        }
        $theme = $themepath.$theme;
        xCopy($theme,$publicpath);
    }

    /**
     * 复制 widget所需文件 到用户目录
     */
    function download_widget_link($public_rootpath){
        $widgetpath = ".".C('WIDGET_PUBLIC_PATH');
        xCopy($widgetpath,$public_rootpath);
    }

    /**
     * 转换所用图片路径
     */
    function replaceHtml($html){
        $uploads = C('TMPL_PARSE_STRING')['__UPLOADS__'];
        return  str_replace($uploads,'../Uploads',$html);
    }
}
