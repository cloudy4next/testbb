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
Route::get('news', 'Api\ReactApiController@getNews');
Route::get('articles', 'Api\ReactApiController@getArticles');
Route::get('pptx', 'Api\ReactApiController@getPptx');
Route::post('query', 'Api\ReactApiController@postQueries');
Route::get('query-list', 'Api\ReactApiController@getQuery');

// Route::get('Category', 'Api\ReactApiController@getCategory');
