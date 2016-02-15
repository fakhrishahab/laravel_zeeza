<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\category;


class CategoryController extends Controller
{
	function __construct(){
		date_default_timezone_set('Asia/Jakarta');
		$this->data = new category;
	}

    function getCategory(){
    	return $this->data->get_data();
    }

    function getType(Request $request){
        $id = $request->input('id');
    	return $this->data->get_type($id);
    }

    function getSize(){
        return $this->data->get_size();
    }

    function create(Request $request){
        $category = new category;
        $category->name = $request->input('name');
        $category->save();

        return Response::json(array(
            'error' => false,
            'pages' => $category->toArray()),
            200
        );
    }
}
