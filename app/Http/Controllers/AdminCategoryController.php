<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Response;
use DB;
use App\Http\Controllers\Controller;
use App\Http\Models\category;

class AdminCategoryController extends Controller
{
	function __construct(){
		date_default_timezone_set('Asia/Jakarta');
		$this->data = new category;
	}

    function index(Request $request){   	
    	$limit = $request->input('limit');
    	$offset = $request->input('offset');
    	$id = $request->input('id');
    	if($request->input()){
    		return $this->data->get_data($limit, $offset, $id);
    	}else{
    		return DB::table('category')->get();
    	}
    }

    function create(Request $request){
        $category = new category;
        $category->name = $request->input('name');
        $category->rank = $request->input('rank');
        
        if($category->save()){
        	Response('', 200);
        }else{
        	Response('', 500);
        }        
    }

    function detail(Request $request){
    	$id = $request->input('id');
    	return DB::table('category')->where('id_category', $id)->get();
    }

    function edit(Request $request){
    	$id = $request->input('id');
    	$rank = $request->input('rank');
    	$name = $request->input('name');
    	return DB::table('category')
    			->where('id_category', $id)
    			->update([
    					'rank' => $rank,
    					'name' => $name
    				]);
    }

    function delete(Request $request){
    	$id = $request->input('id');
    	return DB::table('category')
    			->where('id_category', $id)
    			->delete();
    }
}
