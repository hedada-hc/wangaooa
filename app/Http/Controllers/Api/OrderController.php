<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Goods;
use App\Models\Cates;
use App\Models\CateGoods;
use App\Models\AddGoods;
use App\Models\Alc;
use Excel;
class OrderController extends Controller
{
    /**
	 * 订单列表
    **/
    public function index(Request $request){
        //获取alc可显示字段
        $alc = Alc::where('user_id', $request->user()->id)->first();
        $select = json_decode($alc->order);
        array_push($select, 'id','created_at');
        if($alc->status == 5){
            $where = [];
        }else{
            $where = ['user_id' => $request->user()->id];
        }
        
        //分页数据
        $pageSize = 30;
        $page = $request->get('page') <= 1 ? 0 : (abs($request->get('page')) * $pageSize) - $pageSize;



        if($request->get('goods_id')){
            $result = Order::where('id',$request->get('goods_id'))->select($select)->get();
        }

        if($request->get('status')){
            switch ($request->get('status')) {
                case '1':
                    //未发货的
                    $result = Order::where($where)->orderBy('express_status','asc')->select($select)->offset($page)->limit($pageSize)->get();
                    break;
                default:
                    $result = Order::where($where)->orderBy('express_status','desc')->select($select)->offset($page)->limit($pageSize)->get();
                    break;
            }
        }

        if($request->get('take')){
            switch ($request->get('take')) {
                case '1':
                    //只看已签收
                    array_push($where,["express_status" => 2]);
                    $result = Order::latest()->where($where)->select($select)->offset($page)->limit($pageSize)->get();
                    $count = Order::where($where)->count();
                    break;
                case '2':
                    //只看已发货
                    array_push($where,["express_status" => 1]);
                    $result = Order::latest()->where($where)->select($select)->offset($page)->limit($pageSize)->get();
                    $count = Order::where($where)->count();
                    break;
                case '3':
                    //只看未签收
                    array_push($where,["express_status" => 0]);
                    $result = Order::latest()->where($where)->select($select)->offset($page)->limit($pageSize)->get();
                    $count = Order::where($where)->count();
                    break;
                case '4':
                    //只看微信
                    array_push($where,["pay_method" => 1]);
                    $result = Order::latest()->where($where)->select($select)->offset($page)->limit($pageSize)->get();
                    $count = Order::where($where)->count();
                    break;
                case '5':
                    //只看支付宝
                    array_push($where,["pay_method" => 2]);
                    $result = Order::latest()->where($where)->select($select)->offset($page)->limit($pageSize)->get();
                    $count = Order::where($where)->count();
                    break;
                default:
                    //只看复购订单
                    $result = $this->queryRepOrder($request,$select);
                    break;
            }
        }
        if(!$request->get('take') && !$request->get('status') && !$request->get('goods_id')){
            $result = Order::latest()->where($where)->select($select)->offset($page)->limit($pageSize)->get();
            $count = Order::where($where)->count();
        }
   		return response()->json([
   			"status" => 200,
   			"result" => $result,
            "total" => $count,
   			"message" => "订单列表获取成功"
   		]);
    }

    /**
     * 是否复购检测
    **/
    public function isRepOrder($phone){
        $count = Order::where('phone',$phone)->count();
        if($count >= 1){
            Order::where('phone',$phone)->update(['rep_count' => $count]);
        }
    }

    /**
     * 获取复购订单
    **/
    public function queryRepOrder(Request $request,$select){
        $user_id = $request->user()->id;
        return Order::where('user_id',$user_id)->where('rep_count','>=',1)->select($select)->get();
    }

