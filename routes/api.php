<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('categories', 'Api\ReactApiController@getCategory');
Route::get('pages', 'Api\ReactApiController@getPages');
Route::get('notices', 'Api\ReactApiController@getNotice');
Route::get('projects', 'Api\ReactApiController@getProjects');
Route::get('News', 'Api\ReactApiController@getNews');
Route::post('qouery-submit', 'Api\ReactApiController@postQueries');
// Route::get('Category', 'Api\ReactApiController@getCategory');
