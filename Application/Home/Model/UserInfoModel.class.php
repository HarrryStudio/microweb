<?php
namespace Home\Model;
use Think\Model;
class UserInfoModel extends Model{
    /*
     *登录
     */
    function login($data){
        $login = M("user_info");
        $where['account'] = $data['account'];
        $login_res = $login -> where($where) -> find();
        if ($login_res['forbidden'] == 1) {
            return "账户已被禁用，请联系管理员";
        } else if ($login_res['status'] == 1) {
            return "用户不存在";
        }
        $ids = M('site_info')
                ->field('id')
                ->where(array('user_id'=>$login_res['id'],'status'=>0,'forbidden'=>0))
                ->select();
        $site_all = array();
        foreach ($ids as $key => $value) {
            array_push($site_all, $value['id']);
        }
        if($login_res['password'] == md5($data['password'])){
            session("user_info",$login_res);
            session("site_info",$site_all);
            if($data['remember'] == 0){
                cookie("user_account",$data['account']);
                cookie("user_password",$data['password']);
            }else{
                cookie("user_account",null);
                cookie("user_password",null);
            }
            return "ok";
        }
        return "账号或密码错误";
    }
    /*
     *注册自动验证
     *自动完成
     */
    protected $trueTableName = 'user_info';
    protected $_validate = array(
        array('account', '', '帐号名称已经存在!', 0, 'unique', 1), // 在新增的时候验证username字段是否唯一
        array('account', '/^\w{9,15}$/', '账户名9~15位', 3, regex),
    );
    protected $_auto = array(
        array('status', '0'), // 新增的时候把status字段设置为0
        array('password', 'md5', 1, 'function'), // 对password字段在新增的时候使md5函数处理
        array('create_time','time',1,'function'),
        array('update_time','time',1,'function')
    );

    //修改密码
    function changePassword($data){
        $user_info = M('user_info');
        if(empty($data['id'])){    //修改密码
            $where['user_id'] = session('user_info')['id'];
            // $where['user_id'] = 6;
            $where['question_id'] = $data['problem'];
            $answer = M('answer');
            $answer_result = $answer -> where($where) -> field('answer') -> find();
            if($answer_result['answer'] == $data['answer']){
                 $where['id'] = session('user_info')['id'];
//                $map['id'] = 6;
                $where['password'] = md5($data['password_old']);
                $save_data['password'] = md5($data['password']);
                $save_data['update_time'] = time();
                $save_result = $user_info -> where($where) -> save($save_data);
                if(!empty($save_result)){
                    return 'ok';
                }else{
                    return 'false';
                }
            }
            return "error";
        }
        //找回密码重置密码忘记密码
        $where['id'] = $data['id'];
        $save_data['password'] = md5($data['password']);
        $save_data['update_time'] = time();
        $changePassword_result = $user_info
            -> where($where)
            -> save($save_data);
        if(!empty($changePassword_result)){
            return 'ok';
        }else{
            return 'false';
        }
    }
}
?>