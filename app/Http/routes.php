<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return "hello world";
    //return $app->version();
});

//用户注册和登录接口
$app->post('user/userRegist','UserController@userRegist');
$app->post('user/userLogin','UserController@userLogin');

//修改密码
$app->post('user/chgPassword','UserController@chgPassword');
//修改个人信息
$app->post('user/submitUserInfo','UserController@submitUserInfo');

//用户验证问题接口
$app->get('verify/verificationApply','VerifyController@verificationApply');
$app->post('verify/verification','VerifyController@verification');

//心率血氧信息接口
$app->post('blood/submitBloodInfo','BloodController@submitBloodInfo');
$app->post('blood/submitBigData','BloodController@submitBigData');
$app->get('blood/getBloodInfo','BloodController@getBloodInfo');

//登录后操作接口
//$app->group(['middleware' => 'userAuth'],function() use ($app){
//});

//获取系统推送消息
$app->get('sys/GetMessage','SystemController@GetMessage');
//提交反馈消息
$app->post('sys/SubmitFeedback','SystemController@SubmitFeedback');
//获取系统版本号等信息
$app->get('sys/GetSysInfo','SystemController@GetSysInfo');


$app->post('index/index','IndexController@index');
