<?php

namespace App\Http\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class size extends Model
{
	protected $table = "age";
	public $timestamps = false;
	function get_data($limit, $offset, $name){

		if($name != '' || $name != null){
			$result = DB::table('age')->where('name','like', '%'.$name.'%')->skip($offset)->take($limit)->get();
			$count = DB::table('age')->where('name','like', '%'.$name.'%')->count();
		}else{
			$result = DB::table('age')->skip($offset)->take($limit)->get();
			$count = DB::table('age')->count();
		}

		return array(
				'count' => $count,
				'result' => $result
			);
	}

	function get_brand($id){
		if($id){
			return DB::table('age')->where('id_age', $id)->orderBy('id_age')->get();
		}else{
			// return DB::table('type')->orderBy('id_type')->get();
			$result = DB::table('age')
						->get();
			return $result;
		}
		// return $id;
		// return DB::table('type')->where('id_category', $id)->orderBy('id_type')->get();	
	}
}
