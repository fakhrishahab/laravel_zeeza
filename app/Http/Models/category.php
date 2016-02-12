<?php

namespace App\Http\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
	protected $table = "product_category";
	function get_data(){
		return DB::table('product_category')->orderBy('id_category')->get();
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
