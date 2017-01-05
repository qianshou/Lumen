<?php
/**
 * Created by PhpStorm.
 * User: zhezhao
 * Date: 2016/12/5
 * Time: 15:02
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifyController extends Controller
{
    /**
     * 查询验证问题
     * @param Request $request
     * @return mixed
     *
     */
    public function verificationApply(){
        $params = json_extract();
        //查询验证问题
        $question = DB::table('d_user_que')->where('USER_ID', $params['UserId'])->value('USER_QUE');
        if(empty($question)){
            return ['code'=>2800];
        }else{
            return ['code'=>2000,'msg'=>$question];
        }
    }

    /**
     * 检查验证问题答案
     * @param Request $request
     * @return mixed
     */
    public function verification(){
        $params = json_extract();
        //检查参数
        if(!array_has($params,['Answer'])){
            return ['code'=>2500];
        }
        //查询验证问题
        $ans = DB::table('d_user_que')->where('USER_ID', $params['UserId'])->value('USER_ANS');
        if(empty($ans)){
            return ['code'=>2800];
        }else{
            if($ans == $params['Answer']){
                return ['code'=>2000];
            }else{
                return ['code'=>2900];
            }
        }
    }
}