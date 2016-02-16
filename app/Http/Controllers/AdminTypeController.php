<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\type;

class AdminTypeController extends Controller
{
    function __construct(){
        $this->data = new type;
    }

    function index(Request $request){
        $limit = $request->input('limit');
        $offset = $request->input('offset');
        $id = $request->input('id');
        if($request->input()){
            return $this->data->get_data($limit, $offset, $id);
        }else{
            return DB::table('product_type')->get();
        }
    }

    function create(Request $request){
    	$type = new type;

    	$type->id_category = $request->input('id_category');
        $type->rank = $request->input('rank');
    	$type->name = $request->input('name');

    	$type->save();

    	return Response::json(array(
            'error' => false,
            'pages' => $type->toArray()),
            200
        );
    }

    function detail(Request $request){
        $id = $request->input('id');
        return DB::table('product_type')->where('id_type', $id)->get();
    }

    function edit(Request $request){
        $id = $request->input('id');
        $category = $request->input('id_category');
        $rank = $request->input('rank');
        $name = $request->input('name');
        return DB::table('product_type')
                ->where('id_type', $id)
                ->update([
                        'rank' => $rank,
                        'name' => $name,
                        'id_category' => $category
                    ]);
    }

    function delete(Request $request){
        $id = $request->input('id');
        return DB::table('product_type')
                ->where('id_type', $id)
                ->delete();
    }
}
