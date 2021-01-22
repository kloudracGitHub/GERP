<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

//use Illuminate\Support\Facades\Auth;

use DB;

use Session;

//use Auth;

use Mail;

use URL;

use Hash;



class CommonController extends Controller

{
 public static function login_user_details(){
    	 $userDetails  =  DB::table('grc_user')->where('id','=',session('userId')) 
            ->first();
         
           
        return $userDetails;

    }
}