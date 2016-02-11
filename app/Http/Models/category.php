<?php

namespace App\Http\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
	protected $table = "product_category";
	function get_data(){
		return DB::table('product_category')->get();
	}

	function get_type($id){
		return DB::table('product_type')->where('id_category', $id)->get();	
	}

	function get_size(){
		return DB::table('product_age')->get();
	}
}
