<?php
namespace Admin\Controller;
use Think\Controller;
/**
*前端管理
*
**/
class ReceptionController extends BaseController{

    public function __construct () {
        parent::__construct();
        session('flash_error', null);
        session('flash_success', null);
    }
 /**-----------背景管理部分---------------*/
    //背景管理
	public function index(){
        $this->assign("meta_title","背景管理");
        $list = D("Reception")->index();
        $this->assign("list", $list);
        $this->assign("modular","背景信息浏览");
		$this->display();
	}

    //编辑图片信息
    public function editimg(){
        $id = I("post.seat");
        $data['name'] = I("post.content");
        $res = M("background")->data($data)->where("id=".$id)->save();
        $this->ajaxReturn($res);
    }
    //删除背景图片
    public function delimg(){
        $where['id'] = I("post.id");
        $data['status'] = 1;
        $background = M("background");
        $background->startTrans();
        $res = $background->data($data)->where($where)->save();
        if($res){
            $pic_id = $background->field('pic_id')->where($where)->find();
            $pic_res = M('picture') -> where('id='.$pic_id['pic_id'])->setDec('used');
            if($pic_res){
                $background->commit();
                $this->ajaxReturn('ok');
            }else{
                $background->rollback();
            }
        }
        $this->ajaxReturn(false);
    }

    //背景图片的添加与解禁
    public function uploadBackground(){
        $savePath = I("get.savepath").'/';
        $picture = A("Picture");
        $option = array('savePath'=>$savePath);
        $img_res = $picture->uploadPicture($option);
        if($img_res){//是否上传成功
            $background = M('background');
            $save_add = $background -> where('pic_id='.$img_res["Filedata"]['id']) ->find();
            $data["pic_id"]=$img_res["Filedata"]['id'];
            $data['create_time'] = $data['update_time'] = time();
            $data['status'] = 0;
            if($save_add){//是否有记录
                $status = $background -> where('status=0 and pic_id='.$img_res["Filedata"]['id'])->find();
                if(empty($status)){
                    $res = $background->where('pic_id='.$img_res["Filedata"]['id'])->save($data);
                }else{
                    $this->ajaxReturn('no');//已存在
                }
            }else{
                $res = $background->add($data);
            }
            if($res){
                $this->ajaxReturn('ok');
            }else{
                $this->ajaxReturn("false");
            }
        }else{
            $this->ajaxReturn("false");
        }
    }


/**----------栏目管理部分-----------------*/
    //栏目管理信息查询
	public function column(){
        
        if (!isset($_GET['p'])) {
            $_GET['p'] = 1;
        }
         // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $model = M();
        $list = $model->table("topic")->alias("t")
            ->join(" left join picture as p on p.id=t.icon")
            ->field("t.*,p.savename,p.savepath")
            ->where("t.status=0 and t.id like '%".$_GET['nickname']."%' or"." t.status=0 and t.name like '%".$_GET['nickname']."%'")
            ->order("t.sort asc")
            ->page($_GET['p'].',10')
            ->select();
        $this -> assign('list',$list);             // 赋值数据集
        $count = M("topic")->where('status=0')->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count,10);            // 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();                     // 分页显示输出
        $this->meta_title = '栏目信息';
        $this->assign('_page',$show);               // 赋值分页输出
        $this->display();                           // 输出模板
	}

//栏目管理和控件管理模块某条信息位置的调整位置
    public function position(){
        $type = I("post.type");     // 1：向上移动；2：向下移动
        $seat = I("post.seat");     //被选中项的id
        $tb_name = I("post.tb");    //要操作的表名(topic:栏目表；controller：控件表)
       
       //上移操作
       //
       //
        if (isset($seat) && isset($type) && isset($tb_name) && $type==1) {
            //选中项sort
            $it = M($tb_name)->where("id=".$seat)->field("sort")->find();
            //获取小于选中项id的条数
            $count = M($tb_name)->where("sort<".$it['sort'])->count();
            //获取比选中项大的前一条数据id和sort(位置字段)
            $prev = M($tb_name)->field("id,sort")->where("sort<".$it['sort'])->order("sort desc")->find();
            //将比选中项大一的那一条数据的sort字段值修改为选中项的sort的值
            $ret_prev = M($tb_name)->data("sort=".$it['sort'])->where("id=".$prev['id'])->save();
            //与上一条语句操作相反
            $ret_it= M($tb_name)->data("sort=".$prev['sort'])->where("id=".$seat)->save();
            if (!empty($ret_prev) && !empty($ret_it)) {
                $this->ajaxReturn("向上移动成功");
            }else{
                $this->ajaxReturn("向上移动失败");
            }
        }
        //下移操作
        if (isset($seat) && isset($type) && $type==2) {
            $it = M($tb_name)->where("id=".$seat)->field("sort")->find();
            //获取小于选中项id的条数
            $count = M($tb_name)->where("sort>".$it['sort'])->count();
            //获取小于选中项的下一项的id和sort字段值
            $next = M($tb_name)->field("id,sort")->where("sort>".$it['sort'])->order("sort asc")->find();
            //根据选中字段 id 修改的 sort 值
            $ret_next = M($tb_name)->data("sort=".$it['sort'])->where("id=".$next['id'])->save();
            $ret_it= M($tb_name)->data("sort=".$next['sort'])->where("id=".$seat)->save();
            if (!empty($ret_prev) && !empty($ret_it)) {
                $this->ajaxReturn("向下移动成功");
            }else{
                $this->ajaxReturn("向下移动失败");
            }
        }
        // $this->ajaxReturn($this->getLastSql());
    }

