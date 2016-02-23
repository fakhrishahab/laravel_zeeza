<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Config;
// use Response;

class CurlController extends Controller{

    public function attemptLogin($credentials) 
    {
        return $this->proxy('password', $credentials);
    }

    public function attemptRefresh()
    {
        $crypt = app()->make('encrypter');
        $request = app()->make('request');
        
        return $this->proxy('refresh_token', [
            'refresh_token' => $crypt->decrypt($request->cookie('refreshToken'))
        ]); 
    }

    function proxy($data, $info) 
    {
        $credentials = [
            'client_id' => Config::get('constant.CLIENT_ID'),
            'client_secret' => Config::get('constant.CLIENT_SECRET'),
            'grant_type' => $data['grant_type'],
            'username' => $data['username'],
            'password' => $data['password']
        ];
        // return $credentials;
        try{
            $client = new Client();
            // echo sprintf('%soauth/access-token',Config::get('constant.SITE_PATH'));
            $guzzleResponse = $client->post(sprintf('%soauth/access_token',Config::get('constant.SITE_PATH')),[
                    'form_params' => $credentials
                ]);    
        }catch(\GuzzleHttp\Exception\BadResponseException $e){
            $guzzleResponse = $e->getResponse();
        }

        $response = json_decode($guzzleResponse->getBody());

        if (property_exists($response, "access_token")) {
            // $cookie = App::make('cookie');
            // $crypt  = App::make('encrypter');

            // $encryptedToken = $crypt->encrypt($response->refresh_token);

            // // Set the refresh token as an encrypted HttpOnly cookie
            // $cookie->queue('refreshToken', 
            //     $crypt->encrypt($encryptedToken),
            //     604800, // expiration, should be moved to a config file
            //     null, 
            //     null, 
            //     false, 
            //     true // HttpOnly
            // );
            $response = [
                'access_token'            => $response->access_token,
                'access_token_expiration'  => $response->expires_in,
                'user_info' => $info[0]
            ];
        }else{
            $response = [
                'login' => false
            ];
        }

        $response = response()->json($response);
        $response->setStatusCode($guzzleResponse->getStatusCode());

        $headers = $guzzleResponse->getHeaders();
        foreach($headers as $headerType => $headerValue) {
            $response->header($headerType, $headerValue);
        }

        return $response;
    }

}
?>