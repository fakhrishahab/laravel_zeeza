<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class type extends Model
{
	protected $table = "type";
    public $timestamps = false;

    function get_data($limit, $offset, $id){

		if($id != '' || $id != null){
			$result = DB::table('type')
						->join('category', 'category.id_category', '=', 'type.id_category')
						->where('type.name','like', '%'.$id.'%')
						->select('type.*', 'category.name as category')
						->skip($offset)
						->take($limit)
						->get();
			$count = DB::table('type')->where('name','like', '%'.$id.'%')->count();
		}else{
			$result = DB::table('type')
						->join('category', 'category.id_category', '=', 'type.id_category')
						->select('type.*', 'category.name as category')
						->skip($offset)
						->take($limit)
						->get();
			$count = DB::table('type')->count();
		}

		return array(
				'count' => $count,
				'result' => $result
			);
	}
}
