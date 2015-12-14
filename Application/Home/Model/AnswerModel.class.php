<?php
/**
 * Created by PhpStorm.
 * User: 杨亚东
 * Date: 15-8-9
 * Time: 下午3:16
 */

namespace Home\Model;
use Think\Model;

class AnswerModel extends Model{
    /*
     * 验证密保问题
     */
    function testProtection($data){

        $user_answer = M('user_info');
        if(!empty($data['account'])){       //忘记密码
            $where['account'] = $data['account'];
            $answer_result = $user_answer
                -> where($where)
                -> join('LEFT JOIN answer ON user_info.id = answer.user_id')
                -> field('user_info.id,answer.question_id,answer.answer')
                -> select();
        }else{        //修改密保
            $test_user_answer = M('answer');
            $where['user_id'] = session('user_info')['id'];
            $answer_result = $test_user_answer
                ->where($where)
                -> field('question_id,answer')
                -> select();
        }
        if(empty($answer_result)){
            return false;
        }
        //验证密保
        $num = 0;
        for($i = 1; $i < 4; $i++){
            for($j = 0; $j < 3; $j++){
                if($answer_result[$j]['question_id'] == $data["problem".$i]){
                    if($answer_result[$j]['answer'] != $data["answer".$i]){
                        return false;
                    }else{
                        $num++;
                    }
                }
            }
        }
        if($num != 3){
            return false;
        }
        if(!empty($data['account'])){
            return $answer_result[0]['id'];
        }else{
            return array($answer_result[0]['question_id'],$answer_result[1]['question_id'],$answer_result[2]['question_id'],'ok');
        }
    }
} 