<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\type;

class AdminTypeController extends Controller
{
    function create(Request $request){
    	$type = new type;

    	$type->id_category = $request->input('id_category');
    	$type->name = $request->input('name');

    	$type->save();

    	return Response::json(array(
            'error' => false,
            'pages' => $type->toArray()),
            200
        );
    }
}
