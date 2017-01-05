<?php

namespace App\Http\Models;

use DB;
use Response;
use Carbon\Carbon;
use Config;
// use Illuminate\Http\Request;
// use App\Fileentry;
// use Fileentry;
use Image;
use Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class product extends Model
{
	protected $table = "product";
	public $timestamps = false;
	function save_product($input){
		$product = new Product();
		// echo Request::file('image');
        $product->name = $input['name'];
        // $product->category = $input['category'];
        // $product->type = $input['type'];
        // $product->age = $input['age'];
        $product->description = $input['description'];
        $product->price = $input['price'];
        $product->price_disc = $input['price_disc'];
        $product->price_reseller = $input['price_reseller'];
        $product->brand = $input['product_brand'];
        $product->code = $input['product_code'];
        $product->created_date = Carbon::now();

        $type = explode(',',$input['type']);
        $age = explode(',',$input['age']);

        $file = Request::file('image');
        $extension = $file->getClientOriginalExtension();
        $destinationPath = './public/upload/';
        $fileName = $input['product_code'].'.jpg';
        // Request::file('image')->move($destinationPath, $fileName);

        $img = Image::make($file->getRealPath());
        $img->resize(null, 600, function($constraint){$constraint->aspectRatio();})->save($destinationPath.$fileName);

        // $db_type = new Product_type();
        if($product->save()){
        	$arr_type=[];
        	$arr_age=[];
        	foreach ($type as $key => $value) {
        		array_push($arr_type, ['product_id'=>$product->id, 'type'=>$value]);
        	}
        	foreach ($age as $key => $value) {
        		array_push($arr_age, ['product_id'=>$product->id, 'age'=>$value]);
        	}
        	DB::table('product_type')->insert($arr_type);
        	DB::table('product_age')->insert($arr_age);
        	return Response::json(array(
	            'success' => true,
	            'pages' => $product->code,
	            'last_insert_id' => $product->id),
	            200
	        );
        }        
	}

	function get_brand(){
		return DB::table('product_brand')->get();
	}

	function get_code($id){
		$find = DB::table('product')->where('brand', $id)->get();
		
		// echo $code->id_product;
		if($find){
			$code = DB::table('product')->where('brand', $id)->orderBy('code', 'DESC')->first();
			return $code->code;
		}else{
			return Response(null, 200);
		}
	}

	function get_data($limit, $offset, $id){

		if($id != null || $id != ''){
			$result = DB::table('product')->where('code','like', '%'.$id.'%')->skip($offset)->take($limit)->orderBy('created_date','DESC')->get();	
			$count = DB::table('product')->where('code','like', '%'.$id.'%')->count();
		}else{
			$result = DB::table('product')->skip($offset)->take($limit)->orderBy('created_date','DESC')->get();
			$count = DB::table('product')->count();
		}
		// return DB::table('product')->count();
		// $result = DB::table('product')->where('code', $id)->skip($offset)->take($limit)->get();
		return array(
			'count' => $count,
			'result' => $result
			);
	}

	function latest_product($req){
		// return DB::table('product')->orderBy('created_date', 'DESC')->skip(0)->take(12)->get();

		$offset =  ($req->input('offset') ? $req->input('offset') : 0);
		$limit =  ($req->input('limit') ? $req->input('limit') : 36);
		$filter = DB::table('product')
					// ->join('age', 'age.id_age', '=', 'product.age')
					// ->orderBy('created_date', 'DESC')
					->skip($offset)
					->take($limit)
					// ->select('product.*', 'age.name as size')
					->orderBy('created_date', 'DESC')
					->get();
		foreach ($filter as $key => $value) {
			$filter[$key]->image = Config::get('constant.SITE_PATH').'image?img='.$filter[$key]->code;
			$filter[$key]->size = DB::table('product_age')
									->join('age', 'age.id_age', '=', 'product_age.age')
									->select('age.id_age','age.name')
									->where('product_age.product_id', $filter[$key]->id)
									->get();
		}

		return $filter;
	}

	function show_product($id){
		$product = DB::table('product')
					->where('id', $id)
					->get();
		$product[0]->image = Config::get('constant.SITE_PATH').'image?img='.$product[0]->code;
		$product[0]->type =  DB::table('product_type')
									->join('type', 'type.id_type', '=', 'product_type.type')
									->select('type.id_type','type.name')
									->where('product_type.product_id', $product[0]->id)
									->get();
		$product[0]->size =  DB::table('product_age')
									->join('age', 'age.id_age', '=', 'product_age.age')
									->select('age.id_age','age.name')
									->where('product_age.product_id', $product[0]->id)
									->get();
		return $product;
	}

	function filter_product($req){
		$offset =  ($req->input('offset') ? $req->input('offset') : 0);
		$limit =  ($req->input('limit') ? $req->input('limit') : 12);
		if($req->input('id')){
			$where = ['product_type.type' => $req->input('id')];
			$table = 'product_type';
			$filter = DB::table('product_type')
					->join('product', 'product.id', '=', 'product_type.product_id')					
					->where($where)
					->skip($offset)
					->take($limit)
					->select('product.*', 'product_type.type')
					->get();

		}else if($req->input('size')){
			$where = ['product_age.age' => $req->input('size')];
			$table = 'product_age';
			$filter = DB::table($table)
					->join('product', 'product.id', '=', 'product_age.product_id')					
					->where($where)
					->skip($offset)
					->take($limit)
					->select('product.*', 'product_age.age')
					->get();

		}else if($req->input('brand')){
			$where = ['product.brand' => $req->input('brand')];
			$table = 'product';
			$filter = DB::table($table)
					->join('product_brand', 'product.brand', '=', 'product_brand.id')
					->where($where)
					->skip($offset)
					->take($limit)
					->select('product.*')
					->get();
		}

		foreach ($filter as $key => $value) {
			$filter[$key]->image = Config::get('constant.SITE_PATH').'image?img='.$filter[$key]->code;
			$filter[$key]->size =  DB::table('product_age')
									->join('age', 'age.id_age', '=', 'product_age.age')
									->select('age.id_age','age.name')
									->where('product_age.product_id', $filter[$key]->id)
									->get();
		}

		return array(
			'count' => DB::table($table)->where($where)->count(),
			'result' => $filter
			);
	}

	function search_product($req){
		$offset =  ($req->input('offset') ? $req->input('offset') : 0);
		$limit =  ($req->input('limit') ? $req->input('limit') : 12);
		$filter = DB::table('product')
					->where('code', 'like', '%'.$req->input('code').'%')
					->skip($offset)
					->take($limit)
					->orderBy('created_date')
					->get();
		foreach ($filter as $key => $value) {
			$filter[$key]->image = Config::get('constant.SITE_PATH').'image?img='.$filter[$key]->code;
			$filter[$key]->size =  DB::table('product_age')
									->join('age', 'age.id_age', '=', 'product_age.age')
									->select('age.id_age','age.name')
									->where('product_age.product_id', $filter[$key]->id)
									->get();
		}

		return array(
			'count' => DB::table('product')->where('code', 'like', '%'.$req->input('code').'%')->count(),
			'result' => $filter
			);
	}

	function update_data($input){
		// print_r($input['image']);
		if($input['image']){
			$file = Request::file('image');
	        $extension = $file->getClientOriginalExtension();
	        $destinationPath = './public/upload/';
	        $fileName = $input['product_code'].'.jpg';
	        // Request::file('image')->move($destinationPath, $fileName);
	        Image::make($file->getRealPath())->fit(600)->save($destinationPath.$fileName);
		}

		DB::table('product_type')
                ->where('product_id', $input['id'])
                ->delete();
        DB::table('product_age')
                ->where('product_id', $input['id'])
                ->delete();
		
		$type = explode(',',$input['type']);
        $age = explode(',',$input['age']);

        $arr_type=[];
    	$arr_age=[];
    	foreach ($type as $key => $value) {
    		array_push($arr_type, ['product_id'=>$input['id'], 'type'=>$value]);
    	}
    	foreach ($age as $key => $value) {
    		array_push($arr_age, ['product_id'=>$input['id'], 'age'=>$value]);
    	}
    	DB::table('product_type')->insert($arr_type);
    	DB::table('product_age')->insert($arr_age);

		return DB::table('product')
			->where('id', $input['id'])
			->update([
					'name' => $input['name'],
					'description' => $input['description'],
					'price' => $input['price'],
					'price_disc' => $input['price_disc'],
					'price_reseller' => $input['price_reseller']
				]);
	}
}