//添加及编辑栏目信息
    public function addColumn($column="",$addr_link="",$seat="",$choice=""){

        if (!empty($seat)) {
//            $list = M("topic")->field("id,name")->where("id=".$seat)->find();
            $model = M();
            $list = $model->table("topic")->alias("t")
                ->where("t.id=".$seat)
                ->join(" left join picture as p on p.id=t.icon")
                ->field("t.*,p.savename,p.savepath")
                ->find();
            $this->assign("list", $list);
            $this->assign("modular","编辑栏目");
            $this->assign("meta_title","编辑栏目");
        }else{
            $this->assign("modular","新增栏目");
            $this->assign("meta_title","新增栏目");
        }
        if (IS_POST) {
            session('flash_error', null);
//            $upfile = $_FILES['upfile'];
            $column =trim($column);   //去除空格
            $addr = trim($addr_link);

            //如果为空或有html标签，则显示提示信息
            if ($column=="" || $addr=="") {
                $this->falsh_error("请规范输入内容！");
            }
            if (preg_match("/<\w+>.*?<\/\w+>/",$column) || preg_match("/<\w+>.*?<\/\w+>/",$addr)) {
                $this->falsh_error("格式有误！");
            }
            //长度不能大于6个汉字或大于20个字母或数字//strlen("中")==3
            if (strlen($column)>30) {
                $this->falsh_error("请缩减栏目长度！");
            }
            if (session("flash_error")) {
                $this->display();
                return;
            }

            $savePath = I("get.savepath").'/';
            $picture = A("Picture");
            $option = array('savePath'=>$savePath);
            $info = $picture->uploadPicture($option);
            if(!empty($info)){
                $data['name']=$column;
                if (empty($choice)) {
                    $find = M("topic")->where($data)->select();
                    if(!empty($find)){
                        $this->error("栏目已存在");
                    }
                }

                $data['url'] = $addr;
                $data['update_time']=time();
                $data['icon']=$info['upfile']['id'];
                if (!empty($choice)) {
                    M("topic")->where("id=".$choice)->save($data);
                    $this->flash_success("编辑成功");
                }else{
                    $sort = M("topic")->field('sort')->max('sort') + 1;
                    $data['sort'] = $sort;
                    $data['create_time']=time();
                    M("topic")->data($data)->add();
                    $this->flash_success("添加成功");
                }
            }
            $this->redirect('Reception/column');
        }
        $this->display();
    }


/**----------控件管理部分-----------------*/
//控件管理
	public function widget(){

        if (!isset($_GET['p'])) {
            $_GET['p'] = 1;
        }
        $model = M('controller');                      // 实例化column对象
        $where = "status=0 and id like '%".$_GET['nickname']."%' or"." status=0 and name like '%".$_GET['nickname']."%'";
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $list = $model->where($where)->page($_GET['p'].',10')->order("sort asc")->select();
        $this -> assign('list',$list);             // 赋值数据集
        $count = $model->where('status=0')->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count,10);            // 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();                     // 分页显示输出
        $this->meta_title = '控件信息';
        $this->assign('_page',$show);               // 赋值分页输出
        $this->display();
	}


