<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
class AlcController extends Controller
{
    /**
	 * 获取用户列表
    **/
    public function index(Request $request){
    	if($request->get('status')){
    		$result = User::where('status','>=',1)->with('user')->take(30)->get();
    	}else{
    		$result = User::with('user')->take(30)->get();
    	}
    	return response()->json([
   			"status" => 200,
   			"result" => $result,
   			"message" => "用户获取成功"
   		]);
    }

    /**
     * 添加用户
    **/
    public function addUser(Request $request){
    	$res = $request->get('data');
        $data = [
        	"username" => $res['username'],
            "password" => bcrypt($res['password']),
        	"status" => $res['status'],
        	"super_id" => $res['super_id'] ? $res['super_id'] : User::where('status',">=",1)->first()->id,
        ];
        return response()->json([
   			"status" => 200,
   			"result" => User::create($data),
   			"message" => "用户添加成功"
   		]);
    }

    /**
     * 删除用户
    **/
    public function delUser(Request $request){

    }
}
