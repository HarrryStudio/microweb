<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 登录注册找回密码
 */
class LoginController extends Controller {
    /*
     *登录验证
     */
    public function login(){
        $this -> assign('meta_title','登录');
        $login_data = I('post.');
        if(!empty($login_data)){
            if($login_data["kk"] != "ok"){
                $verify = new \Think\Verify();
                if (!$verify->check(I('post.authCode'))) {
                    $this -> ajaxReturn("验证码错误");
                }
            }
            $login = D('UserInfo');
            $login_res = $login -> login($login_data);
            $this -> ajaxReturn( $login_res);
        }
        $this -> display();
    }

    /*
     *登出
     */
    public function logout(){
        session(null);
        $this->redirect('Login/login');
    }
    /*
     *注册新用户
     */
    public function register(){
        $this->assign('meta_title', '注册');
        $user_info = I('post.');
        if(!empty($user_info)){
            $verify = new \Think\Verify();
            if (!$verify->check(I('post.authCode'))) {
                $this -> ajaxReturn("验证码错误");
            }
            $user_add = D('UserInfo');
            $user_add -> startTrans();      //开启事务
            if (!$user_add->create()) {
                $error = $user_add->getError();
                $this->ajaxReturn($error);
            } else {
                $res = $user_add->add();
                if(!empty($res)){
                    $answer = M("answer");      //密保答案
                    $data[] = array('user_id'=>$res,'question_id'=>$user_info["problem1"],'answer'=>$user_info["answer1"],'create_time'=>time(),'update_time'=>time());
                    $data[] = array('user_id'=>$res,'question_id'=>$user_info["problem2"],'answer'=>$user_info["answer2"],'create_time'=>time(),'update_time'=>time());
                    $data[] = array('user_id'=>$res,'question_id'=>$user_info["problem3"],'answer'=>$user_info["answer3"],'create_time'=>time(),'update_time'=>time());
                    $answer_res = $answer -> addAll($data);
                    if(!empty($answer_res)){
                        $user_add -> commit();
                        $this->ajaxReturn('ok');
                    }else{
                        $user_add -> rollback();
                        $this->ajaxReturn('false');
                    }
                }else{
                    $user_add -> rollback();
                    $this->ajaxReturn("注册失败");
                }
            }
        }
//        $problem_data = S('problem');
//        if(empty($problem_data)){
            $problem = M('problem');
            $problem_data = $problem -> where('status = 0') -> select();
//            S('problem',$problem_data);      //缓存密保问题
//        }
        $this -> assign('problem',$problem_data);
        $this->display();
    }
    //验证账户是否存在
    function verifyAccount(){
        $account = I('post.account');
        $user = M("user_info");
        $res = $user -> where("account = '$account'") -> find();
        if(empty($res)){
            $this -> ajaxReturn("ok");
        }else{
            $this -> ajaxReturn("false");
        }
    }
    /*
     * 验证密保
     * 修改密码
     */
    function forgotPassword(){
        $this->assign('meta_title', '找回密码');
        //判断是否为修改密码
        $user_info = I('post.');
        if(!empty($user_info)){
            $user_answer = D('Answer');
            $answer_result = $user_answer -> testProtection($user_info);
            $this -> ajaxReturn($answer_result);
        }
        //页面显示
//        $problem_data = S('problem');
//        if(empty($problem_data)){
            $problem = M('problem');
            $problem_data = $problem -> where('status = 0') -> select();
//            S('problem',$problem_data);      //缓存密保问题
//        }
        $this -> assign('problem',$problem_data);
        $this -> display();
    }

//重置密码
    public function changePassword(){
        $verify = new \Think\Verify();
        if (!$verify->check(I('post.authCode'))) {
            $this -> ajaxReturn("验证码错误");
        }
        $id = I("post.id");
        $data['password'] = md5(I("post.password"));
        $res = M("user_info")->data($data)->where("id=".$id)->save();
        if ($res) {
            $this->ajaxReturn("ok");
        }
        $this->ajaxReturn(false);
    }

    /**
     * 验证码设置
     */
    function verify(){
        $config = array(
            'useImgBg' => false,    // 使用背景图片
            'fontSize' => 18,       // 验证码字体大小(px)
            'useCurve' => true,    // 是否画混淆曲线
            'useNoise' => false,    // 是否添加杂点
            'imageH'   => 35,       // 验证码图片高度
            'imageW'   => 140,      // 验证码图片宽度
            'length'   => 4, // 验证码位数
            'bg'       => array(243, 251, 254), // 背景颜色
            'reset'    => true,     // 验证成功后是否重置
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }
}