<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alc extends Model
{
    protected $fillable = [
    	'user_id','order','goods','cates','user','status'
    ];
}
