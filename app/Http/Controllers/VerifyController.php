<?php
/**
 * Created by PhpStorm.
 * User: zhezhao
 * Date: 2016/12/5
 * Time: 15:02
 */

namespace App\Http\Controllers;


class VerifyController extends Controller
{
    /**
     * 查询验证问题
     * @param Request $request
     * @return mixed
     *
     */
    public function verificationApply(Request $request){
        return $request->all();
    }

    /**
     * 检查验证问题答案
     * @param Request $request
     * @return mixed
     */
    public function verification(Request $request){
        return $request->all();
    }
}