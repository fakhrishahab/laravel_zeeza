<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\size;

class AdminSizeController extends Controller
{
    function __construct(){
        $this->data = new size;
    }

    function index(Request $request){
        $limit = $request->input('limit');
        $offset = $request->input('offset');
        $name = $request->input('name');
        if($request->input()){
            return $this->data->get_data($limit, $offset, $name);
        }else{
            return DB::table('product_age')->get();
        }
    }

    function create(Request $request){
    	$size = new size;

    	$size->name = $request->input('name');

    	$size->save();

    	return Response::json(array(
            'error' => false,
            'pages' => $size->toArray()),
            200
        );
    }

    function detail(Request $request){
        $id = $request->input('id');
        return DB::table('product_age')->where('id_age', $id)->get();
    }

    function edit(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        return DB::table('product_age')
                ->where('id_age', $id)
                ->update([
                        'name' => $name
                    ]);
    }

    function delete(Request $request){
        $id = $request->input('id');
        return DB::table('product_age')
                ->where('id_age', $id)
                ->delete();
    }
}