    /**
	 * 新增订单
    **/
    public function add(Request $request){
        $data = $request->get("data");
        $fill = [
            "user_id" => $request->user()->id,
            "order_name" => $data['order_name'],
            "name" => $data['name'],
            "address" => $data['address'],
            "phone" => $data['phone'],
            "wechat" => $data['wechat'],
            "total_price" => $data['total_price'],
            "price" => $data['price'],
            "pay_status" => $data['pay_status'],
            "pay_method" => $data['pay_method'],
            "source" => $data['source'],
            "remark" => $data['remark'],
            "express" => $data['express'],
            "number" => $data['number'],
            "express_status" => $data['express_status'],
            "goods_id" => isset($data['goods_id']) ? $data['goods_id'] : false,
            "add_goods" => $data['add_goods'],
        ];
        if(count($fill['add_goods']) <= 0){
            //直接套餐选择
            $this->subGoodsStock($request,['id' => $data['goods_id']]);
            $fill['add_goods'] = "";
            $order = Order::create($fill);
        }else{
            //附加商品或者单商品
            if(isset($data['goods_id'])){
                $handleData = [
                    "id" => $data['goods_id'],
                    "num" => $data['add_goods'],
                    "user_id" => $request->user()->id
                ];
            }else{
                $handleData = [
                    "num" => $data['add_goods'],
                    "user_id" => $request->user()->id
                ];
            }
            $addGoods = $this->subGoodsStock($request,$handleData);
            $fill['add_goods'] = implode(",",$addGoods);
            $order = Order::create($fill);
            AddGoods::whereIn('id',$addGoods)->update(['order_id' => $order->id]);
        }
        $this->isRepOrder($fill['phone']);
    	return response()->json([
   			"status" => 200,
   			"result" => $order,
   			"message" => "订单添加成功"
   		]);
    }

    /**
     * 减少库存
    **/
    public function subGoodsStock(Request $request, $data = null){
        if(isset($data['id'])){
            $cate_id = Cates::where('id',$data['id'])->first()->cate_goods_id;
            $cate_id = CateGoods::whereIn('id',explode(",", $cate_id))->get();
            $res = collect($cate_id)->map(function($item){
                return Goods::where('id',$item->goods_id)->decrement('stock',$item->stock);
            });
        }
        if(isset($data['num'])){
            $stock = $data['num'];
            $res = collect($stock)->map(function($item) use($data){
                Goods::where('id',$item['select'])->decrement('stock',$item['value']);
                $addGoods_id = AddGoods::create([
                    "user_id" => $data['user_id'],
                    "goods_id" => $item['select'],
                    "stock" => $item['value']
                ]);
                return $addGoods_id->id;
            })->toArray();
            return $res;
        }
        return response()->json([
            "status" => 200,
            "result" => $res,
            "message" => "库存减少",
        ]);
    }

    /**
	 * 删除订单
    **/
    public function del(Request $request){
    	return response()->json([
   			"status" => 200,
   			"result" => Order::destroy($request->get('id')),
   			"message" => "订单添加成功"
   		]);
    }

    /**
     * 修改订单
    **/
    public function update(Request $request){
        if($request->get('name')){
            
        }else{
            $data = [
                'express' => $request->get('express'),
                'number' => $request->get('number'),
                'express_status' => 1
            ];
            if($request->get("express_status")){
                $res = Order::where('id',$request->get('id'))->update(['express_status' => 2]);
            }else{
                $res = Order::where('id',$request->get('id'))->update($data);
            }
        }
        return $res;
    }

    /**
     * 
    **/
    public function excel(Request $request){

        $start = $request->get('start');
        $end = $request->get('end');
        $count = Order::where('created_at','>=',$start)->where('created_at','<=',$end)->count();
        if($count >= 1){
            $orderData = Order::where('created_at','>=',$start)->where('created_at','<=',$end)->select([
                'id','order_name','name','address','phone','wechat','total_price','express','number','source','remark','created_at'
            ])->get()->toArray();
            array_unshift($orderData,['订单号','订单名称','收货人','收货地址','收货人电话','收货人微信号','订单总价','快递公司','快递单号','出单来源','备注','订单时间']);
            $file_name = $request->user()->username."-".$start."至".$end;
            Excel::create($file_name,function($excel) use ($orderData){
                $excel->sheet('score', function($sheet) use ($orderData){
                    $sheet->rows($orderData);
                });
            })->export('xls');
        }
    }

}
