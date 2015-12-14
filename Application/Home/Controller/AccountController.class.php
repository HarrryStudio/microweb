<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 账户管理
 */
class AccountController extends BaseController {

    /*
     * 个人信息
     */
    public function personalDetails(){
/*        $this -> assign('account', session('user_info')['account']);
        $this -> assign('nickname', session('user_info')['nickname']);
        $this -> assign('phone', session('user_info')['phone']);
        $this -> assign('email', session('user_info')['email']);
        $this->init_head("个人信息",2,1,1);
        $this -> display();
*/
        $User_info = M('user_info');
        $map['id'] = session('user_info')['id'];
        $result = $User_info->where($map)->select();
        if($result) {
            session("user_info.head_img", $result[0]['head_img']);
            $this->assign("user_info", $result[0]);
            $this->init_head("个人信息",2,1,1);
            $this -> display();
        } 
    }
    /*
     * 修改密码
     */
    public function changePassword(){
        $this->init_head("修改密码",2,2,2);
        // $this->assign('meta_title', '修改密码');
        $user_info = I('post.');
        if(!empty($user_info)){
            $verify = new \Think\Verify();
            if (!$verify->check(I('post.authCode'))) {
                $this -> ajaxReturn("验证码错误");
            }
            $changePassword = D('UserInfo');
            $changePassword_res = $changePassword -> changePassword($user_info);
            $this -> ajaxReturn($changePassword_res);
        }
//        $problem_data = S('problem');
//        if(empty($problem_data)){
            $problem = M('problem');
            $problem_data = $problem -> where('status = 0') -> select();
//            S('problem',$problem_data);      //缓存密保问题
//        }
        $this -> assign('problem',$problem_data);
        $this -> display();
    }

    //修改密保
    public function changeProtection(){
        $this->init_head("修改密保",2,2,1);
        // $this -> assign('meta_title', '修改密保');

        $user_answer = I('post.');
        //判断是否为对密保的操作
        if(!empty($user_answer)){
            //验证密保
            if(empty($user_answer['old_problem_id'])){
                $test_user_answer = D('Answer');
                $test_result = $test_user_answer -> testProtection($user_answer);
                $this -> ajaxReturn($test_result);
            }else{      //修改密保
                $save_user_protection = M('answer');
                $where['user_id'] = session('user_info')['id'];
                for($i = 0; $i < 3; $i++){
                    $where['question_id'] = $user_answer['old_problem_id'][$i];
                    $save_data['question_id'] = $user_answer['problem'.($i+1)];
                    $save_data['answer'] = $user_answer['answer'.($i+1)];
                    $save_data['update_time'] = time();
                    $save_result = $save_user_protection
                        -> where($where)
                        -> save($save_data);
                    if(empty($save_result)){
                        $this -> ajaxReturn("false");
                    }
                }
                $this -> ajaxReturn('ok');
            }
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


/*
*gaoyadong
*完善用户个人信息
*/
    public function perfect(){
        $where['account'] = I("post.account");
        $data['nickname'] = I("post.nickname");
        $data['phone'] = I("post.phone");
        $data['email'] = I("post.inputEmail3");
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      './Uploads/'; // 设置附件上传根目录
        $upload->savePath  =      'personal/'; // 设置附件上传（子）目录
        $info   =   $upload->upload();          // 上传文件 
        $head_img = $info['file_upload']['savepath'].$info['file_upload']['savename'];
        if(!empty($head_img)){
            $data['head_img'] = $head_img;
        }
        $res = M("user_info")->data($data)->where($where)->save();
/*        if ($res) {
        }*/

        $this->redirect("personalDetails");
    }
}