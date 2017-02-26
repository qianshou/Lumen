<?php
/**
 * Created by PhpStorm.
 * User: zhezhao
 * Date: 2016/12/5
 * Time: 10:55
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * 用户注册方法
     * @param Request $request
     * @return mixed
     *  2500    参数不正确
     *  2200    手机号重复
     *  2000    注册成功
     */
    public function userRegist(Request $request){
        $params = json_extract();
        Log::info(var_export($params,true));
        //检查参数
        if(!array_has($params,['UserPhone','UserPwd','VerificationQuestion','VerificationAnswer'])){
            return ['code'=>2500];
        }
        //检查手机号格式
        if(!preg_match('/^1[34578][0-9]{9}$/',$params['UserPhone'])){
            return ['code'=>2500];
        }
        //查询手机号是否重复
        $num = DB::table("p_user_info")->where('USER_PHONE',$params['UserPhone'])->count();
        if($num != 0){
            return ['code'=>2200];
        }
        //手机号和密码插入基本信息表
        $user_id = DB::table("p_user_info")->insertGetId([
            'USER_PHONE'=>$params['UserPhone'],
            'USER_PWD'=>$params['UserPwd'],
        ]);
        //用户ID和验证问题插入数据表
        DB::table("d_user_que")->insert([
            'USER_ID'=>$user_id,
            'USER_QUE'=>$params['VerificationQuestion'],
            'USER_ANS'=>$params['VerificationAnswer'],
        ]);
        $retUser['UserId'] = $user_id;
        $retUser['UserPhone'] = $params['UserPhone'];
        return ['code'=>2000,'msg'=>$retUser];
    }

    /**
     * 用户登录方法
     * @param Request $request
     * @return mixed
     *  2500    参数不正确
     *  2000    注册成功
     *  2600    手机号未注册
     *  2700    手机号和密码不匹配
     */
    public function userLogin(Request $request){
        $params = json_extract();
//        Log::info(var_export($params,true));
        //检查参数
        if(!array_has($params,['UserPhone','UserPwd'])){
            return ['code'=>2500];
        }
        //检查手机号和密码是否匹配
        $user = DB::table('p_user_info')->where('USER_PHONE',$params['UserPhone'])->first();
        if(empty($user)){
            return ['code'=>2600];
        }
        if($user->USER_PWD == $params['UserPwd']){
            $retUser['UserId'] = $user->USER_ID;
            $retUser['UserPhone'] = $user->USER_PHONE;
            $retUser['UserName'] = $user->USER_NAME;
            $retUser['UserSex'] = $user->USER_SEX;
            $retUser['UserAge'] = $user->USER_AGE;
            $retUser['UserHeight'] = $user->USER_HEI;
            $retUser['UserWeight'] = $user->USER_WEI;
            $retUser['UserBrithday'] = $user->USER_BRI;
            $retUser['UserIMG'] = $user->USER_IMG;
            return ['code'=>2000,'msg'=>$retUser];
        }else{
            return ['code'=>2700];
        }
    }

    /**
     * 修改用户密码
     * @param Request $request
     * @return mixed
     *  2500    参数不正确
     *  2200    手机号重复
     */
    public function chgPassword(Request $request){
        $params = json_extract();
        //检查参数
        if(!array_has($params,['UserPwdNew','UserId'])){
            return ['code'=>2500];
        }
        //更新数据库
        DB::table('p_user_info')->where('USER_ID', $params['UserId'])
        ->update(['USER_PWD' => $params['UserPwdNew']]);
        return ['code'=>2000];
    }

    /**
     * 修改用户个人信息
     * @param Request $request
     * @return mixed
     *  2500    参数不正确
     *  2200    手机号重复
     */
    public function submitUserInfo(Request $request){
        $params = json_extract();
       // Log::info(var_export($params,true));
        //检查参数
        if(!array_has($params,['UserPhone','UserName','UserSex','UserAge','UserHeight','UserWeight','UserBrithday'])){
            return ['code'=>2500];
        }
        $updateArr = [];
        //更新数据库
        $updateArr['USER_PHONE'] = $params['UserPhone'];
        $updateArr['USER_NAME'] = $params['UserName'];
        $updateArr['USER_SEX'] = $params['UserSex'];
        $updateArr['USER_AGE'] = $params['UserAge'];
        $updateArr['USER_HEI'] = $params['UserHeight'];
        $updateArr['USER_WEI'] = $params['UserWeight'];
        $updateArr['USER_BRI'] = $params['UserBrithday'];
        if(isset($params['UserIMG'])){
            $updateArr['USER_IMG'] = $params['UserIMG'];
        }
        DB::table('p_user_info')->where('USER_ID', $params['UserId'])
            ->update($updateArr);
        return ['code'=>2000];
    }
}