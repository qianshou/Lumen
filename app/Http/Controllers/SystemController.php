<?php
/**
 * Created by PhpStorm.
 * User: zhezhao
 * Date: 2017/2/16
 * Time: 20:11
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SystemController extends Controller
{
    /**
     * @param Request $request
     * 获取系统消息
     */
    public function GetMessage(Request $request){
        if($request->has('time')){
            $time = $request->input('time');
        }else{
            $time = '0000-00-00 00:00:00';
        }
        $where = [
            ['MESSAGE_TIME', '>=', $time],
        ];
        $items = DB::table('s_msg')->where($where)->get();
        $ret = array();
        $tmp = array();
        foreach ($items as $item){
            $tmp['MessageId'] = $item->MESSAGE_ID;
            $tmp['Type'] = $item->MESSSAGE_TYPE;
            $tmp['Content'] = $item->MESSSAGE_CONTENT;
            $tmp['Time'] = $item->MESSAGE_TIME;
            $ret[] = $tmp;
        }
        return ['code'=>2000,'data'=>$ret];
    }

    /**
     * 提交反馈消息
     */
    public function SubmitFeedback(){
        $params = json_extract();
        if(!array_has($params,['userId','content','time','contactWayType','contactWay'])){
            return ['code'=>2500];
        }
        DB::table("s_feedback")->insert([
            'USER_ID'=>$params['userId'],
            'FEEDBACK_CONTENT'=>$params['content'],
            'FEEDBACK_TIME'=>$params['time'],
            'USER_CONTACT_WAY_TYPE'=>$params['contactWayType'],
            'USER_CONTACT_WAY'=>$params['contactWay'],
        ]);
        return ['code'=>2000];
    }

    /**
     * 获取系统版本号等信息
     */
    public function GetSysInfo(){
        $items = DB::table('s_config')->get();
        $ret['version'] = null;
        $ret['apkUri'] = null;
        foreach ($items as $item){
            if($item->item == 'version'){
                $ret['version'] = $item->value;
            }
            if ($item->item == 'apkUri'){
                $ret['apkUri'] = $item->value;
            }
        }
        return ['code'=>2000,'data'=>$ret];
    }
}