<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Contracts\CategoryContract;

class CategoriesController extends Controller
{
	/**
	 * Get all images based on the category name.
	 * 
	 * @param  string $name
	 * @return 
	 */
    public function singular(CategoryContract $category, $name)
    {
    	return $category->singular($name);
    }
}
