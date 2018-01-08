<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cates;
use App\Models\CateGoods;
use App\Models\Goods;
class CatesController extends Controller
{
    /**
  	 * 分类列表
    **/
    public function index(){
        $result = $this->findCateGoodsId(Cates::take(30)->get());
    	return response()->json([
   			"status" => 200,
   			"result" => $result,
   			"message" => "分类列表获取成功"
   		]);
    }

    /**
     * 根据套餐商品id找出商品
    **/
    public function findCateGoodsId($res){
        $data = collect($res)->map(function($item){
            $arr = explode(",",$item->cate_goods_id);
            $goodsArr = collect(CateGoods::whereIn('id',$arr)->select('goods_id')->get())->map(function($item){
                return $item->goods_id;
            });
            $item->goods = Goods::whereIn('id',$goodsArr)->select('name','price','stock')->get()->toArray();
            return $item;
        })->toArray();
        return $data;
    }

    /**
	 * 添加分类
    **/
    public function add(Request $request){
        $res = $request->get('data');
        $res['user_id'] = $request->user()->id;
    	$data = [
    		"cate_goods_id" => $this->addCateGoods($res),
    		"name" => $res['name'],
    		"price" => $res['price'],
    		"user_id" => $res['user_id'],
    	];
    	return response()->json([
   			"status" => 200,
   			"result" => Cates::create($data),
   			"message" => "分类添加成功"
   		]);
    }

    /**
	 * 删除分类
    **/
    public function del(Request $request){
    	return response()->json([
   			"status" => 200,
   			"result" => Cates::destroy($request->get('id')),
   			"message" => "分类删除成功"
   		]);
    }

    /**
	 * 编辑分类
    **/
    public function update(Request $request){
    	$data = [
    		"cate_goods_id" => $request->get('cate_goods_id'),
    		"name" => $request->get('name'),
    		"price" => $request->get('price'),
    		"user_id" => $request->user()->id,
    	];
    	return response()->json([
   			"status" => 200,
   			"result" => Cates::where('id',$request->get('id'))->update($data),
   			"message" => "分类更新成功"
   		]);
    }

    /**
     * 套餐下面的什么商品
    **/
    public function addCateGoods($goods){
        $goodsList = $goods['goods'];
        $data = collect($goodsList)->map(function($item) use($goods){
            $tmp_data = [
                'goods_id' => $item['goods_id'],
                'stock' => $item['count'],
                'user_id' => $goods['user_id'],
            ];
            $res = CateGoods::create($tmp_data);
            return $res->id;
        })->toArray();
        return implode(",",$data);
    }
}
