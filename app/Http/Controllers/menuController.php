<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\content;
use Cache;

class menuController extends Controller
{
	function __construct(){
		$this->data = new content;
	}

    function index(){
    	$this->data->get_all_menu();
    	return Cache::get('menu');
    }

    function getNav(){
    	return $this->data->get_nav();
    }

    function getContent(Request $request){
    	$id = $request->input('id');
    	return $this->data->get_content($id);
    }
}
