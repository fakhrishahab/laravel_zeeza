<?php

namespace App\Http\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class brand extends Model
{
	protected $table = "product_brand";
	public $timestamps = false;
	function get_data($limit, $offset, $name){

		if($name != '' || $name != null){
			$result = DB::table('product_brand')->where('name','like', '%'.$name.'%')->skip($offset)->take($limit)->get();
			$count = DB::table('product_brand')->where('name','like', '%'.$name.'%')->count();
		}else{
			$result = DB::table('product_brand')->skip($offset)->take($limit)->get();
			$count = DB::table('product_brand')->count();
		}

		return array(
				'count' => $count,
				'result' => $result
			);
	}

	function get_brand($id){
		if($id){
			return DB::table('product_brand')->where('id', $id)->orderBy('id')->get();
		}else{
			// return DB::table('type')->orderBy('id_type')->get();
			$result = DB::table('product_brand')
						->get();
			return $result;
		}
		// return $id;
		// return DB::table('type')->where('id_category', $id)->orderBy('id_type')->get();	
	}
}
