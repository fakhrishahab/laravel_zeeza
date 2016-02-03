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

    function getType(){
    	return $this->data->get_type();
    }
}
