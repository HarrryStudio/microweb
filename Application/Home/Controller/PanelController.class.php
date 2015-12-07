<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 操作面板
 */
class PanelController extCends BaseController {

    public function allowColumn($id){
       // echo session("site_id");
        //echo "ggg".$id;
        $result = M()->table('user_column')
                      ->where(array('id'=>$id,'site_id'=>session('site_id')))
                      ->find();
               // var_dump($result);
        return !empty($result);
    }


    public function index($site_id){
        if(!A("Website")->allow_site($site_id)){
            return $this->error();
        }
        session('site_id',$site_id);
        
        $column_info = D('UserColumn')->get_column_info($site_id);
        $site_info = M()->table('site_info')->field('theme')->where(array('id'=>$site_id))->find();

        $controller_list = M('controller')
                            ->field('id,name,intro,cname,icon')
                            ->where(array('forbidden' => 0 , 'status' => 0))
                            ->order('sort')
                            ->select();
        $theme_list = M()->table('theme as a')
                         ->field('a.name,a.id,b.savepath,b.savename')
                         ->join('picture as b on a.pic_id = b.id')
                         ->where(array('a.status'=> 0,'a.name'=>array('neq',"")))
                         ->select();
                         // echo M()->getLastSql();
        $back_list = M()->table('background as a')
                         ->field('a.name,a.id,b.savepath,b.savename')
                         ->join('picture as b on a.pic_id = b.id')
                         ->where(array('a.status'=> 0,'a.forbidden'=> 0))
                         ->select();
        $this->assign('nowColumn',$column_info[0]);
        $this->assign('column_info',$column_info);
        $this->assign('site_info',$site_info);
        $this->assign('controller_list',$controller_list);
        $this->assign('theme_list',$theme_list);
        $this->assign('back_list',$back_list);
        $this->assign('site_id',$site_id);
        $this->display();
    }


    //harrry_change ::: update
    /**
     * 显示html
     */
    public function readHtml(){
        $column_id = I('column_id');
        //echo "fff".$id;
        $user_id = session('user_info')['id'];
        if(empty($user_id)){
            $this->error("没有找到用户");
            return;
        }
        $site_id = session('site_id');
        if(empty($site_id)){
            $this->error("还没创建任何栏目,请在右边栏目中创建");
            return;
        }elseif(!$this->allowColumn($column_id)){
            //echo $id;
            //echo 'error';
            $this->error('无权访问网页');
            return;
        }
        $result = M()->table('user_column')
            ->field("html")
            ->where(array('id'=>$column_id,'forbidden'=>0))
            ->find();
        if(empty($result)){
            $this->error('没有找到网页');
            return;
        }

        $user_info = M()->table('user_info')->field('nickname,head_img')->find($user_id);

        $Column = D('UserColumn');
        $json = $Column->get_html_json($column_id);
        $content = $this->resolve_json($json);

        $site_common = $this->get_site_common($site_id);

        $theme_templet = $site_common['theme_templet'];
        unset($site_common['theme_templet']);

        foreach($site_common as $key => $value){
            $this->assign($key,$value);
        }
        $this->assign('user_info',$user_info);
        $this->assign('now_column',$column_id);
        $this->assign('content',$content);
        $this->display( $theme_templet );

    }

    /**
     * 找到主题的模板
     * @param $theme_name 主题名
     * @return string   模板地址
     * 模板文件 是Home/View/Theme文件夹下 名为{$theme_name}_theme.html   可以没有 默认选择 theme.html
     */
    private function load_theme_templet($theme_name){
        $html_name = $theme_name."_theme";
        if(file_exists(C('THEME_HTML_ROOT').$html_name."html")){
            return "Theme/".$html_name;
        }else{
            return "Theme/theme";
        }
    }

    /**
     * 加载主题文件
     * @param $theme_name   文件名
     * css,js 分别在Public/Home/theme/{$theme_name} 文件夹下 的 css文件夹下 和 js文件夹下
     * @return data['html'] string  模板文件   ['public'] string 引入js,css文件的html脚本
     */
    private function load_theme_file($theme_name){

        $dir_name = C('THEME_PUBLIC_ROOT').$theme_name;
        $data = [];
        if(is_dir($dir_name)){
            if(is_dir($dir_name."/js")){
                if ($dh = opendir($dir_name."/js")) {
                    while (($file = readdir($dh)) !== false) {
                        $data['js'] = $file;
                        //$data['public'] .= '<script type="text/javascript" src="'.$file.'"></script>'."\n";
                    }
                    closedir($dh);
                }
            }
            if(is_dir($dir_name."/css")){
                if ($dh = opendir($dir_name."/css")) {
                    while (($file = readdir($dh)) !== false) {
                        $data['css'] = $file;
                        //$data['public'] .= '<link rel="stylesheet" type="text/css" href="'.$file.'">'."\n";
                    }
                    closedir($dh);
                }
            }
        }
        return $data;
    }

