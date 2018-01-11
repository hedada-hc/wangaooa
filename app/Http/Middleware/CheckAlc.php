<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Models\Alc;

class CheckAlc
{
    protected $Req;
    /**
     * Handle an incoming request.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->Req = $request;
        $alc = $this->queryAlc();
        if(!$alc) return response()->json(['message' => "请联系管理员添加权限", "status" => 500]);
        if($this->isAuth($alc)){
            return $next($request);
        }else{
            return response()->json(['message' => "请不要非法访问,妈的", "status" => 500]);
        }
    }

    /**
     * 获取用户权限值
    **/
    public function queryAlc(){
        $id = $this->Req->user()->id;
        $alc= Alc::where('user_id',$id)->first();
        return $alc;
    }

    /**
     * 鉴定权限
    **/
    public function isAuth($alc){
        
        if($alc->status == 5){
            return true;
        }
        switch ($this->Req->path()) {
            case 'api/user':
                $res = $alc->user >= 1 ? true : false;
                break;
            case 'api/user/add':
                $res = $alc->user >= 1 ? true : false;
                break;
            case 'api/user/del':
                $res = $alc->user >= 2 ? true : false;
                break;
            case 'api/user/alc/list':
                $res = $alc->user >= 1 ? true : false;
                break;
            case 'api/user/add/alc':
                $res = $alc->status == 5 ? true : false;
                break;
            case 'api/goods':
                $res = $alc->goods >= 1 ? true : false;
                break;
            case 'api/goods/add':
                $res = $alc->goods >= 1 ? true : false;
                break;
            case 'api/goods/del':
                $res = $alc->goods >= 2 ? true : false;
                break;
            case 'api/goods/update':
                $res = $alc->goods >= 3 ? true : false;
                break;
            case 'api/cate':
                $res = $alc->cates >= 1 ? true : false;
                break;
            case 'api/cate/add':
                $res = $alc->cates >= 1 ? true : false;
                break;
            case 'api/cate/del':
                $res = $alc->cates >= 2 ? true : false;
                break;
            case 'api/cate/update':
                $res = $alc->cates >= 3 ? true : false;
                break;
            default:
                $res = true;
                break;
        }
        return $res;
    }
}
