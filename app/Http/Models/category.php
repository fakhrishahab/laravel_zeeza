<?php

namespace App\Http\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
	protected $table = "product_category";
	public $timestamps = false;
	function get_data($limit, $offset, $id){

		if($id != '' || $id != null){
			$result = DB::table('product_category')->where('name','like', '%'.$id.'%')->skip($offset)->take($limit)->get();
			$count = DB::table('product_category')->where('name','like', '%'.$id.'%')->count();
		}else{
			$result = DB::table('product_category')->skip($offset)->take($limit)->get();
			$count = DB::table('product_category')->count();
		}

		return array(
				'count' => $count,
				'result' => $result
			);
	}

	function get_type($id){
		if($id){
			return DB::table('product_type')->where('id_category', $id)->orderBy('id_type')->get();
		}else{
			// return DB::table('product_type')->orderBy('id_type')->get();
			$result = DB::table('product_type')
						->join('product_category', 'product_category.id_category' , '=', 'product_type.id_category')
						->select('product_type.*', 'product_category.name as category')
						->get();
			return $result;
		}
		// return $id;
		// return DB::table('product_type')->where('id_category', $id)->orderBy('id_type')->get();	
	}

	function get_size(){
		return DB::table('product_age')->get();
	}
}
