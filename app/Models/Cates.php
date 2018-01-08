<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cates extends Model
{
    protected $fillable = [
    	"cate_goods_id","name","price","user_id"
    ];
}
