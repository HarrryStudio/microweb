<?php 
namespace Admin\Controller;
use Think\Controller;

/**
*用户管理
**/
class UserController extends BaseController	{
	
	public function index(){
		 if (!isset($_GET['p'])) {
            $_GET['p'] = 1;
        }
        $where = "status=0 and id like '%".$_GET['nickname']."%' or"." status=0 and nickname like '%".$_GET['nickname']."%' or"." status=0 and account like '%".$_GET['nickname']."%'";
        $model = M('user_info');                      // 实例化column对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $list = $model->where($where)->page($_GET['p'].',10')->select();
        $this -> assign('_list',$list);             // 赋值数据集
        $count = $model->where($where)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count,10);            // 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();     
        $this -> assign('_page',$show);             // 赋值数据集
        $this->meta_title = '用户信息';
		$this->display();
	}


    public function changeStatus($method="",$id=""){
        empty($id) && $this->error('参数错误！');      
        $map['id'] =   $id;
        switch (strtolower($method)) {
            case 'forbiduser':
                M("user_info")->where($map)->data("forbidden=1")->save();
                break;
            case 'resumeuser':
                M("user_info")->where($map)->data("forbidden=0")->save();
                break;
            case 'deleteuser':
                M("user_info")->where($map)->data("status=1")->save();
                
                break;
            default:
                $this->error('参数非法');
                break;
        }
    }


	
}

?>