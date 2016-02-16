<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\brand;

class AdminBrandController extends Controller
{
    function __construct(){
        $this->data = new brand;
    }

    function index(Request $request){
        $limit = $request->input('limit');
        $offset = $request->input('offset');
        $name = $request->input('name');
        if($request->input()){
            return $this->data->get_data($limit, $offset, $name);
        }else{
            return DB::table('product_brand')->get();
        }
    }

    function create(Request $request){
    	$brand = new brand;

        $brand->code = $request->input('code');
    	$brand->name = $request->input('name');

    	$brand->save();

    	return Response::json(array(
            'error' => false,
            'pages' => $brand->toArray()),
            200
        );
    }

    function detail(Request $request){
        $id = $request->input('id');
        return DB::table('product_brand')->where('id', $id)->get();
    }

    function edit(Request $request){
        $id = $request->input('id');
        $code = $request->input('code');
        $name = $request->input('name');
        return DB::table('product_brand')
                ->where('id', $id)
                ->update([
                        'code' => $code,
                        'name' => $name
                    ]);
    }

    function delete(Request $request){
        $id = $request->input('id');
        return DB::table('product_brand')
                ->where('id', $id)
                ->delete();
    }
}
