<?php

namespace App\Http\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
	protected $table = "menu_content";
	public $timestamps = false;
	function get_data($limit, $offset, $id, $name){

		if($name != '' || $name != null){
			$result = DB::table('menu_content')
						->join('menu', 'menu.id', '=', 'menu_content.menu')
						->where('menu_content.menu', $id)
						->where('menu_content.name','like', '%'.$name.'%')
						->skip($offset)
						->take($limit)
						->select('menu_content.*', 'menu.name as menu_name')
						->get();

			$count = DB::table('menu_content')
						->where('menu', $id)
						->where('name','like', '%'.$name.'%')
						->count();
		}else{
			$result = DB::table('menu_content')
						->join('menu', 'menu.id', '=', 'menu_content.menu')
						->where('menu', $id)
						->skip($offset)
						->take($limit)
						->select('menu_content.*', 'menu.name as menu_name')
						->get();
			$count = DB::table('menu_content')->where('menu', $id)->count();
		}

		return array(
				'count' => $count,
				'result' => $result
			);
	}

	function get_brand($id){
		if($id){
			return DB::table('menu_content')->where('id', $id)->orderBy('id')->get();
		}else{
			// return DB::table('product_type')->orderBy('id_type')->get();
			$result = DB::table('menu_content')
						->get();
			return $result;
		}
		// return $id;
		// return DB::table('product_type')->where('id_category', $id)->orderBy('id_type')->get();	
	}
}
