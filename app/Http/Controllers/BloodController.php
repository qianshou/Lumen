<?php
/**
 * Created by PhpStorm.
 * User: zhezhao
 * Date: 2016/12/5
 * Time: 11:06
 */

namespace App\Http\Controllers;


class BloodController extends Controller
{
    /**
     * 上传心率血氧信息
     * @param Request $request
     * @return mixed
     */
    public function submitBloodInfo(Request $request){
        return $request->all();
    }

    /**
     * 获取心率血氧信息
     * @param Request $request
     * @return mixed
     */
    public function getBloodInfo(Request $request){
        return $request->all();
    }
}