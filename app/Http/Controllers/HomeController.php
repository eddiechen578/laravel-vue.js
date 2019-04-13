<?php

namespace App\Http\Controllers;

use App\Entities\Session;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
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
        return view('home');
    }

    public function get(){
        return UserResource::collection(User::where('id', '!=', auth()->id())->get());
    }

    public function getOwner(){
        return User::where('id', auth()->id())->first();
    }
}