//添加及编辑控件管理
    public function addController($c_name="",$c_intro="",$c_addr="",$seat="",$choice=""){
        if ($seat) {
            $list = M("controller")->field("id,name,intro,url,icon")->where("id=".$seat)->find();
            $effect_img = M("theme")
                    ->field("theme.name,theme.id,picture.savename,picture.savepath")
                    ->join('picture ON theme.pic_id = picture.id')
                    ->where("theme.status=0 and theme.controller_id=".$seat)
                    ->order("theme.update_time desc")
                    ->select();
            $this->assign("list", $list);
            $this->assign("effect_img", $effect_img);
//            dump($list);
            $this->assign("modular", "编辑控件信息");
            $this->assign("meta_title","编辑控件信息");
        }else{
            $this->assign("modular", "新增控件信息");
            $this->assign("meta_title","新增控件信息");
        }
        if (IS_POST) {
            $upfile = $_FILES['upfile'];
            trim($c_name)=="" && $this->falsh_error("控件名称信息不能为空！");
            // trim($c_name)=="" && $this->error("请完善控件名称信息！");
            trim($c_intro)=="" && $this->falsh_error("控件简介信息不能为空！");
            trim($c_addr)=="" && $this->falsh_error("控件链接信息不能为空！");
            if (preg_match("/<\w+>.*?<\/\w+>/",$c_name) || preg_match("/<\w+>.*?<\/\w+>/",$c_intro) || preg_match("/<\w+>.*?<\/\w+>/",$c_addr)) {
                $this->falsh_error("请更正信息内容格式！");
            }
            //匹配问题长度不能大于6个汉字或大于20个字母或数字//strlen("中")==3
            strlen($c_name)>30 && $this->falsh_error("请精简控件<-名称->长度！");
            mb_strlen($c_name)>120 && $this->falsh_error("请精简控件<-简介->长度！");


            //验证控件地址不符合要求。
/*            if (preg_match("/(http|https|ftp|file){1}(:\/\/)?([\da-z-\.]+)\.([a-z]{2,6})([\/\w \.-?&%-=]*)*\/?/", $c_addr)==false){
                $this->falsh_error("控件链接地址格式有误！");
            }*/
/*            if (session("flash_error")) {
                $this->display();
                return;
            }*/

//            $data['icon'] = $info['upfile']['savepath'].$info['upfile']['savename'];
            $data['name'] = $c_name;
            $find = M("controller")->where($data)->select();
            if(!empty($find)){
                $this->error("控件已存在");
            }
            $picture = A("Picture");
            $img_res = $picture->uploadPicture();
            if($img_res){
                $data['img_id'] = $img_res["Filedata"]['id'];
            }
            $data['intro'] = $c_intro;
            $data['url'] = $c_addr;
            $data['update_time'] = time();
            if ($choice=="") {
                // $this->falsh_error($choice);
                 $this->falsh_error(123);
                
                // $this->display();
                // return;
            }
            if ($choice) {
                $res = M("controller")->data($data)->where('id='.$choice)->save();
                $success="编辑成功！";
            }else{
                $sort = M("controller")->field('sort')->max('sort') + 1; 
                $data['sort'] = $sort;
                $data['create_time'] = time();
                $res = M("controller")->data($data)->add();
                $success="添加成功！";
            }
            if ($success) {
                $this->redirect("widget");
                // $this->falsh_error(2121221121);
                return;
            }else{
                $this->display();
            }
           
        }
        $this->display();
    }

    //上传效果图
    public function upload(){
        $controller_id = I("get.id");
        $save_add = I("get.old_img");
        $picture = A("Picture");
        $option = array("savePath","background/");
        $img_res = $picture->uploadPicture($option);
        if($img_res){
            if($save_add=="true"){
                $where["controller_id"] = $controller_id;
                $have_no = M("theme")->where("status=0 and controller_id=".$controller_id." and pic_id=".$img_res["Filedata"]['id'])->find();
                if($have_no){
                    $res = "no";
                }else{
                    $id = M("theme")->where($where)->order("update_time asc")->select();
                    $data['update_time'] = time();
                    $data["pic_id"]=$img_res["Filedata"]['id'];
                    $where1["id"] = $id[0]["id"];
                    $res = M("theme")->where($where1)->save($data);
                    if($res){
                        $res=$id[0]["id"];
                    }
                }
            }else{
                $theme = M("theme");
                $where["controller_id"] = $controller_id;
                $where["status"] = 1;
                $theme_id = $theme -> where($where)->find();
                if($theme_id["id"]){
                    $data["pic_id"]=$img_res["Filedata"]['id'];
                    $data['update_time'] = time();
                    $data["status"] = 0;
                    $res = M("theme") -> where('id='.$theme_id["id"]) -> save($data);
                    if($res){
                        $res=$theme_id["id"];
                    }
                }else{
                    $data["pic_id"]=$img_res["Filedata"]['id'];
                    $data["controller_id"] = $controller_id;
                    $data['create_time'] = $data['update_time'] = time();
                    $res = $theme->add($data);
                }
            }
            if($res){
                $img_res["theme_id"]=$res;
                $this->ajaxReturn($img_res);
            }
        }else{
            $this->ajaxReturn($img_res);
        }
    }

    //效果图去除
    public function delete_theme(){
        $theme_id = I("post.theme_id");
        $theme = M("theme");
        $res = $theme -> where("id=".$theme_id) -> data("status=1 and update_time = ".time()) -> save();
        if($res){
            $this->ajaxReturn("ok");
        }else{
            $this->ajaxReturn("false");
        }
    }

    //效果图重命名
    public function effectName(){
        $name = I("post.data");
        $theme_id = I("post.id");
        $data['name']=$name;
        $data['update_time']=time();
        $res = M("theme")->where('id='.$theme_id)->save($data);
        if(empty($res)){
            $this->ajaxReturn("false");
        }else{
            $this->ajaxReturn("ok");
        }
    }

    public function falsh_error($msg) {
        session('flash_error', '<div class="alert alert-error" style="width:80%;height:40px;float:left;position: absolute;"><h2 style="color:white;z-index:10;">'.$msg.'</h2></div>');
    }
    public function flash_success($msg) {
        session('flash_success', '<div class="alert alert-success" style="width:80%;height:40px;float:left; position: absolute;"><h2 style="color:white;z-index:10;">'.$msg.'</h2></div>');
    }