    /**
     * 得到网站的通用信息
     * @param $site_id  网站id
     * @return array    通用信息
     */
    public function get_site_common($site_id){
        $Column = D('UserColumn');

        $site_info = M()
            ->table('site_info')
            ->field('site_name,theme,back')
            ->where(array('status' => 0, 'id' => $site_id))
            ->find();
        $back = M()
            ->table('background as a')
            ->field('a.id,savepath,savename')
            ->join('picture as b on a.pic_id = b.id')
            ->where(array('a.id' => $site_info['back'], 'a.status' => 0) )
            ->find();

        $site_info['back'] = $back['savepath'] . $back['savename'];

        $theme = M()
            ->table('theme')
            ->field('name')
            ->where(array('status' => 0, 'id' => $site_info['theme']))
            ->find();
        $theme_file = $this->load_theme_file($theme['name']);

        $theme_templet= $this->load_theme_templet($theme['name']);

        $nav_list = $Column->get_nav_list($site_id);

        return array(
            'site_info'     =>  $site_info,
            'nav_list'      =>  $nav_list,
            'theme_templet' =>  $theme_templet,
            'theme_file'    =>  $theme_file
        );
    }

    /**
     * 解析json 返回html
     * @param  $json   json字符串
     *  { header : {} ,
     *   content: [
     *       { name: , resoures : , theme :} , .....
     *   ],
     *    footer: {},
     * }
     * @return string  html
     */
    public function resolve_json($json){
        $content = json_decode($json,true);
        $widgets = [];
        foreach($content['content'] as $item){
            $class =  $item['name'] . WIDGET_NAME;
            import(MODULE_NAME ."/" . WIDGET_NAME .$class);
            if(class_exists($class)) {
                $widgets[] = new $class($item);
            }else {
                continue;
            }
        }
        // 页面缓存
        ob_start();
        ob_implicit_flush(0);
        foreach($widgets as $widget){
            $widget->show();
        }
        $content = ob_get_clean();
        \Think\Hook::listen('view_filter',$content);
        return $content;
    }


    //harrry ::: update
    /**
     * 修改html
     */
    public function writeHtml(){
        $return  = array('status' => 0, 'info' => '保存成功', 'data' => '');
        $id = I('get.column_id');
        // echo $id;
        if(!$this->allowColumn($id)){
            $return['info'] = '无权访问网页';
            $this->ajaxReturn($return);
            return;
        }
        $Column = D("UserColumn");
        $result = $Column->writeHtml();

        if($result){
            $return['status'] = 1;
        }else{
            $return['info'] = $Column->getError();
        }
        $this->ajaxReturn($return);
    }

    public function writeArticle(){
        $return  = array('status' => 0, 'info' => '保存成功', 'data' => '');
        $result = M()->table('site_info')
                     ->where(array('id'=>session('site_id')))
                     ->save(array('theme'=>I('theme'),'back'=>I('back')));
        if($result === false){
            $return['info'] = 'info保存失败';
        }else{
            $return['status'] = 1;
        }
        $this->ajaxReturn($return);
    }


    /**
     * [control_widget description]
     * @param  [type] $name    [description]
     * @param  [type] $is_edit [description]
     * @return [type]          [description]
     */
    public function control_widget($name,$is_edit){
        $class =  $item['name'] . WIDGET_NAME;
        import(MODULE_NAME ."/" . WIDGET_NAME .$class);
        if(class_exists($class)) {
            $widget = new $class($item);
        }else {
            $this->show(':( 没有找到控件');
            return;
        }
        $widget->controller($is_edit);
    }























    /**
*获取栏目信息
*gaoyadong
*/

    // public function column_title(){
    //     // $id = I("post.id");
    //     $id = 1;
    //     $model=M();
    //     $list = $model->table("site_info")->alias("s")
    //         ->join("user_column as u on s.id=u.site_id")
    //         ->join("picture as p on u.icon=p.id")
    //         ->field("u.name, u.url, p.savepath, p.savename")
    //         //->limit(6)
    //         ->where("s.user_id=".$id)->select();
    //     $this->ajaxReturn($list);
    // }

