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
class UserController extends Controller
{
    /**
     * 用户注册方法
     * @param Request $request
     * @return mixed
     */
    public function userRegist(Request $request){
        if(!$request->has(['UserPhone','UserPwd','VerificationQuestion','VerificationAnswer'])){
            return ['code'=>2500,'msg'=>"request params is wrong"];
        }
        if(!preg_match('/^1[34578][0-9]{9}$/',$request->input('UserPhone'))){
            return ['code'=>2500,'msg'=>"UserPhone patten is wrong"];
        }
        //查询手机号是否重复
        $num = DB::table("p_user_info")->where('USER_PHONE',$request->input('UserPhone'))->count();
        if($num != 0){
            return ['code'=>2200,'msg'=>"UserPhone is already registered"];
        }
        //手机号和密码插入基本信息表
        $user_id = DB::table("p_user_info")->insertGetId([
            'USER_PHONE'=>$request->input('UserPhone'),
            'USER_PWD'=>$request->input('UserPwd'),
        ]);
        //用户ID和验证问题插入数据表
        DB::table("d_user_que")->insert([
            'USER_ID'=>$user_id,
            'USER_QUE'=>$request->input('VerificationQuestion'),
            'USER_ANS'=>$request->input('VerificationAnswer'),
        ]);
        return ['code'=>2000,'msg'=>$user_id];
    }

    /**
     * 用户登录方法
     * @param Request $request
     * @return mixed
     */
    public function userLogin(Request $request){
        if(!$request->has(['UserPhone','UserPwd'])){
            return ['code'=>2500,'msg'=>"request params is wrong"];
        }
        $user = DB::table('p_user_info')->where('USER_PHONE',$request->input('UserPhone'))->first();
        if(empty($user)){
            return ['code'=>2600,'msg'=>"not registed yet"];
        }
        if($user->USER_PWD == $request->input('UserPwd')){
            $retUser['UserId'] = $user->USER_ID;
            $retUser['UserPhone'] = $user->USER_PHONE;
            $retUser['UserName'] = $user->USER_NAME;
            $retUser['UserSex'] = $user->USER_SEX;
            $retUser['UserAge'] = $user->USER_AGE;
            $retUser['UserHeighe'] = $user->USER_HEI;
            $retUser['UserWeight'] = $user->USER_WEI;
            $retUser['UserBrithday'] = $user->USER_BRI;
            $retUser['UserImage'] = $user->USER_IMG;
            return ['code'=>2000,'msg'=>$retUser];
        }else{
            return ['code'=>2700,'msg'=>"password is wrong"];
        }
    }

    /**
     * 修改用户密码
     * @param Request $request
     * @return mixed
     */
    public function chgPassword(Request $request){
        if(!$request->has(['UserId','UserPwd','UserPwdNew'])){
            return ['code'=>2500,'msg'=>"request params is wrong"];
        }
        $pwd = DB::table('p_user_info')->where('USER_ID', $request->input('UserId'))->value('USER_PWD');
        if($pwd != $request->input('UserPwd')){
            return ['code'=>2700,'msg'=>"wrong password"];
        }
        DB::table('p_user_info')->where('USER_ID', $request->input('UserId'))
        ->update(['USER_PWD' => $request->input('UserPwdNew')]);
        return ['code'=>2000,'msg'=>'ok'];
    }

    /**
     * 修改用户个人信息
     * @param Request $request
     * @return mixed
     */
    public function submitUserInfo(Request $request){
        if(!$request->has(['UserId','UserPhone','UserPwd','UserName','UserSex','UserAge','UserHeight','UserWeight','UserBrithday'])){
            return ['code'=>2500,'msg'=>"request params is wrong"];
        }
        $pwd = DB::table('p_user_info')->where('USER_ID', $request->input('UserId'))->value('USER_PWD');
        if($pwd != $request->input('UserPwd')){
            return ['code'=>2700,'msg'=>"wrong password"];
        }
        $updateArr['USER_PHONE'] = $request->input('UserPhone');
        $updateArr['USER_NAME'] = $request->input('UserName');
        $updateArr['USER_SEX'] = $request->input('UserSex');
        $updateArr['USER_AGE'] = $request->input('UserAge');
        $updateArr['USER_HEI'] = $request->input('UserHeighe');
        $updateArr['USER_WEI'] = $request->input('UserWeight');
        $updateArr['USER_BRI'] = $request->input('UserBrithday');
        if($request->hasFile('UserImage')){
            //上传图片
            $file = $request->file('UserImage');
            $extension = $file->extension();
            $path = storage_path('app/UserImage').'/'.$request->input('UserId').".".$extension;
            return $path = $file->store('UserImage');
            //更新 p_user_info
            $updateArr['USER_IMG'] = $path;
        }
        DB::table('p_user_info')->where('USER_ID', $request->input('UserId'))
            ->update($updateArr);
        return ['code'=>2000,'msg'=>"ok"];
    }
}