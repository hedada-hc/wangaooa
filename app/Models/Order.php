<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    	"user_id",'order_name',"name","address","phone","wechat","total_price","price","pay_status","pay_method","source","remark","express","number","express_status","goods_id","add_goods"
    ];
}
