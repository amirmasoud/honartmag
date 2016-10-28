<?php
/*header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
*/
Route::get('/images', 'Api\ImagesController@all');
Route::get('/images/{id}', 'Api\ImagesController@singular');
Route::get('categories/{name}', 'Api\CategoriesController@all');
Route::get('categories/{name}/images/{id}', 'Api\CategoriesController@singular');
Route::post('authenticate', 'Api\UserController@authenticate');
