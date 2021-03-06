<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use File;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\product;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Image;
use Illuminate\Support\Facades\Storage;
use Cache;
// use Illuminate\Support\Facades\File;

// use Input;

class productController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(){
        $this->data = new product;
    }
    
    public function index(Request $request)
    {
        // return $request->input();
        if($request->input()){
            return $this->data->filter_product($request);
            // return $this->data->latest_product();    
        }else{
            return $this->data->latest_product($request);    
        }
        
        // //
        // $pages = Page::all();;

        // return Response::json(array(
        //     'status' => 'success',
        //     'pages' => $pages->toArray()),
        //     200
        // );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $input = Input::all();
        $product = new product;
        // $type = explode(',',$input['type']);
        // foreach ($type as $key => $value) {
        //     echo $value.'<br>';
        // }
        $product->save_product($input); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $this->data->show_product($request->input('id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {         
        // echo 'abs';  
        $input = Input::all();
        return $this->data->update_data($input);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function getBrand(){        
        return $this->data->get_brand();
    }

    function getCode($id=null){
        return $this->data->get_code($id);
    }

    function getImage(Request $request){
        $response = Response::make(File::get('public/upload/'.$request->input('img').'.jpg'));
        $response->header('Content-Type', 'image/png');
        return $response;
    }

    function search(Request $request){
        // $code = $request->input('code');
        return $this->data->search_product($request);
    }

    function delete(Request $request){
        // $id = $request->input('id');
        $id = $request->input('id');
        $code = $request->input('code');
        @unlink('public/upload/'.$code.'.jpg');
        // return $request->input('id');
        return DB::table('product')
                ->where('id', $id)
                ->delete();
    }
}
