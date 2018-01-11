<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alc;
use App\User;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id',Auth::user()->id)->with('alc')->first();
        return view('home')->with('user',$user);
    }
}
