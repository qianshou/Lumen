<?php
/**
 * Created by PhpStorm.
 * User: zhezhao
 * Date: 2016/12/6
 * Time: 16:07
 */

namespace App\Http\Middleware;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\Request;
use Closure;

class UserAuth
{
    public function handle(Request $request, Closure $next)
    {
        $params = json_extract();
        //检查参数
        if(!array_has($params,['UserId','UserPwd'])){
            return ['code'=>2500];
        }
        //检查uid和pwd是否匹配
        $pwd = DB::table('p_user_info')->where('USER_ID', $params['UserId'])->value('USER_PWD');
        if($pwd != $params['UserPwd']){
            return ['code'=>2700];
        }else{
            //uid和pwd校验通过
            return $next($request);
        }
    }
}