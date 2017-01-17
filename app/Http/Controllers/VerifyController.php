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
    public function verificationApply(Request $request){
        //查询验证问题
        $userid = DB::table('p_user_info')->where('USER_PHONE',$request->input('UserPhone'))->value('USER_ID');
        if(empty($userid)){
            return ['code'=>2700];
        }
        $question = DB::table('d_user_que')->where('USER_ID', $userid)->value('USER_QUE');
        $ret['UserId'] = $userid;
        $ret['UserQue'] = $question;
        if(empty($question)){
            return ['code'=>2800];
        }else{
            return ['code'=>2000,'msg'=>$ret];
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
        if(!array_has($params,['Answer',"UserId"])){
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