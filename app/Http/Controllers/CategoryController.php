<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\category;


class CategoryController extends Controller
{
	function __construct(){
		date_default_timezone_set('Asia/Jakarta');
		$this->data = new category;
	}

    function getCategory(){
    	return $this->data->get_data();
    }

    function getType($id=null){
    	return $this->data->get_type($id);
    }

    function getSize(){
        return $this->data->get_size();
    }
}
