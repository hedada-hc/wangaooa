<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CateGoods extends Model
{
    protected $fillable = [
    	"goods_id","stock","user_id"
    ];
}
