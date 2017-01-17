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
    return $app->version();
});

//用户基本操作接口
$app->post('user/userRegist','UserController@userRegist');
$app->post('user/userLogin','UserController@userLogin');
$app->post('user/chgPassword','UserController@chgPassword');
$app->post('user/submitUserInfo','UserController@submitUserInfo');

//用户验证问题接口
$app->get('verify/verificationApply','VerifyController@verificationApply');
$app->post('verify/verification','VerifyController@verification');

//心率血氧信息接口
$app->post('blood/submitBloodInfo','BloodController@submitBloodInfo');
$app->get('blood/getBloodInfo','BloodController@getBloodInfo');