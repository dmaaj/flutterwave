<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Excel;
use File;
use App\User;

class FeeController extends Controller
{
    //

    
    public function index(){

    }

    public function import(Request $request){
        //validate the xls file
        $user = Auth::user();
            
            
                $path = $request->file;
                $data = Excel::load($path, function($reader) {
                })->get();
                if(!empty($data) && $data->count()){
 
                    foreach ($data as $key => $value) {
                        $insert[] = [
                        'user_id' => $user->id,
                        'fee' => $value->fee,
                        'amount' => $value->amount,
                        'status' => $value->status,
                        'session' => $value->session,
                        ];
                    }
 
                    if(!empty($insert)){
 
                        $insertData = DB::table('fees')->insert($insert);
                        if ($insertData) {
                            Session::flash('success', 'Fees has been generated successfully');
                        }else {                        
                            Session::flash('error', 'Error generating fees..');
                            return back();
                        }
                    }
                }
 
                return back();
 
            }

            
    
}
