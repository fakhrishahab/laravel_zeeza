<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\content;

class adminContentController extends Controller
{
    function __construct(){
		$this->data = new content;
	}

	function getMenu(){
		return $this->data->get_menu();
	}

	function getMenuDetail(Request $request){
		$id = $request->input('id');
		return $this->data->get_menu_detail($id);
	}
}
