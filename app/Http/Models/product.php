<?php

namespace App\Http\Models;

use DB;
use Response;
use Carbon\Carbon;
use Config;
// use Illuminate\Http\Request;
// use App\Fileentry;
// use Fileentry;
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
		echo Request::file('image');
        $product->name = $input['name'];
        $product->category = $input['category'];
        $product->type = $input['type'];
        $product->age = $input['age'];
        $product->description = $input['description'];
        $product->price = $input['price'];
        $product->price_disc = $input['price_disc'];
        $product->price_reseller = $input['price_reseller'];
        $product->brand = $input['product_brand'];
        $product->code = $input['product_code'];
        $product->created_date = Carbon::now();

        $file = Request::file('image');
        $extension = $file->getClientOriginalExtension();
        $destinationPath = './public/upload';
        $fileName = $input['product_code'].'.'.$extension;
        Request::file('image')->move($destinationPath, $fileName);
		// $extension = $file->getClientOriginalExtension();
		// Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));
		// $entry = new Fileentry();
		// $entry->mime = $file->getClientMimeType();
		// $entry->original_filename = $file->getClientOriginalName();
		// $entry->filename = $file->getFilename().'.'.$extension;

        $product->save();

        return Response::json(array(
            'error' => false,
            'pages' => $product->toArray()),
            200
        );
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
			$result = DB::table('product')->where('code','like', '%'.$id.'%')->skip($offset)->take($limit)->get();	
		}else{
			$result = DB::table('product')->skip($offset)->take($limit)->get();
		}
		// return DB::table('product')->count();
		// $result = DB::table('product')->where('code', $id)->skip($offset)->take($limit)->get();
		return array(
			'count' => DB::table('product')->count(),
			'result' => $result
			);
	}

	function latest_product($req){
		// return DB::table('product')->orderBy('created_date', 'DESC')->skip(0)->take(12)->get();

		$offset =  ($req->input('offset') ? $req->input('offset') : 0);
		$limit =  ($req->input('limit') ? $req->input('limit') : 12);
		$filter = DB::table('product')
					->join('product_age', 'product_age.id_age', '=', 'product.age')
					// ->orderBy('created_date', 'DESC')
					->skip($offset)
					->take($limit)
					->select('product.*', 'product_age.name as size')
					->orderBy('product.created_date', 'DESC')
					->get();
		foreach ($filter as $key => $value) {
			$filter[$key]->image = Config::get('constant.SITE_PATH').'image?img='.$filter[$key]->code;
		}

		return $filter;
	}

	function show_product($id){
		$product = DB::table('product')
					->join('product_age', 'product_age.id_age', '=', 'product.age')
					->where('product.id', $id)
					->select('product.*', 'product_age.name as size')
					->get();
		$product[0]->image = Config::get('constant.SITE_PATH').'image?img='.$product[0]->code;
		return $product;
	}

	function filter_product($req){
		$offset =  ($req->input('offset') ? $req->input('offset') : 0);
		$limit =  ($req->input('limit') ? $req->input('limit') : 12);
		if($req->input('id')){
			$where = ['product.category' => $req->input('id')];
		}else if($req->input('size')){
			$where = ['product.age' => $req->input('size')];
		}else if($req->input('brand')){
			$where = ['product.brand' => $req->input('brand')];
		}

		$filter = DB::table('product')
					->join('product_age', 'product_age.id_age', '=', 'product.age')
					->where($where)
					->skip($offset)
					->take($limit)
					->select('product.*', 'product_age.name as size')
					->orderBy('product.price_disc')
					->get();
		foreach ($filter as $key => $value) {
			$filter[$key]->image = Config::get('constant.SITE_PATH').'image?img='.$filter[$key]->code;
		}

		return array(
			'count' => DB::table('product')->where($where)->count(),
			'result' => $filter
			);
	}

	function search_product($req){
		$offset =  ($req->input('offset') ? $req->input('offset') : 0);
		$limit =  ($req->input('limit') ? $req->input('limit') : 12);
		$filter = DB::table('product')
					->join('product_age', 'product_age.id_age', '=', 'product.age')
					->where('product.code', 'like', '%'.$req->input('code').'%')
					->skip($offset)
					->take($limit)
					->select('product.*', 'product_age.name as size')
					->orderBy('product.created_date')
					->get();
		foreach ($filter as $key => $value) {
			$filter[$key]->image = Config::get('constant.SITE_PATH').'image?img='.$filter[$key]->code;
		}

		return array(
			'count' => DB::table('product')->where('code', 'like', '%'.$req->input('code').'%')->count(),
			'result' => $filter
			);
	}
}
