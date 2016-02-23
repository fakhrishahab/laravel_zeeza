<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App;
use URL;
use Response;
use App\Http\Models\users;
use App\Http\Controllers\Auth\CurlController;


class LoginController extends Controller
{
    // function __construct(){
    // 	$this->data = new Users();
    // }

    function login(Request $request){
    	$get_user = DB::table('users')
    				->where('email', $request->username)
    				->get();

    	if($get_user){
    		if(sha1($request->password) != $get_user[0]->password){
    			return Response::json('not found' ,404);
    		}else{
    			return App::make('App\Http\Controllers\Auth\CurlController')->proxy($request, $get_user);
    		}
    	}else{
    		echo 'ga ada';
    	}
    }
}