    public function column_title(){
        $id = I("post.id");
        $model=M();
        $list = $model->table("user_column")->alias("u")
            ->join("left join picture as p on u.icon=p.id")
            ->field("u.name, u.url, p.savepath, p.savename")
            ->where("u.site_id=".$id)->select();
        $this->ajaxReturn($list);
    }
    
    /**
    *添加编辑页右侧栏目导航信息
    *gaoyadong
     * @update harrry 2015-12-3
    */
    public function addColumn(){
        $return  = array('status' => 0, 'info' => '保存成功', 'data' => '');

        $pic_info = $this->upload_column_icon();

        if($pic_info === false){
            $return['info'] = "上传图片失败";
        }else{
            if($pic_info > 0){
                $pic_id = $pic_info['column_icon']['id'];
            }
            $Column = D('UserColumn');
            $result = $Column->add_column($pic_id);
            if(!$result){
                $return['info'] = "添加失败";
                if( $pic_id > 0){
                    $this->rollback_column_icon();
                }
            }else{
                if( $pic_id > 0){
                    $result['icon_url'] = C('UPLOAD_ROOT').$pic_info['savepath'].$pic_info['savename'];
                }
                $return['data'] = $result;
                $return['status'] = 1;
            }
        }
        $this->ajaxReturn($return);
    }
    /**
     * 编辑 栏目column
     * @update harrry 2015-12-3
     */
    public function editColumn(){
        $return  = array('status' => 0, 'info' => '保存成功', 'data' => '');
        $column_id = I('post.id');
        if(!$this->allowColumn($column_id)){
            $return['info'] = "无权操作此栏目";
            $this->ajaxReturn($return);
            return;
        }
        $pic_info = $this->upload_column_icon();


        if($pic_info === false){
            $return['info'] = "上传图片失败";
        }else{
            if($pic_info > 0){
                $pic_id = $pic_info['column_icon']['id'];
            }
            $Column = D('UserColumn');
            $result = $Column->edit_column($pic_id);
            if(!$result){
                $return['info'] = "修改失败";
                if( $pic_id > 0){
                    $this->rollback_column_icon();
                }
            }else{
                if( $pic_id > 0){
                    $result['icon_url'] = C('UPLOAD_ROOT').$pic_info['savepath'].$pic_info['savename'];
                }
                $return['data'] = $result;
                $return['status'] = 1;
            }

        }
        $this->ajaxReturn($return);
    }
    /**
     * 禁用 栏目
     */
    public function forbide_column(){
        $return  = array('status' => 0, 'info' => '操作成功', 'data' => '');
        $status = I('status');
        //echo I('status');
        $column_id = I('column_id');
        if(!is_numeric($status)){
            $return['info'] = "请明确是否禁用";
            $this->ajaxReturn($return);
            return;
        }
        if(empty($column_id)){
            $return['info'] = "请选择要操作的栏目";
            $this->ajaxReturn($return);
            return;
        }
        if(!$this->allowColumn($column_id)){
            $return['info'] = "无权操作此栏目";
            $this->ajaxReturn($return);
            return;
        }
        $count = M()->table('user_column')
                    ->where(array('id'=>$column_id,'forbidden'=>0))
                    ->count();
        if($count <= 1){
            $return['info'] = "必须保留有一正常显示栏,此栏不能删除";
            $this->ajaxReturn($return);
            return;
        }
        $result = M()->table('user_column')
                    ->where(array('id'=>$column_id))
                    ->save(array('forbidden'=>$status));
        if($result === false){
            $return['info'] = "操作失败";
        }else{
            $return['status'] = 1;
        }
        $this->ajaxReturn($return);

    }
    /**
     * 删除 栏目
     */
    public function del_column(){
        $return  = array('status' => 0, 'info' => '保存成功', 'data' => '');
        $status = 1;
        $column_id = I('column_id');
        if(empty($column_id)){
            $return['info'] = "请选择要操作的栏目";
            $this->ajaxReturn($return);
            return;
        }
        if(!$this->allowColumn($column_id)){
            $return['info'] = "无权操作此栏目";
            $this->ajaxReturn($return);
            return;
        }
        $count = M()->table('user_column')
                    ->where(array('id'=>$column_id,'forbidden'=>0))
                    ->count();
        if($count <= 1){
            $return['info'] = "必须保留有一正常显示栏,此栏不能删除";
            $this->ajaxReturn($return);
            return;
        }
        $result = M()->table('user_column')
                    ->where(array('id'=>$column_id))
                    ->delete();
        if($result === false){
            $return['info'] = "操作失败";
        }else{
            $return['status'] = 1;
        }
        $this->ajaxReturn($return);

    }

