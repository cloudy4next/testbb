<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ActivityController;

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

    // Route::get('edit-account-info', ['as' => 'edit-account-info', 'uses' => 'DashBoardController@myAccount']);

    Route::group(['middleware' => 'acl:Page'], function () {
        Route::crud('page', 'PageCrudController');
        Route::get('page/{id}/edit', ['as' => 'admin.page.edit', 'uses' => 'PageCrudController@edit']);
        Route::post('page/store', ['as' => 'admin.page.store', 'uses' => 'PageCrudController@store']);
        Route::post('page/{id}/update', ['as' => 'admin.page.update', 'uses' => 'PageCrudController@update']);
    });
    Route::group(['middleware' => 'acl:Page'], function () {
        Route::crud('category', 'CategoryCrudController');
        Route::crud('funded', 'FundedCrudController');
    });

    Route::crud('pptx', 'PPTXCrudController');
    Route::post('pptx/store', ['as' => 'admin.pptx.store', 'uses' => 'PPTXCrudController@store']);


    Route::group(['middleware' => 'acl:Article'], function () {
        Route::crud('article', 'ArticleCrudController');
        Route::post('article/store', ['as' => 'admin.articles.store', 'uses' => 'ArticleCrudController@store']);
        Route::post('article/{id}/update', ['as' => 'admin.articles.update', 'uses' => 'ArticleCrudController@update']);
    });

    Route::group(['middleware' => 'acl:Project'], function () {
        Route::crud('project', 'ProjectCrudController');
        Route::post('project/store', ['as' => 'admin.project.store', 'uses' => 'ProjectCrudController@store']);
        Route::post('project/{id}/update', ['as' => 'admin.project.update', 'uses' => 'ProjectCrudController@update']);
    });
    Route::group(['middleware' => 'acl:News'], function () {
        Route::crud('news', 'NewsCrudController');
        Route::post('news/store', ['as' => 'admin.news.store', 'uses' => 'NewsCrudController@store']);
        Route::post('news/{id}/update', ['as' => 'admin.news.update', 'uses' => 'NewsCrudController@update']);
    });
    Route::group(['middleware' => 'acl:Notice'], function () {

        Route::crud('notice', 'NoticeCrudController');
        Route::post('notice/store', ['as' => 'admin.notice.store', 'uses' => 'NoticeCrudController@store']);
        Route::post('notice/{id}/update', ['as' => 'admin.notice.update', 'uses' => 'NoticeCrudController@update']);
    });

    Route::group(['middleware' => 'acl:ActivityLog'], function () {
        Route::get('index', ['as' => 'audit.log.index', 'uses' => 'ActivityController@index']);
        Route::get('search', ['as' => 'audit.log.search', 'uses' => 'ActivityController@search']);
        Route::get('user-name', ['as' => 'audit.log.user.name', 'uses' => 'ActivityController@getUserName']);
    });

    Route::group(['middleware' => 'acl:Notification'], function () {
        Route::get('notification', ['as' => 'notification.data', 'uses' => 'ActivityController@showNotificaton']);
        Route::post('mark-as-read', ['as' => 'markNotification', 'uses' => 'ActivityController@markNotification']);
    });

    Route::crud('query', 'QueryCrudController');
    Route::get('query/{id}/show-detail', ['as' => 'admin.show.detail', 'uses' => 'QueryCrudController@showDetails']);
    Route::post('query/{id}/mark-as-read', ['as' => 'admin.query.read', 'uses' => 'QueryCrudController@markAsRead']);
    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashBoardController@dashboard']);

    Route::crud('research', 'ResearchCrudController');

    Route::group(['middleware' => 'acl:Settings'], function () {
            Route::crud('users', 'UserCrudController');

    });

});
