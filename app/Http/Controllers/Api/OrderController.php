<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Goods;
use App\Models\Cates;
use App\Models\CateGoods;
use App\Models\AddGoods;
class OrderController extends Controller
{
    /**
	 * 订单列表
    **/
    public function index(){
    	$result = Order::take(50)->get();
   		return response()->json([
   			"status" => 200,
   			"result" => $result,
   			"message" => "订单列表获取成功"
   		]);
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
}
