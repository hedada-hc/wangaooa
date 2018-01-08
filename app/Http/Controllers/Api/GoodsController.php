<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Goods;
class GoodsController extends Controller
{

	/**
	 * 获取商品列表
	**/
   	public function index(Request $reuqest){
   		$result = Goods::take(30)->get();
   		return response()->json([
   			"status" => 200,
   			"result" => $result,
   			"message" => "商品列表获取成功"
   		]);
   	}


	/**
    * 添加商品
    * @params object  
	**/
	public function add(Request $request){
		$res = $request->get('data');
		$data = [
			"name" => $res['name'],
			"spec" => $res['spec'],
			"stock" => $res['stock'],
			"price" => $res['price'],
			"user_id" => $request->user()->id,
		];
		return response()->json([
			"status" => 200,
			"result" => Goods::create($data),
			"message" => "商品添加成功"
		]);
	}

	/**
    * 删除商品
	**/
	public function del(Request $request){
		return response()->json([
			"status" => 200,
			"result" => Goods::destroy($request->get('id')),
			"message" => "商品删除成功"
		]);
	}

   /**
    * 更新商品
   **/
   public function update(Request $request){
      $data = [
         "name" => $reuqest->get('name'),
         "spec" => $reuqest->get('spec'),
         "stock" => $reuqest->get('stock'),
         "price" => $reuqest->get('price'),
         "user_id" => $reuqest->user()->id,
      ];

      return response()->json([
         "status" => 200,
         "result" => Goods::where('id',$request->get('id'))->update($data),
         "message" => "商品添加成功"
      ]);
   }
}
