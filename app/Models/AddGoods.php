<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddGoods extends Model
{
    protected $fillable = [
    	"user_id","goods_id","stock","order_id"
    ];
}
