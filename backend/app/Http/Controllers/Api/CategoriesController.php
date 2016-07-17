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
	 * @return json
	 */
    public function all(CategoryContract $category, $name)
    {
    	return $category->all($name);
    }

    /**
     * Get single image based on category.
     *
     * @param  string $name
     * @param  integer $id
     * @return json
     */
    public function singular(CategoryContract $category, $name, $id) 
    {
    	return $category->singular($name, $id);
    }
}
