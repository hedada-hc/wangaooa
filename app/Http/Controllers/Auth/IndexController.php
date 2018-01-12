<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
class IndexController extends Controller
{
   	public function index(){
   		if(Auth::user()){
   			$user = User::where('id',Auth::user()->id)->with('alc')->first();
   			return view('layouts.main')->with('user',$user);
   		}
   		return redirect('/login');
   	}
}
