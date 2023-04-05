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
Route::get('research', 'Api\ReactApiController@getResearch');
Route::get('notices', 'Api\ReactApiController@getNotice');
Route::get('projects', 'Api\ReactApiController@getProjects');
Route::get('news', 'Api\ReactApiController@getNews');
Route::get('articles', 'Api\ReactApiController@getArticles');
Route::get('pptx', 'Api\ReactApiController@getPptx');
Route::get('faq', 'Api\ReactApiController@getFaq');


Route::get('pages/{id}', 'Api\ReactApiController@getSinglePage');
Route::get('research/{id}', 'Api\ReactApiController@getSingleResearch');
Route::get('notices/{id}', 'Api\ReactApiController@getSingleNotice');
Route::get('projects/{id}', 'Api\ReactApiController@getSingleProject');
Route::get('news/{id}', 'Api\ReactApiController@getSingleNews');
Route::get('articles/{id}', 'Api\ReactApiController@getSingleAritcle');
Route::get('pptx/{id}', 'Api\ReactApiController@getSinglePptx');


Route::post('query', 'Api\ReactApiController@postQueries');
Route::get('query-list', 'Api\ReactApiController@getQuery');
Route::get('search', 'Api\ReactApiController@getSearch');
Route::post('newsletter', 'Api\ReactApiController@storeNewsletter');

// Route::get('Category', 'Api\ReactApiController@getCategory');

