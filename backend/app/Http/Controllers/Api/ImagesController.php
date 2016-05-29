<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Contracts\ImageContract;

class ImagesController extends Controller
{
    public function all(ImageContract $images)
    {
    	return $images->all();
    }

    public function singular(ImageContract $image, $id)
    {
    	return $image->singular($id);
    }
}
