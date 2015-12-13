<?php
namespace Admin\Controller;
use Think\App;
use Think\Controller;

/**
* 网站管理
*/
class WebsiteController extends BaseController{

	public function __construct () {
		parent::__construct();
		session('flash_error', null);
	}
	
	//团队人员列表信息查询及分页（每页10条）
	public function index(){
		if (!isset($_GET['p'])) {
			$_GET['p'] = 1;
		}
		$model = M('admin_info'); 						// 实例化problem对象
		// 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
		if (!empty($_GET['nickname'])) {
/*
			$where['status'] = 
			$condition = $_GET['nickname'];
			$where = ("id=d and account=")*/
			$condition = $_GET['nickname'];
			$where['admin_name'] = array('like','%'.$condition.'%');
			$where['account'] = array('like','%'.$condition.'%');
			$where['id'] = (int)$condition;
			$where['_logic'] = 'or';
			$map['_complex'] = $where;
		}
		$map['status'] = 0;
		$list = $model->where($map)->page($_GET['p'].',10')->order("id desc")->select();
		$this -> assign('_list',$list);				// 赋值数据集
		$count = $model->where('status=0')->count();// 查询满足要求的总记录数
		$Page  = new \Think\Page($count,10);			// 实例化分页类 传入总记录数和每页显示的记录数
		$show  = $Page->show();						// 分页显示输出
		$this->meta_title = '网站信息';
		$this->assign('_page',$show);				// 赋值分页输出
		$this->display(); 							// 输出模板

	}	

//密保问题信息
	public function security(){
		if (!isset($_GET['p'])) {
			$_GET['p'] = 1;
		}


		$model = M('problem'); 						// 实例化problem对象
		// 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
		$list = $model->where('status=0')->page($_GET['p'].',10')->select();
		$this -> assign('_list',$list);				// 赋值数据集
		$count = $model->where('status=0')->count();// 查询满足要求的总记录数
		$Page  = new \Think\Page($count,10);			// 实例化分页类 传入总记录数和每页显示的记录数
		$show  = $Page->show();						// 分页显示输出
		$this->meta_title = '网站信息';
		$this->assign('_page',$show);				// 赋值分页输出
		$this->display(); 							// 输出模板
	}

//添加及编辑密保问题
	public function addProblem($problem="",$seat="",$choice=""){
		if (!empty($seat)) {
			$list = M("problem")->field("id,question")->where("id=".$seat)->find();
		 	$this->assign("list", $list);
		 	$this->assign("modular","编辑问题");
		}else{
			$this->assign("modular","新增问题");
		}
		if (IS_POST) {
			$problem =trim($problem);	//去除空格
            //如果为空或有html标签，则显示提示信息
            if ($problem=="") {
                $this->error("请规范输入内容！");
            }
            if (preg_match("/<\w+>.*?<\/\w+>/",$problem)) {
            	$this->error("格式有误！");
            }
            //匹配问题长度不能大于16个汉字//strlen("中")==3
            if (strlen($problem)>50) {
                $this->error("请缩减问题长度！");
            }
			$find = M("problem")->where("question='$problem'")->select();
			if(!empty($find)){
				$this->error("问题已存在");
			}
            $data['question']=$problem;
            $data['update_time']=time();
            if (!empty($choice)) {
            	M("problem")->where("id=".$choice)->save($data);
            	$this->success("编辑成功",__CONTROLLER__."/security");
            }else{
            	$data['create_time']=time();
            	M("problem")->add($data);

            	$this->success("添加成功","security");
            }
//			$this->redirect('security');
		}
		$this->display();
		
	}

//编辑使用指导教程
	public function tutorial(){
		$this->assign("meta_title","使用教程");
		$where['id'] = I("post.seat");
		$data["guide_title"] = I("post.title");
		$data['content'] =I("post.editor");
		$data['update_time'] = time();
		$num = M("guide")->count();
		if (IS_POST) {
			if (isset($data['guide_title']) && !empty($num)) {
				$res = M("guide")->where($where['id'])->save($data);
				$this->ajaxReturn($res);
			}
			if (isset($data['guide_title']) && empty($num)) {
				$res = M("guide")->data($data)->add();
				$this->ajaxReturn($res);
			}
		}
		$res = M("guide")->select();
		$res = $res[0];
		$this->assign("list",$res);
		$this->display();
	}

//添加管理员信息，如果添加成功则跳转到列表页
	public function addUser($realname='',$account='',$phone='',$password='',$repassword='',$choice=''){
		$admin_user = M("admin_info");
		if (!empty($choice) && $choice==1 && session("id")) {
			$list = $admin_user->field("id,account,admin_name,phone")->where("id=".session("id"))->select();
			$list = $list[0];
			$this->assign("list", $list);
		}
		if (IS_POST) {
			if (empty($realname) || empty($account) || empty($phone) || empty($password) || empty($repassword)) {
				// $this->assign("error", "")
				$this->falsh_error("请完善信息");	
			}elseif ($admin_user->where("admin_name='".$realname."'")->count()!=0) {
				 $this->falsh_error("此用户名已存在");
			}elseif ($admin_user->where("account='".$account."'")->count()!=0) {
				$this->falsh_error("账号已存在");
			}elseif ($admin_user->where("phone='".$phone."'")->count()!=0) {
				$this->falsh_error("此联系方式已存在");
			}
			if (session("flash_error")) {
				$this->display();
				return;
			}
			$data['admin_name'] = $realname;
			$data['account'] = $account;
			$data['phone'] = $phone;
			$data['update_time'] = time();
			$data['password'] = $password;
			if (!empty($choice)) {
				$res = $admin_user->where("id=".session("id"))->save($data);
			}else{
				$data['create_time'] = time();
				$res = $admin_user->add($data);
			}
			if ($res!="") {
				$this->redirect("index");
				return ;
			}
		}
		$this->meta_title = '用户信息管理';
        $this->display();
    }

    public function falsh_error($msg) {
    	session('flash_error', '<div class="alert alert-error" style="width:80%;height:30px;float:left; margin-left:10px;"><h2 style="color:white;">'.$msg.'</h2></div>');
    }

//密保问题及团队管理模块中 禁用，删除操作功能
    public function changeStatus($type="",$method="",$id=""){
        empty($id) && $this->error('参数错误！');      
        $map['id'] =   $id;
        if ($type=="team"){
            $model = M("admin_info");
        }elseif ($type=="security"){
            $model = M("problem");  
        } 
        switch (strtolower($method)) {
            case 'forbiduser':
                $model->where($map)->data("forbidden=1")->save();
                break;
            case 'resumeuser':
                $model->where($map)->data("forbidden=0")->save();
                break;
            case 'deleteuser':
                $model->where($map)->data("status=1")->save();
                break;
            default:
                $this->error('参数非法');
                break;
        }
    }


	
}
?>