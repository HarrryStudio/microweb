<?php 
namespace Admin\Controller;
use Think\Controller;

class PublicController extends Controller {

	public function login()
	{
        
		$this->display();
	}

     /**
     * 进行登录验证
     */
    public function do_login(){
        $username = I('post.username');
        $password = I('post.password');
        $verify = I('post.verify');
        if(empty($username) || empty($password))
        {
            echo '用户名或密码不能为空';
            return;
        }
        if(empty($verify))
        {
            echo '验证码不能为空';
            return;
        }
        //检测验证码，为空则验证码不正确
        $result = $this->check_verify($verify,'');
        if(false == $result)
        {
            echo '验证码错误';
            return;
        }
        $user_arr = M('admin_info')->where(array('account' => $username))->find();
        if(md5($password) != $user_arr['password'])
        {
            echo '用户名或密码错误';
            return;
        }
        session('admin_user',$username);
        session('id',$user_arr['id']);
        echo 1;
    }

    /**
     * 验证码处理
     */
    public function verify(){
        $config = array(
            'length'   => 5  //字数
            //'useNoise'=> false,//是否显示背景图片
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }

    /**
     * 检验验证码
     */
    public function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }


    /**
     * 退出登录
     */
    public function logout(){
        session(null);
        $this->redirect('Public/login');
    }
	
    
}

 ?>