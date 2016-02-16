<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class type extends Model
{
	protected $table = "product_type";
    public $timestamps = false;

    function get_data($limit, $offset, $id){

		if($id != '' || $id != null){
			$result = DB::table('product_type')
						->join('product_category', 'product_category.id_category', '=', 'product_type.id_category')
						->where('product_type.name','like', '%'.$id.'%')
						->select('product_type.*', 'product_category.name as category')
						->skip($offset)
						->take($limit)
						->get();
			$count = DB::table('product_type')->where('name','like', '%'.$id.'%')->count();
		}else{
			$result = DB::table('product_type')
						->join('product_category', 'product_category.id_category', '=', 'product_type.id_category')
						->select('product_type.*', 'product_category.name as category')
						->skip($offset)
						->take($limit)
						->get();
			$count = DB::table('product_type')->count();
		}

		return array(
				'count' => $count,
				'result' => $result
			);
	}
}
