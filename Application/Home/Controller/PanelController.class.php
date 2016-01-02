<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 操作面板
 */
class PanelController extends ResourceController  {

    public function allowColumn($id){
       // echo session("site_id");
        //echo "ggg".$id;
        $result = M()->table('user_column')
                      ->where(array('id'=>$id,'site_id'=>$this->site_info['id']))
                      ->find();
               // var_dump($result);
        return !empty($result);
    }


    public function index(){
        $site_session = session("site_info");
        $site_id = $site_session['id'];
        $column_info = D('UserColumn')->get_column_info($site_id);
        $site_info = M()->table('site_info')->field('theme,back')->where(array('id'=>$site_id))->find();

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
        $site_id = $this->site_info['id'];
        if(empty($site_id)){
            $this->error("还没创建任何栏目,请在右边栏目中创建");
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

        $widget_common = $this->resolve_json($site_id,$json);

        $site_common = $this->get_site_common($site_id);

        $theme_templet = $site_common['theme_templet'];

        $links = array_merge_recursive($site_common['theme_links'],$widget_common['links']) ;

        unset($site_common['theme_templet']);

        $this->assign($site_common);
        $this->assign('html_json',$json);
        $this->assign('user_info',$user_info);
        $this->assign('now_column',$column_id);
        $this->assign('content' ,$widget_common['content']);
        $this->assign($links);
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
     * css,js 分别在Public/Home/Theme/{$theme_name} 文件夹下 的 css文件夹下 和 js文件夹下
     * @return data['html'] string  模板文件   ['public'] string 引入js,css文件的html脚本
     */
    private function load_theme_link($theme_name){

        $root_path = C('THEME_PUBLIC_ROOT');
        $static_path = $root_path."Static/";
        $public_path = $root_path."Public/";
        $theme_path = $root_path.$theme_name."/";
        $data = array('js' => [] , 'css' => []);
        if(is_dir(".".$static_path)){
            if ($dh = opendir(".".$static_path)){
                while (($file = readdir($dh)) !== false) {
                    $ext = pathinfo($file,PATHINFO_EXTENSION);
                    if($ext == 'js'){
                        $data['js'][] = __ROOT__.$static_path.$file;
                    }elseif($ext == 'css'){
                        $data['css'][] = __ROOT__.$static_path.$file;
                    }
                }
                closedir($dh);
            }
        }
        if(is_dir(".".$public_path)){
            if ($dh = opendir(".".$public_path)){
                while (($file = readdir($dh)) !== false) {
                    $ext = pathinfo($file,PATHINFO_EXTENSION);
                    if($ext == 'js'){
                        $data['js'][] = __ROOT__.$public_path.$file;
                    }elseif($ext == 'css'){
                        $data['css'][] = __ROOT__.$public_path.$file;
                    }
                }
                closedir($dh);
            }
        }
        if(is_dir(".".$theme_path)){
            $theme_path = $root_path."default/";
        }
        if(is_dir(".".$theme_path)){
            if ($dh = opendir(".".$theme_path)) {
                while (($file = readdir($dh)) !== false) {
                    $ext = pathinfo($file,PATHINFO_EXTENSION);
                    if($ext == 'js'){
                        $data['js'][] = __ROOT__.$theme_path.$file;
                    }elseif($ext == 'css'){
                        $data['css'][] = __ROOT__.$theme_path.$file;
                    }
                }
                closedir($dh);
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
        $theme_links = $this->load_theme_link($theme['name']);

        $theme_templet= $this->load_theme_templet($theme['name']);

        $nav_list = $Column->get_column_info($site_id,1);
        return array(
            'site_info'     =>  $site_info,
            'nav_list'      =>  $nav_list,
            'theme_templet' =>  $theme_templet,
            'theme_links'   =>  $theme_links
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
    public function resolve_json($site_id,$json){
        $content = json_decode($json,true);
        // var_dump($content);
        $widgets = [];
        foreach($content['content'] as $item){
            $temp = $this->load_widget($item['name'],$item);
            if($temp == false){
                continue;
            }
            $widgets[] = $temp;
        }

        $links = [];
        foreach($widgets as $widget){
            $links = array_merge_recursive($links,$widget->load_template_link());
        }
        $links['js'] = array_unique($links['js']);
        $links['css'] = array_unique($links['css']);
        // 页面缓存
        ob_start();
        ob_implicit_flush(0);
        foreach($widgets as $widget){
            $widget->index($site_id);
        }
        $content = ob_get_clean();
        \Think\Hook::listen('view_filter',$content);
        return array('content' => $content, 'links' => $links);
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
     * 编辑控件 移交给具体类实现
     * @param  String $name    空间名
     * @param  String $data    json数据
     */
    public function control_widget($name){
        $data = I("post.data");
        if(!empty($data)){
            $data = json_decode(htmlspecialchars_decode($data),true);
            if($data == false){
                $this->show(':( 没有数据');
                return;
            }
        }
        $site_id = $this->site_info['id'];
        if(empty($site_id)){
            $this->show(':( 没有找到网站');
        }elseif( ($widget = $this->load_widget($name,$data)) ) {
            $widget->controller($site_id,$data);
        }else {
            $this->show(':( 没有找到控件');
        }
    }

    public function load_widget($name,$data){
        $class =  $name . WIDGET_NAME;
        import(MODULE_NAME ."/" . WIDGET_NAME . "/" .$class);
        if(class_exists(MODULE_NAME . "\\" . WIDGET_NAME . "\\" .$class)) {
            $class = "\\".MODULE_NAME . "\\" . WIDGET_NAME . "\\" .$class;
            return new $class($data['theme'],$data['resource'],$data['option']);
        }else {
            return false;
        }
    }


    public function save_widget(){
        $return = array('status' => 0, 'data' => "", 'info' => "");
        $data = I('post.');
        $site_id = $this->site_info['id'];
        if(empty($site_id)){
            $result['info'] = "没有找到网站";
        }else{
            $widget = $this->load_widget($data['name'],$data);
            ob_start();ob_implicit_flush(0);
            $widget->index($site_id,true);
            $result = ob_get_clean();
            if($result){
                $return['data']['html'] = $result;
                $return['data']['json'] = $widget->get_json();
                $return['status'] = 1;
            }
        }

        $this->ajaxReturn($return);
    }


/*==================栏目(column) 操作======================*/

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
    public function add_column(){
        $return  = array('status' => 0, 'info' => '保存成功', 'data' => '');

        $pic_info = $this->upload_column_icon();

        if($pic_info === false){
            $return['info'] = "上传图片失败";
        }elseif($pic_info == 0){
            $return['info'] = "请上传图片";
        }else{
            $pic_id = $pic_info['id'];
            $Column = D('UserColumn');
            $result = $Column->add_column($this->site_info['id'],$pic_id);
            if(!$result){
                $return['info'] = "添加失败";
                $this->rollback_column_icon();
            }else{
                $result['icon_url'] = C('UPLOAD_ROOT').$pic_info['savepath'].$pic_info['savename'];
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
    public function edit_column(){
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
                $pic_id = $pic_info['id'];
            }
            $Column = D('UserColumn');
            $result = $Column->edit_column($this->site_info['id'],$pic_id);
            if(!$result){
                $return['info'] = $pic_info.$Column->getError();
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
     * 上传栏目图标
     * @return int 0 没有上传   array 上传成功   Boolean false 上传失败
     */
    public function upload_column_icon(){
        if(empty($_FILES['column_icon']['name'])){
            return 0;
        }
        $Picture = D('Picture');
        $info = $Picture->upload(
            $_FILES,
            C('PICTURE_UPLOAD'),
            C('PICTURE_UPLOAD_DRIVER')
        );
        return $info["column_icon"];
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
}
