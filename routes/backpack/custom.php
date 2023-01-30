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
    Route::crud('page', 'PageCrudController');
    Route::post('page/store', ['as' => 'admin.page.store', 'uses' => 'PageCrudController@store']);
    Route::post('page/{id}/update', ['as' => 'admin.page.update', 'uses' => 'PageCrudController@update']);
    Route::crud('category', 'CategoryCrudController');
    Route::crud('funded', 'FundedCrudController');
}); // this should be the absolute last line of this file