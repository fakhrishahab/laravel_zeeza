<?php

namespace App\Http\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class size extends Model
{
	protected $table = "product_age";
	public $timestamps = false;
	function get_data($limit, $offset, $name){

		if($name != '' || $name != null){
			$result = DB::table('product_age')->where('name','like', '%'.$name.'%')->skip($offset)->take($limit)->get();
			$count = DB::table('product_age')->where('name','like', '%'.$name.'%')->count();
		}else{
			$result = DB::table('product_age')->skip($offset)->take($limit)->get();
			$count = DB::table('product_age')->count();
		}

		return array(
				'count' => $count,
				'result' => $result
			);
	}

	function get_brand($id){
		if($id){
			return DB::table('product_age')->where('id_age', $id)->orderBy('id_age')->get();
		}else{
			// return DB::table('product_type')->orderBy('id_type')->get();
			$result = DB::table('product_age')
						->get();
			return $result;
		}
		// return $id;
		// return DB::table('product_type')->where('id_category', $id)->orderBy('id_type')->get();	
	}
}
