<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Alc;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','password','super_id','alc_id','wechat_id','status','headPic'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user(){
        return $this->belongsTo(User::class,'super_id','id');
    }

    public function alc(){
        return $this->belongsTo(Alc::class,'alc_id','id');
    }
}
