<?php
/**
 * Created by PhpStorm.
 * User: zhezhao
 * Date: 2016/12/7
 * Time: 13:58
 */

namespace App\Http\Controllers;


class IndexController extends Controller
{
    public function index(){
        $params = json_extract();
        $body = [array_has($params,['Count','Index','name'])];
        return response($body)->header('Content-Type',"application/json;charset=UTF-8");
    }
}