//控件及栏目管理中的禁用及删除操作
    public function changeStatus($type="",$method="",$id=""){
        empty($id) && $this->error('参数错误！');
        $map['id'] =   $id;
        if ($type=="controller"){
            $model = M("controller");
        }elseif ($type=="topic"){
            $model = M("topic");  
        } 
        switch (strtolower($method)) {
            case 'forbiduser':  //禁止
                $res = $model->where($map)->data("forbidden=1")->save();
                break;          
            case 'resumeuser':  //重启
                $res = $model->where($map)->data("forbidden=0")->save();
                break;
            case 'deleteuser':  //删除
                $res = $model->where($map)->data("status=1")->save();
                break;
            default:
                $this->error('参数非法');
                break;
        }
        if(!empty($res)) {
            $this->success();
        }else{
            $this->error('操作失败');
        }
    }


/**-------------主题管理部分--------------*/
//主题效果展示
    public function theme(){
        $this->assign("meta_title","主题管理");
        $list = D("Reception")->theme();
        $this->assign("list", $list);
        $this->assign("modular", "主题管理");
        $this->display();
    }
//添加主题效果
    public function uploadtheme(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->saveName = array('uniqid','');
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
        $upload->savePath  =     'template/'; // 设置附件上传（子）目录
        $info   =   $upload->upload();      // 上传文件
        $upfile = $info['Filedata'];
        $map['md5'] = $upfile['md5'];
        $search_md5 = M("picture")->field("id")->where($map)->select();
        $con['pic_id'] = $search_md5[0]["id"];
        $judge = M("theme")->field("id,status")->where($con)->select();
        if($judge) {
            if ($judge[0]['status'] == 1) {
                M("theme")->where(array('id' =>$judge[0]['id']))->save(array('status' => 0));
            } else {
                $this->ajaxReturn(1);
            }
        }
        if ($upfile && empty($judge)) {
            $data['savename'] = $upfile['savename'];
            $data['savepath'] = $upfile['savepath'];
            $data['md5'] = $upfile['md5'];
            $data['size'] = $upfile['size'];
            $data['create_time'] = $data['update_time'] = time();
            $where['create_time'] = $where['update_time'] = time();
            $p_seat = M("picture")->data($data)->add();
            $where['pic_id'] = $p_seat;
            $b_seat = M("theme")->data($where)->add();
        }
        if (!empty($p_seat) && !empty($b_seat)) {
            $this->ajaxReturn(2);
        }
    }

//编辑主题链接地址
    public function editaddr(){
        $id = I("post.seat");
        $data['addr'] = I("post.content");
        $res = M("theme")->data($data)->where(array("id"=>$id))->save();
        //echo M("theme")->getLastSql();
        $this->ajaxReturn($res);
    }

//删除主题
    public function deltheme(){
        $where['id'] = I("post.id");
        $data['status'] = 1;
        $res = M("theme")->data($data)->where($where)->save();
        $this->ajaxReturn($res);
    }

}
?>