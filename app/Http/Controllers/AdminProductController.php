<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\product;

class AdminProductController extends Controller
{
    //
    function __construct(){
    	$this->data = new product;
    }

    function get(Request $request){
    	// return $request->input('limit');
    	return $this->data->get_data($request->input('limit'), $request->input('offset'), $request->input('id'));
    }
}
