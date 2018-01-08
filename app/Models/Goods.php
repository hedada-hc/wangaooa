<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $fillable = [
    	'name','spec','stock','price','user_id'
    ];
}
