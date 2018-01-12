<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Alc;
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
            'headPic' => '/avatars/defaultPic'.rand(1,10).'.png'
        ];
        $user = User::create($data);
        //生成alc权限记录
        $alc = [
            'user_id' => $user->id,
            'order' => json_encode([]),
            'cates' => 0,
            'user' => 0,
            'goods' => 0,
            'status' => 0,
        ];
        $alc_c = Alc::create($alc);
        User::where('id',$user->id)->update('alc_id',$alc_c->id);
        return response()->json([
   			"status" => 200,
   			"result" => $user,
   			"message" => "用户添加成功"
   		]);
    }

    /**
     * 删除用户
    **/
    public function delUser(Request $request){
        return response()->json([
            "code" => 0,
            "result" => User::destroy($request->get('id')),
            'message' => "用户删除成功"
        ]);
    }

    /**
     * 获取权限列表
    **/
    public function queryAlcList(Request $request){
        $data = [
            ["value" => 'order_name', "desc" => "订单名称"],
            ["value" => 'name', "desc" => "收货人姓名"],
            ["value" => 'address', "desc" => "收货地址"],
            ["value" => 'phone', "desc" => "收货人电话"],
            ["value" => 'wechat', "desc" => "收货人微信"],
            ["value" => 'total_price', "desc" => "订单总价"],
            ["value" => 'price', "desc" => "已付款金额"],
            ["value" => 'pay_status', "desc" => "支付状态"],
            ["value" => 'pay_method', "desc" => "支付方式"],
            ["value" => 'source', "desc" => "出单来源"],
            ["value" => 'remark', "desc" => "订单备注"],
            ["value" => 'express', "desc" => "快递公司"],
            ["value" => 'number', "desc" => "快递单号"],
            ["value" => 'express_status', "desc" => "快递状态"],
            ["value" => 'goods_id', "desc" => "订单商品"],
            ["value" => 'add_goods', "desc" => "订单附加商品"],
            ["value" => 'rep_count', "desc" => "订单复购"],
        ];
        return response()->json([
            "status" => 200,
            "result" => ['order' => $data, 'alc' => Alc::where('user_id',$request->get('id'))->first()]
        ]);
    }

    /**
     * 赋值权限
    **/
    public function addAlc(Request $request){
        $user_id = $request->get('user_id');
        $order = $request->get('order');
        $user = $request->get('user');
        $goods = $request->get('goods');
        $cateGoods = $request->get('cateGoods');
        $data = [
            "user_id" => $user_id,
            "order" => json_encode($order),
            "user" => $user,
            "cates" => $cateGoods,
            "goods" => $goods,
        ];

        if(Alc::where('user_id',$user_id)->first()){
            $res = Alc::where('user_id',$user_id)->update($data);
        }else{
            $alc = Alc::create($data);
            $res = User::where('id',$user_id)->update(['alc_id' => $alc->id]);
        }
        return response()->json([
            "status" => 200,
            "result" => $res,
            "message" => "权限更新成功"
        ]);
    }

    /**
     * 用户头像上传
    **/
    public function upload(Request $request){
        $file = $request->file('file');
        $filename = md5($request->user()->username.time()).'.'.$file->getClientOriginalExtension();
        $file->move(public_path('avatars'),$filename);
        //保存
        User::where('id',$request->user()->id)->update(['headPic' => '/avatars/'.$filename]);
        return response()->json([
            "code" => 0,
            "result" => '/avatars/'.$filename,
            'message' => "头像上传成功"
        ]);
    }
}
