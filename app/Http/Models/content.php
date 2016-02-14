<?php

namespace App\Http\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Contracts\Cache\Repository;
use Cache;

class content extends Model
{
	function get_menu(){
		return DB::table('menu')->get();
	}

	function get_all_menu(){
		Cache::put('menu', DB::table('menu_content')
				->join('menu', 'menu.id', '=', 'menu_content.menu')
				->select('menu_content.*', 'menu.name as menu_name')
				->orderBy('menu_content.id')
				->get(), 600);
		// return DB::table('menu_content')
		// 		->join('menu', 'menu.id', '=', 'menu_content.menu')
		// 		->select('menu_content.*', 'menu.name as menu_name')
		// 		->orderBy('menu_content.id')
		// 		->get();
	}

	function get_menu_detail($id){
		return DB::table('menu_content')
				->join('menu', 'menu.id', '=', 'menu_content.menu')
				->where('menu', $id)
				->select('menu_content.*', 'menu.name as menu_name')
				->orderBy('menu_content.id')
				->get();
	}

	function get_nav(){
		$category = DB::table('product_category')->select('id_category', 'name')->orderBy('rank')->get();
		foreach ($category as $key => $value) {
			$category[$key]->child = DB::table('product_type')->select('id_type', 'name')->where('id_category', $category[$key]->id_category)->orderBy('rank')->get();
		}
		return $category;
	}

	function get_content($id){
		return DB::table('menu_content')->where('id', $id)->get();
	}
}