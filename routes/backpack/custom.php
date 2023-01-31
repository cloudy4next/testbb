<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes


    Route::group(['middleware' => 'acl:Page'], function () {
        Route::crud('page', 'PageCrudController');
        Route::get('page/{id}/edit', ['as' => 'admin.page.edit', 'uses' => 'PageCrudController@edit']);
        Route::post('page/store', ['as' => 'admin.page.store', 'uses' => 'PageCrudController@store']);
        Route::post('page/{id}/update', ['as' => 'admin.page.update', 'uses' => 'PageCrudController@update']);

    });
    Route::crud('category', 'CategoryCrudController');
    Route::crud('funded', 'FundedCrudController');
    Route::crud('project', 'ProjectCrudController');

    Route::post('project/store', ['as' => 'admin.project.store', 'uses' => 'ProjectCrudController@store']);
    Route::post('project/{id}/update', ['as' => 'admin.project.update', 'uses' => 'ProjectCrudController@update']);

    Route::crud('news', 'NewsCrudController');
    Route::post('news/store', ['as' => 'admin.news.store', 'uses' => 'NewsCrudController@store']);
    Route::post('news/{id}/update', ['as' => 'admin.news.update', 'uses' => 'NewsCrudController@update']);

    Route::crud('notice', 'NoticeCrudController');
    Route::post('notice/store', ['as' => 'admin.notice.store', 'uses' => 'NoticeCrudController@store']);
    Route::post('notice/{id}/update', ['as' => 'admin.notice.update', 'uses' => 'NoticeCrudController@update']);
}); // this should be the absolute last line of this file