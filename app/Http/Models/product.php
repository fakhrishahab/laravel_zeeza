<?php

namespace App\Http\Models;

use DB;
use Response;
use Carbon\Carbon;
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
}
