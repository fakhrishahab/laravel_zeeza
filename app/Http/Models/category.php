<?php

namespace App\Http\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
	protected $table = "category";
	public $timestamps = false;
	function get_data($limit, $offset, $id){

		if($id != '' || $id != null){
			$result = DB::table('category')->where('name','like', '%'.$id.'%')->skip($offset)->take($limit)->get();
			$count = DB::table('category')->where('name','like', '%'.$id.'%')->count();
		}else{
			$result = DB::table('category')->skip($offset)->take($limit)->get();
			$count = DB::table('category')->count();
		}

		return array(
				'count' => $count,
				'result' => $result
			);
	}

	function get_type($id){
		if($id){
			return DB::table('type')->where('id_category', $id)->orderBy('id_type')->get();
		}else{
			// return DB::table('type')->orderBy('id_type')->get();
			$result = DB::table('type')
						->join('category', 'category.id_category' , '=', 'type.id_category')
						->select('type.*', 'category.name as category')
						->get();
			return $result;
		}
		// return $id;
		// return DB::table('type')->where('id_category', $id)->orderBy('id_type')->get();	
	}

	function get_size(){
		return DB::table('age')->get();
	}
}
