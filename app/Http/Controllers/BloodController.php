<?php
/**
 * Created by PhpStorm.
 * User: zhezhao
 * Date: 2016/12/5
 * Time: 11:06
 */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BloodController extends Controller
{
    /**
     * 上传心率血氧信息
     * @param Request $request
     * @return mixed
     */
    public function submitBloodInfo(){
        $params = json_extract();
        //检查参数
        if(!array_has($params,['UserId','binfos'])){
            return ['code'=>2500];
        }
        $UserId = $params['UserId'];
        $binfos = $params['binfos'];
        $multy_insert = [];
        foreach ($binfos as $item){
            $tmp = [];
            $tmp['USER_ID'] = $UserId;
            $tmp['TYPE'] = $item['Type'];
            $tmp['VALUE'] = $item['Value'];
            $tmp['TIMESTAMP'] = $item['Time'];
            $multy_insert[] = $tmp;
        }
        DB::table("d_blood_info")->insert($multy_insert);
        return ['code'=>2000];
    }

    /**
     * 上传大数据检测信息
     * @param Request $request
     * @return mixed
     */
    public function submitBigData(){
        $params = json_extract();
        //检查参数
        if(!array_has($params,['UserId','binfos'])){
            return ['code'=>2500];
        }
        $UserId = $params['UserId'];
        $binfos = $params['binfos'];
        $multy_insert = [];
        foreach ($binfos as $item){
            $tmp = [];
            $tmp['USER_ID'] = $UserId;
            $tmp['TYPE'] = $item['Type'];
            $tmp['VALUE'] = $item['Value'];
            $tmp['TIMESTAMP'] = $item['Time'];
            $multy_insert[] = $tmp;
        }
        DB::table("d_big_info")->insert($multy_insert);
        return ['code'=>2000];
    }

    /**
     * 获取心率血氧信息
     * @param Request $request
     * @return mixed
     */
    public function getBloodInfo(Request $request){
        $date = $request->input('Date');
        $UserId = $request->input('UserId');
        $where = [
            ['TIMESTAMP', '>=', $date.' 00:00'],
            ['TIMESTAMP', '<=', $date.' 23:59'],
            ['USER_ID', '=', $UserId]
        ];
        Log::info(var_export($where,true));
        $items = DB::table('d_blood_info')->where($where)->get();
        return ['code'=>2000,'data'=>$items];
    }
}