<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Fees;
use Session;

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
    public function index(Request $request)
    {
        $user = Auth::user();
        $fees = Fees::where('user_id','=', $user->id)->where('status','=', 'unpaid')->get();
        $paid = Fees::where('user_id','=', $user->id)->where('status','=', 'paid')->get();
        return view('home', compact('fees', 'user', 'paid'));
    }

    public function login(){

        return view('landing');
    }

    public function success(Request $request){
        $fee = Fees::findorfail($request->id);
        $fee->status = 'Paid';
        $fee->update();
        
        Session::flash('success', 'Payment succesfully');
        return back();
    }
}