    /**
     * 栏目调序
     * @return [type] [description]
     */
    public function sort_column(){
        $return  = array('status' => 0, 'info' => '调序成功', 'data' => '');
        $now_column_id = I('post.now_column_id');
        $to_column_id = I('post.to_column_id');
        
        if(empty($now_column_id) || empty($to_column_id)){
            $return['info'] = "请选择要移动的栏目";
            $this->ajaxReturn($return); 
            return;
        }

        if(!$this->allowColumn($now_column_id) || !$this->allowColumn($to_column_id)){
            $ajax['status'] = 0;
            $ajax['info'] = "无权操作该栏目";
            $this->ajaxReturn($ajax);
            return;
        }

        $Column = D('user_column');
        $result = $Column->sort_column($now_column_id,$to_column_id);
        if($result){
            $return['status'] = 1;
        }else{
            $return['info'] = $Column->getError();
        }
        $this->ajaxReturn($return);
    }

    /**
     * 上传栏目图标
     * @return [type] [description]
     */
    public function upload_column_icon(){
        $Picture = D('Picture');
        $info = $Picture->upload(
            $_FILES,
            array_merge(C('PICTURE_UPLOAD'),array('savePath'=>'column/')),
            C('PICTURE_UPLOAD_DRIVER')
        ); 
        return $info;
    }













//魔方导航:gaoyadong
    public function magic(){
        $id = I("id");      //控件id
        $this -> assign("controllerId",$id);
        $is_edit = I('get.is_edit',0);
        if(!empty($is_edit)){
            $this->assign("status", 1);
        }
        $this -> display();
    }
    /**
     * 取得文章类型
     * @return type_list
     */
    public function article_list(){
        $is_edit = I('get.is_edit',0);
        if(!empty($is_edit)){
            $this->assign("status",1);
        }
        $Type = M('type');
        $map['site_id'] = session('site_id');
        $type_list = $Type->field('id, name')->where($map)->select();
        $Column = M('user_column');
        $column_list = $Column->where($map)->select();
        $this->assign("column_list", $column_list);
        $this->assign('controller_id',I('id'));
        $this->assign('type_list',$type_list);
        $this->display();
    }
    /**
     * 取得文章列表
     * @return article_info
     */
    public function article_type(){
        $getType = I('get.type');
        if (!empty($getType)) {
            if (I('post.type')[0] == 0) {

            } else {
                $map['article.type_id'] = array(in, I('post.type'));
            }
            $map['article.status'] = 0;
            $Article = M('article');
            $article_info = $Article
                    ->field('article.id, picture.savepath, picture.savename, article.title, article.content')
                    ->join('left join picture ON  article.pic_id = picture.id')
                    ->where($map)
                    ->order('article.is_top desc, article.create_time desc')
                    ->limit(5)
                    ->select();

/*            var_dump($article_info);
            echo $Article->getLastSql();*/
            foreach ($article_info as $key => $value) {
                foreach ($value as $k => $val) {
                    if($k == "content"){
                        $article_info[$key][$k] = htmlspecialchars_decode($val);

                    }
                }
            }
            $this->assign("article_info", $article_info);
            $this->ajaxReturn($article_info);
        }
    }
    /**
     * 取得对应的文章信息
     * @return 
     */
    public function article_info(){
        $map['article.id'] = I('get.article_id');
        $map['article.status'] = 0;
        $map['site_id'] = session('site_id');
        $Article = M('article');
        $article_item = $Article->join('left join picture ON  picture.id = article.pic_id')
        ->where($map)
        ->select();

        $id = I('column_id');
        $site_id = session('site_id');
        if(!$this->allowColumn($id)){
           // $this->error('无权访问网页');
            return;
        }
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
            $site_info = M()->table('site_info')->field('site_name')->find($site_id);
            $this->assign('site_name',$site_info['site_name']);
            $this->assign('nav_list',$nav);
            $this->assign('now_column',$id);
        $status = I('get.status');
        if ($status) {
            $this->ajaxReturn($article_item[0]);
            return;
        }
        $this->assign("article_item",$article_item[0]);
        $this->display('Public/article_theme');
    }
    /**
     * 图文展示
     */
    public function image_text(){
        $is_edit = I('get.is_edit',0);
        if(!empty($is_edit)){
            $this->assign("status", 1);
        }
        $map['article.site_id'] = session('site_id');
        $Article = M('article');
        $count = $Article->where($map)->count();
        $Page = new \Think\Page($count,5);
        $show = $Page->show();
        $article_list = $Article
        ->join('JOIN picture on picture.id = article.pic_id')
        ->where($map)
        ->field('article.id, article.title, article.content, picture.savepath, picture.savename')
        ->order('article.is_top desc, article.create_time desc')
        ->limit($Page->firstRow.','.$Page->listRows)
        ->select();
        foreach ($article_list as $key => $value) {
            foreach ($value as $k => $val) {
                if($k == "content"){
                    $article_list[$key][$k] = htmlspecialchars_decode($val);
                }
            }
        }
/*        $map2['album.site_id'] = session('site_id');
        $Album = M('album'); 
        $img_list = $Album->field('picture.id, picture.savepath, picture.savename')
        ->join('photo ON album.id = photo.album_id')
        ->join('picture ON photo.pic_id = picture.id')
        ->where($map2)
        ->select();
        $this->assign("img_list", $img_list);*/
        $p = I('get.p');
        if (!empty($p)) {
            $data['article_list'] = $article_list;
            $data['page'] = $show;
            $this->ajaxReturn($data);
        }
        $this->assign("article_list",$article_list);
        $this->assign("page",$show);
        $this->assign('controller_id',I('id'));
        $this->display("image_text");
    }
//轮播图
    public function Viwepager(){
        $id = I("id");      //控件id
        $this -> assign("controllerId",$id);
        $is_edit = I('get.is_edit',0);
        if(!empty($is_edit)){       //判断是否为编辑
            $this->assign("status", 1);
        }
        $album_id = I('album_id');
        if(empty($album_id)){
            $album = D('Album');
            $album_list = $album -> get_album_list(session('site_id'));
            $this -> assign('album_list',$album_list);
            $this->display();
        }else{
            $photo = D("Picture");
            $pic = $photo -> getPicture($album_id);
            $this->ajaxReturn($pic);
        }
    }

//横幅
    public function banner(){
        $id = I("id");      //控件id
        $this -> assign("controllerId",$id);
        $is_edit = I('get.is_edit',0);
        if(!empty($is_edit)){
            $this->assign("status", 1);
        }
        $album_id = I('album_id');
        if(empty($album_id)){
            $album = D('Album');
            $album_list = $album -> get_album_list(session('site_id'));
            $this -> assign('album_list',$album_list);
            $photo = D("Picture");
            $pic = $photo -> getPicture($album_list[0]['id']);
            $this -> assign('album_pic',$pic);
            $this -> display();
        }else{
            $photo = D("Picture");
            $pic = $photo -> getPicture($album_id);
            $this->ajaxReturn($pic);
        }
    }
//图片展示
    public function PicturesShow(){
        $id = I("id");      //控件id
        $this -> assign("controllerId",$id);
        $is_edit = I('get.is_edit',0);
        if(!empty($is_edit)){
            $this->assign("status", 1);
        }
        $album_id = I('album_id');
        if(empty($album_id)){       //获得图册名
            $album = D('Album');
            $album_list = $album -> get_album_list(session('site_id'));
            $this -> assign('album_list',$album_list);
            $this->display();
        }else{             //获得图片
            $photo = D("Picture");
            $pic = $photo -> getPicture($album_id);
            $this->ajaxReturn($pic);
        }
    }
//滚动公告
    public function notice(){
        $id = I("id");      //控件id
        $this -> assign("controllerId",$id);
        $is_edit = I('get.is_edit',0);
        if(!empty($is_edit)){
            $this->assign("status", 1);
        }
        $this -> display();
    }



    /**
     * 文章分类
     */
    public function article_sort(){
        $is_edit = I('get.is_edit',0);
        if(!empty($is_edit)){
            $this->assign("status",1);
        }
        $Type = M('type');
        $is_edit = I('get.is_edit',0);
        $map['site_id'] = session('site_id');
        $type_list = $Type->field('id, name')
        ->where($map)->select();
        $User_column = M('user_column');
        $column_list = $User_column->where($map)->select();
        if (empty($column_list)) {
            $column_list[0]['id'] = 1;
            $column_list[0]['name'] = "新闻动态";
        };
        $this->assign('type_list',$type_list);
        $this->assign('column_list',$column_list);
        $this->assign('controller_id',I('id'));
        $this->display();
    }
    /**
     * 文章分类的分类信息
     */
    public function article_sort_info(){
        $Article = M('article');
        $map['article.site_id'] = session('site_id');
        $map['type.id'] = I('get.article_sort_id');
        $article_list = $Article
        ->join('type ON article.type_id = type.id')
        ->where($map)
        ->select();
        $this->assign('article_list',$article_list);
        $this->display();
    }

    


}