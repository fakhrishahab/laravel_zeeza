<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\menu;

class AdminMenuController extends Controller
{
    function __construct(){
        $this->data = new menu;
    }

    function index(Request $request){
        $limit = $request->input('limit');
        $offset = $request->input('offset');
        $name = $request->input('name');
        $id = $request->input('id');
        if($request->input()){
            return $this->data->get_data($limit, $offset, $id, $name);
        }else{
            return DB::table('menu_content')->get();
        }
    }

    function create(Request $request){
    	$menu = new menu;

    	$menu->name = $request->input('name');
    	$menu->content = $request->input('content');
    	$menu->menu = $request->input('menu');

    	$menu->save();

    	return Response::json(array(
            'error' => false,
            'pages' => $menu->toArray()),
            200
        );
    }

    function detail(Request $request){
        $id = $request->input('id');
        return DB::table('menu_content')->where('id', $id)->get();
    }

    function edit(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $content = $request->input('content');
        return DB::table('menu_content')
                ->where('id', $id)
                ->update([
                        'name' => $name,
                        'content' => $content
                    ]);
    }

    function delete(Request $request){
        $id = $request->input('id');
        return DB::table('menu_content')
                ->where('id', $id)
                ->delete();
    }
}
