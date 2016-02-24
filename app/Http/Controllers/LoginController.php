<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App;
use URL;
use Config;
use Curl;
use Response;
use App\Http\Models\users;
use App\Http\Controllers\Auth\CurlController;


class LoginController extends Controller
{
    // function __construct(){
    // 	$this->data = new Users();
    // }

    function login(Request $request){
        $credentials = [
            'client_id' => Config::get('constant.CLIENT_ID'),
            'client_secret' => Config::get('constant.CLIENT_SECRET'),
            'grant_type' => $request->grant_type,
            'username' => $request->username,
            'password' => $request->password
        ];

    	$get_user = DB::table('users')
    				->where('email', $request->username)
    				->get();

    	if($get_user){
    		if(sha1($request->password) != $get_user[0]->password){
    			return Response::json('not found' ,404);
    		}else{
                $response = Curl::post(Config::get('constant.SITE_PATH').'oauth/access_token',
                        array(),
                        $credentials
                    );

                if($response){
                    // return Response::json($response, 200);
                    return array(
                        'result'=> json_decode($response),
                        'user_info' => $get_user[0]
                        );
                }else{
                    return Response::json('error get access_token', 500);
                }
    		}
    	}else{
    		echo 'ga ada';
    	}
    }
}
