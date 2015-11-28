<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 操作面板
 */
class PanelController extends BaseController {

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
                            ->field('id,name,intro,url,icon')
                            ->where(array('forbidden' => 0 , 'status' => 0))
                            ->order('sort')
                            ->select();
        $theme_list = M()->table('theme as a')
                         ->field('a.addr,a.id,b.savepath,b.savename')
                         ->join('picture as b on a.pic_id = b.id')
                         ->where(array('a.status'=> 0,'a.addr'=>array('neq',"")))
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

    public function show_user_html($site_url,$column_url){

        //M('site_info')->field('id,name,intro')where(array('id' => $site_id))->select();
    }

    

    public function readHtml(){
        $id = I('column_id');
        //echo "fff".$id;
        $user_id = session('user_info')['id'];
        $site_id = session('site_id');
        if(empty($id)){
            echo "还没创建任何栏目,请在右边栏目中创建";
            return;
        }elseif(!$this->allowColumn($id)){
            //echo $id;
            //echo 'error';
            $this->error('无权访问网页');
            return;
        }
        $result = M()->table('user_column')
                   ->field('html.html')
                   ->join('html on html.id = user_column.html_id')
                   ->where(array('user_column.id'=>$id))
                   ->find();
        if(empty($result)){
            $this->error('没有找到网页');
        }else{  
            $this->show( $this->showHtml($user_id,$site_id,$result['html'],$id) );
        }
    }

    public function showHtml($user_id,$site_id,$content,$now_column){
        $user_info = M()->table('user_info')->field('nickname,head_img')->find($user_id);
       // var_dump($user_info);
        $nav = M()->table('user_column as a')
                  ->field('a.id , a.name, a.sort, a.forbidden, a.url, savepath,savename')
                  ->join('left join picture as b on a.icon = b.id')
                  ->where(array('site_id'=>$site_id))
                  ->order('sort')
                  ->select();
        $root = C('UPLOAD_ROOT');
        foreach ($nav as $key => $value) {
            $nav[$key]['icon_url'] = $root.$value['savepath'].$value['savepath'];
        }
        $site_info = M()->table('site_info')
                        ->field('site_name,theme,back')
                        ->where(array('status' => 0, 'id' => $site_id))
                        ->find();

            $theme = M()->table('theme')
                        ->field('addr')
                        ->where(array('status' => 0, 'id' => $site_info['theme']))
                        ->find();

             $back = M()->table('background as a')
                        ->field('a.id,savepath,savename')
                        ->join('picture as b on a.pic_id = b.id')
                        ->where(array('a.id' => $site_info['back'], 'a.status' => 0) )
                        ->find();

        $this->assign('user_info',$user_info);
        $this->assign('site_name',$site_info['site_name']);
        $this->assign('nav_list',$nav);
        $this->assign('now_column',$now_column);
        $this->assign('theme',$theme['addr']);
        $this->assign('back_url',$back['savepath'] . $back['savename']);
        $this->assign('content',$content);
        return $this->fetch('Public/theme');
    }

    public function writeHtml(){
        $return  = array('status' => 0, 'info' => '保存成功', 'data' => '');
        $id = I('get.column_id');
        // echo $id;
        $content = I('content');
        $content = htmlspecialchars_decode($content);
        if(!$this->allowColumn($id)){
            $return['info'] = '无权访问网页';
            $this->ajaxReturn($return);
            return;
        }
        $html_id = M()->table('user_column')
                      ->field('html_id')
                      ->where(array('user_column.id'=>$id))
                      ->find();

        if(empty($html_id)){
            $return['info'] = '没有找到网页';
            $this->ajaxReturn($return);
            return;
        }
        $result = M()->table('html')
                     ->where(array('id'=>$html_id['html_id']))
                     ->save( array('html'=>$content) );
        if($result === false){
            $return['info'] = 'html保存失败';
            $this->ajaxReturn($return);
            return;
        }
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
    */
    public function addColumn(){
        $pic_id = 0;
        $return  = array('status' => 0, 'info' => '保存成功', 'data' => '');
        foreach ($_FILES as $key => $value) {
            $file = $value['name'];
        }
        if(!empty($file)){
            $info = $this->upload_column_icon();
            if(empty($info)){
                $return['info'] = '上传图片失败';
                $this->ajaxReturn($return);
                return;
            }
            $info = $info['column_icon'];
            $pic_id = $info['id'];
        }
        $Column = D('UserColumn');
        $result = $Column->add_column($pic_id);
        if(!$result){
            $m->rollback();
            $return['info'] = $Column->getError();
            $this->ajaxReturn($return);
            return;
        }
        
        if($pic_id > 0){
            $result['icon_url'] = C('UPLOAD_ROOT').$info['savepath'].$info['savename'];
        }
        $return['data'] = $result;
        $return['status'] = 1;
        $this->ajaxReturn($return);
    }
    /**
     * 编辑 栏目column
     * @return $id $name $url [$_file]
     */
    public function editColumn(){
        $return  = array('status' => 0, 'info' => '保存成功', 'data' => '');
        $column_id = I('post.id');
        if(!$this->allowColumn($column_id)){
            $return['info'] = "无权操作此栏目";
            $this->ajaxReturn($return);
            return;
        }
        $pic_id = 0;
        foreach ($_FILES as $key => $value) {
            $file = $value['name'];
        }
        // var_dump($file);
        if(!empty($file)){
            $info = $this->upload_column_icon();
            if(empty($info)){
                $return['info'] = '上传图片失败';
                $this->ajaxReturn($return);
                return;
            }
            $info = $info['column_icon'];
            $pic_id = $info['id'];
        }
        //var_dump($info);
        $Column = D('UserColumn');
        $result = $Column->edit_column($pic_id);
        if($result){
            if($pic_id > 0){  // 删除旧图片
                $pre_pic = $Column->find(I('id')); 
                D('picture')->deleteFile($pic_id['icon']);
                $result['icon_url'] = C('UPLOAD_ROOT').$info['savepath'].$info['savename'];
            }
            $return['data'] = $result;
            $return['status'] = 1;
            $this->ajaxReturn($return);
            return;
        }
        if($pic_id > 0){// 删除刚刚上传的图片
            D('picture')->deleteFile($pic_id);
        }
        $return['info'] = $Column->getError();
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
            C('PICTURE_UPLOAD_DRIVER'),
            C("UPLOAD_{$pic_driver}_CONFIG")
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